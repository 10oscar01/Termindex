<?php 
    if (empty($_SESSION['username'])){
        header('location: login.php');
    } 
?>
<html>
<title>段詞輸入</title>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script language="Javascript" ></script>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<link href="css/bootstrap-theme.css" rel="stylesheet">

	<style type="text/css">
        body {
  			margin: 15px;
   			background-color: #E8FFE8; 
		}

        .form{
            position: absolute;
            left: 25%;
            top:  20%;
        }

        .line{
            border:2px #D9D9D9 solid;
            text-align: 10px;
            font-family:Microsoft JhengHei;
            background-color: #F2FFF2;
            width: 600px;
            height: 600px;
        }
        .font{
        	font-family:Microsoft JhengHei;
        	text-align: 10px;
        }
        .BOX{
        	position: absolute;
        	left: 65%;
        	top: 20%;
        }
        .btn{
        	position: absolute;
        	left: 37%;
        	top:  33%;
        }
  		</style>

  		<script>
            
			function addata() {
                var booktitle = document.getElementById("booktitle").value;
                var term = document.getElementById("term").value;
    			
                if ( booktitle=="" || term=="" ) 
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
                    xmlhttp.open("GET","insertphterm.php?title="+booktitle+"&term="+term,true);
                    xmlhttp.send();
			     }
        }
		</script>

		<script>
			function send(){
				addata();
				
			}
		</script>
</head>
<body>
	<h1 align="center">段詞輸入</h1>
	<form class="form"> 
	<p><font class="font">書名: </font><input type="text" id="booktitle"/></p>
	<p><font class="font">詞　: </font><input type="text" id="term"/></p>
	
	</form>
	<button class="btn" onclick="send()">送出</button>
	<div class="BOX" id="txtHint">........</div>
<body>
</html>