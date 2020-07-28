<?php
	include 'core/init.php';

	if(isset($_GET['id'])){
		$id = sanitize($_GET['id']);
	}else{
		redirect("index.php");
		exit;
	}
	
	if($article_data = $article->getArticle($id)){

	}else{
		redirect("index.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - <?php echo $article_data["naslov"]; ?></title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/clanak.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<div id="left">
					<?php
						if($article_data["arhiva"]){
							echo '<div class="archived_article">Ovaj članak je arhiviran te se neće prikazivati sa ostalim vjestima!</div>';
						}
					?>
					<h2><?php echo $article_data["kategorija"]; ?></h2>
					<h1><?php echo $article_data["naslov"]; ?></h1>
					<p>Autor: <b><?php echo $article->getAuthor($article_data["autor"]); ?></b>, <?php echo format_datum($article_data["datum_objave"]); ?></p>
					<img src="images/articles/<?php echo $article_data["slika"]; ?>" alt="">
					<a href="clanci.php?cat=<?php echo $article_data["kategorija"]; ?>"><?php echo $article_data["kategorija"]; ?></a>
					<article>
						<pre>
							<?php echo ltrim($article_data["sadrzaj"]); ?>
						</pre>
					</article>
				</div>
				<div id="right">					
					<h2>Zadnje objavljeno</h2>
					<?php
						$latestArticles = $article->fetchLatestArticles();

						foreach ($latestArticles as $latestArticle) {
							echo '<div class="article">';
								echo '<a href="clanak.php?id='.$latestArticle["id"].'">';
									echo '<div class="img_container"><img src="images/articles/'.$latestArticle["slika"].'" alt=""></div>';
									echo '<div class="title_container"><h3>'.$latestArticle["naslov"].'</h3></div>';
								echo '</a>';
							echo '</div>';
						}
					?>
				</div>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script src="js/transition.js"></script>
	</body>
</html>