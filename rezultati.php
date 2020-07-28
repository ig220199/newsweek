<?php
	include 'core/init.php';

	if(isset($_GET['search'])){
		$search = sanitize($_GET['search']);
	}else{
		redirect("index.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - rezultati pretrage</title>
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
					$resultArticles = $article->searchArticles($search);

					if(!empty($resultArticles)):					
				?>
					<section>
						<h2>Rezultati pretrage za: <i><?php echo $search; ?></i></h2>
						<?php foreach($resultArticles as $resultArticle): ?>
							<div class="article">
								<a href="clanak.php?id=<?php echo $resultArticle['id']; ?>">
									<div class="img_container" style="background-image: url('images/articles/<?php echo $resultArticle['slika']; ?>');"></div>
								</a>
								<div class="title_container">
									<a href="clanak.php?id=<?php echo $resultArticle['id']; ?>"><h3><?php echo $resultArticle["naslov"]; ?></h3></a>
									<p><?php echo $resultArticle["kratki_sadrzaj"]; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</section>
				<?php else: ?>
					<section>
						<center><h2>Nema rezultata pretrage za pojam: <i><?php echo $search; ?></i></h2></center>				
					</section>
				<?php endif; ?>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script src="js/transition.js"></script>
	</body>
</html>