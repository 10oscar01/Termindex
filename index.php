<?php include('server.php');
    if(empty($_SESSION['username'])) {
        header('location: login.php');
    }
?>
<!DOCTYPE html>
<html>
	<title>同位詞大典</title>
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<script language="Javascript" ></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel = "stylesheet" type="text/css" href="style.css">
		<script>
		window.onload = function()
		{
			document.getElementById("bt1").onclick = function() 
    		{
        		window.location.href = 'ftsdemo.php';
    		}
    		document.getElementById("bt2").onclick = function()
    		{
    			window.location.href = 'uploadterm.php';
    		}
    		document.getElementById("bt3").onclick = function()
    		{
    			window.location.href = 'phterm.php';
    		}
    		document.getElementById("bt4").onclick = function()
    		{
    			window.location.href = 'termsearch.php';
    		}
    		document.getElementById("bt5").onclick = function()
    		{
    			window.location.href = "index.php?logout=1";
    		}
		}
		</script>
	</head>
	<body>
		<div class="index-top">
			<?php if (isset($_SESSION['username'])): ?>
			<p>Welcome&nbsp <strong><?php echo $_SESSION['username'];?> [<?php echo $_SESSION['access']?>]</strong>
						<button type="button" class="btn" style="width:60px;height:40px;" id="bt5">
							登出
						</button>
			</p>
			<?php endif ?>
		</div>
		<div class= "index-middle">
		<div class= "index-left">
			<p>	
				<button type="button" class="index-btn btn btn-lg btn-Primary" style="width:140px;height:50px;" id="bt1">
					<span style="font-family:Microsoft JhengHei;color:white;font-size:0.7cm;">全文檢索</span>
				</button>
			</p>

			<p>
			<button type="button" class="index-btn btn btn-lg btn-Primary" style="width:140px;height:50px;" id="bt2">
				<span style="font-family:Microsoft JhengHei;color:white;font-size:0.7cm;">字詞上傳</span>
			</button>
			</p>

			<p>
			<button type="button" class="index-btn btn btn-lg btn-Primary" style="width:140px;height:50px;" id="bt3">
				<span style="font-family:Microsoft JhengHei;color:white;font-size:0.7cm;">段詞輸入</span>
			</button>
			</p>

			<p>
			<button type="button" class="index-btn btn btn-lg btn-Primary" style="width:140px;height:50px;" id="bt4">
				<span style="font-family:Microsoft JhengHei;color:white;font-size:0.7cm;">字詞搜尋</span>
			</button>
			</p>
		</div>
		<div class="index-center">
			<div class="index-header header">
				<h2>同位詞大典</h2>
			</div>

			<div class="index-content content">
				<?php if (isset($_SESSION['success'])): ?>
					<div class="error success">
						<h3>
							<p class="message">
							<?php
								echo $_SESSION['success'];
								unset($_SESSION['success']);
							?>
							</p>
						</h3>
					</div>
				<?php endif ?>
			</div>
		</div>
		</div>
	</body>
</html>