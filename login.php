<html>
<div class='login-block' style="margin-right:0px">
    <?php 
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();	
		}
		if(!isset($_SESSION['active']))
		{
			$_SESSION['active']= 0;
		}
		if (isset($_POST['deco']))
		{
			disconnect();
		}
		else
		{
			if ($_SESSION['active'] != 1)
			{
				if (isset($_POST['id']))
				{
					$connexionDb = connecteDb();
					$mdp = $_POST['mdp'];
					$idPseudo = $_POST['id'];
					if(verifmdp($mdp,$idPseudo,$connexionDb))
					{
						connection($mdp,$idPseudo,$connexionDb);
					}
					else
					{
						echo "Aucune correspondance entre <br/>l'identifiant et le mot de passe";
					}
					closeDb($connexionDb);						
				}
				else
				{
					echo "
						<form method='post'>
							<input id='username' type='text' name='id' placeholder='Pseudonyme'/><br />
							<input id='password' type='password' name='mdp' placeholder='Mot de passe'/><br />
							<input class='login' name='login' type='submit' value='Connexion'/>
						</form>";
				}
			}
			if ($_SESSION['active'] == 1)
			{
				echo"<div class='pseudo'>Bonjour, ".$_SESSION['pseudo']." !</div>";
				echo"
						<a href=\"/index.php\"><input  type=\"button\" name=\"index \" class='login' value=\"Index\"/></a>
						<a href=\"/domaine.php\"><input  type=\"button\" name=\"flux \" class='login' value=\"Gestion des Flux\"/></a>
						<a href=\"/update.php\"><input  type=\"button\" name=\"update \" class='login' value=\"Update\"/></a>
						<form method='post'>
							<input class='login' name='deco' type='submit' value='deconnexion'/>
						</form>";
			}
		}
	?>
</div>
</html>