<?php
	$filename = "score.txt";
	
?>

<table border = "1">
	<caption>スコア表</caption>
	<tr><th>選手名</th><th>ゴール</th><th>アシスト</th><th>シュート(外)</th><th>シュート(内)</th><th>ボールロスト</th><th>パスミス</th><th>トラップミス</th></tr>
	<form method="post"action="mission_6.php">
	
	<?php for ($s=1; $s<=15; $s++) { ?>
	<tr><td>
	<input type="text"name="name<?php echo $s ?>">
	</td>
	
	<td><select name="goal<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td>
	
	<td><select name="assist<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td>

	</td>
	<td><select name="sh_out<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td>

	<td><select name="sh_in<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td>

	<td><select name="bl<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td>

	<td><select name="pm<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td>

	<td><select name="tm<?php echo $s ?>">
 	<?php for ($i=0; $i<=10; $i++) { ?>
 	<option value="<?php echo $i ?>"><?php echo $i ?></option> 
	<?php } ?>
	</select>
	</td></tr>
	<?php } ?>


</table>
<input type="submit"value="まとめて送信"><input type="reset" value="リセット"><br>
*選手名はアルファベットで入力してください<br>

<?php
	for($i=1; $i<=15; $i++){
		$name = $_POST["name$i"];
		$goal = $_POST["goal$i"];
		$assist = $_POST["assist$i"];
		$sh_out = $_POST["sh_out$i"];
		$sh_in = $_POST["sh_in$i"];
		$bl = $_POST["bl$i"];
		$pm = $_POST["pm$i"];
		$tm = $_POST["tm$i"];
		$date = date('Y-m-d H:i:s');


		if(isset($name)){
			$dsn = 'データベース名';
			$user = 'ユーザー名';
			$password = 'パスワード';
			$pdo = new PDO($dsn,$user,$password);
			//データベースへ接続
			$sql = "CREATE TABLE $name(goal INT,assist INT,sh_out INT,sh_in INT, bl INT,pm INT,tm INT,date TEXT)";
			$stmt = $pdo -> query($sql);
			
			$sql = $pdo -> prepare("INSERT INTO $name (goal, assist, sh_out, sh_in, bl, pm, tm, date) VALUES (:goal, :assist, :sh_out, :sh_in, :bl, :pm, :tm, :date)");
			$sql->bindParam(':goal', $goal, PDO::PARAM_STR);
			$sql->bindParam(':assist', $assist, PDO::PARAM_STR);
			$sql->bindParam(':sh_out', $sh_out, PDO::PARAM_STR);
			$sql->bindParam(':sh_in', $sh_in, PDO::PARAM_STR);
			$sql->bindParam(':bl', $bl, PDO::PARAM_STR);
			$sql->bindParam(':pm', $pm, PDO::PARAM_STR);
			$sql->bindParam(':tm', $tm, PDO::PARAM_STR);
			$sql->bindParam(':date', $date, PDO::PARAM_STR);
			$sql->execute();
			//テーブルにデータを入力
			
			
			
			$sql = "SELECT SUM(goal) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum1 = $row['SUM(goal)'];
			}
			
			$sql = "SELECT SUM(assist) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum2 = $row['SUM(assist)'];
			}
			
			$sql = "SELECT SUM(sh_out) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum3 = $row['SUM(sh_out)'];
			}
			
			$sql = "SELECT SUM(sh_in) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum4 = $row['SUM(sh_in)'];
			}
			$sql = "SELECT SUM(bl) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum5 = $row['SUM(bl)'];
			}
			$sql = "SELECT SUM(pm) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum6 = $row['SUM(pm)'];
			}

			$sql = "SELECT SUM(tm) FROM $name";
			$result = $pdo->query($sql);
			while($row = $result->fetch()){
			$sum7 = $row['SUM(tm)'];
			}

?>


<br>
<table border = "1">
	
	スコア合計<th>選手名</th><th>ゴール</th><th>アシスト</th><th>シュート(外)</th><th>シュート(内)</th><th>ボールロスト</th><th>パスミス</th><th>トラップミス</th>
	
	<tr><td>
	<?php echo $name ?>
	</td>
	
	<td>
	<?php echo $sum1 ?>
	</td>
	
	<td>
	<?php echo $sum2 ?>
	</td><td>
	<?php echo $sum3 ?>
	</td><td>
	<?php echo $sum4 ?>
	</td><td>
	<?php echo $sum5 ?>
	</td><td>
	<?php echo $sum6 ?>
	</td><td>
	<?php echo $sum7 ?>
	</td>
	<?php }} ?>
</table>