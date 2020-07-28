<?php
	include 'core/init.php';

	if($user->is_loggedin()){
		redirect('index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - registracija</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/registracija.min.css">
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
					<h2>Registracija</h2>
					<div id="success"></div>
					<form method="post" action="">
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
								<p>Ponovi lozinku: </p>
								<input type="password" name="re_pass" placeholder="Ponovite lozinku" autocomplete="off">
							</li>
							<li>
								<p>E-mail: </p>
								<input type="mail" name="mail" placeholder="Unesite e-mail adresu">
							</li>
							<li>
								<p>Ime: </p>
								<input type="text" name="name" placeholder="Unesite ime">
							</li>
							<li>
								<p>Prezime: </p>
								<input type="text" name="surname" placeholder="Unesite prezime">
							</li>
							<li>
								<input type="submit" name="reg" value="Registriraj se">
								<p id="reg">Imaš račun? <a href="prijava.php">Prijavi se</a></p>
							</li>
						</ul>
					</form>
				</div>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script>
			$(document).on('click', 'input[type="submit"]', function(e){
				e.preventDefault();
				var passf = true;
				var username = $('input[name="username"]').val();
				var pass = $('input[name="pass"]').val();
				var repass = $('input[name="re_pass"]').val();
				var mail = $('input[name="mail"]').val();
				var name = $('input[name="name"]').val();
				var surname = $('input[name="surname"]').val();

				$(".error").remove();
				$('input[type="text"], input[type="mail"], input[type="password"]').css("border", "1px solid #adadad");

				if(username.length < 5){
					$('input[name="username"]').css("border", "1px solid red");
					$('input[name="username"]').after('<p class="error">Korisničko ime mora imati više od 5 znaka</p>');
					passf = false;
				}else if(username.length > 25){
					$('input[name="username"]').css("border", "1px solid red");
					$('input[name="username"]').after('<p class="error">Korisničko ime mora imati manje od 25 znaka</p>');
					passf = false;
				}

				if(pass.length < 4){
					$('input[name="pass"]').css("border", "1px solid red");
					$('input[name="pass"]').after('<p class="error">Lozinka mora imati više od 4 znaka</p>');
					passf = false;
				}else if(pass.length > 50){
					$('input[name="pass"]').css("border", "1px solid red");
					$('input[name="pass"]').after('<p class="error">Lozinka mora imati manje od 50 znaka</p>');
					passf = false;
				}

				if(repass != pass){
					$('input[name="re_pass"]').css("border", "1px solid red");
					$('input[name="re_pass"]').after('<p class="error">Lozinke se ne poklapaju</p>');
					passf = false;
				}

				if(mail.length < 5){
					$('input[name="mail"]').css("border", "1px solid red");
					$('input[name="mail"]').after('<p class="error">E-mail mora imati više od 5 znaka</p>');
					passf = false;
				}else if(mail.length > 50){
					$('input[name="mail"]').css("border", "1px solid red");
					$('input[name="mail"]').after('<p class="error">E-mail mora imati manje od 50 znaka</p>');
					passf = false;
				}

				if(name.length < 2){
					$('input[name="name"]').css("border", "1px solid red");
					$('input[name="name"]').after('<p class="error">Ime mora imati više od 2 znaka</p>');
					passf = false;
				}else if(name.length > 25){
					$('input[name="name"]').css("border", "1px solid red");
					$('input[name="name"]').after('<p class="error">Ime mora imati manje od 25 znaka</p>');
					passf = false;
				}

				if(surname.length < 2){
					$('input[name="surname"]').css("border", "1px solid red");
					$('input[name="surname"]').after('<p class="error">Prezime mora imati više od 2 znaka</p>');
					passf = false;
				}else if(surname.length > 25){
					$('input[name="surname"]').css("border", "1px solid red");
					$('input[name="surname"]').after('<p class="error">Prezime mora imati manje od 25 znaka</p>');
					passf = false;
				}

				if(passf){
					$.ajax({
						type: "POST",
				        url: "process/sign_process.php",
				        data: { "reg" : '1', username: username, pass: pass, repass: repass, mail: mail, name: name, surname: surname },
				        success: function(response){
			        		if(response == "success"){
			        			$('form').find("input[type=text], input[type=password], input[type=mail]").val("");
			        			$('#success').append('<p class="success"><span>Registracija je uspješna!</span> <a href="prijava.php">Prijavi se.</a></p>');
			        			$("#success").show();
			        			$('html,body').animate({ scrollTop: 0 }, 'slow');
			        		}else{
			        			$.each(JSON.parse(response), function(index, value) {
								  switch(index){
								  	case 'username':
								  		$('input[name="username"]').css("border", "1px solid red");
								  		$('input[name="username"]').after(value);
								  		break;
								  	case 'mail':
								  		$('input[name="mail"]').css("border", "1px solid red");
								  		$('input[name="mail"]').after(value);
								  		break;
								  	case 'pass':
								  		$('input[name="pass"]').css("border", "1px solid red");
								  		$('input[name="pass"]').after(value);
								  		break;
								  	case 'repass':
								  		$('input[name="re_pass"]').css("border", "1px solid red");
								  		$('input[name="re_pass"]').after(value);
								  		break;
								  	case 'name':
								  		$('input[name="name"]').css("border", "1px solid red");
								  		$('input[name="name"]').after(value);
								  		break;
								  	case 'surname':
								  		$('input[name="surname"]').css("border", "1px solid red");
								  		$('input[name="surname"]').after(value);
								  		break;
								  }
								});
			        		}
				        }
					});
				}
			});
		</script>
		<script src="js/transition.js"></script>
	</body>
</html>