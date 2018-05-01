<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php require_once 'init.php'; ?>
<?php  require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!

if($user->isLoggedIn()) { $thisUserID = $user->data()->id;} else { $thisUserID = 0; }

if(isset($_GET['id']))
	{
	$userID = Input::get('id');
	
	$userQ = $db->query("SELECT * FROM profiles LEFT JOIN users ON user_id = users.id WHERE user_id = ?",array($userID));
	$thatUser = $userQ->first();

	if($thisUserID == $userID)
		{
		$editbio = ' <small><a href="edit_profile.php">Edit Bio</a></small>';
		}
	else
		{
		$editbio = '';
		}
	
	$ususername = ucfirst($thatUser->username)."'s Profile";
	$grav = get_gravatar(strtolower(trim($thatUser->email)));
	$useravatar = '<img src="'.$grav.'" class="img-thumbnail" alt="'.$ususername.'">';
	$usbio = html_entity_decode($thatUser->bio);
	//Uncomment out the line below to see what's available to you.
	//dump($thisUser);
	}
else
	{
	$ususername = '404';
	$usbio = 'User not found';
	$useravatar = '';
	$editbio = ' <small><a href="/">Go to the homepage</a></small>';
	}
?>


<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>Gallery</title>


  <!-- blueimp-gallery POP Up Picture Style Sheet --> 


        <link rel="stylesheet" href="album/css/blueimp-gallery.min.css">

<!-- Gallery pictures Style Sheet --> 

         <link rel="stylesheet" href="album/css/gallerystyle1.css">

          </head>
    <body>



   <div id="page-wrapper">

		 <div class="container">
				<!-- Main jumbotron for a primary marketing message or call to action -->
				<div class="well">
					<div class="row">
						<div class="col-xs-12 col-md-2">
							<p><?php echo $useravatar;?></p>
						</div>
						<div class="col-xs-12 col-md-10">
						<h1><?php echo $ususername;?></h1>
							<h2><?php echo $usbio.$editbio;?></h2>
	
					</div>
					</div>
				</div>
				
										

               <!--------List Albums------->

<?php
    

if(isset($_GET['id']))

{

             $usersAlbumsQ = $db->query("SELECT album_name FROM album WHERE user_no='".$userID."' AND publicORprivate = 'Public' ORDER BY user_no ASC");

$file_info = $usersAlbumsQ->results(true);

?>

              <div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    Public Albums <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">

        <?php


                  
				
				foreach ($file_info as $Data) {
				 
                  ?>

      <li><a href="profile.php?id=<?= $userID; ?>&album=<?= $Data["album_name"]; ?>"><?= $Data["album_name"]; ?></a></li>
      
         <?php

				}

}

				?>

    </ul>
  </div>




              <!--------Public Albums------->


           



             <h3><?php  
  
  if (isset($_GET['album']))

   {
  
  echo $_GET['album']; 
    
    }

    ?>
    
    </h3>

<div class="well">
<div class="row">

   
    

    <div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    </div>

       

    <div class="content slide">     <!--	Add "slideRight" class to items that move right when viewing Nav Drawer  -->

<div id="links">

       <?php
           
   $db2 = DB::getInstance();
           
   //getting album name

   if (isset($_GET['album']))

   {
        
    $name2 = $_GET['album']; 

   

    //getting album no

    $user_no_info = $user->data()->id; 

    $query1 = $db2->query("SELECT * FROM album WHERE album_name='".$name2."'AND user_no='".$user_no_info."' AND publicORprivate = 'Public'"); 

    $x1 = $query1->results(true);

   $albumNo = NULL;

    foreach ($x1 as $value1)

                {
                   $albumNo = $value1['no'];
                   break;
                }

               

    //getting user name
    
   $user_no_info = $user->data()->id;       

//getting pictures info for a user

$query2 = $db2->query("SELECT * FROM pics_category WHERE pics_category='".$albumNo."' AND user_no='".$user_no_info."'");

$x2 = $query2->results(true);

                               
               foreach ($x2 as $value2)

                {

                   echo(" <div class='responsive'>");
                    
                  echo("<div class='gallery'>");

                   echo("<a target='_blank' href='album/upload/data/".$value2['folder']."/".$value2['file']."'>");

            echo("<img src='album/upload/data/".$value2['folder']."/resize".$value2['file']."' alt='' width='600' height='400'> </a>");
               
            echo("</div>");

          $catNo = $value2['no'];
          $fileValue = $value2['file'];
           $folderValue =  $value2['folder'];
           $albumName = $value2['pics_category'];    

 
            echo("</div>");
                                           
                }
          
   }

            ?>




    </div>

            </div>

     </div> <!-- /.col -->
		</div> <!-- /.row -->


              <!--------Pulbic Albums------->


    </div> <!-- /container -->

</div> <!-- /#page-wrapper -->
 
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>
<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>


   
  <!-- Photo Pop Up Click Javascript -->       

        <script>
document.getElementById('links').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
</script>

    <script src="album/js/blueimp-gallery.min.js"></script>
        

 </body>    

</html>