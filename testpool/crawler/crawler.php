<!DOCTYPE html>
<html>
<head>
</head>
<script type="text/javascript"> 
function checkResult()
{
    var xmlhttp;
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
    else {
      // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }v
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","checkResult.php?t="+ Math.random(),true);
    xmlhttp.send();
}
</script> 
<body>

<?php
  $urlinput = urlencode('魏延');
  //system("python crawler_wiki.py https://zh.wikipedia.org/wiki/$urlinput> /tmp/null &"); 
  //system("python crawler_wiki.py https://zh.wikipedia.org/wiki/$urlinput>> tmp.txt &");
	
  //$mystring = system("python crawler_wiki.py https://zh.wikipedia.org/wiki/$urlinput", $retval); //wiki
  $mystring = system("python crawler_wiki.py $urlinput"); //taiwan wiki
  echo "</br>";
  echo "</br>";
  $mystring = strip_tags($mystring);
  if (empty($mystring))
    echo "empty";
  else
  {
   // $mystring = '"\u4e9b\u7c97\u7b28\u7684\u751f\u6d3b\u3002"';
    //echo $mystring;
    $mystring = "\"".$mystring."\"";
    echo json_decode($mystring);
  }
?> 
...
<p id='txtHint'>
...
<script>
	//checkResult();
</script>
</body>
<html>