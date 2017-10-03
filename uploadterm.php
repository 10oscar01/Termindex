<?php 
        if (empty($_SESSION['username'])){
            header('location: login.php');
        }
?>
<!DOCTYPE html>
<html>
<title>字詞上傳</title>
	<head>
		<meta charset="utf-8">
		<script language="javascript" type="text/javascript"></script>
		<script src="mark.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/result-light.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<script type="text/javascript" src="https://cdn.jsdelivr.net/mark.js/7.0.0/mark.min.js"></script>
		<style type="text/css">
        body {
  			margin: 15px;
   			background-color: #E8FFE8; 
		}

        .BOX{
            position: absolute;
            left: 50%;
            top:  5%;
        }

        .line{
            border:2px #D9D9D9 solid;
            text-align: 10px;
            font-family:Microsoft JhengHei;
            background-color: #F2FFF2;
            width: 600px;
            height: 600px;
        }

  		</style>

		<script>
            
			function addata() {
                title = document.getElementById("booktitle").value;
                tid   = document.getElementById("termindex").value;
                term  = document.getElementById(  "term"   ).value;
                //tag   = document.getElementById(  "tag"    ).value;
    			//var unitag=encodeURIComponent(document.getElementById("tag").value);
                //unistr=document.getElementById("tag").value;
                //var unicode="";
                /*
                for(var i=0;i<unistr.length;i++)
                {
                    unicode+=parseInt(unistr[i].charCodeAt(0),10).toString(16);
                    if (unistr[i]==' ')unicode+=" ";
                }
                var unicode=encodeURIComponent(unicode).toUpperCase();;
                */
                if ( booktitle=="" || termindex=="" || term=="" ) 
                {
                    document.getElementById("txtHint").innerHTML = "資料缺少";
                    return;
                }

                else 
                {
                    if (window.XMLHttpRequest) 
                    {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } 
                    else 
                    {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() 
                    {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                        {
                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        }
                    };
                    xmlhttp.open("GET","insertterm.php?title="+title+"&tid="+tid+"&term="+term,true);
                    xmlhttp.send();
			     }
        }
		</script>
		<script>
			function showtext(){
				addata();
				//alert("OK");
			}

		</script>
	</head>
	<body>
		<p>書  名:</p><p><input id='booktitle' type="text"/></p>
        <p>詞集名:</p><p><input id='termindex' type="text"/></p>
        <p>    詞:</p><p><input id='term' type="text"/></p>
		
		<div>
        
		<button onclick="showtext()">提交</button>
		</div>
		<div id="txtHint" class="BOX"><b><table class="line"><table></b></div>


	</body>
</html>