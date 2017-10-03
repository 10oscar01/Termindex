<html>
<head>
	<meta charset="utf-8"> 
	
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel = "stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php
	$str = $_GET['str'];
//	echo $str;

	$db = mysqli_connect('localhost','root','kone5566','literatures');
  	if (!$db)
  	{
    	die('Could not connect: ' . mysqli_error($db));
  	}
  	//--------------------------------------------------------------------------

  	$sql = "SELECT * FROM book WHERE title LIKE ('$str')";
	$bookresult = mysqli_query($db,$sql);
	while($row = mysqli_fetch_array($bookresult))
	{	
    	$bookguid = $row['guid'];
	}

//	echo $bookguid;

	$sql = "SELECT * FROM termindex WHERE bookgref LIKE ('$bookguid')";
	$termindexguid = mysqli_query($db,$sql);
	$indexarray = array();
	while($row = mysqli_fetch_array($termindexguid))
	{
    	array_push($indexarray, $row['guid']);
	}
	foreach($indexarray as $value)
	{
		$sql = "SELECT * FROM term WHERE termindexgref LIKE ('$value')";
		$termresult = mysqli_query($db,$sql);
		while($row = mysqli_fetch_array($termresult))
		{
			//"<div class='"."Tdiv"."' style='"."text-align:center;font-family:Microsoft JhengHei;"."'>";
			//wikiPediaUrl = "https://zh.wikipedia.org/wiki/";
			//taiwanWikiUrl = "http://www.twwiki.com/wiki/";
			$cRef = $row['contentref'];
			$refUrl = "";
			$urlText = "";
			$termUrl = urlencode($row['term']);
			if ($cRef == 'WP')
			{
				$refUrl = "https://zh.wikipedia.org/wiki/".$termUrl;
				$urlText = "...(Wikipedia)";
			}
			else if ($cRef == 'TW')
			{
				$refUrl = "http://www.twwiki.com/wiki/".$termUrl;
				$urlText = "...(TaiwanWiki)";
			}

			echo "<div class="."panel panel-default".">";
			echo  "<div class="."panel-heading".">";
			echo $row['term'];
			echo  "<button class="."btn fulltextbtn"." style="."float: right;"." onclick="."fullText('".$row['term']."');>全文檢索</button>";
			echo  "</div>";
			echo  "<div class="."panel-body".">";
			echo $row['content']."<a target="."_blank"." href=$refUrl>$urlText</a>";
			echo  "</div>";
    		echo "</div>";
    		
		}
	}
?>
</body>
</html>