<?php include("TTOC.php"); ?>
<?php
    set_time_limit(0);
    $book = $_GET['book'];
	  $cag  =  $_GET['cag'];
	  $term = $_GET['term'];
    $isNew = $_GET['new'];
	  $log = "";
    //echo $term;
    $termArray = explode("@",$term);
	  //-------------------------------------------------
	  $con = mysqli_connect('localhost','root','kone5566','literatures');
  	if (!$con)
  	{
    	die('Could not connect: ' . mysqli_error($con));
  	}
    //-------------------------------------------------
    echo "<div id="."txtHint"." class = "."txtHint panel panel-default"."><div class="."panel-body".">";
    if ( $isNew == '1' ) 
    {
        mysqli_select_db($con,"termindex");
        //get guid-------------------------------------------------------
        $gusql = "SELECT uuid();";
        $guidresult = mysqli_query($con,$gusql);
        while ($gurow = $guidresult->fetch_assoc()) 
        {
            $newCagGuid =  $gurow['uuid()'];
        }
        $newCagGuid= strtoupper($newCagGuid);
       //-----------------------------------------------------------------
        $comsql = "SELECT * FROM termindex WHERE class='$cag' AND bookgref = '$book';";
        $comresult = mysqli_query($con, $comsql);
        if ( mysqli_num_rows($comresult) == 1 ) 
        {
            echo "類別 重複新增";
            $isNew = 0;
        }
      else 
      {
          $bookName = "";
          $findBookSql = "SELECT * FROM termindex WHERE bookgref = '$book';";
          $findBookRes = mysqli_query($con, $findBookSql);
          while($row = mysqli_fetch_array($findBookRes)) 
          {
              $bookName =  $row['booktitle'];
              echo $bookName;
          }
          $sql = "INSERT INTO termindex (guid,bookgref,booktitle,class) VALUES ('".$newCagGuid."','".$book."','".$bookName."','".$cag."');";
          mysqli_query($con,$sql)or die ("無法新增".mysql_error());
        }

      $cagRegularSql = "SELECT * FROM termindex WHERE class = '$cag' AND bookgref = '$book';";
      $cagRegularRes = mysqli_query($con,$cagRegularSql);
      echo $cag;
        
      while($row = mysqli_fetch_array($cagRegularRes)) 
      {
          $cag =  $row['guid'];
          echo "</br>";
          //echo $cag;
          echo "</br>";
      }
    
    }


    foreach($termArray as $term)
    {
        if ($term == "")
        {
            continue;
        }
	      //-------------------------------------------------
  	    mysqli_select_db($con,"term");
  	    //get guid-------------------------------------------------------
        $gusql = "SELECT uuid();";
        $guidresult = mysqli_query($con,$gusql);
        while ( $gurow = $guidresult -> fetch_assoc() )
        {
            $guid =  $gurow['uuid()'];
        }
        $guid = strtoupper($guid);
        //---------------------------------------------------------------
        $comsql = "SELECT * FROM term WHERE termindexgref='$cag' AND term = '$term';";
        $comresult = mysqli_query($con, $comsql);
        if ( mysqli_num_rows($comresult) == 1 )
        {
            echo $term." 重複新增"."</br>";
        }
        else
        {
            $sql = "INSERT INTO term (guid,termindexgref,term) VALUES ('".$guid."','".$cag."','".$term."');";
  	        mysqli_query($con,$sql)or die ("無法新增".mysql_error());
  	        


            //----------------------------------------------------------------------------------------------
            $termgref = $guid;
            $urlinput = urlencode($term);
            //echo "------------------------------------------------------------";
            //echo "</br>";
            $mystring = system("python crawler_wiki.py $urlinput", $retval);
            //echo "</br>";
            //echo "------------------------------------------------------------";
            //echo "</br>";
            $mystring = strip_tags($mystring);
            $mystring = json_decode("\"".$mystring."\"");
            $termContentRef = substr($mystring,-2);
            $mystring = substr($mystring, 0, strlen($mystring)-2);
      
      
            //echo $row['term'];
            //echo "</br>";
            //echo $mystring;
      
            $utf8_chinese_str = new utf8_chinese;
            $mystring = $utf8_chinese_str->gb2312_big5($mystring);
            $secsql="UPDATE term SET content='$mystring',contentref='$termContentRef' WHERE guid='$termgref'";
            mysqli_query($con,$secsql);
            //----------------------------------------------------------------------------------------------



            //新增段詞統計表(Phterm)------------------------------------------------------------------------
            $newsql="SELECT guid,ROUND((CHAR_LENGTH(realtext)-CHAR_LENGTH(Replace(realtext,'".$term."','')))/(".strlen($term)."/3)) AS count FROM paragraph where bookgref = '$book' AND realtext LIKE '%".$term."%';";
            $result=mysqli_query($con,$newsql);


            mysqli_select_db($con,"phterm");
            while ($row = $result->fetch_assoc()) {

            //get guid
            $gusql = "SELECT uuid();";
            $guidresult = mysqli_query($con,$gusql);
            while ($gurow = $guidresult->fetch_assoc()) {
              $guid =  $gurow['uuid()'];
            }
            $guid = strtoupper($guid);

            //insert data to phterm
            $sql="INSERT INTO phterm (guid,phgref,termgref,count) VALUES ('".$guid."','".$row['guid']."','".$termgref."','".$row['count']."');";
            //echo $row['count'];
            mysqli_query($con,$sql)or die ("無法新增".mysql_error());
            }
            //----------------------------------------------------------------------------------------------


            echo $term." 新增成功"."</br>";
  	    }
    }
    echo "</div></div>";
?>