<?php
//-------------------------------------------------


    $con = mysqli_connect('localhost','root','kone5566','literatures');
  	if (!$con)
  	{
        die('Could not connect: ' . mysqli_error($con));
  	}
//-------------------------------------------------
  	/*
  	$cars = [];
  	array_push($cars, "123");
  	$guid =  $_POST["bookguid"];
	echo json_encode($cars);
	*/

	  $index = [];
	  $indexguid = [];
  	$bookgref =  $_POST["bookguid"];
  	
  	mysqli_select_db($con,"termindex");
  	$sql = "SELECT * FROM termindex WHERE bookgref = '$bookgref'";
  	
  	$result = mysqli_query($con, $sql);

  	while ( $row = mysqli_fetch_array($result) )
  	{
  		  array_push($index, $row['class']);
  		  array_push($index, $row['guid']);
  	}
  	echo json_encode($index);
  	

  	
  
?>