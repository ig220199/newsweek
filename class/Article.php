<?php

	class Article{
		private $db;

		function __construct($pdo){
			$this->db = $pdo;
		}

		public function createArticle($data){
			$date = date("Y-m-d H:i:s");

			$stmt = $this->db->prepare("INSERT INTO articles (autor, naslov, kratki_sadrzaj, sadrzaj, slika, kategorija, arhiva, datum_objave) VALUES (:autor, :naslov, :kratki_sadrzaj, :sadrzaj, :slika, :kategorija, :arhiva, :datum_objave)");
			$stmt->bindParam(":autor", $_SESSION["user"]);
			$stmt->bindParam(":naslov", $data["title"]);
			$stmt->bindParam(":kratki_sadrzaj", $data["ksv"]);
			$stmt->bindParam(":sadrzaj", $data["sv"]);
			$stmt->bindParam(":slika", $_SESSION["img"]);
			$stmt->bindParam(":kategorija", $data["category"]);
			$stmt->bindParam(":arhiva", $data["archive"]);
			$stmt->bindParam(":datum_objave", $date);
			$stmt->execute();

			self::saveArticleImage($_SESSION["img"]);

			return $this->db->lastInsertId();
		}

		public function editArticle($data){
			if(isset($_SESSION["save"][$data["id"]]["img"])){
				self::deleteArticleImage(self::getArticleImage($data["id"]));

				$stmt = $this->db->prepare("UPDATE articles SET naslov = :naslov, kratki_sadrzaj = :kratki_sadrzaj, sadrzaj = :sadrzaj, slika = :slika, kategorija = :kategorija, arhiva = :arhiva WHERE id = :id");
				$stmt->bindParam(":naslov", $data["title"]);
				$stmt->bindParam(":kratki_sadrzaj", $data["ksv"]);
				$stmt->bindParam(":sadrzaj", $data["sv"]);
				$stmt->bindParam(":slika", $_SESSION["save"][$data["id"]]["img"]);
				$stmt->bindParam(":kategorija", $data["category"]);
				$stmt->bindParam(":arhiva", $data["archive"]);
				$stmt->bindParam(":id", $data["id"]);
				$stmt->execute();

				self::saveArticleImage($_SESSION["save"][$data["id"]]["img"]);		
			}else{
				$stmt = $this->db->prepare("UPDATE articles SET naslov = :naslov, kratki_sadrzaj = :kratki_sadrzaj, sadrzaj = :sadrzaj, kategorija = :kategorija, arhiva = :arhiva WHERE id = :id");
				$stmt->bindParam(":naslov", $data["title"]);
				$stmt->bindParam(":kratki_sadrzaj", $data["ksv"]);
				$stmt->bindParam(":sadrzaj", $data["sv"]);
				$stmt->bindParam(":kategorija", $data["category"]);
				$stmt->bindParam(":arhiva", $data["archive"]);
				$stmt->bindParam(":id", $data["id"]);
				$stmt->execute();
			}

			return $stmt->rowCOunt();
		}

		public function deleteArticleImage($image){
			unlink("../images/articles/".$image);
		}

		public function getArticleImage($id){
			$stmt = $this->db->prepare("SELECT slika FROM articles WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC)["slika"];
		}

		public function saveArticleImage($image){
			rename('../images/tmp/'.$image, '../images/articles/'.$image);
		}

		public function compressImgPNG($source, $destination){
			ini_set("gd.jpeg_ignore_warning", 1);		

			$heightNew = 500;
			$widthNew = 800;

			$original = $source;

			$image = imagecreatefrompng($original);
			$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
			imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			imagealphablending($bg, TRUE);
			imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
			imagedestroy($image);
			$quality = 90; 
			imagejpeg($bg, $original . ".jpg", $quality);
			imagedestroy($bg);

			$original = $original . ".jpg";

			list($width, $height) = getimagesize($original);
			if($width > $height || $width == $height){
				$new_width = $widthNew;
				$new_height = round($widthNew/($width/$height));
			}else{
				$new_height = $heightNew;
				$new_width = round($heightNew*($width/$height));
			}

			$imageResourceId = imagecreatefromjpeg($original); 
	        $targetLayer=imagecreatetruecolor($new_width,$new_height);
			imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$new_width,$new_height, $width,$height);
			imageinterlace($targetLayer, true);
	        imagejpeg($targetLayer, $destination, 90);

			return $destination;
		}

		public function compressImgJPEG($source, $destination){
			ini_set("gd.jpeg_ignore_warning", 1);

			$heightNew = 500;
			$widthNew = 800;

			$original = $source;

			list($width, $height) = getimagesize($original);
			if($width > $height){
				$new_width = $widthNew;
				$new_height = round($widthNew/($width/$height));
			}else if($width < $height){
				$new_height = $heightNew;
				$new_width = round($heightNew*($width/$height));
			}else if($width == $height){
				$new_width = $heightNew;
				$new_height = $heightNew;
			}

			$imageResourceId = imagecreatefromjpeg($original); 
	        $targetLayer=imagecreatetruecolor($new_width,$new_height);
			imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$new_width,$new_height, $width,$height);
			imageinterlace($targetLayer, true);
	        imagejpeg($targetLayer, $destination, 90);

			return $destination;
		}

		public function tempImgExist($img){
			return file_exists("images/tmp/".$img);
		}

		public function getArticle($id){
			$stmt = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC);
		}

		public function getAuthor($id){
			$stmt = $this->db->prepare("SELECT username FROM users WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->fetch(PDO::FETCH_ASSOC)["username"];
		}

		public function fetchLatestArticles(){
			$stmt = $this->db->prepare("SELECT * FROM articles WHERE arhiva = 0 ORDER BY datum_objave DESC LIMIT 3");
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function fetchArticlesByCategory($category, $limit){
			if($limit){
				$limit = " LIMIT ".$limit;
			}else{
				$limit = "";
			}

			$stmt = $this->db->prepare("SELECT * FROM articles WHERE kategorija = :kategorija AND arhiva = 0 ORDER BY datum_objave DESC".$limit);
			$stmt->bindParam(":kategorija", $category);
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function searchArticles($search){
			$stmt = $this->db->prepare("SELECT * FROM articles WHERE MATCH(naslov, kratki_sadrzaj, sadrzaj) AGAINST(:search IN BOOLEAN MODE) AND arhiva = 0");
			$stmt->bindParam(":search", $search);
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function fetchAllArticles($archived = null){
			$stmt = $this->db->prepare("SELECT * FROM articles ORDER BY datum_objave DESC");
			$stmt->execute();

			return $stmt->fetchAll();
		}

		public function inArchiveArticle($id){
			$stmt = $this->db->prepare("UPDATE articles SET arhiva = 1 WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->rowCount();
		}

		public function fromArchiveArticle($id){
			$stmt = $this->db->prepare("UPDATE articles SET arhiva = 0 WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->rowCount();
		}

		public function deleteArticle($id){
			$stmt = $this->db->prepare("DELETE FROM articles WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return $stmt->rowCount();
		}
	}