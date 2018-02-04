<?php
	require_once (__DIR__ . "/bitly.php");
	//---------------------------------------------------------------------------------------------------------------------------)
	//-----------------------------Affiche le flux rss, $connectDb = la base de données ou on se connecte----)
	function affichage($connectDb)
	{
		$sql=requete("SELECT *
								FROM flux, domaine
								WHERE domaine.nom = flux.domaine
								AND actif = 1
								ORDER BY DATE DESC
								LIMIT 15"
								, $connectDb);
		aideaffichage($sql, "true");
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function reaffichage($last, $connectDb)
	{
		$sql=requete("SELECT *
								FROM flux, domaine
								WHERE domaine.nom = flux.domaine
								AND actif = 1
								AND date < \"".$last."\"
								ORDER BY DATE DESC
								LIMIT 15"
							, $connectDb);
		return aideaffichage($sql, "true");
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function triaffichage($connexionDb)
	{
		if(isset($_GET['domaine']))
		{
			if(isset($_GET['guid']))
			{
				$sql=requete("SELECT *
									FROM flux, domaine
									WHERE domaine.nom = flux.domaine
									and nom='".$_GET['domaine']."'
									and guid='".$_GET['guid']."'
									ORDER BY DATE DESC"
									, $connexionDb);
				aideaffichage($sql, "true");
			}
			else
			{
				$sql=requete("SELECT *
									FROM flux, domaine
									WHERE domaine.nom = flux.domaine
									and nom='".$_GET['domaine']."'
									ORDER BY DATE DESC
									LIMIT 15"
									, $connexionDb);
				aideaffichage($sql, "true");	
			}
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function aideaffichage($sql, $redirection)
	{
		$i=0;
		while($tranche=mysqli_fetch_array($sql, MYSQLI_ASSOC))
		{
			$articles[$i++] = $tranche;
			echo "<div id='".$tranche['nom']."/".$tranche['guid']."' class=\"article\" date='".$tranche['date']."'>";
			if ($redirection == "true")
			{
				echo '<h2>
							<a href="/domaine/'.$tranche['nom'].'/'.$tranche['guid'].'">'.$tranche['titre'].'</a>
						</h2>
						<br/>'.$tranche['description'].'
						<br/><a href="'.$tranche['lien'].'">lire l\'article</a> 
						<br/>Dans la <a href="/domaine/'.$tranche['nom'].'"> 
						<div class="soulignement">catégorie</div> </a>' 
						.$tranche['nom'].' le ('.$tranche['date'].')<br/><br/>';
				include(__DIR__ . "/../button.php");
			}
			else
			{
				echo '<h2>
							<a href="'.$tranche['lien'].'">'.$tranche['titre'].'</a>
						</h2><br/>'.$tranche['description'].'
						<br/><a href="'.$tranche['lien'].'">lire l\'article</a>
						<br/>Dans la <a href="/domaine/'.$tranche['nom'].'"> 
						<div class="soulignement">catégorie</div> </a>'
						.$tranche['nom'].' le ('.$tranche['date'].')<br/><br/>';
			}
			echo "</div>";
		}
		return $articles;
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function updateallbase($connexionDb)
	{
		$query=requete("SELECT * FROM domaine", $connexionDb);
		while ($tranche=mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			enregistrement($tranche['domaine'], $tranche['nom'], $connexionDb);
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function articleExist($guid,$domaine,$connexionDb)
	{
		$result = requete('SELECT count(*) as article_exists FROM flux WHERE guid="' . $guid . '" AND domaine="'.$domaine.'"',$connexionDb);
		$req = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if ($req['article_exists'] >= 1) 
		{ 
			return true;
		} 
		else
		{
			return false;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function urlvalide($url)
	{
		if (filter_var($url, FILTER_VALIDATE_URL)) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function enregistrement($url, $domaine, $connexionDb)
	{
		$rss = simplexml_load_file($url);
		foreach ($rss->channel->item as $item)
		{
			$guid = preg_replace('/[^0-9]/','',$item->guid);
			if(articleExist($guid,$domaine,$connexionDb))
			{
				echo "existe deja";
			}
			else
			{
				$datetime = date_create($item->pubDate);
				$date = date_format($datetime, 'Y-m-d H:h:i');
				tweetupdate($domaine,$guid,$item->title,$connexionDb);
				$url = urlencode($item->link);
				echo $url;
				echo $item->link;
				var_dump(shortURL($url));
				$requete = "INSERT INTO flux VALUES('".$guid."','".$domaine."','".str_replace("'","\'","$item->title")."','".$item->link."','".str_replace("'","\'","$item->description")."','".shortURL($url)."','".$date."');";
				requete($requete, $connexionDb);
			}
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function tweetupdate($domaine,$guid,$title,$connexionDb)
	{
		\Codebird\Codebird::setConsumerKey("********************", "****************************");
		$cb = \Codebird\Codebird::getInstance();
		$cb->setToken("*****************-*******************", "**************************");
		$status= substr($title, 0, 110).'  http://fluxarticle.fr/domaine/'.$domaine.'/'.$guid.'';
		$params = array( 'status' => $status);
		// $reply = $cb->statuses_update($params);
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function addDomaine($table, $nom, $domaine, $database)
	{
		requete("INSERT INTO $table VALUES('".$nom."','".$domaine."','1');", $database);
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function requete($requete, $database)
	{
		return mysqli_query($database, $requete);
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function connecteDb()
	{
		return new mysqli('**********.****.**', '***********', '**********', '**********');
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function closeDb($database)
	{
		mysqli_close($database);
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function verifadmin()
	{
		if ($_SESSION['role'] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function connection($mdp,$idPseudo,$connexionDb)
	{
		$sql=requete("SELECT * FROM user WHERE pseudo='".$idPseudo."'", $connexionDb);
		if($tranche=mysqli_fetch_array($sql, MYSQLI_ASSOC))
		{
			$_SESSION['active'] = 1;
			$_SESSION['pseudo'] = $tranche['pseudo'];
			$_SESSION['role'] = $tranche['admin'];
			return true;
		}
		else
		{
			return false;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function verifmdp($mdp,$idPseudo,$connexionDb)
	{
		$mdp = hash('sha256', $mdp);
		$sql=requete("SELECT * FROM user WHERE pseudo='".$idPseudo."'", $connexionDb);
		if($tranche=mysqli_fetch_array($sql, MYSQLI_ASSOC))
		{
			$mdpverif = $tranche['mdp'];
			if($mdp == $mdpverif)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function disconnect()
	{
		$_SESSION['active'] = 0;
		unset($_SESSION['pseudo']);
		unset($_SESSION['role']);
		header('Location: /index.php');
		return true;
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function isConnected()
	{
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();	
		}
		if(!isset($_SESSION['active']))
		{
			$_SESSION['active']= 0;
		}
		if ($_SESSION['active'] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
	function shortURL($url)
	{
		if(!defined("ACCESS_TOKEN"))
			define("ACCESS_TOKEN", "*****************");
		
		$jsonURL = file_get_contents("https://api-ssl.bitly.com/v3/shorten?access_token=".ACCESS_TOKEN."&longUrl=".$url."&format=json");
		$jsonURL = json_decode($jsonURL);
		
		return $jsonURL->data->url;
	}
	//---------------------------------------------------------------------------------------------------------------------------)
	//---------------------------------------------------------------------------------------------------------------------------)
?>