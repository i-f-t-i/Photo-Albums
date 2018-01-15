
<?php 
 
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/users/init.php";
 
 
  require_once ($path); 
  
  ?>

<?php 

   session_start(); // this NEEDS TO BE AT THE TOP of the page before any output etc


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

        header("Location: /users/album/upload/upload_pics.php?cat=".$_POST['access']."");

		
	}


?>

<div id="page-wrapper">
<div class="container">
<div class="well">
<div class="row">

    <?php
    	    if(!empty($errorMessage)) 
		    {
			    echo("<p>There was an error with your form:</p>\n");
			    echo("<ul>" . $errorMessage . "</ul>\n");
         
            }
   ?>

<div class="container">
  <h3>Select Album to Upload</h3>
  <form class="form-horizontal" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      
 

 

      <div class="form-group">
  
 <div class="col-sm-10">
    <select class="form-control" id="access"  name ="access" >

          <?php 

 //getting user name
    
            $user_no_info = $user->data()->id; 

  //getting info from database
                
 $db = DB::getInstance(); 

$query = $db->query("SELECT album_name FROM album WHERE user_no='".$user_no_info."'"); 

$x = $query->results(true);

if (isset($_SESSION['getAlbumName'])){

echo("<option>" . $_SESSION['getAlbumName'] ."</option>");

}
  
               foreach ($x as $value)
                {
                    if ($value[album_name]!=$_SESSION['getAlbumName']){

                   echo("<option>" . $value[album_name] ."</option>"); 
                    
                    }
                 
                }

            ?>

   
   
  </select>

</div>
</div>
<div class="form-group"> 
    <div class="col-sm-10">

        <button type="submit" name="formSubmit" value="Submit" class="btn btn-primary">Select</button>


        
  </div>
   </div> 
              
  </form>

</div>



 </div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->

     <!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>


