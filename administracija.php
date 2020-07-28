<?php
	include 'core/init.php';

	if($user->is_loggedin()){
		if(!$user_data["admin"]){
			redirect("prijava.php");
		}
	}else{
		redirect("prijava.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Newsweek - administracija</title>
		<meta charset="utf-8">
		<link rel="shortcut icon" href="images/icons/newsweek-logo.png" type="image/png">
		<link rel="stylesheet" type="text/css" href="css/min/administracija.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/footer.min.css">
		<link rel="stylesheet" type="text/css" href="css/includes/min/header.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="container">
			<?php include 'includes/header.php'; ?>
			<main>
				<div id="hideAll"></div>
				<h1>Administracija članaka</h1>

				<?php
					$articles = $article->fetchAllArticles();

					if(!empty($articles)){
						echo '<table>';
						echo '
							<tr>
								<th>Slika</th>
								<th>Naslov</th>
								<th>Kategorija</th>
								<th>Datum objave</th>
								<th>Autor</th>
								<th></th>
							</tr>
						';

						foreach($articles as $art){
							if($art["arhiva"]){
								$arhiva = '<li class="live" data-role="from_archive"><img src="images/icons/wfcew.png" alt="" title="Vrati iz arhive"><span>Vrati iz arhive</span></li>';
								$style = 'class="archived"';
							}else{
								$arhiva = '<li class="live" data-role="in_archive"><img src="images/icons/wfcew.png" alt="" title="Arhiviraj članak"><span>Arhiviraj članak</span></li>';
								$style = "";
							}

							echo '
								<tr data-id="'.$art["id"].'"'.$style.'>
									<td><a href="clanak.php?id='.$art["id"].'"><img src="images/articles/'.$art["slika"].'" alt=""></a></td>
									<td><h3><a href="clanak.php?id='.$art["id"].'">'.$art["naslov"].'</a></h3></td>
									<td>'.$art["kategorija"].'</td>
									<td>'.format_datum($art["datum_objave"]).'</td>
									<td>'.$article->getAuthor($art["autor"]).'</td>
									<td>
										<ul>
											<li><a href="uredi.php?id='.$art["id"].'"><img src="images/icons/edit.png" alt="" title="Uredi članak">Uredi članak</a></li>
											'.$arhiva.'
											<li class="live" data-role="delete"><img src="images/icons/trash1600.png" alt="" title="Obriši članak">Obriši članak</li>
										</ul>
									</td>							
								</tr>
							';
						}

						echo '</table>';
					}else{
						echo '<center><h2>Trenutno nema članaka za prikazati.</h2></center>';
					}
				?>
			</main>
			<?php include 'includes/footer.php'; ?>
		</div>
		<script>
			$(document).on("click", ".live", function(){
				var live = $(this);
				var role = $(this).data("role");
				var tr = $(this).parent().parent().parent();
				var id = tr.data("id");

				$.ajax({
					type: "POST",
			        url: "process/article_process.php",
			        data: { role: role, id: id },
			        success: function(response){
			        	if(response == "success"){
			        		if(role == "in_archive"){
			        			live.find("span").html("Vrati iz arhive");
			        			live.data("role", "from_archive");
			        			tr.addClass("archived");
			        		}else if(role == "from_archive"){
			        			live.find("span").html("Arhiviraj članak");
			        			live.data("role", "in_archive");
			        			tr.removeClass("archived");
			        		}else if(role == "delete"){
			        			tr.fadeOut("fast");
			        		}
			        	}
			        }
				});
			});
		</script>
		<script src="js/transition.js"></script>
	</body>
</html>