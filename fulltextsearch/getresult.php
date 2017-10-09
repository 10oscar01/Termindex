<?php 

$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con)
{
  die('Could not connect: ' . mysqli_error($con));
}

//-------------------------------------------------

if (isset($_GET['uni_term']))
{
  $keyword_set = mysqli_real_escape_string($con, $_GET['uni_term']);
  mysqli_select_db($con,"paragraph");


  $keyword_set = str_replace ("+","",$keyword_set);
  $arrays = explode("20",$keyword_set);
  array_filter($arrays);
  $sqls = "SELECT *,Match(unitext) AGAINST ('$keyword_set' IN BOOLEAN MODE)  from paragraph WHERE";
  for($i = 0; $i < sizeof($arrays); $i++)
  {
    if ($arrays[$i] == " ")continue;
    $arrays[$i] = trim($arrays[$i]);
    if (preg_match("/ 7c /", $arrays[$i]))
    {
      $orArrays = explode("7c", $arrays[$i]);
      if ($i == 0)
      {
        for ( $j = 0; $j < sizeof($orArrays); $j++ )
        {
          if ($j == 0)
            $sqls = $sqls." ((unitext) LIKE '%$orArrays[0]%'";
          else
            $sqls = $sqls." OR (unitext) LIKE '%$orArrays[1]%'";
        }
          $sqls = $sqls.")";
      }
      else
      {
        for ( $j = 0; $j < sizeof($orArrays); $j++ )
        {
          if ($j == 0)
            $sqls = $sqls." AND ((unitext) LIKE '%$orArrays[0]%'";
          else
            $sqls = $sqls." OR (unitext) LIKE '%$orArrays[1]%'";
        }
        $sqls = $sqls.")";
      }
    }
    else if (substr($arrays[$i],0,2) == "2d")
    {
      $noterm = substr($arrays[$i],3,sizeof($arrays[$i])-3);
      if ($i == 0)
        $sqls = $sqls." (unitext) NOT LIKE '%$noterm%'";
      else
        $sqls = $sqls." AND (unitext) NOT LIKE '%$noterm%'";
    }
    else
    {
      if ($i == 0)
        $sqls = $sqls." (unitext) LIKE '%$arrays[$i]%'";
      else
        $sqls = $sqls." AND (unitext) LIKE '%$arrays[$i]%'";
    }
  }
  //--------------------------------------------------
  $result = mysqli_query($con,$sqls);
  $paragraph_output_array = array(); 
  while($row = mysqli_fetch_array($result))
  {
    mysqli_select_db($con,"book");
    $bookid = $row['bookgref'];
    $sql="SELECT title FROM book WHERE guid = '".$row['bookgref']."';";
    $titleFind = mysqli_query($con,$sql);
    $title="";
    while($titleInTableResult = mysqli_fetch_array($titleFind))
    {
      $title = $titleInTableResult['title']; //data 1
    }
    $paragraph_chapter = $row['chapter'];    //data 2
    $paragraph_graf = $row['bookgref'];      //data 3
    $paragraph_text = $row['realtext'];      //data 4
    $element_in_output_arr = array( 'title' => $title, 'chapter' => $paragraph_chapter, 'text' => $paragraph_text );

    array_push($paragraph_output_array, $element_in_output_arr);
  }

  echo json_encode($paragraph_output_array);
}

if (isset($_GET['get_phterm_count']))
{
  echo "OK";
}
/*
//$ptsql="SELECT guid FROM paragraph WHERE MATCH(unitext) AGAINST('".$q."'IN BOOLEAN MODE);";
$ptsql = $sqls;
$ptresult = mysqli_query($con,$ptsql);
$c=mysqli_num_rows($ptresult);
mysqli_select_db($con,"phterm");
$findptsql = "SELECT termgref,count,guid, sum(count) as count FROM phterm WHERE";
//select guid,termgref, sum(count) as count from phterm group by termgref

while($row = mysqli_fetch_array($ptresult))
{
    $c-=1;
    $findptsql=$findptsql." phgref='".$row['guid']."'";
    if($c!=0)
      $findptsql=$findptsql." OR";
}
$findptsql=$findptsql." group by termgref ORDER BY count DESC;";
$findptresult=mysqli_query($con,$findptsql);
*/





/*
echo "<div>";
echo  "<ul class='nav nav-tabs'>";
echo    "<li class="."active"."><a data-toggle="."tab"." href="."#home".">總覽</a></li>";
echo    "<li><a data-toggle="."tab"." href="."#menu1".">人名</a></li>";
echo    "<li><a data-toggle="."tab"." href="."#menu2".">地名</a></li>";
echo    "<li><a data-toggle="."tab"." href="."#menu3".">其他</a></li>";
echo  "</ul>";

echo  "<div class="."tab-content".">";
echo    "<div id="."home"." class='tab-pane fade in active'>";
//echo      "<h3>HOME</h3>";
echo "<table style='"."text-align:center;width:100%;float:right;border:2px #D9D9D9 solid;background-color:#FFFFFF;"."'>";

echo "<tr>";
echo "<th style='"."width:60%;border:2px #D9D9D9 solid;text-align:center;"."'>詞</th>";/*Realtext
echo "<th style='"."width:40%;border:2px #D9D9D9 solid;text-align:center;"."'>次數</th>";/*Score
echo "</tr>";
*/
/*
$character = array();
$character_count = array(); 
$local = array();
$local_count = array();
$other = array();
$other_count = array();
while($row = mysqli_fetch_array($findptresult)) 
{
  $realterm = "";
  mysqli_select_db($con,"term");
  $findterm = "SELECT term,termindexgref FROM term WHERE guid='".$row['termgref']."';";
  $termresult = mysqli_query($con,$findterm);
  $classgerf =" ";
  while ($trow = mysqli_fetch_array($termresult)) 
  {
    $realterm = $trow['term'];
    $classgerf = $trow['termindexgref'];
  }
    
  /*
  echo "<tr style='"."width:60%;border:2px #D9D9D9 solid;"."'>";
  echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>
            <a id="."termA"." href="."#"." onclick="."termAdd('".$realterm."');return false;".">"."+"."</a>

            <a id="."termA"." href="."#"." onclick="."newTerm('".$realterm."');return false;".">"."$realterm"."</a>

            <a id="."termA"." href="."#"." onclick="."termAdd('-".$realterm."');return false;".">"."-"."</a>
        </td>";
  echo "<td style='"."width:60%;border:2px #D9D9D9 solid;"."'>" . $row['count'] . "</td>";
  echo "</tr>";
*/
  /*
  mysqli_select_db($con,"termindex");
  $findclass = "SELECT class FROM termindex WHERE guid='".$classgerf."';";
  $classresult = mysqli_query($con,$findclass);
  while($crow = mysqli_fetch_array($classresult)) 
  {
    if( $crow['class'] == "人名")
    {
      array_push($character, $realterm);
      array_push($character_count, $row['count']);
      
    }
    else if( $crow['class'] == "地名")
    {
      array_push($local, $realterm);
      array_push($local_count, $row['count']);
    }

    else 
    {
      array_push($other, $realterm);
      array_push($other_count, $row['count']);
    }
  }
}
/*
echo "</table>";
echo    "</div>";
echo    "<div id="."menu1"." class='tab-pane fade'>";
echo "<table style='"."text-align:center;width:100%;border:2px #D9D9D9 solid;background-color:#FFFFFF;"."'>";

echo "<tr>";
echo "<th style='"."width:60%;border:2px #D9D9D9 solid;text-align:center;"."'>詞</th>";/*Realtext
echo "<th style='"."width:40%;border:2px #D9D9D9 solid;text-align:center;"."'>次數</th>";/*Score
echo "</tr>";
*/
/*
for($x = 0;$x<sizeof($character);$x++){
 $partition[0] = $character[$x];
 $partition[1] = $character_count[$x];
 echo "<tr style='"."width:60%;border:2px #D9D9D9 solid;"."'>";
 echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>

        <a id="."termA"." href="."#"." onclick="."termAdd('".$partition[0]."');return false;".">"."+"."</a>
        <a id="."termA"." href="."#"." onclick="."newTerm('".$partition[0]."');return false;".">".$partition[0]."</a>
        <a id="."termA"." href="."#"." onclick="."termAdd('-".$realterm."');return false;".">"."-"."</a>
      
      </td>";
 echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>".$partition[1]."</td>";
 echo "</tr>";
}
echo "</table>";
echo    "</div>";





echo    "<div id="."menu2"." class='tab-pane fade'>";
echo "<table style='"."text-align:center;width:100%;border:2px #D9D9D9 solid;background-color:#FFFFFF;"."'>";
echo "<tr>";
echo "<th style='"."width:60%;border:2px #D9D9D9 solid;text-align:center;"."'>詞</th>";/*Realtext
echo "<th style='"."width:40%;border:2px #D9D9D9 solid;text-align:center;"."'>次數</th>";/*Score
echo "</tr>";
*/
/*
for($x = 0;$x<sizeof($local);$x++)
{
 $partition[0] = $local[$x];
 $partition[1] = $local_count[$x];
 echo "<tr style='"."width:60%;border:2px #D9D9D9 solid;"."'>";
 echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>
        <a id="."termA"." href="."#"." onclick="."termAdd('".$partition[0]."');return false;".">"."+"."</a>
        <a id="."termA"." href="."#"." onclick="."newTerm('".$partition[0]."');return false;".">".$partition[0]."</a>
        <a id="."termA"." href="."#"." onclick="."termAdd('-".$realterm."');return false;".">"."-"."</a>
      </td>";
 echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>".$partition[1]."</td>";
 echo "</tr>";
}
echo "</table>";
echo    "</div>";

echo    "<div id="."menu3"." class='tab-pane fade'>";
echo "<table style='"."text-align:center;width:100%;border:2px #D9D9D9 solid;background-color:#FFFFFF;"."'>";
echo "<tr>";

echo "<th style='"."width:60%;border:2px #D9D9D9 solid;text-align:center;"."'>詞</th>";/*Realtext
echo "<th style='"."width:40%;border:2px #D9D9D9 solid;text-align:center;"."'>次數</th>";/*Score
echo "</tr>";
for($x = 0;$x<sizeof($other);$x++)
{
  $partition[0] = $other[$x];
  $partition[1] = $other_count[$x];
  echo "<tr style='"."width:60%;border:2px #D9D9D9 solid;"."'>";
  echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>
          <a id="."termA"." href="."#"." onclick="."termAdd('".$partition[0]."');return false;".">"."+"."</a>
          <a id="."termA"." href="."#"." onclick="."newTerm('".$partition[0]."');return false;".">".$partition[0]."</a>
          <a id="."termA"." href="."#"." onclick="."termAdd('-".$realterm."');return false;".">"."-"."</a>
        </td>";
  echo "<td style='"."width:20%;border:2px #D9D9D9 solid;"."'>".$partition[1]."</td>";
  echo "</tr>";
}
echo "</table>";
echo    "</div>";




echo  "</div>";
echo "</div>";

//----------------------------------------------------------
echo "</div>";
*/
mysqli_close($con);
?>