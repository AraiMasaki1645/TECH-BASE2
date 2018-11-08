<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
?>
 
<!DOCTYPE html>
<html>
<head>
<title>メール登録</title>
<meta charset="utf-8">
</head>
<body>
<h2>メール登録</h2>
 
<form action="mail_check.php" method="post">
 
<p>メールアドレス：<input type="text" name="mail"></p>
*登録するメールアドレスを入力してください<br>

<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="登録する">
 
</form>
 
</body>
</html>