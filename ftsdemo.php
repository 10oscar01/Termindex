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
  document.getElementById('txtHint').innerHTML = "";
  unicode = str;
  $.ajax
  ({
    url:'fulltextsearch/getresult.php',
    data:{uni_term:unicode},
    dataType: "json",
    type :'GET',
    success:function(response) 
    {
      var htmls = [];
      for (key in response)
      {
        htmls.push('<div class="panel panel-default">');
        htmls.push('<div class="panel-heading">' + response[key]['title']); 
        htmls.push('<a href="#" onclick = "chapterSearch(\''+ response[key]['chapter'] +'\',\''+ response[key]['bookid'] +'\')">' + response[key]['chapter'] + '</a>');
        htmls.push('</div>');
        htmls.push('<div class="panel-body">' + response[key]['text'] + '</div>');
        htmls.push('</div>');
      }
      document.getElementById('txtHint').innerHTML = htmls.join('');
    }
  });
}

function getPhtermCountTable(str)
{
  document.getElementById('phtermTable').innerHTML = "";
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
      for (key in response)
      {
        if ( key == "total" )
        {
          html.push('<div id="home" class="tab-pane fade in active">');
        }
        else if ( key == "character")
        {
          html.push('<div id="menu1" class="tab-pane fade">');
        }
        else if ( key == "local")
        {
          html.push('<div id="menu2" class="tab-pane fade">');
        }
        else if ( key == "other")
        {
          html.push('<div id="menu3" class="tab-pane fade">');
        }
        html.push('<table style="text-align:center;width:100%;float:right;border:2px #D9D9D9 solid;background-color:#FFFFFF;">');
        html.push('<tr>');
        html.push('<th style="border:2px #D9D9D9 solid;text-align:center;">詞</th>');
        html.push('<th style="border:2px #D9D9D9 solid;text-align:center;">次數</th>');
        html.push('</tr>');
        for ( keys in response[key])
        {
          name = response[key][keys]['name'];
          html.push('<tr style="border:2px #D9D9D9 solid;">');
          html.push('<td>');
          html.push('<a id="termA" href="#" onclick="termAdd(\''+ name +'\')";return false;">'+ "+"  +'</a>');
          html.push('<a id="termA" href="#" onclick="newTerm(\''+ name +'\')";return false;">'+ name +'</a>');
          html.push('<a id="termA" href="#" onclick="termAdd(\'-'+ name +'\')";return false;">'+ "-"  +'</a>');
          html.push('</td>');
          html.push('<td style="border:2px #D9D9D9 solid;">' + response[key][keys]['count'] + '</td>');
          html.push('</tr>');
        }  
        html.push('</table>');
        html.push('</div>');
      }
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
  function chapterSearch(chapter,bookid){
    var chapter1 = (chapter.split("-"))[0];
    var chapter2 = (chapter.split("-"))[1];
    var bookguid = bookid;

    open('showchapter.php?chapter='+chapter1+'&pharagraph='+chapter2+'&bookid='+bookguid+"#target",'_blank',
        'result', config='height=600,width=600');
  } 

  function termAdd(term){
    document.getElementById("keyword").value= document.getElementById("keyword").value + " " + term;
    showUser();
  }

  function newTerm(term){
    document.getElementById("keyword").value = term;
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

<div id="phtermTable" class="phtermTable"></div>
<div id="txtHint" class = "container" style="width:50%"></div>


</body>
</html>