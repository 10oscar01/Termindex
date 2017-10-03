<?php include("TTOC.php"); ?>
<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8">
</head>
<body>
<?php
	set_time_limit(0);
	$con = mysqli_connect('localhost','root','kone5566','literatures');
	if (!$con)
  	{
    	die('Could not connect: ' . mysqli_error($con));
  	}
  	mysqli_select_db($con,"term");
  	$sql = "SELECT * FROM term WHERE '1'";
  	$result = mysqli_query($con,$sql);

  	$i = 0;
  	while($row = mysqli_fetch_array($result))
  	{
      $i++;
  		$termgref = $row['guid'];
  		$urlinput = urlencode($row['term']);
      echo "------------------------------------------------------------";
      echo "</br>";
  		$mystring = system("python crawler_wiki.py $urlinput", $retval);
      echo "</br>";
      echo "------------------------------------------------------------";
      echo "</br>";
  		$mystring = strip_tags($mystring);
      $mystring = json_decode("\"".$mystring."\"");
      $termContentRef = substr($mystring,-2);
      $mystring = substr($mystring, 0, strlen($mystring)-2);
  		
  		
  		echo $row['term'];
  		echo "</br>";
  		//echo $mystring;
      
      $utf8_chinese_str = new utf8_chinese;
      $mystring = $utf8_chinese_str->gb2312_big5($mystring);
      echo $mystring;
      echo "</br>";
      echo $termContentRef;
      echo "</br>";
      
      $secsql="UPDATE term SET content='$mystring',contentref='$termContentRef' WHERE guid='$termgref'";
      mysqli_query($con,$secsql);
      
  	}
  	
  	
?>
<body>