<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<body>
		<?php
			include("header.php");
			if (isConnected())
			{
				include("login.php");
			}
			echo "<div class=\"menu_gauche\">";
			include("navbar.php");
			echo "</div>";
		?>
		<div class="cont_article">
			<?php
				$connexionDb = connecteDb();
				affichage($connexionDb);
				closeDb($connexionDb);
			?>
		</div>
		<div class="hautpage">
			<a href="index.php"><input type="button" name="hautpage" class='login' value="Haut de Page"/></a>
		</div>
	</body>
</html>