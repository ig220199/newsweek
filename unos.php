<?php
	include 'core/init.php';

	if(!$user->is_loggedin()){
		redirect("prijava.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - unos članka</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/unos.min.css">
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
					<h2>Unesi članka</h2>
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
							echo '<div id="success">Članak je uspješno unesen. <a href="clanak.php?id='.$_SESSION["success"].'">Pogledaj unjeti članak.</a></div>';
							unset($_SESSION["success"]);
						}
					?>					
					<form method="post" action="process/article_process.php">
						<ul>
							<li>
								<p>Naslov vijesti: </p>
								<input type="text" name="title" placeholder="Unesite naslov vijesti" <?php checkSaver("title", "input"); ?>>
							</li>
							<li>
								<p>Kratki sadržaj vjesti (do 50 znakova): </p>
								<textarea name="ksv" placeholder="Unesite kratki sadržaj vjesti"><?php checkSaver("ksv", "textarea"); ?></textarea>
							</li>
							<li>
								<p>Sadržaj vjesti: </p>
								<textarea name="sv" placeholder="Unesite sadržaj vjesti"><?php checkSaver("sv", "textarea"); ?></textarea>
							</li>
							<li>
								<p>Slika: </p>
								<input type="file" name="img" accept="image/*">
								<?php
									if(isset($_SESSION["img"]) && $article->tempImgExist($_SESSION["img"])){
										$savedImage = 1;
									}
								?>
								<div id="preview" <?php if(isset($savedImage)) echo 'style="display: block;"' ?>><img src="<?php if(isset($savedImage)) echo 'images/tmp/'.$_SESSION["img"]; ?>" alt=""></div>
							</li>
							<li>
								<p>Kategorija vjesti: </p>
								<select name="category">
									<option value="">Odaberi kategoriju članka</option>
									<option value="Hrvatska" <?php checkSaver("category", "select", "Hrvatska"); ?>>Hrvatska</option>
									<option value="Svijet" <?php checkSaver("category", "select", "Svijet"); ?>>Svijet</option>
									<option value="Sport" <?php checkSaver("category", "select", "Sport"); ?>>Sport</option>
									<option value="Kultura" <?php checkSaver("category", "select", "Kultura"); ?>>Kultura</option>
									<option value="Znanost" <?php checkSaver("category", "select", "Znanost"); ?>>Znanost</option>
								</select>
							</li>
							<li>
								<p><label>Spremiti u arhivu: <input type="checkbox" name="archive" value="Yes" <?php checkSaver("archive", "checkbox"); ?>></label></p>
							</li>
							<li>
								<input type="submit" name="add" value="Dodaj članak">
								<input type="submit" name="cancel" value="Poništi">								
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
                	formData.append('img', 1);
                	formData.append('image', input.files[0]);
					$.ajax({
						type: "POST",
				        url: "process/article_process.php",
				        data: formData,
				        processData: false,
						contentType: false,
				        success: function(response){	
				        console.log(response);			        	
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