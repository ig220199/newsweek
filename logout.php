<?php
	include 'core/init.php';

	session_destroy();

	redirect("index.php");
?>