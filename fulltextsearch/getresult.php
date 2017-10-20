<?php 

$con = mysqli_connect('localhost','root','kone5566','literatures');
if (!$con)
{
  die('Could not connect: ' . mysqli_error($con));
}

//-------------------------------------------------
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
    $element_in_output_arr = array( 'title' => $title, 'chapter' => $paragraph_chapter, 'text' => $paragraph_text ,'bookid' => $paragraph_graf);

    array_push($paragraph_output_array, $element_in_output_arr);
  }

echo json_encode($paragraph_output_array);
mysqli_close($con);
?>