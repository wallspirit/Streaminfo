<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" dir="ltr" lang="fr">
	<?php
		include("header.php");
		ini_set("display_errors",0);
		error_reporting(0);
		include("login.php");
		verifadmin();
		include("navbar.php");
		$connexionDb = connecteDb();
		if (isset($_POST['Nom'])) 
		{
			if (empty($_POST['Nom'])) 
			{
				unset($_POST['Nom']);
			}
			else
			{
				addDomaine("domaine", $_POST['Nom'], $_POST['Domaine'], $connexionDb);
			}
		}
		if(isset($_POST['modification']))
		{
			$compteur = 0;
			$sql=requete("SELECT * FROM domaine", $connexionDb);
				while($tranche=mysqli_fetch_array($sql, MYSQLI_ASSOC))
				{
					$compteur = $compteur + 1;
					libxml_use_internal_errors(true);
					$rss = simplexml_load_file($_POST['domaine'.$compteur.'']);
					if($rss)
					{
						if(urlvalide($_POST['domaine'.$compteur.'']))
						{
							if(isset($_POST['actif'.$compteur.'']))
							{
								$valueactif = 1;
							}
							else
							{
								$valueactif = 0;
							}
							$requete = "UPDATE domaine SET nom='".$_POST['nom'.$compteur.'']."', domaine='".$_POST['domaine'.$compteur.'']."', actif='".$valueactif."' WHERE nom='".$tranche['nom']."';";
							requete($requete, $connexionDb);
						}					
						else
						{
							echo "<div class=\"erreurflux\">";
							echo "L'url indiquée pour ".$_POST['nom'.$compteur.'']." n'est pas valide!<br/>";
							echo "</div>";
						}
					}
					else
					{
						echo "<div class=\"erreurflux\">";
						echo "L'url indiquée pour ".$_POST['nom'.$compteur.'']." n'est pas valide!<br/>";
						echo "</div>";
					}
					libxml_clear_errors();
				}
		}
		?>
		<body>
			<div class="modifflux">
				<?php
					$compteur = 0;
					echo "<form method=\"post\">";
					echo "<input type=\"hidden\" name=\"modification\" value=\"modification\"><br/>";
					$sql=requete("SELECT * FROM domaine", $connexionDb);
					while($tranche=mysqli_fetch_array($sql, MYSQLI_ASSOC))
					{
						$compteur = $compteur + 1;
						echo "".$tranche['nom']." :<br/>";
						echo "Nom du site: <input type=\"text\" value=\"".$tranche['nom']."\" name=\"nom".$compteur."\"/><br/>";
						echo "Flux du site: <input type=\"text\" value=\"".$tranche['domaine']."\" name=\"domaine".$compteur."\"/><br/>";
						if($tranche['actif'] == 1)
						{
							echo "Actif: <input type=\"checkbox\" name=\"actif".$compteur."\" value=\"actif\" checked><br/>";
						}
						else
						{
							echo "Actif: <input type=\"checkbox\" name=\"actif".$compteur."\" value=\"actif\"><br/>";
							
						}
						echo "<hr>";
					}
					echo "<input  class='login' type='submit' value='enregister'/><br/>";
					echo "</form>";
				?>
			</div>
			<div class="flux">
				<form method="post">
						Nom du site: <input type="text" name="Nom" /><br/>
						Lien du flux: <input type="text" name="Domaine" /><br/><br/>
					<input  class='login' type="submit" value="valider"/><br/>
				</form>
			</div>
		</body>
		<?php
		closeDb($connexionDb);
	?>
</html>
	