<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <script language="javascript" type="text/javascript"></script>
  <script src="mark.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/mark.js/7.0.0/mark.min.js"></script>
<style type="text/css">
        body {
  margin: 15px;
  background-color: #E8FFE8; 

}

div.search span,
div.search input[name="keyword"] {
  display: block;
}

div.search input[name="keyword"] {
  margin-top: 4px;
}

div.panel {
  margin-bottom: 15px;
}

div.panel .panel-body p:last-child {
  margin-bottom: 0;
}

mark {
  padding: 0;
}
.line{
  border:2px #D9D9D9 solid;
  text-align: 10px;
  font-family:Microsoft JhengHei;
  background-color: #F2FFF2;
}
  </style>
</head>
<body>

<?php
$booktitle = $_GET['title'];
$termindex = $_GET['tid'];
$term = $_GET['term'];
//$tag = $_GET['tag'];
//$utag = $_GET['utag'];
$parent=$booktitle." ".$termindex;
$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
//echo $booknum;
//echo $chapter;
/*
echo $booktitle."<br/>";
echo $termindex."<br/>";
echo $term."<br/>";
echo $tag."<br/>";
echo $utag."<br/>";
echo $parent;
*/
mysqli_select_db($con,"term");
$def = "SELECT * FROM term WHERE term='".$term."';";
$result = mysqli_query($con,$def);


if (mysqli_num_rows($result)<1){
  mysqli_select_db($con,"termindex");
  $gusql = "SELECT uuid();";
  $result = mysqli_query($con,$gusql);
  while ($row = $result->fetch_assoc()) {
        $guid =  $row['uuid()'];
    }

  $tidgref_sql="SELECT guid FROM termindex WHERE booktitle = '".$booktitle."' AND class='".$termindex."';";
  $result = mysqli_query($con,$tidgref_sql);
  while ($row = $result->fetch_assoc()) {
         $gref =  $row['guid'];
      }
  echo "guid: ".$guid."<br/>";
  echo "termgref: ".$gref."<br/>";
  //echo $gref;
  mysqli_select_db($con,"term");
  $gref = strtoupper($gref);
  $guid = strtoupper($guid);
  $sql = "INSERT INTO term (guid,termindexgref,parent,term) VALUES ('".$guid."','".$gref."','".$parent."','".$term."');";
  mysqli_query($con,$sql)or die ("無法新增".mysql_error());
  }
else echo "資料已存在";
mysqli_close($con);
/*
$sql="SELECT *, MATCH (unitext) AGAINST
    ('".$q."') AS score
    FROM book WHERE MATCH (unitext) AGAINST
    ('".$q."'IN BOOLEAN MODE)
    ORDER BY score DESC;";
$result = mysqli_query($con,$sql);
*/


/*
echo "<div style='"."text-align:left;font-family:Microsoft JhengHei"."'>"."共 ".mysqli_num_rows($result)." 筆結果"."</div>";
//echo $q;
echo "<table class='"."line"."' style='"."text-align:center"."'>";
echo "<tr class='"."line"."'>";
echo "<th class='"."line"."' style='"."width:5%"."'>序號</th>";/*ID*/
/*
echo "<th class='"."line"."' style='"."width:5%"."'>章節</th>";/*chapter*/
/*
echo "<th class='"."line"."' style='"."width:75%"."'>內文</th>";/*Realtext*/
/*
echo "<th class='"."line"."' style='"."width:15%"."'>結果分數</th>";/*Score*/
/*
echo "</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr class='"."line"."'>";
    echo "<td class='"."line"."'>" . $row['id'] . "</td>";
    echo "<td class='"."line"."'>" . $row['chapter'] . "</td>";
    echo "<td class='"."line"."'>" . $row['realtext'] . "</td>";
  //  echo "<td>" . $row['unitext'] . "</td>";
    echo "<td class='"."line"."'>" . $row['score'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);
*/
?>
</body>
</html>