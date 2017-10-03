<?php 
$text = $_GET['text'];
$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con)
{
	die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"book");
$sql = "SELECT * FROM book WHERE title = '$text'";
$result = mysqli_query($con, $sql);

if(mysqli_num_rows($result) == 1)
	echo "book";
else
	echo "term";


?>