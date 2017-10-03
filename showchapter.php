<html>
<?php
	$chapter = $_GET['chapter'];
	$bookgref = $_GET['bookid'];
	$pharagraph = $_GET['pharagraph'];

	$con = mysqli_connect('localhost','root','kone5566','literatures');
  if (!$con)
  {
    die('Could not connect: ' . mysqli_error($con));
  }
  mysqli_select_db($con,"paragraph");
  $sql="SELECT realtext,chapter ,  CONVERT(SUBSTRING_INDEX(chapter,'-',-1),UNSIGNED INTEGER) AS num FROM paragraph WHERE bookgref = '$bookgref' AND chapter LIKE '$chapter-%'  ORDER BY num";
  $result = mysqli_query($con,$sql);
  
  mysqli_select_db($con,"book");
  $sql_findbook="SELECT title FROM book WHERE guid='$bookgref'";
  $book_result = mysqli_query($con,$sql_findbook);
  $article="";
  while($bookrow = mysqli_fetch_array($book_result))
  {
    $article = $bookrow['title'];
  }
  $article = $article." "."第".$chapter."回";
  echo "<div style="."text-align:center;"."><h1>".$article."</h1></div>";
  echo "<table>";
  while($row = mysqli_fetch_array($result))
{
	$targetParagraph = $chapter.'-'.$pharagraph;
	echo "<tr>";
	if ( $targetParagraph == $row['chapter'])
	{
    	echo "<td bgcolor='#FFBB00'><a id=".'target'.">".$row['realtext']."<a></td>";
    	
    }
    else
    {
    	echo "<td>".$row['realtext']."</td>";
    	
    }
    echo "</tr>";
}
  echo "</table>";
?>
</html>
