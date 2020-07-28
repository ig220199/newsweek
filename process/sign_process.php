<?php
	include '../core/init.php';

	if(isset($_POST["reg"])){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if(empty($post['username'])){
			$err['username'] = '<p class="error">Morate unijeti korisničko ime.</p>';		
		}elseif(strlen($post['username']) < 5){
			$err['username'] = '<p class="error">Korisničko ime mora imati više od 5 znaka.</p>';	
		}elseif(strlen($post['username']) > 25){
			$err['username'] = '<p class="error">Korisničko ime mora imati manje od 25 znaka.</p>';
		}elseif($user->usernameExist($post['username'])){
			$err['username'] = '<p class="error">Korisničko ime je u uporabi.</p>';
		}

		if(empty($post['pass'])){
			$err['pass'] = '<p class="error">Morate unijeti lozinku.</p>';		
		}elseif(strlen($post['pass']) < 4){
			$err['pass'] = '<p class="error">Lozinka mora imati više od 4 znaka.</p>';	
		}elseif(strlen($post['pass']) > 50){
			$err['pass'] = '<p class="error">Lozinka mora imati manje od 50 znaka.</p>';
		}

		if($post['pass'] != $post['repass']){
			$err['repass'] = '<p class="error">Lozinke se ne poklapaju.</p>';
		}

		if(empty($post['mail'])){
			$err['mail'] = '<p class="error">Morate unijeti e-mail adresu.</p>';		
		}elseif(strlen($post['mail']) < 5){
			$err['mail'] = '<p class="error">E-mail mora imati više od 5 znaka.</p>';	
		}elseif(strlen($post['mail']) > 50){
			$err['mail'] = '<p class="error">E-mail mora imati manje od 50 znaka.</p>';
		}elseif($user->mailExist($post['mail'])){
			$err['mail'] = '<p class="error">E-mail je u uporabi.</p>';
		}

		if(empty($post['name'])){
			$err['name'] = '<p class="error">Morate unijeti ime.</p>';		
		}elseif(strlen($post['name']) < 2){
			$err['name'] = '<p class="error">Ime mora imati više od 2 znaka.</p>';	
		}elseif(strlen($post['name']) > 25){
			$err['name'] = '<p class="error">Ime mora imati manje od 25 znaka.</p>';
		}

		if(empty($post['surname'])){
			$err['surname'] = '<p class="error">Morate unijeti prezime.</p>';		
		}elseif(strlen($post['surname']) < 2){
			$err['surname'] = '<p class="error">Prezime mora imati više od 2 znaka.</p>';	
		}elseif(strlen($post['surname']) > 25){
			$err['surname'] = '<p class="error">Prezime mora imati manje od 25 znaka.</p>';
		}

		if(empty($err)){
			if($user->registracija($post)){
				echo 'success';
			}
		}else{
			echo json_encode($err);
		}
	}

	if(isset($_POST['login'])){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if(!empty($post['username']) && !empty($post['pass'])){
			if($data = $user->prijava($post['username'], $post['pass'])){
				$_SESSION['user'] = $data['id'];

				if(isset($_SESSION['error'])){
					unset($_SESSION['error']);
				}

				redirect('../index.php');
			}else{
				$_SESSION['error'] = "Korisničko ime i lozinka se ne poklapaju";
			}
		}else{
			$_SESSION['error'] = "Unesite korisničko ime i lozinku";
		}


		redirect('../prijava.php');
	}
?>