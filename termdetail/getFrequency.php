<?php
$term = $_GET['term'];
$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con)
{
	die('Could not connect: ' . mysqli_error($con));
}

$sql = "SELECT guid,termindexgref FROM term WHERE term = '$term'";
$sqlRes = mysqli_query($con, $sql);
while ( $row = mysqli_fetch_array($sqlRes) )
{
	$frequencyarray = array();
	$termguid = $row['guid'];
	$termindexgref = $row['termindexgref'];
	$sqlfindbook = "SELECT bookgref FROM termindex WHERE guid = '$termindexgref'";
	$sqlfindbookres = mysqli_query($con, $sqlfindbook);
	while ( $rowfb = mysqli_fetch_array( $sqlfindbookres ) )
	{
		$bookguid = $rowfb['bookgref'];
	}
	//$sqlfindpart = "SELECT guid,chapter FROM paragraph WHERE bookgref = '$bookguid'";
	$sqlfindpart="SELECT guid,chapter,  CONVERT(SUBSTRING_INDEX(chapter,'-',-1),UNSIGNED INTEGER) AS part ,CONVERT(SUBSTRING_INDEX(chapter,'-',1),UNSIGNED INTEGER) AS para FROM paragraph WHERE bookgref = '$bookguid' ORDER BY para,part";
	$sqlfindpartres = mysqli_query($con, $sqlfindpart);
	while ( $rowfpart = mysqli_fetch_array($sqlfindpartres))
	{
		$paraguid = $rowfpart['guid'];
		
		$sqlfindfre = "SELECT * FROM phterm WHERE phgref = '$paraguid' AND termgref = '$termguid'";
		$sqlfindfreres = mysqli_query($con, $sqlfindfre);
		while ($rowcountfre = mysqli_fetch_array($sqlfindfreres))
		{
			if ( array_key_exists($rowfpart['para'], $frequencyarray) )
				$frequencyarray[$rowfpart['para']] += $rowcountfre['count'];
			else
				$frequencyarray[$rowfpart['para']] = $rowcountfre['count'];
		}
	}

	echo json_encode($frequencyarray);
	//echo $frequencyarray;
}

?>