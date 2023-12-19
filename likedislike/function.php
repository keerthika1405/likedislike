
<?php
require 'config.php';

$post_id = isset($_POST["post_id"]) ? $_POST["post_id"] : "";
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : "";
$status = isset($_POST["status"]) ? $_POST["status"] : "";

// echo '$post_id'

// $post_id = $_POST["post_id"];
// $user_id = $_POST["user_id"];
// $status = $_POST["status"];

$ratings = mysqli_query($conn, "SELECT * FROM ratings WHERE post_id = '$post_id' AND user_id = '$user_id' "); 

if(mysqli_num_rows($ratings) > 0)// user has noted the post
{ 
$rating = mysqli_fetch_assoc($ratings);

if($rating['status'] == $status){//her izlete their rating

mysqli_query($conn, "DELETE FROM ratings WHERE post_id = '$post_id' AND user_id = '$user_id' ");

   echo "delete". $status; // Send response that theater is deleting their Like
}
else{
 mysqli_query($conn, "UPDATE ratings SET `status` = '$status' WHERE post_id = '$post_id' AND user_id = '$user_id' ");

  echo "changeto" . $status; // Senf response that the user is change their rating to like or to dislike
}
}
else{ 
    mysqli_query($conn, "INSERT INTO ratings VALUES('', '$post_id', '$user_id', '$status') ");
    
   echo "new" . $status;
 }
?> 











