
<?php
	require_once(__DIR__ . "/../fonction/fonction.php");
	
	if(isset($_GET['last']))
	{
		$last = $_GET['last'];
		$connexionDb = connecteDb();
		$articles = reaffichage($last, $connexionDb);
		closeDb($connexionDb);
		
		var_dump($articles);
		
	}
	else
	{
		?>
		
		
		<div>
			<label>Tous les articles ont étés chargés.</label>
		</div>
		
		<?php
	}
?>