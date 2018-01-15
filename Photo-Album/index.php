<?php

if(file_exists("install/index.php")){
	//perform redirect if installer files exist
	//this if{} block may be deleted once installed
	header("Location: install/index.php");
}

require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/custom_header.php';
require_once $abs_us_root.$us_url_root.'users/includes/custom_navigation.php';
?>

<style>
html,body {height:100%;width:100%;}

.jumbotron {background-color:inherit;}
.container-full-bg {width:100%;height:100%;max-width:100%;background-position:center;background-size:cover;}
.container-full-bg .container, .container-full-bg .container .jumbotron {height:100%;width:100%;}
 .container-full-bg h1 {
    color: #68f380;
}
     .container-full-bg p {
    color: #ebe733 ;
}

</style>


 
<div class="container-full-bg" style="background-image:url('css/greg-rakozy 1.jpg');">
	
     

  		 <div class="jumbotron text-center">
               
           

    <h1>Albums</h1> 

    <p>An Open Source Solution for Creating Online Albums</p>
           
          
  
                   </div>

    </div>


     
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->


<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
