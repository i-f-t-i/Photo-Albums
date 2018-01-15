

<?php 
 
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/users/init.php";
 
 
  require_once ($path); 
  
  ?>


<?php
    
 if (!isset ($_GET['cat'])){
     
     header("Location: /users/album/upload_pics.php");

			exit();

 }
   session_start();

    $db2 = DB::getInstance();

       //getting user name
    
   $user_no_info = $user->data()->id;  

    //getting album name

   $name2 = $_GET['cat'];

   //looking up album_no from album table

 $query1 = $db2->query("SELECT * FROM album WHERE album_name='".$name2."'AND user_no='".$user_no_info."'"); 

 $x1 = $query1->results(true);

   

    foreach ($x1 as $value1)

                {
                   $albumNo = $value1[no];
                   break;
                }

   $_SESSION['getCatName'] = $albumNo;

?>



<?php
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

    



<!DOCTYPE html>
<html lang="en">

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

    <a href="/users/album/album.php">Albums</a>
  
     > 


    <a href="/users/album/upload_pics.php">Upload</a>

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
            }
        });
    </script>


  


   



</body>
</html>