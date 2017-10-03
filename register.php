<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="header">
		<h2>註冊</h2>
	</div>

	<form method="post" action="register.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>帳號</label>
			<input type="text" name="username">
		</div>
		<div class="input-group">
			<label>信箱</label>
			<input type="text" name="email">
		</div>
		<div class="input-group">
			<label>密碼</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>確認密碼</label>
			<input type="password" name="password_2">
		</div>
		<div>
			<button type="sumbit" name="register" class="btn">確認</button>
		</div>
		<p>
			已經是會員了嗎? <a href="login.php">登入</a>
		</p>
	</form>
</body>
</html>