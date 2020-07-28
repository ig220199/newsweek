<?php
	include 'core/init.php';

	if($user->is_loggedin()){
		redirect('index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - prijava</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/prijava.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<div id="login_container">
					<h2>Prijava</h2>
					<?php
						if(isset($_SESSION['error'])){
							echo '<p class="error">'.$_SESSION['error'].'</p>';
							unset($_SESSION['error']);
						}
					?>
					<form method="post" action="process/sign_process.php">
						<ul>
							<li>
								<p>Korisničko ime: </p>
								<input type="text" name="username" placeholder="Unesite korisničko ime">
							</li>
							<li>
								<p>Lozinka: </p>
								<input type="password" name="pass" placeholder="Unesite lozinku" autocomplete="off">
							</li>
							<li>
								<input type="submit" name="login" value="Prijavi se">
								<p id="reg">Nemaš račun? <a href="registracija.php">Registriraj se</a></p>
							</li>
						</ul>
					</form>			
				</div>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script src="js/transition.js"></script>
	</body>
</html>