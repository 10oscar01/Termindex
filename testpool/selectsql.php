<?php
//-------------------------------------------------
$option_title = [];
$option_guid = [];
//-------------------------------------------------


	$con = mysqli_connect('localhost','root','kone5566','literatures');
  	if (!$con)
  	{
        die('Could not connect: ' . mysqli_error($con));
  	}
//-------------------------------------------------
    array_push($option_title,"請選擇");
    array_push($option_guid,"");

  	mysqli_select_db($con,"book");
  	$sql = "SELECT title,guid FROM book";
  	$result = mysqli_query($con, $sql);
  	while($row = mysqli_fetch_array($result))
  	{
  		  array_push($option_title,$row['title']);
  		  array_push($option_guid,$row['guid']);
  	}
    
	echo "<select id = "."bookname"." onChange=renew(this.value);>";
	for ($i = 0; $i < sizeof($option_title); $i++ )
	{
		  echo "<option value = $option_guid[$i]>$option_title[$i]</option>";
	}
	echo "</select>";
?>