<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" dir="ltr" lang="fr">
	<head>
		<?php
			require_once("fonction/fonction.php");
		?>
	</head>
	<body>
		<?php
			$connexionDb = connecteDb();
			if(articleExist("4930739","www.lemonde.fr",$connexionDb))
			{
				echo "ok";
			}
			else
			{
				echo "nop";
			}
			closeDb($connexionDb);
		?>
	</body>
</html>