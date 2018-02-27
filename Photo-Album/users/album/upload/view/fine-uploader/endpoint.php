<?php 

   session_start(); // this NEEDS TO BE AT THE TOP of the page before any output etc


?>


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


   
require_once 'php_image_magician.php';  

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


<?php

// Include the upload handler class
// require_once "upload_pics.php"

require_once "handler.php";

$uploader = new UploadHandler();

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
$uploader->allowedExtensions = array("jpeg","jpg","gif","png"); // all files types allowed by default

// Specify max file size in bytes.
$uploader->sizeLimit = 1048576; // 1 MB

// Specify the input name set in the javascript.
$uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
$uploader->chunksFolder = "../../data/chunks";

$method = get_request_method();

// This will retrieve the "intended" request method.  Normally, this is the
// actual method of the request.  Sometimes, though, the intended request method
// must be hidden in the parameters of the request.  For example, when attempting to
// delete a file using a POST request. In that case, "DELETE" will be sent along with
// the request in a "_method" parameter.
function get_request_method() {
    global $HTTP_RAW_POST_DATA;

    if(isset($HTTP_RAW_POST_DATA)) {
    	parse_str($HTTP_RAW_POST_DATA, $_POST);
    }

    if (isset($_POST["_method"]) && $_POST["_method"] != null) {
        return $_POST["_method"];
    }

    return $_SERVER["REQUEST_METHOD"];
}

if ($method == "POST") {
    header("Content-Type: text/plain");

    // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
    // For example: /myserver/handlers/endpoint.php?done
    if (isset($_GET["done"])) {
        $result = $uploader->combineChunks("../../data");
    }
    // Handles upload requests
    else {

        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        $result = $uploader->handleUpload("../../data");

        $folder["name"] = $uploader->getUploadfolder();

        // To return a name used for uploaded file you can use the following line.
        $result["uploadName"] = $uploader->getUploadName();

       if (isset($result["uploadName"]))

       {

        $db = DB::getInstance();

        //getting user name
    
            $user_no_info = $user->data()->id; 

            //posting to database


        $fields=array('user_no'=>$user_no_info,'pics_category'=>$_SESSION['getCatName'], 'folder'=>$folder["name"], 'file'=>$result["uploadName"]);

         $db->insert('pics_category',$fields);

         // resize the files

         	// require_once('../php_image_magician.php');

     

	/*	Purpose: Open image
     *	Usage:	 resize('filename.type')
     * 	Params:	 filename.type - the filename to open
     */
	 $magicianObj = new imageLib("../../data/".$folder["name"]."/".$result["uploadName"]."");

  //  $magicianObj = new imageLib('../../data/06cdc2ad-8f9b-4193-9d21-0739b0dc0cf2/blog-970722_640.jpg');

	/*	Purpose: Resize image
     *	Usage:	 resizeImage([width], [height])
     * 	Params:	 width - the new width to resize to
     *			 height - the new height to resize to 
     */	
	 $magicianObj -> resizeImage(600, 400);


	/*	Purpose: Save image
     *	Usage:	 saveImage('[filename.type]', [quality])
     * 	Params:	 filename.type - the filename and file type to save as
 	 * 			 quality - (optional) 0-100 (100 being the highest (default))
     *				Only applies to jpg & png only
     */
	 $magicianObj -> saveImage('../../data/'.$folder["name"].'/resize'.$result["uploadName"].'', 100);

	// $magicianObj -> saveImage('../../data/06cdc2ad-8f9b-4193-9d21-0739b0dc0cf2/test.jpg');

       }

    }

    echo json_encode($result);
}
// for delete file requests
else if ($method == "DELETE") {
    $result = $uploader->handleDelete("../../data");
    echo json_encode($result);
}
else {
    header("HTTP/1.0 405 Method Not Allowed");
}
?>