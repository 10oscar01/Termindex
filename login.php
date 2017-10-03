<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="header">
		<h2>登入</h2>
	</div>

	<form method="post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>帳號</label>
			<input type="text" name="username">
		</div>
		<div class="input-group">
			<label>密碼</label>
			<input type="password" name="password">
		</div>
		<div>
			<button type="sumbit" name="login" class="btn">登入</button>
		</div>
		<p>
			不是會員? <a href="register.php">註冊</a>
		</p>
	</form>
</body>
</html>