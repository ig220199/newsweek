<?php
	session_start();

	$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].'/newsweek';

	require_once $_SERVER['DOCUMENT_ROOT'].'/core/connection.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/class/User.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/class/Article.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';

	$user = new User($pdo);
	$article = new Article($pdo);

	if($user->is_loggedin()){
		$user_data = $user->getUserData();
	}
?>