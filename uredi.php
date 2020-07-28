<?php
	include 'core/init.php';

	if(!$user->is_loggedin()){
		redirect("prijava.php");
	}

	if(!isset($_GET['id'])){
		redirect("administracija.php");
	}else{
		$id = sanitize($_GET['id']);
	}

	$article_data = $article->getArticle($id);

	if(empty($article_data)){
		redirect("administracija.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - uredi članka</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/uredi.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<div id="add_container">
					<h2>Uredi članka</h2>
					<?php
						if(isset($_SESSION["error"])){
							echo '<div id="error_container">';
							foreach ($_SESSION["error"] as $err) {
								echo $err;
							}
							echo '</div>';

							unset($_SESSION["error"]);
						}

						if(isset($_SESSION["success"])){
							echo '<div id="success">Članak je uspješno uređen. <a href="clanak.php?id='.$_SESSION["success"].'">Pogledaj uređeni članak.</a></div>';
							unset($_SESSION["success"]);
						}
					?>					
					<form method="post" action="process/article_process.php">
						<ul>
							<li>
								<p>Naslov vijesti: </p>
								<input type="text" name="title" placeholder="Unesite naslov vijesti" value="<?php if(isset($_SESSION["save"][$id]["title"])) echo $_SESSION["save"][$id]["title"]; else echo $article_data["naslov"]; ?>">
							</li>
							<li>
								<p>Kratki sadržaj vjesti (do 50 znakova): </p>
								<textarea name="ksv" placeholder="Unesite kratki sadržaj vjesti"><?php if(isset($_SESSION["save"][$id]["ksv"])) echo $_SESSION["save"][$id]["ksv"]; else echo $article_data["kratki_sadrzaj"]; ?></textarea>
							</li>
							<li>
								<p>Sadržaj vjesti: </p>
								<textarea name="sv" placeholder="Unesite sadržaj vjesti"><?php if(isset($_SESSION["save"][$id]["sv"])) echo $_SESSION["save"][$id]["sv"]; else echo $article_data["sadrzaj"]; ?></textarea>
							</li>
							<li>
								<p>Slika: </p>
								<input type="file" name="img" accept="image/*">
								<div id="preview" style="display: block;"><img src="<?php if(isset($savedImage)) echo 'images/tmp/'.$_SESSION["save"][$id]["img"]; else echo 'images/articles/'.$article_data['slika']; ?>" alt=""></div>
							</li>
							<li>
								<p>Kategorija vjesti: </p>
								<select name="category">
									<option value="">Odaberi kategoriju članka</option>
									<option value="Hrvatska" <?php if(isset($_SESSION["save"][$id]["category"]) && $_SESSION["save"][$id]["category"] == "Hrvatska") echo 'selected'; else if($article_data["kategorija"] == "Hrvatska") echo "selected"; ?>>Hrvatska</option>
									<option value="Svijet" <?php checkSaver("category", "select", "Svijet"); ?> <?php if(isset($_SESSION["save"][$id]["category"]) && $_SESSION["save"][$id]["category"] == "Svijet") echo 'selected'; else if($article_data["kategorija"] == "Svijet") echo "selected"; ?>>Svijet</option>
									<option value="Sport" <?php checkSaver("category", "select", "Sport"); ?> <?php if(isset($_SESSION["save"][$id]["category"]) && $_SESSION["save"][$id]["category"] == "Sport") echo 'selected'; else if($article_data["kategorija"] == "Sport") echo "selected"; ?>>Sport</option>
									<option value="Kultura" <?php checkSaver("category", "select", "Kultura"); ?> <?php if(isset($_SESSION["save"][$id]["category"]) && $_SESSION["save"][$id]["category"] == "Kultura") echo 'selected'; else if($article_data["kategorija"] == "Kultura") echo "selected"; ?>>Kultura</option>
									<option value="Znanost" <?php checkSaver("category", "select", "Znanost"); ?> <?php if(isset($_SESSION["save"][$id]["category"]) && $_SESSION["save"][$id]["category"] == "Znanost") echo 'selected'; else if($article_data["kategorija"] == "Znanost") echo "selected"; ?>>Znanost</option>
								</select>
							</li>
							<li>
								<p><label>Spremiti u arhivu: <input type="checkbox" name="archive" value="Yes" <?php if(isset($_SESSION["save"][$id]["archive"])) echo "checked"; else if($article_data["arhiva"]) echo "checked"; ?>></label></p>
							</li>
							<li>
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<input type="submit" name="edit" value="Uredi članak">
								<input type="submit" name="cancelEditing" value="Poništi">								
							</li>
						</ul>
					</form>
				</div>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script>
			$(document).on('change', 'input[name="img"]', function(){
				var input = this;

				if (this.files && this.files[0]) {
					formData = new FormData();
                	formData.append('imge', 1);
                	formData.append('id', <?php echo $id; ?>);
                	formData.append('image', input.files[0]);
					$.ajax({
						type: "POST",
				        url: "process/article_process.php",
				        data: formData,
				        processData: false,
						contentType: false,
				        success: function(response){
				        	if(response == "success"){
				        		var reader = new FileReader();
					    
							    reader.onload = function(e) {
							      $('#preview img').attr('src', e.target.result);
							      $('#preview').show();
							    }
							    
							    reader.readAsDataURL(input.files[0]);
				        	}else{
				        		response = JSON.parse(response);
				        		alert(response[1]);
				        	}			        	
				        }
					});
				}
			});
		</script>
		<script src="js/transition.js"></script>
	</body>
</html>