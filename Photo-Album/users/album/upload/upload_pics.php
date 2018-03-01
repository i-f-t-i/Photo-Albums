

<?php 

$abs_us_root=$_SERVER['DOCUMENT_ROOT'];

$self_path=explode("/", $_SERVER['PHP_SELF']);
$self_path_length=count($self_path);
$file_found=FALSE;

for($i = 1; $i < $self_path_length; $i++){
	array_splice($self_path, $self_path_length-$i, $i);
	$us_url_root=implode("/",$self_path)."/";
	
	if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
		$file_found=TRUE;
		break;
	}else{
		$file_found=FALSE;
	}
}

require_once $abs_us_root.$us_url_root.'users/init.php';
 

  
    
 if (!isset ($_GET['cat'])){
     
$uri .= '../upload_pics.php';
header("Location: $uri");
exit;

			

 }


    $db2 = DB::getInstance();

       //getting user name
    
   $user_no_info = $user->data()->id;  

    //getting album name

   $name2 = $_GET['cat'];

   //looking up album_no from album table

 $query1 = $db2->query("SELECT * FROM album WHERE album_name='".$name2."'AND user_no='".$user_no_info."'"); 

 $x1 = $query1->results(true);

   $albumNo=NULL;

    foreach ($x1 as $value1)

                {
                   $albumNo = $value1['no'];
                   break;
                }

   $_SESSION['getCatName'] = $albumNo;

?>



<?php
require_once $abs_us_root.$us_url_root.'users/includes/custom_header.php';
require_once $abs_us_root.$us_url_root.'users/includes/custom_navigation.php';    

//dealing with if the user is logged in
if($user->isLoggedIn() || !$user->isLoggedIn() && !checkMenu(2,$user->data()->id)){
	if (($settings->site_offline==1) && (!in_array($user->data()->id, $master_account)) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')){
		$user->logout();
		Redirect::to($us_url_root.'users/maintenance.php');
	}
}

$grav = get_gravatar(strtolower(trim($user->data()->email)));
$get_info_id = $user->data()->id;
// $groupname = ucfirst($loggedInUser->title);
$raw = date_parse($user->data()->join_date);
$signupdate = $raw['month']."/".$raw['day']."/".$raw['year'];
$userdetails = fetchUserDetails(NULL, NULL, $get_info_id); //Fetch user details

?>

    



<div id="page-wrapper">
<div class="container">
<div class="well">
<div class="row">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="fine-uploader-gallery.min.css" rel="stylesheet">
	<script src="fine-uploader.min.js"></script>		
	<?php require_once("gallery.html"); ?>
	<title>Multiple File Upload using FineUploader</title>
	<style>
	body {width:auto;font-family:calibri;}
	</style>
</head>
<body>
    
  
    <h3>Upload Files to <?php echo ($_GET['cat']);?></h3>

    <p>

    <a href="<?php echo $us_url_root;?>users/album/album.php">Albums</a>
  
     > 


    <a href="<?php echo $us_url_root;?>users/album/upload_pics.php">Upload</a>

    </p>

     <p>  
         
         <br /> 
     
     </p>

    <div id="file-drop-area"></div>

 
    
    <script>
        var multiFileUploader = new qq.FineUploader({
            element: document.getElementById("file-drop-area"),
            request: {
                endpoint: 'view/fine-uploader/endpoint.php'
            },
      
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif','png'],
                itemLimit: 40, // not more than 40 files
                sizeLimit: 1048576 // 1 mb
            }
        });
    </script>


  


   

 </div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->


     <!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
