<?php
	include 'core/init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/kontakt.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<div id="contact_container">
					<h2>Kontaktirajte nas</h2>
					<div id="success"></div>
					<form method="post" action="">
						<ul>
							<li>
								<p>Predmet: </p>
								<input type="text" name="subject" placeholder="Unesite predmet poruke">
							</li>						
							<li>
								<p>E-mail: </p>
								<input type="mail" name="mail" placeholder="Unesite svoju e-mail adresu">
							</li>
							<li>
								<p>Poruka: </p>
								<textarea name="msg" placeholder="Ovdje upišite Vašu poruku"></textarea>
							</li>							
							<li>
								<input type="text" name="email">
								<input type="submit" name="send" value="Pošalji">
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
				var predmet = $('input[name="subject"]').val();
				var mail = $('input[name="mail"]').val();
				var email = $('input[name="email"]').val();
				var textarea = $('textarea[name="msg"]').val();

				$(".error").remove();
				$('input[type="text"], input[type="mail"], input[type="password"], textarea').css("border", "1px solid #adadad");

				if(predmet.length < 5){
					$('input[name="subject"]').css("border", "1px solid red");
					$('input[name="subject"]').after('<p class="error">Predmet mora imati više od 5 znaka</p>');
					passf = false;
				}else if(predmet.length > 100){
					$('input[name="subject"]').css("border", "1px solid red");
					$('input[name="subject"]').after('<p class="error">Predmet mora imati manje od 100 znaka</p>');
					passf = false;
				}

				if(mail.length < 10){
					$('input[name="mail"]').css("border", "1px solid red");
					$('input[name="mail"]').after('<p class="error">E-mail mora imati više od 10 znaka</p>');
					passf = false;
				}else if(mail.length > 50){
					$('input[name="mail"]').css("border", "1px solid red");
					$('input[name="mail"]').after('<p class="error">E-mail mora imati manje od 50 znaka</p>');
					passf = false;
				}

				if(textarea.length < 10){
					$('textarea[name="msg"]').css("border", "1px solid red");
					$('textarea[name="msg"]').after('<p class="error">Porka mora imati više od 10 znaka</p>');
					passf = false;
				}else if(textarea.length > 1000){
					$('textarea[name="msg"]').css("border", "1px solid red");
					$('textarea[name="msg"]').after('<p class="error">Porka mora imati manje od 1000 znaka</p>');
					passf = false;
				}

				if(passf){
					$.ajax({
						type: "POST",
				        url: "process/kontakt_process.php",
				        data: { "send" : '1', predmet: predmet, mail: mail, email: email, textarea: textarea },
				        success: function(response){
				        	console.log(response);
			        		if(response == "success"){
			        			$('#success').empty();
			        			$('#success').append('<p class="success">Poruka uspješno poslana!.</p>');
			        			$("#success").show();
			        			$('html,body').animate({ scrollTop: 0 }, 'slow');
			        		}else{
			        			$.each(JSON.parse(response), function(index, value) {
								  switch(index){
								  	case 'predmet':
								  		$('input[name="subject"]').css("border", "1px solid red");
								  		$('input[name="subject"]').after(value);
								  		break;
								  	case 'mail':
								  		$('input[name="mail"]').css("border", "1px solid red");
								  		$('input[name="mail"]').after(value);
								  		break;
								  	case 'textarea':
								  		$('input[name="msg"]').css("border", "1px solid red");
								  		$('input[name="msg"]').after(value);
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