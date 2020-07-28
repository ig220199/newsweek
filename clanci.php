<?php
	include 'core/init.php';

	if(isset($_GET["cat"])){
		$cat = sanitize($_GET["cat"]);

		if(in_array($cat, ["Hrvatska", "Svijet", "Sport", "Kultura", "Znanost"])){
			$article_data = $article->fetchArticlesByCategory($cat, 0);
		}else{
			redirect("index.php");
			exit;
		}
	}else{
		redirect("index.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - <?php echo $_GET['cat']; ?></title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/clanci.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<h1><?php echo $cat; ?></h1>
				<?php
					if(!empty($article_data)){
						foreach ($article_data as $articleByCategory) {
							echo '<div class="article">
								<a href="clanak.php?id='.$articleByCategory["id"].'">
									<div class="img_container" style="background-image: url(\'images/articles/'.$articleByCategory["slika"].'\');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id='.$articleByCategory['id'].'"><h3>'.$articleByCategory["naslov"].'</h3></a>
									<p>'.$articleByCategory["kratki_sadrzaj"].'</p>
								</div>
							</div>';
						}
					}else{
						echo '<center><h2 class="no">Trenutno nema članaka u kategoriji <i>'.$cat.'</i></h2></center>';
					}
				?>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script src="js/transition.js"></script>
	</body>
</html>