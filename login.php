<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
  
?>
 
<!DOCTYPE html>
<html>
<head>
<title>ログイン画面</title>
<meta charset="utf-8">
</head>
<body>
<h2>ログイン画面</h2>
 
<form action="login_check.php" method="post">
 
<p>アカウント：<input type="text" name="account"></p>
<p>パスワード：<input type="text" name="password"></p>
 
<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="ログインする">
 
</form>
 
</body>
</html>