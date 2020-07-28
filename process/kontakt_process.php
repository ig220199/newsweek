<?php
	include '../core/init.php';

	if(isset($_POST["send"])){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if(empty($post["email"])){
			if(empty($post['predmet'])){
				$err['predmet'] = '<p class="error">Morate unijeti predmet poruke.</p>';		
			}elseif(strlen($post['predmet']) < 5){
				$err['predmet'] = '<p class="error">Predmet poruke mora imati više od 5 znaka.</p>';	
			}elseif(strlen($post['predmet']) > 100){
				$err['predmet'] = '<p class="error">Predmet poruke mora imati manje od 100 znaka.</p>';
			}

			if(empty($post['textarea'])){
				$err['textarea'] = '<p class="error">Morate unijeti sadržaj poruke.</p>';		
			}elseif(strlen($post['textarea']) < 10){
				$err['textarea'] = '<p class="error">Sadržaj poruke mora imati više od 10 znaka.</p>';	
			}elseif(strlen($post['textarea']) > 1000){
				$err['textarea'] = '<p class="error">Sadržaj poruke mora imati manje od 1000 znaka.</p>';
			}

			if(empty($post['mail'])){
				$err['mail'] = '<p class="error">Morate unijeti e-mail adresu.</p>';		
			}elseif(strlen($post['mail']) < 10){
				$err['mail'] = '<p class="error">E-mail mora imati više od 10 znaka.</p>';	
			}elseif(strlen($post['mail']) > 50){
				$err['mail'] = '<p class="error">E-mail mora imati manje od 50 znaka.</p>';
			}

			if(empty($err)){
				if($user->kontak($post)){
					echo 'success';
				}
			}else{
				echo json_encode($err);
			}
		}else{
			return("kontakt.php");
		}
	}
?>