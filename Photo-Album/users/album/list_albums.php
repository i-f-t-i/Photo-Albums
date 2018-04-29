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
 
$path_for = $us_url_root;
 
  
  ?>


<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>

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

  $db = DB::getInstance();

  //getting user name
    
   $user_no_info = $user->data()->id; 

$usersAlbumsQ = $db->query("SELECT no,album_name,publicORprivate FROM album WHERE user_no='".$user_no_info."' ORDER BY user_no ASC");

$album_info = $usersAlbumsQ->results(true);

?>
<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-sm-12">
        
        <!-- Left Column -->
        <div class="class col-sm-3"></div>

        <!-- Main Center Column -->
        <div class="class col-sm-6">
          <!-- Content Goes Here. Class width can be adjusted -->

			<form name='adminPermissions' action='<?=$_SERVER['PHP_SELF']?>' method='post'>
			  <h2>List of Albums</h2>
			  

			  <br>
			  <table class='table table-hover table-list-search'>
				<tr>
				  <th>No</th><th>Albums</th><th>Modify</th><th>Access</th>
				</tr>

				<?php
        
                  $count_no = 1;

                  $pathforimage2 = $path_for.'users/album/album.php?album=';

                  $pathforModify = $path_for.'users/album/update_album.php?album=';
				
				foreach ($album_info as $Data) {
				  ?>
				  <tr>
					<td><?=$count_no;?></a></td>

					<td> <a href="<?php echo ("$pathforimage2"); echo ($Data['album_name']); ?>"><?= $Data["album_name"]; ?> </a>  </td>

                    <td> <a href="<?php echo ("$pathforModify"); echo ($Data['no']); ?>"><?php echo "Update/Modify"; ?> </a>  </td>

                    <td> <a href="<?php echo ("$pathforModify"); echo ($Data['no']); ?>"><?= $Data["publicORprivate"]; ?> </a>  </td>

				  </tr>


				  <?php
          
                 $count_no+=1;
				  
				}
				?>

			  </table>


			  
			</form>

          <!-- End of main content section -->
        </div>

        <!-- Right Column -->
        <div class="class col-sm-1"></div>
      </div>
    </div>
	</div>
	</div>

    <!-- /.row -->

    <!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>

