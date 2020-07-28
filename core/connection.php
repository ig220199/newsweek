<?php
	/* Konekcija na bazu */
	$dbname = "newsweek";
	$host = "127.0.0.1";
	$charset = "utf8";
	$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
	$user = 'root';
	$password = '';

	try{
		$pdo = new PDO($dns, $user, $password);
	}catch(PDOexception $e){
		echo 'Povezivanje sa serverom nije moguće. ['.$e->getMessage().']';
	}
?>