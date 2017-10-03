<!DOCTYPE html>
<html>
	<head>

		<script language="javascript" type="text/javascript"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel = "stylesheet" type="text/css" href="termadd.css">

	<script>
		inputstring = "";
		newflag = 0;
		window.onload = function()
		{
				document.getElementById('myfile').onchange = readFile;

				document.getElementById("test").onclick = function fun() 
    			{
        			var cag = document.getElementById("termcategory").value;
        			var book = document.getElementById("bookname").value;
        			alert( book + "\n" + cag + "\n" + newflag );
      			}


		}
		function readFile()
		{
				file = this.files[0];
				var fReader = new FileReader();
				fReader.onload = function(event){
					document.getElementById('fileContent').value = event.target.result;
					inputstring = event.target.result;
				};
				fReader.readAsText(file);
		}
		
		function showtext()
		{
			var splitStr = inputstring.split("\r\n");
			var outPutTermArray="";
			//var splitStr = inputstring;
			if (newflag == 0)
			{
				var cag = document.getElementById("termcategory").value;
			}
			if (newflag == 1)
			{
				var cag = document.getElementById('other').value;
			}
        	var book = document.getElementById("bookname").value;
			for ( i = 0; i < splitStr.length; i++ )
			{
				if (splitStr[i] != "")
				{
					outPutTermArray+=splitStr[i];
					outPutTermArray+='@';
				}
			}
					//------------------------------------------------------------
					
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
                    	xmlhttp.open("GET","insertTerm.php?term="+outPutTermArray+"&cag="+cag+"&book="+book+"&new="+newflag,true);
                    	xmlhttp.send();
			     	
					//------------------------------------------------------------
			//	}
			//}
		}
		function check(val)
		{
			if (val == "其他")
			{
				document.getElementById('other').style.display='block';
				newflag = 1;
			}
			else
			{
				document.getElementById('other').style.display='none';
				newflag = 0;
			}
		}

		function renew(value)
		{
			id_numbers = new Array();
			
			
			$.ajax
			({
			    url:'selectcategory.php',
				data:{bookguid:value},
				type :'POST',
				
				success:function(response) 
				{
                	
                	id_numbers = response;
                	id_numbers = JSON.parse(id_numbers);
                	
                	




                	var newOptions = {};

                	for (var j = 0; j < id_numbers.length; j+=2 )
                	{
                		newOptions[id_numbers[j]] = id_numbers[j+1];
                	}
                	

					var $el = $("#termcategory");
					$el.empty(); // remove old options

					$.each(newOptions, function(key,value) 
					{
  					$el.append($("<option></option>")
     					.attr("value", value).text(key));
					});
					$el.append($("<option></option>").attr("其他", "其他").text("其他"));
            	}
            	
			});
		}

	</script>
	</head>

	<body>	

			<div class="index-top">
      			<?php if (isset($_SESSION['username'])): ?>
      			<p>Welcome&nbsp <strong><?php echo $_SESSION['username'];?> [<?php echo $_SESSION['access']?>]</strong>
            		<button type="button" class="log-btn" style="width:60px;height:40px;" id="bt5">
              		登出
            		</button>
      			</p>
      			<?php endif ?>
    		</div>
    		
    		<div class = "centerContent">
    		<div id = "inputArea" class="inputArea panel panel-default">
					<p>書名:</p><?php include("selectsql.php"); ?><br/><br/>
					<p>類別:</p><select id = "termcategory" onchange='check(this.value)'></select><br/><br/>
					<input type="text" name="other" id="other" style='display:none'/><br/>
					<!--<button id = "test" type = "submit">測</button>-->
					<p><input id='myfile' type="file"/></p><br/><br/>
					<textarea id="fileContent" cols="30" rows="10"></textarea><br/>
					<button onclick="showtext()">上傳資料</button>
			</div>

			
			
			
			<div id="txtHint"></div>
			</div>
	</body>
</html>