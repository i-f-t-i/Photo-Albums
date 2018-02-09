
<?php 
 
  $path = $_SERVER['DOCUMENT_ROOT'];
   $path .= "/Photo-Albums/Photo-Album/users/init.php";
 
 
  require_once ($path); 
  
  ?>

<?php require_once $abs_us_root.$us_url_root.'users/includes/custom_header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/custom_navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
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

<?php
    

	if($_POST['formSubmit'] == "Submit") 
    {

		$errorMessage = "";
        $varAlbum = $_POST['album'];

         $db = DB::getInstance(); 

        $user_no_info = $user->data()->id; 

        //getting album no from album

 $query1 = $db->query("SELECT * FROM album WHERE album_name='".$varAlbum."' AND user_no='".$user_no_info."'"); 

  $x1 = $query1->results(true);

    foreach ($x1 as $value1)

                {
                   $albumNo = $value1[no];
                   break;
                }

        // getting info from pics_category

     //  $query = $db->query("SELECT * FROM pics_category WHERE pics_category=?",array($albumNo)," AND user_no=",array($user_no_info)); 

 $query = $db->query("SELECT * FROM pics_category WHERE pics_category='".$albumNo."' AND user_no='".$user_no_info."'"); 


       $r = $query->results(true);

        $count = 0;


          			foreach($r as $value1) 
        {

			$errorMessage .= "<li>".$varAlbum." album has images. Move them to other album or delete these images.</li>";

            $count+=1;

            break;
		}

        if($count < 1){

            $db->delete('album',array('no','=',$albumNo));


			header("Location: album.php");

			exit();
		}
	}
            

    
?>


<!DOCTYPE html>

<html lang="en">
<head>
  <title>Delete Album</title>
  <meta charset="utf-8">
</head>
<body>

 <div id="page-wrapper">
<div class="container">
<div class="well">
<div class="row">

    <?php
    	    if(!empty($errorMessage)) 
		    {
			    echo("<p>Error:</p>\n");
			    echo("<ul>" . $errorMessage . "</ul>\n");
         
            }
   ?>




  <h2>Delete Album</h2>
  <form class="form-horizontal" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">


      <div class="form-group">
  <label class="col-sm-2 control-label">Delete Album</label>
 <div class="col-sm-10">
    <select class="form-control" id="album"  name ="album" >

         <?php
                
                

 $db = DB::getInstance(); 

  $user_no_info = $user->data()->id;

$query = $db->query("SELECT album_name FROM album WHERE user_no='".$user_no_info."'"); 

$x = $query->results(true);


                
               foreach ($x as $value)
                {


                    echo("<option>" . $value[album_name] . "</option>");


                }
          
            

            ?>
   
   
  </select>

</div>
</div>
<div class="form-group"> 
    <div class="col-sm-10">

        <button type="submit" name="formSubmit" value="Submit" class="btn btn-primary">Delete</button>


        
  </div>
   </div> 
              
  </form>

 </div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->

     <!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>


</body>
</html>
