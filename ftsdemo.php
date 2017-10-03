<?php include('server.php');
    if(empty($_SESSION['username'])) 
    {
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<script language="javascript" type="text/javascript"></script>
<link rel = "stylesheet" type="text/css" href="getresult.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
function getTextSearchResult(str)
{
  unicode = str;
  $.ajax
  ({
    url:'fulltextsearch/getresult.php',
    data:{uni_term:unicode},
    dataType: "json",
    type :'GET',
    success:function(response) 
    {
      var html = [];
      for (key in response)
      {
        html.push('<div class="panel panel-default">');
        html.push('<div class="panel-heading">' + response[key]['title'] + response[key]['chapter'] + '</div>');
        html.push('<div class="panel-body">' + response[key]['text'] + '</div>');
        html.push('</div>');
      }
      document.getElementById('txtHint').innerHTML = html.join('');
    }
  });
}

function getPhtermCountTable(str)
{
  alert("123");
  unicode = str;
  $.ajax
  ({
    url:'fulltextsearch/getphtermcount.php',
    data:{get_phterm_count:unicode},
    dataType: "json",
    type :'GET',
    success:function(response) 
    {
      var html = [];
      
      html.push('<ul class="nav nav-tabs">');
      html.push('<li class="active"><a data-toggle="tab" href="#home">總覽</a></li>');
      html.push('<li><a data-toggle="tab" href="#menu1">人名</a></li>');
      html.push('<li><a data-toggle="tab" href="#menu2">地名</a></li>');
      html.push('<li><a data-toggle="tab" href="#menu3">其他</a></li>');
      html.push('</ul>');
      html.push('<div class="tab-content">');
      html.push('<div id="home" class="tab-pane fade in active">');
      html.push('<table style="text-align:center;width:100%;float:right;border:2px #D9D9D9 solid;background-color:#FFFFFF;">');
      html.push('<tr>');
      html.push('<th style="border:2px #D9D9D9 solid;text-align:center;">詞</th>');
      html.push('<th style="border:2px #D9D9D9 solid;text-align:center;">次數</th>');
      html.push('</tr>');
      
      for (key in response)
      {
        for ( keys in response[key])
        {
          html.push('<tr style="border:2px #D9D9D9 solid;">');
          html.push('<td style="border:2px #D9D9D9 solid;">');
          html.push('<a id="termA">'+ response[key][keys]['name'] +'</a>');
          html.push('</td>');
          html.push('<td style="border:2px #D9D9D9 solid;">' + response[key][keys]['count'] + '</td>');
          html.push('</tr>');
        }
        html.push('</table>');
        
      }
      html.push('</div>');
      html.push('</div>');
      
      
      document.getElementById('phtermTable').innerHTML = html.join('');
    }
  });
}

  function geturl()
  {
    //URL
    var url = location.href;
    
    //取得問號之後的值
    var temp = url.split("?");
    
    //將值再度分開
    var vars = temp[1].split("&");

    //一一顯示出來
    for (var i = 0; i < vars.length; i++)
    {
     var res = decodeURI(vars[i]).split("=");
     document.getElementById("keyword").value = res[1];
    }
    showUser();
   }
  function showUser() 
  {
    var str=encodeURIComponent(document.getElementById("keyword").value);
    str=document.getElementById("keyword").value;
    var unicode="";
    for(var i=0;i<str.length;i++)
    {
      unicode+="+"+parseInt(str[i].charCodeAt(0),10).toString(16)+" ";
    }

    document.getElementById("txtHint").innerHTML ="";
    getTextSearchResult(unicode);
    getPhtermCountTable(unicode);
  }
  window.onload = function() 
  {
    document.getElementById("Save").onclick = function fun() 
    {
      showUser();
    }
    document.getElementById("bt5").onclick = function()
    {
      window.location.href = "index.php?logout=1";
    }
  }
</script>
<script>
  function chapterSearch(chapter1,chapter2,bookid){
    var chapter = chapter1+'-'+chapter2;
    var bookguid = bookid;

    open('showchapter.php?chapter='+chapter1+'&pharagraph='+chapter2+'&bookid='+bookguid+"#target",'_blank',
        'result', config='height=600,width=600');
  } 

  function termAdd(term){
    document.getElementById("keyword").value= document.getElementById("keyword").value + " " + term;
    showUser();
  }

  function newTerm(term){
    document.getElementById("keyword").value= term;
    showUser();
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
  <div class="searchbar">
    <table>
      <tr>
        <td>
          <div class="search"><input type="text" id="keyword" name="keyword" style="font-size:30px;width:600px;"></div>
        </td>
        <td>
          <div class="btn"><input type="submit"  class="btn btn-primary" id="Save" name="Save" value="檢索" style="font-size:0.6cm;"></div>
        </td>
      </tr>
    </table>
  </div>
<br>
<br>
<div id="phtermTable"></div>
<div id="txtHint" class = "container" style="width:50%"></div>


</body>
</html>