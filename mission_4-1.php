<?php

	$filename1 = "mission_2-1_ARAI.txt";
	$filename2 = "mission_2-5_ARAI.txt";
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$sakujo = $_POST["sakujo"];
	$hensyu = $_POST["hensyu"];
	$hensyuno = $_POST["hensyuno"];
	$pass1 = $_POST["pass1"];
	$pass2 = $_POST["pass2"];
	$pass3 = $_POST["pass3"];
	$date = date('Y-m-d H:i:s');
	

	if(empty($name) && empty($comment) && empty($sakujo) && !empty($hensyu) && empty($hensyuno) && empty($pass1) && empty($pass2) && !empty($pass3)){
	//編集表示機能(未完了)select,fetch文でテーブル内のデータを取得し$data[0],[1],[2]とする		
		$file2 = file($filename2);
		foreach($file2 as $value){
			$explode = explode("<>",$value);
			
			if($pass3 == $explode[1]){
				$dsn = 'データベース名';
				$user = 'ユーザー名';
				$password = 'パスワード';
				$pdo = new PDO($dsn,$user,$password);
				//データベースへ接続
				
				$stmt = $pdo->query("SELECT * FROM Masaki where id = $hensyu");
				$result = $stmt->fetch();
				echo $result['id'].',';
				echo $result['name'].',';
				echo $result['comment'].'<br>';
				$data0 = $result['id'];
				$data1 = $result['name'];
				$data2 = $result['comment'];				
				
			}if($pass3 != $explode[1]){
			}
		}
	}

?>

<html>
<body>
<form method="post"action="mission_4.php">
	<input type="text"name="name"value="<?php echo $data1;?>"><br />
	<input type="text"name="comment"value="<?php echo $data2;?>"><br />
	<input type="text"name="pass1"placeholder="パスワード">
	<input type="hidden"name="hensyuno"value="<?php echo $data0;?>">
	<input type="submit"value="送信"><br /><br />
	<input type="number"name="sakujo"placeholder="削除対象番号"><br />
	<input type="text"name="pass2"placeholder="パスワード">
		<input type="submit"value="削除"><br /><br />
	<input type="number"name="hensyu"placeholder="編集対象番号"><br />
	<input type="text"name="pass3"placeholder="パスワード">
		<input type="submit"value="編集">
	
	
</form>
</body>
</html>	

<?php	
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);
	//データベースへ接続
if(!empty($name) && !empty($comment) && empty($sakujo) && empty($hensyu) && empty($hensyuno) && !empty($pass1) && empty($pass2) && empty($pass3)){
	//投稿機能(完了)
	$file2 = file($filename2);
	
	$count2 = count($file2);
		
	$passes = $count2."<>".$pass1."<>";
		
	$fp2 = fopen($filename2,"a");
		
	fputs($fp2,"$passes\n");
		
	fclose($fp2);
	
	$sql = $pdo -> prepare("INSERT INTO Masaki (id, name, comment, date) VALUES (:id, :name, :comment, :date)");
	$sql->bindParam(':id', $count2, PDO::PARAM_STR);
	$sql->bindParam(':name', $name, PDO::PARAM_STR);
	$sql->bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql->bindParam(':date', $date, PDO::PARAM_STR);
	$sql->execute();
	//テーブルにデータを入力
	
	

		
		
	}elseif(empty($name) && empty($comment) && !empty($sakujo) && empty($hensyu) && empty($hensyuno) && empty($pass1) && !empty($pass2) && empty($pass3)){
	//削除機能(おそらく完了)
		$file2 = file($filename2);
		foreach($file2 as $value){
			$ex = explode("<>",$value);		
			
			if($pass2 == $ex[1]){
				$id = $sakujo;
				$sql = "delete from Masaki where id = $id";
				$result = $pdo->query($sql);
				//入力したデータを削除
			}				
				$file2 = file($filename2);
				$fp2 = fopen($filename2,"a");
				ftruncate($fp2, 0);
				fclose($fp2);
				foreach($file2 as $value){
				//配列を反復処理
					$explode = explode("<>",$value);
					//文字列を<>で分割し、配列に格納
					
					if($explode[0] != $sakujo){
					//投稿番号と削除番号が一致しないとき
						$fp = fopen($filename2,"a");
						$explodes = $explode[0]."<>".$explode[1]."<>".$explode[2];
						fwrite($fp,"$explodes");
						fclose($fp);	
					}elseif($explode[0] == $sakujo){
					}		
				}
		}
	}elseif(!empty($name) && !empty($comment) && empty($sakujo) && empty($hensyu) && !empty($hensyuno) && !empty($pass1) && empty($pass2) && empty($pass3)){
	//編集機能(未完了)
		$id = $hensyuno;
		$sql = "update Masaki set name='$name',comment='$comment'where id = $id";
		$result = $pdo -> query($sql);
		
		$file2 = file($filename2);
		$fp2 = fopen($filename2,"a");
		ftruncate($fp2, 0);
		fclose($fp2);
		
		foreach($file2 as $value){
			$explode = explode("<>",$value);
			if($explode[0] != $hensyuno){
			//投稿番号と編集番号が一致しないとき
				$fp2 = fopen($filename2,"a");
				$explodes = $explode[0]."<>".$explode[1]."<>";
				fwrite($fp2,"$explodes\n");
				fclose($fp2);	
				
			}elseif($explode[0] == $hensyuno){
				$newdata = $hensyuno."<>".$pass1."<>";
				$fp = fopen($filename2,"a");
				fwrite($fp,"$newdata\n");
				fclose($fp); 
			}
		}
	}

	$sql = "CREATE TABLE Masaki(id INT,name char(32),comment TEXT,date TEXT)";
	$stmt = $pdo -> query($sql);

	$sql = 'SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";

	$sql = 'SHOW CREATE TABLE Masaki';
	$result = $pdo -> query($sql);
	foreach($result as $row){
		print_r($row);
	}
	echo "<hr>";
	
	$sql = 'SELECT * FROM Masaki';
	$results = $pdo->query($sql);
	foreach($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	}
	//入力したデータを表示する

?>
