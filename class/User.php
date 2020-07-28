<?php

	class User{
		private $db;

		function __construct($pdo){
			$this->db = $pdo;
		}

		public function registracija($data){
			$date = date("Y-m-d");
			$pass = password_hash($data['pass'], PASSWORD_DEFAULT);

			$stmt = $this->db->prepare("INSERT INTO users (username, lozinka, ime, prezime, mail, datum_registracije) VALUES (:username, :lozinka, :ime, :prezime, :mail, :datum_registracije)");
			$stmt->bindParam(":username", $data["username"]);
			$stmt->bindParam(":lozinka", $pass);
			$stmt->bindParam(":ime", $data["name"]);
			$stmt->bindParam(":prezime", $data["surname"]);
			$stmt->bindParam(":mail", $data["mail"]);
			$stmt->bindParam(":datum_registracije", $date);
			$stmt->execute();

			return $stmt->rowCount();
		}

		public function usernameExist($username){
			$stmt = $this->db->prepare("SELECT id FROM users WHERE username = :username");
			$stmt->bindParam(':username', $username);
			$stmt->execute();			

			return $stmt->rowCount();
		}

		public function mailExist($mail){
			$stmt = $this->db->prepare("SELECT id FROM users WHERE mail = :mail");
			$stmt->bindParam(':mail', $mail);
			$stmt->execute();			

			return $stmt->rowCount();
		}

		public function prijava($username, $pass){
			$stmt = $this->db->prepare("SELECT id, lozinka FROM users WHERE username=:username");
			$stmt->bindParam(':username', $username);
			$stmt->execute();			

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			if(password_verify($pass, $data['lozinka'])){
				return $data;
			}
		}

		public function is_loggedin(){
			if(isset($_SESSION['user'])){
				return $_SESSION['user'];
			}

			return false;
		}

		public function getUserData(){
			$stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
			$stmt->bindParam(":id", $_SESSION['user']);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function kontak($data){
			$datum = date("Y-m-d H:i:s");

			$stmt = $this->db->prepare("INSERT INTO kontakt (predmet, poruka, od, datum) VALUES (:predmet, :poruka, :od, :datum)");
			$stmt->bindParam(":predmet", $data["predmet"]);
			$stmt->bindParam(":poruka", $data["textarea"]);
			$stmt->bindParam(":od", $data["mail"]);
			$stmt->bindParam(":datum", $datum);
			$stmt->execute();

			return $stmt->rowCount();
		}	
	}