
<?php
$conn = mysqli_connect("localhost:3308","root","Keerthi1405@","login");

if (!$conn)
{
     die('could not connect:' .mysqli_connect_error());
  
 }


echo $name = isset($_POST["name"]) ? $_POST["name"] : "";
echo $mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$comment = isset($_POST["comment"]) ? $_POST["comment"] : "";


$sql="INSERT INTO demo VALUES ('$name ', '$mobile','$email ', '$comment ')"; 

if (!mysqli_query($conn,$sql))
{
die('Error in posting values:'. mysqli_connect_error());
}
echo 
"feedback is stored in to the table successfully";

 mysqli_close($conn)

?>