<html>
	<head>
		<title>login page</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<script type="text/javascript" src="/script/jquery.js"></script>
		<script type="text/javascript" src="/script/scriptscroll.js"></script>
		<script type="text/javascript" src="/script/modernizr-custom.js"></script>
		<script type="text/javascript" src="/script/classie.js"></script>
		<script type="text/javascript" src="/script/main.js"></script>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="/style/style.css" />  
		<link rel="stylesheet" type="text/css" href="/style/demo.css" />
		<link rel="stylesheet" type="text/css" href="/style/component.css" />
		<title>Page de login</title>
		<?php
			require_once("fonction/fonction.php");
		?>
	</head>
	<body>
		<?php
			include("login.php");
			include("navbar.php");
		?>
		<div class="cont_article">
			<?php
				$connexionDb = connecteDb();
				affichage($connexionDb);
				closeDb($connexionDb);
			?>
		</div>
	</body>
</html>