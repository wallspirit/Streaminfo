<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<body>
		<?php
			include("header.php");
			if (isConnected())
			{
				include("login.php");
			}
			include("navbar.php");
		?>
		<div class="cont_article">
			<?php
				$connexionDb = connecteDb();
				triaffichage($connexionDb);
				closeDb($connexionDb);
			?>
			<div class="precedent">	
				<?php
					echo "<img class=\"arrowleft\" src=\"/images/arrows-left.png\" alt=\"Precedent\">Précédent ";
				?>
			</div>
			<div class="suivant">	
				<?php
					echo "Suivant <img class=\"arrowright\" src=\"/images/arrows-right.png\" alt=\"Suivant\">";
				?>
			</div>
		</div>
	</body>
</html>
	