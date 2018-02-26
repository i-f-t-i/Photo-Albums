
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
    
   if (isset($_POST['formSubmit']))

   {

	if($_POST['formSubmit'] == "Submit") 
    {

		$errorMessage = "";
        $varName = $_POST['name'];
        $varDes = $_POST['description'];
        $varAccess = $_POST['access'];

				if(empty($varName)) 
        {

			$errorMessage .= "<li>You forgot to enter a name!</li>";

		}

        elseif  (strlen($varName)>35) 
        {

           $errorMessage .= "<li>Name is too long!</li>";
        
         }

          			if(empty($varDes)) 
        {

			$errorMessage .= "<li>You forgot to enter a description!</li>";

		}

        elseif  (strlen($varDes)>45) 
        
        {

           $errorMessage .= "<li>Description is too long!</li>";

          }

          elseif  (empty($errorMessage)) 
        
        {

           $db2 = DB::getInstance();

    //getting album no

    $user_no_info = $user->data()->id; 

    $query1 = $db2->query("SELECT * FROM album WHERE album_name='".$varName."'AND user_no='".$user_no_info."'"); 

    $x1 = $query1->results(true);

   

    foreach ($x1 as $value1)

                {
                   $errorMessage .= "<li>This album already exists!</li>";

                   break;
                }

          }


		if(empty($errorMessage)) 

        {
            //getting user name
    
            $user_no_info = $user->data()->id; 

            //posting to database

            $db = DB::getInstance();

            $fields=array('user_no'=>$user_no_info,'album_name'=>$varName, 'description'=>$varDes, 'publicORprivate'=>$varAccess);

            $db->insert('album',$fields);

			header("Location: album.php?album=".$varName);

			exit();
		}
	}
            
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


  <h2>Create Album</h2>
  <form class="form-horizontal" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      
    <div class="form-group">
      <label class="col-sm-2 control-label">Album Name</label>
      <div class="col-sm-10">
        <input class="form-control" id="name" name ="name" type="text" value="">
      </div>
    </div>

   <div class="form-group">
      <label class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10">
        <input class="form-control" id="description"  name ="description" type="text" value="">
      </div>
    </div>

      <div class="form-group">
  <label class="col-sm-2 control-label">Access</label>
 <div class="col-sm-10">
    <select class="form-control" id="access"  name ="access" >

    <option>Private</option>
    
   
   
  </select>

</div>
</div>
<div class="form-group"> 
    <div class="col-sm-10">

        <button type="submit" name="formSubmit" value="Submit" class="btn btn-primary">Create</button>


        
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


