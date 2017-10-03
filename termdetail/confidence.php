<?php
$term = $_GET['term'];
$termGuid = array();
$termIndexGref = array();
$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con)
{
	die('Could not connect: ' . mysqli_error($con));
}
/*-------------search term in Term-Table-------------*/
mysqli_select_db($con,"term");
$sql = "SELECT * FROM term WHERE term = '$term'";
$result = mysqli_query($con,$sql);
while ( $row = mysqli_fetch_array($result))
{
	array_push($termGuid, $row['guid']);
	array_push($termIndexGref, $row['termindexgref']);
}
/*
echo $termGuid;
echo "<br/>";
echo $termIndexGref;
*/
/*-------------processing and calculating confidence in Phterm-Table-------------*/
foreach (array_combine($termGuid,$termIndexGref) as $termGuid => $termIndexGref)
{
	mysqli_select_db($con,"phterm");
	//echo $termGuid." ".$termIndexGref;
	$termCounter = 0;
	$termCountArray = array();
	$sql = "SELECT * FROM phterm WHERE termgref = '$termGuid'";
	$result = mysqli_query($con, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		
		
		$termCounter += $row['count'];
		
		$phgref = $row['phgref'];
		$sqlCountTerm = "SELECT * FROM phterm WHERE phgref = '$phgref'";
		$sqlCountTermRes = mysqli_query($con, $sqlCountTerm);
		while ($rowT = mysqli_fetch_array($sqlCountTermRes))
		{
			$addr = 0;
			if ($rowT['count'] >= $row['count'])
				$addr = $row['count'];
			else if ($rowT['count'] < $row['count'])
				$addr = $rowT['count'];
			
			if (array_key_exists($rowT['termgref'], $termCountArray))
				$termCountArray[$rowT['termgref']]+= $addr;
			else
				$termCountArray[$rowT['termgref']] = $addr;
			/*
			if (array_key_exists($rowT['termgref'], $termCountArray))
				$termCountArray[$rowT['termgref']]+= $rowT['count'];
			else
				$termCountArray[$rowT['termgref']] = $rowT['count'];
			*/
		}

	}
	arsort($termCountArray);
	$limit = 0;
	echo "<table class="."table".">";
	echo "<thead>";
    echo   "<tr>";
    echo    "<th>詞</th>";
    echo    "<th>相關性</th>";
    echo  "</tr>";
    echo "</thead>";
    echo "<tbody>";
	foreach ( $termCountArray as $key => $value)
	{
		if ( $limit >= 10 ) break;
		$limit++;
		mysqli_select_db($con,"term");
		$sql = "SELECT * FROM term WHERE guid = '$key'";
		$sqlRes = mysqli_query($con, $sql);
		while ($row = mysqli_fetch_array($sqlRes))
		{
			$confidenceTerm = $row['term'];
		}
		$confidenceCal = ($value/$termCounter)*(100);
		echo "<tr>";
		echo "<td>".$confidenceTerm."</td>";
		echo "<td>".$confidenceCal."</td>";
		echo "</tr>";
		
	}
	echo "</tbody>";
	echo "</table>";
}
?>