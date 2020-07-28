<header>
	<div id="header">
		<div id="mob_menu"><img src="images/icons/menu.png" alt=""></div>
		<span id="date"><?php echo date("D, M d, Y"); ?></span>
		<?php if($user->is_loggedin()): ?>
			<span id="logout"><a href="logout.php">Odjavi se</a></span>
		<?php endif; ?>
		<a href="index.php"><img src="images/logo/newsweek-logo.png" title="Newsweek" alt="Newsweek"></a>
		<?php if($user->is_loggedin()): ?>
			<div id="loggedin">
				<ul>
					<li>Dobrodošao, <span><?php echo $user_data['username']; ?></span> !</li>
					<li><a href="unos.php">Kreiraj članak</a></li>
				</ul>
			</div>
		<?php else: ?>
			<span id="signin">
				<a href="prijava.php">Prijava</a> | <a href="registracija.php">Registracija</a>
			</span>
		<?php endif; ?>
	</div>
	<nav>
		<ul>
			<li>
				<a href="clanci.php?cat=Hrvatska" <?php if(isset($cat) && $cat == "Hrvatska") echo 'class="selected"'; ?>>Hrvatska</a>
			</li>
			<li>
				<a href="clanci.php?cat=Svijet" <?php if(isset($cat) && $cat == "Svijet") echo 'class="selected"'; ?>>Svijet</a>
			</li>
			<li>
				<a href="clanci.php?cat=Sport" <?php if(isset($cat) && $cat == "Sport") echo 'class="selected"'; ?>>Sport</a>
			</li>
			<li>
				<a href="clanci.php?cat=Kultura" <?php if(isset($cat) && $cat == "Kultura") echo 'class="selected"'; ?>>Kultura</a>
			</li>
			<li>
				<a href="clanci.php?cat=Znanost" <?php if(isset($cat) && $cat == "Znanost") echo 'class="selected"'; ?>>Znanost</a>
			</li>
			<?php
				if($user->is_loggedin() && $user_data["admin"]){
					echo '
						<li class="foradmin">
							<a href="administracija.php">Administracija</a>
						</li>
					';
				}
			?>
			<?php if($user->is_loggedin()): ?>
				<li id="logout_nav">
					<a href="logout.php">Odjavi se</a>
				</li>
			<?php endif; ?>
			<li class="searchli">
				<form action="rezultati.php" method="get">
					<img src="images/icons/fvergvedvbgeb.png" alt="">
					<input type="text" name="search" placeholder="Pretraži Newsweek..." autocomplete="off">
				</form>
			</li>
		</ul>
	</nav>
</header>
<script>
	$(document).on("click", "#mob_menu", function(){
		$("nav").toggle();
	});
</script>