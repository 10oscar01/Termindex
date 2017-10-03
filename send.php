<?php
	header("Content-Type:text/html; charset=utf-8");
	$to = "ziuanhuang@gmail.com";
	$subject="系統認證信";
	$msg="test";
	$headers = "From: termindex@gmail.com";

	if (mail("$to","subject","$msg","$headers")) {
		echo "信件已發送成功";
	}
	else {
		echo "信件發送失敗";
	}
?>