<?php
$term = $_GET["term"];
$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con)
{
	die('Could not connect: ' . mysqli_error($con));
}
/*-------------search term in Term-Table-------------*/
mysqli_select_db($con,"term");
$sql = "SELECT * FROM term WHERE term = '$term'";
$sqlRes = mysqli_query($con, $sql);
while ( $row = mysqli_fetch_array($sqlRes))
{
	//echo $row['content'];

	echo "<div class="."panel panel-default".">";
    echo  "<div class="."panel-heading".">";
    echo $term;
    echo "<button class="."editTerm".">編輯</button>";
    echo  "</div>";
    echo  "<div class="."panel-body".">";
    echo $row['content'];
    echo  "</div>";
    echo "</div>";
}
?>