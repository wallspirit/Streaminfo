<header class="bp-header cf">
    <div class="dummy-logo">
		<div class="dummy-icon foodicon foodicon--coconut"></div>
        <h2 class="dummy-heading">
            Flux Article
        </h2>
    </div>
</header><button aria-label="Open Menu" class="action action--open"><span class="icon icon--menu"></span></button>
<nav class="menu" id="ml-menu">
    <button aria-label="Close Menu" class="action action--close"><span class="icon icon--cross"></span></button>
    <div class="menu__wrap">
        <ul class="menu__level" data-menu="main">
            <li class="menu__item2">
                <a class="menu__link" href="/index.php">Accueil</a>
            </li>
            <li class="menu__item">
                <a class="menu__link" data-submenu="submenu-1" href="">Voir les catégories</a>
            </li>
        </ul><!-- Submenu 1 -->
        <ul class="menu__level" data-menu="submenu-1">
            <?php
                $compteur = 1;
                $connexionDb = connecteDb();
                $query=requete("SELECT * FROM domaine WHERE actif=1", $connexionDb);
                while ($tranche=mysqli_fetch_array($query, MYSQLI_ASSOC))
                {
                    echo "<li class=\"menu__item\"><a class=\"menu__link\" data-submenu=\"submenu-1-".$compteur."\" href=\"\">".$tranche['nom']."</a></li>";
                    $compteur = $compteur + 1;
                }
            ?>
        </ul>
        <?php
        $compteur = 1;
        $query=requete("SELECT * FROM domaine WHERE actif=1", $connexionDb);
        while ($tranche=mysqli_fetch_array($query, MYSQLI_ASSOC))
        {
                echo '<ul data-menu="submenu-1-'.$compteur.'" class="menu__level">';
                echo '<li class="menu__item2"><a class="menu__link" href="http://fluxarticle.fr/domaine/'.$tranche['nom'].'">tous les articles</a></li>';
                $query2=requete("SELECT * FROM flux WHERE domaine='".$tranche['nom']."' ORDER BY date DESC limit 6", $connexionDb);
                while ($tranche2=mysqli_fetch_array($query2, MYSQLI_ASSOC))
                {
                    echo "<li class=\"menu__item2\"><a class=\"menu__link\" href=\"http://fluxarticle.fr/domaine/".$tranche2['domaine']."/".$tranche2['guid']."\">".substr($tranche2['titre'], 0, 60)."</a></li>";
                }
                $compteur = $compteur + 1;
                echo '</ul>';
        }
        ?>
        <div id="footer">
            <label>Developed by el Polak #M. Mielvac<br>
            Designed by le chinois #A. Nguyen</label>
        </div>
    </div>
</nav>
<script src="/script/module.js" type="text/javascript"></script>