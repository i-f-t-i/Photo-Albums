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


if (isset($_GET['foldername'])){
    
    if (isset($_GET['filename'])){

        if (isset($_GET['albumname'])){
        
        $foldername= $_GET['foldername'];

        $filename= $_GET['filename'];

        $albumname = $_GET ['albumname'];


           $db = DB::getInstance();


       $db->delete('pics_category',array('folder','=',$foldername));
       
       $foldername="$foldername";



// deleting folder and its contents
     
$path = "upload/data/".$foldername;

{  
          $dirPath = $path;
          $TrackDir=opendir($dirPath);
          $i = 0;
           while ($file = readdir($TrackDir)) { 
                if ($file == "." || $file == "..") { } 
                    else {
                    $narray[$i]=$file;  
                    $i++;               
                } 
            }     
            $count1 = count($narray);

            if($count1 > 0){       
                $r=0;
                while($r < $count1){
                    $Filename = $narray[$r];
                    $myFile = $dirPath."/".$Filename;
                    unlink($myFile);                        
                    $r++;
                }   
                rmdir($dirPath);
            }else{
                rmdir($dirPath);
            }
            closedir($TrackDir);
}

    $user_no_info = $user->data()->id; 

    $query1 = $db->query("SELECT * FROM album WHERE no ='".$albumname."' AND user_no='".$user_no_info."'"); 

  $x1 = $query1->results(true);

    foreach ($x1 as $value1)

                {
                   $albumName2 = $value1[album_name];
                   break;
                }

     header("Location: album.php?album=".$albumName2."");
    }
}

}

?>


