<?php
	include '../core/init.php';

	if(isset($_POST["cancel"])){
		if(isset($_SESSION["error"])){
			unset($_SESSION["error"]);
		}

		if(isset($_SESSION["fill"])){
			unset($_SESSION["fill"]);
		}

		redirect("../index.php");
	}

	if(isset($_POST["cancelEditing"])){
		if(isset($_SESSION["error"])){
			unset($_SESSION["error"]);
		}

		if(isset($_SESSION["save"])){
			unset($_SESSION["save"]);
		}

		redirect("../administracija.php");
	}

	if(isset($_POST['add'])){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if(empty($post['title'])){
			$err['title'] = '<p class="error">Morate unijeti naslov vjesti.</p>';		
		}elseif(strlen($post['title']) < 5){
			$err['title'] = '<p class="error">Naslov vjesti mora imati više od 5 znaka.</p>';	
		}elseif(strlen($post['title']) > 100){
			$err['title'] = '<p class="error">Naslov vjesti mora imati manje od 100 znaka.</p>';
		}

		if(empty($post['ksv'])){
			$err['ksv'] = '<p class="error">Morate unijeti kratki sadržaj vjesti.</p>';		
		}elseif(strlen($post['ksv']) < 5){
			$err['ksv'] = '<p class="error">Kratki sadržaj vjesti mora imati više od 5 znaka.</p>';	
		}elseif(strlen($post['ksv']) > 50){
			$err['ksv'] = '<p class="error">Kratki sadržaj vjesti mora imati manje od 50 znaka.</p>';
		}

		if(empty($post['sv'])){
			$err['sv'] = '<p class="error">Morate unijeti sadržaj vjesti.</p>';		
		}elseif(strlen($post['sv']) < 50){
			$err['sv'] = '<p class="error">Sadržaj vjesti mora imati više od 50 znaka.</p>';	
		}elseif(strlen($post['sv']) > 5000){
			$err['sv'] = '<p class="error">Sadržaj vjesti mora imati manje od 5000 znaka.</p>';
		}

		if(!isset($_SESSION["img"]) || !file_exists("../images/tmp/".$_SESSION["img"])){
			$err['img'] = '<p class="error">Morate odabrati sliku članka.</p>';
		}

		if(empty($post['category'])){
			$err['category'] = '<p class="error">Morate unijeti kategoriju vjesti.</p>';		
		}elseif(strlen($post['category']) < 2){
			$err['category'] = '<p class="error">Kategorija vjesti mora imati više od 2 znaka.</p>';	
		}elseif(strlen($post['category']) > 15){
			$err['category'] = '<p class="error">Kategorija vjesti mora imati manje od 15 znaka.</p>';
		}

		if(isset($post['archive']) && $post['archive'] == "Yes"){
			$post['archive'] = 1;
		}else{
			$post['archive'] = 0;
		}

		if(empty($err)){
			if($id = $article->createArticle($post)){
				if(isset($_SESSION["error"])){
					unset($_SESSION["error"]);
				}

				if(isset($_SESSION["fill"])){
					unset($_SESSION["fill"]);
				}

				if(isset($_SESSION["img"])){
					unset($_SESSION["img"]);
				}

				redirect('../clanak.php?id='.$id);
			}
			
		}else{
			$_SESSION["error"] = $err;
			$_SESSION["fill"] = [
				"title" => $post["title"],
				"ksv" => $post["ksv"],
				"sv" => $post["sv"],
				"category" => $post["category"],
				"archive" => $post["archive"],
			];

			redirect('../unos.php');
		}
	}

	if(isset($_POST["edit"])){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if(empty($post['title'])){
			$err['title'] = '<p class="error">Morate unijeti naslov vjesti.</p>';		
		}elseif(strlen($post['title']) < 5){
			$err['title'] = '<p class="error">Naslov vjesti mora imati više od 5 znaka.</p>';	
		}elseif(strlen($post['title']) > 100){
			$err['title'] = '<p class="error">Naslov vjesti mora imati manje od 100 znaka.</p>';
		}

		if(empty($post['ksv'])){
			$err['ksv'] = '<p class="error">Morate unijeti kratki sadržaj vjesti.</p>';		
		}elseif(strlen($post['ksv']) < 5){
			$err['ksv'] = '<p class="error">Kratki sadržaj vjesti mora imati više od 5 znaka.</p>';	
		}elseif(strlen($post['ksv']) > 50){
			$err['ksv'] = '<p class="error">Kratki sadržaj vjesti mora imati manje od 50 znaka.</p>';
		}

		if(empty($post['sv'])){
			$err['sv'] = '<p class="error">Morate unijeti sadržaj vjesti.</p>';		
		}elseif(strlen($post['sv']) < 50){
			$err['sv'] = '<p class="error">Sadržaj vjesti mora imati više od 50 znaka.</p>';	
		}elseif(strlen($post['sv']) > 5000){
			$err['sv'] = '<p class="error">Sadržaj vjesti mora imati manje od 5000 znaka.</p>';
		}

		if(empty($post['category'])){
			$err['category'] = '<p class="error">Morate unijeti kategoriju vjesti.</p>';		
		}elseif(strlen($post['category']) < 2){
			$err['category'] = '<p class="error">Kategorija vjesti mora imati više od 2 znaka.</p>';	
		}elseif(strlen($post['category']) > 15){
			$err['category'] = '<p class="error">Kategorija vjesti mora imati manje od 15 znaka.</p>';
		}

		if(isset($post['archive']) && $post['archive'] == "Yes"){
			$post['archive'] = 1;
		}else{
			$post['archive'] = 0;
		}

		if(empty($err)){
			if($id = $article->editArticle($post)){
				if(isset($_SESSION["error"])){
					unset($_SESSION["error"]);
				}

				if(isset($_SESSION["save"][$post["id"]])){
					unset($_SESSION["save"][$post["id"]]);
				}			

				redirect('../clanak.php?id='.$post["id"]);
			}
			
		}else{
			$_SESSION["error"] = $err;
			$_SESSION["save"][$post["id"]] = [
				"title" => $post["title"],
				"ksv" => $post["ksv"],
				"sv" => $post["sv"],
				"category" => $post["category"],
				"archive" => $post["archive"],
			];

			redirect('../uredi.php?id='.$post["id"]);
		}
	}

	if(isset($_POST["img"])){
		$image_name = $_FILES['image']['name'];
		$size 		= $_FILES['image']['size'];
		$type 		= $_FILES['image']['type'];

		if(in_array($type, ["image/jpeg", "image/png", "image/jpg"])){
			if($size > 2097152){
				echo json_encode(["error", "Slika mora biti manja od 2MB!"]);
			}else{
				switch ($type) {
					case 'image/jpeg':
						$ext = "jpg";
						break;
					case 'image/png':
						$ext = "png";
						break;
				}

				$new_image_name = round(microtime(true)) . '.' . $ext;
				$target_dir = "../images/tmp/";
				$target_file = $target_dir.$new_image_name;

				$_SESSION["img"] = $new_image_name;

				if($ext == 'png'){
					$article->compressImgPNG($_FILES['image']['tmp_name'], $target_file);
				}else{
					$article->compressImgJPEG($_FILES['image']['tmp_name'], $target_file);
				}

				echo "success";
				exit;
			}
		}else{
			echo json_encode(["error", "Nepodržan format slike!"]);
			exit;
		}
	}

	if(isset($_POST["imge"])){
		$image_name = $_FILES['image']['name'];
		$size 		= $_FILES['image']['size'];
		$type 		= $_FILES['image']['type'];

		$id = sanitize($_POST["id"]);

		if(in_array($type, ["image/jpeg", "image/png", "image/jpg"])){
			if($size > 2097152){
				echo json_encode(["error", "Slika mora biti manja od 2MB!"]);
			}else{
				switch ($type) {
					case 'image/jpeg':
						$ext = "jpg";
						break;
					case 'image/png':
						$ext = "png";
						break;
				}

				$new_image_name = round(microtime(true)) . '.' . $ext;
				$target_dir = "../images/tmp/";
				$target_file = $target_dir.$new_image_name;

				$_SESSION["save"][$id]["img"] = $new_image_name;

				if($ext == 'png'){
					$article->compressImgPNG($_FILES['image']['tmp_name'], $target_file);
				}else{
					$article->compressImgJPEG($_FILES['image']['tmp_name'], $target_file);
				}

				echo "success";
				exit;
			}
		}else{
			echo json_encode(["error", "Nepodržan format slike!"]);
			exit;
		}
	}

	if(isset($_POST["role"])){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		switch ($post["role"]) {
			case 'in_archive':
				if($article->inArchiveArticle($post["id"])){
					echo "success";
					exit;
				}
				break;
			case 'from_archive':
				if($article->fromArchiveArticle($post["id"])){
					echo "success";
					exit;
				}
				break;
			case 'delete':
				if($article->deleteArticle($post["id"])){
					echo "success";
					exit;
				}
				break;		
		}
	}
?>