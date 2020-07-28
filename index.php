<?php
	include 'core/init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/index.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<?php
					$articlesByCategory = $article->fetchArticlesByCategory("Hrvatska", 4);

					if(!empty($articlesByCategory)):					
				?>
					<section>
						<h2><a href="clanci.php?cat=Hrvatska">Hrvatska</a></h2>
						<?php foreach($articlesByCategory as $articleByCategory): ?>
							<div class="article">
								<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>">
									<div class="img_container" style="background-image: url('images/articles/<?php echo $articleByCategory['slika']; ?>');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>"><h3><?php echo $articleByCategory["naslov"]; ?></h3></a>
									<p><?php echo $articleByCategory["kratki_sadrzaj"]; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</section>
				<?php endif; ?>

				<?php
					$articlesByCategory = $article->fetchArticlesByCategory("Svijet", 4);

					if(!empty($articlesByCategory)):					
				?>
					<section>
						<h2><a href="clanci.php?cat=Svijet">Svijet</a></h2>
						<?php foreach($articlesByCategory as $articleByCategory): ?>
							<div class="article">
								<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>">
									<div class="img_container" style="background-image: url('images/articles/<?php echo $articleByCategory['slika']; ?>');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>"><h3><?php echo $articleByCategory["naslov"]; ?></h3></a>
									<p><?php echo $articleByCategory["kratki_sadrzaj"]; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</section>
				<?php endif; ?>

				<?php
					$articlesByCategory = $article->fetchArticlesByCategory("Sport", 4);

					if(!empty($articlesByCategory)):					
				?>
					<section>
						<h2><a href="clanci.php?cat=Sport">Sport</a></h2>
						<?php foreach($articlesByCategory as $articleByCategory): ?>
							<div class="article">
								<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>">
									<div class="img_container" style="background-image: url('images/articles/<?php echo $articleByCategory['slika']; ?>');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>"><h3><?php echo $articleByCategory["naslov"]; ?></h3></a>
									<p><?php echo $articleByCategory["kratki_sadrzaj"]; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</section>
				<?php endif; ?>

				<?php
					$articlesByCategory = $article->fetchArticlesByCategory("Kultura", 4);

					if(!empty($articlesByCategory)):					
				?>
					<section>
						<h2><a href="clanci.php?cat=Kultura">Kultura</a></h2>
						<?php foreach($articlesByCategory as $articleByCategory): ?>
							<div class="article">
								<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>">
									<div class="img_container" style="background-image: url('images/articles/<?php echo $articleByCategory['slika']; ?>');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>"><h3><?php echo $articleByCategory["naslov"]; ?></h3></a>
									<p><?php echo $articleByCategory["kratki_sadrzaj"]; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</section>
				<?php endif; ?>

				<?php
					$articlesByCategory = $article->fetchArticlesByCategory("Znanost", 4);

					if(!empty($articlesByCategory)):					
				?>
					<section>
						<h2><a href="clanci.php?cat=Znanost">Znanost</a></h2>
						<?php foreach($articlesByCategory as $articleByCategory): ?>
							<div class="article">
								<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>">
									<div class="img_container" style="background-image: url('images/articles/<?php echo $articleByCategory['slika']; ?>');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id=<?php echo $articleByCategory['id']; ?>"><h3><?php echo $articleByCategory["naslov"]; ?></h3></a>
									<p><?php echo $articleByCategory["kratki_sadrzaj"]; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</section>
				<?php endif; ?>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script src="js/transition.js"></script>
	</body>
</html>