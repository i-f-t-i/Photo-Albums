
function deleteFunction(filename,foldername,albumname) {


var txt;
var r = confirm("Delete pic "+filename);


if (r == true) {
    

   window.location.replace("delete_image.php?albumname="+albumname+"&foldername="+foldername+"&filename="+filename);


} else {
   
    txt = "You pressed Cancel!";
}

}


function moveFunction(no,filename,foldername,albumname) {


var txt;
var r = confirm("Move pic "+filename);


if (r == true) {
    

   window.location.replace("move_image.php?pic="+no+"&albumname="+albumname+"&foldername="+foldername+"&filename="+filename);


} else {
   
    txt = "You pressed Cancel!";
}

}
