<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" dir="ltr" lang="fr">
	<head>
		<?php
			require_once('/codebird-php-develop/src/codebird.php');
		?>
	</head>
	<body>
		<?php
			include("header.php");
			include("login.php");
			verifadmin();
			include("navbar.php");
		?>
		<div class="cont_article">
		<?php
			$connexionDb = connecteDb();
			updateallbase($connexionDb);
			closeDb($connexionDb);
		?>
		</div>
	</body>
</html>
	