<?php 
 
  $path = $_SERVER['DOCUMENT_ROOT'];
  $path .= "/Photo-Albums/Photo-Album/users/init.php";
 
 
  require_once ($path); 
  
  ?>

<?php

   session_start();
   $_SESSION['getAlbumName'] = $_GET['album'];

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



<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>Gallery</title>

<!-- blueimp-gallery POP Up Picture Style Sheet --> 


        <link rel="stylesheet" href="css/blueimp-gallery.min.css">

<!-- Gallery pictures Style Sheet --> 

         <link rel="stylesheet" href="css/gallerystyle1.css">



<!-- Scripts --> 

        <!-- Move & Delete Functions Javascript Script -->

 <script type="text/javascript" language="javascript" src="js/galleryfunctions1.js"></script>

      

    </head>
    <body>

        

<div id="page-wrapper">
<div class="container">

    <h3><?php  echo $_GET['album']; ?></h3>

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
        
    $name2 = $_GET['album']; 

    //getting album no

    $user_no_info = $user->data()->id; 

    $query1 = $db2->query("SELECT * FROM album WHERE album_name='".$name2."'AND user_no='".$user_no_info."'"); 

    $x1 = $query1->results(true);

   

    foreach ($x1 as $value1)

                {
                   $albumNo = $value1[no];
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

                   echo("<a target='_blank' href='upload/data/".$value2[folder]."/".$value2[file]."'>");

            echo("<img src='upload/data/".$value2[folder]."/resize".$value2[file]."' alt='' width='600' height='400'> </a>");
               
            echo("</div>");

          $catNo = $value2[no];
          $fileValue = $value2[file];
           $folderValue =  $value2[folder];
           $albumName = $value2[pics_category];

         echo("<button id='close-image' onclick='deleteFunction(\"$fileValue\",\"$folderValue\",\"$albumName\")'><img src='/users/album/images/erase.png'></button>");

          echo("<button id='close-image' onclick='moveFunction(\"$catNo\",\"$fileValue\",\"$folderValue\",\"$albumName\")'><img src='/users/album/images/move.png'></button>");

            echo("</div>");
                                           
                }
          
             

            ?>




    </div>

            </div>



    
       </div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->



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

    <script src="js/blueimp-gallery.min.js"></script>
        

 </body>    

</html>
