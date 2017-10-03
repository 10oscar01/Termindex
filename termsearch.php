<!DOCTYPE html>
<html>
<head>
	<title>字詞搜尋</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel = "stylesheet" type="text/css" href="termsearch.css">
    <style>
        
    </style>
	<script>
		function getTerm() 
  		{
    		var str=encodeURIComponent(document.getElementById("keyword").value);
    		str=document.getElementById("keyword").value;	
   		 	if (str == "") 
    		{
    		    document.getElementById("txtHint").innerHTML = "";
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
        	xmlhttp.open("GET","termsearchback.php?str="+str,true);
        	xmlhttp.send();
    		}
  		}
        function getConfidence()
        {
            var str=encodeURIComponent(document.getElementById("keyword").value);
            str=document.getElementById("keyword").value;   
    
            
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
                    document.getElementById("rightConfidence").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET","termdetail/confidence.php?term="+str,true);
            xmlhttp.send();  
        }
        function getChart()
        {
            chartdata = new Array();
            var str=encodeURIComponent(document.getElementById("keyword").value);
            str=document.getElementById("keyword").value;
            $.ajax
            ({
                url:'termdetail/getFrequency.php',
                data:{term:str},
                dataType: "json",
                type :'GET',
                success:function(response) 
                {
                    chartdata = response;

                    //document.getElementById("centerFrequency").innerHTML = chartdata;
                    //alert(typeof response);
                    google.charts.load('current', {'packages':['line']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()   
                    {
                        var dataTable = new google.visualization.DataTable();
                        var newData = [['章節',str]];
                        for(var i in chartdata){
                            newData.push([ i, parseInt(chartdata[i]) ]);
                          
                        }
                        var newDatas = [['Year', 'Sales'],
                        ['2004',  1000],
                        ['2005',  1170],
                        ['2006',  660],
                        ['2007',  1030],
                        ['2008',  1530]];
                        
                        var numRows = newData.length;
                        var numCols = newData[0].length;
                        
                        dataTable.addColumn('string', newData[0][0]);

                        for (var i = 1; i < numCols; i++)
                            dataTable.addColumn('number', newData[0][i]);


                        for (var i = 1; i < numRows; i++)
                            dataTable.addRow(newData[i]);

                        var options = {
                            chart: {
                                title: '詞彙出現分布圖',
                                subtitle: ''
                            },
                            legend: { position: 'bottom' },
                            width: window.innerWidth*0.495,
                            height: 500,
                            axes: {
                                x: {
                                0: {side: 'top'}
                                }
                            }
                        };

                        var chart = new google.charts.Line(document.getElementById('chart_div'));
                        chart.draw(dataTable, google.charts.Line.convertOptions(options));
                        $(window).resize(function(){
                            options['width'] = window.innerWidth*0.495;
                            chart.draw(dataTable, google.charts.Line.convertOptions(options));
                        });
                    }
                }       
            });          
        }
        function getContent()
        {
            var str=encodeURIComponent(document.getElementById("keyword").value);
            str=document.getElementById("keyword").value;
            $.ajax
            ({
                url:'termdetail/getcontent.php',
                data:{term:str},
                type :'GET',
                
                success:function(response) 
                {

                    document.getElementById("txtHint").innerHTML = response;
                }
                
            });
        }
        function getTermDetail()
        {
            getContent();
            getConfidence();
            getChart();
        }
        confirmFlag = ""; 
        function Confirm()
        {
            var str=encodeURIComponent(document.getElementById("keyword").value);
            str=document.getElementById("keyword").value;   
            
            
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
                    confirmFlag = xmlhttp.responseText;
                    
                    if (confirmFlag == "book")
                    {
                        getTerm();
                        $('#rightConfidence').css('display', 'none');
                        $('#chart_div').css('display', 'none');
                        $('#foot').css('display', 'none');

                    }
                    else
                    {
                        getTermDetail();
                        $('#rightConfidence').css('display', 'block');
                        $('#chart_div').css('display', 'block');
                        $('#foot').css('display', 'block');
                    }
                    
                }
            };
            xmlhttp.open("GET","confirm.php?text="+str,true);
            xmlhttp.send(); 
        }
        function fullText(term)
        {
           // alert(term);
            location.href="ftsdemo.php?term="+term;
        }
  		window.onload = function()
		{
    		document.getElementById("bt5").onclick = function()
    		{
    			window.location.href = "index.php?logout=1";
    		}

    		document.getElementById("Save").onclick = function trigger() 
    		{
                Confirm();
			}
		}
	</script>
  
</head>
<body>
	<div class="index-top">
			<?php if (isset($_SESSION['username'])): ?>
			<p>Welcome<strong><?php echo $_SESSION['username'];?> [<?php echo $_SESSION['access']?>]</strong>
					  <button type="button" class="btn" id="bt5">
							登出
					  </button>
			</p>
			<?php endif ?>
	</div>
	<div class="term-search-bar">
    	<div class="search"><input type="text" id="keyword" name="keyword"></div>
    	<div class="search-btn-div"><input type="submit"  class="termsearch-btn" id="Save" name="Save" value="檢索"></div>
    </div>
    <div id="rightConfidence" class="right-confidence"></div>
    <div id="txtHint" class="search-view"></div>

    <!--<div id="centerFrequency" class="center-frequency"></div>-->
    <div id="container">
    <div id="foot"></div>
    <div id="chart_div" class="chart_div"></div>
    </div>
    <div id="centerDistributed" class="center-distributed"></div>
</body>
</html>