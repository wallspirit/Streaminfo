<div class="dock">
    <div class ="docknormal">
        <center><button aria-label="Open Menu" class="action action--open"><span class="icon icon--menu"></span></button></center>
    </div>
    <a href="/index.php">
        <div class ="dockred">
            <center><img class="icondock" src="/images/house-outline.png" alt="home"></center>
        </div>
    </a>
    <?php
    if(isset($_GET['guid']))
    {
        $sql=requete("SELECT *
                            FROM flux, domaine
                            WHERE domaine.nom = flux.domaine
                            and nom='".$_GET['domaine']."'
                            and guid='".$_GET['guid']."'
                            ORDER BY DATE DESC"
                            , $connexionDb);
        $articles = aideaffichage($sql, "true");    
        if(!empty($articles))
        {
            foreach($articles as $article)
            {
    ?>
                
                <span onclick="javascript:fb_share('<?php echo $article['bitly']; ?>')">
                    <div class ="dockblue">
                        <center><img class="icondock" src="/images/facebook-logo.png" alt="facebook"></center><br/>
                    </div>
                </span>
                
                <span onclick="javascript:tw_share('<?php echo urlencode($article['titre']); ?>', '<?php echo $article['bitly']; ?>')">
                    <div class ="dockblanc">
                        <center><img class="icondock" src="/images/twitter-logo-silhouette.png" alt="twitter"></center>
                    </div>
                </span>
    <?php
            }
        }
    }
    else
    {
    ?>
        <span onclick="javascript:fb_share('http://streaminfo.franceserv.com/')">
            <div class ="dockblue">
                <center><img class="icondock" src="/images/facebook-logo.png" alt="facebook"></center><br/>*
            </div>
        </span>
        
        <span onclick="javascript:tw_share('site d\'information indépendant', 'http://streaminfo.franceserv.com/')">
            <div class ="dockblanc">
                <center><img class="icondock" src="/images/twitter-logo-silhouette.png" alt="twitter"></center>
            </div>
        </span>
    <?php
    }
    ?>
</div>
<style type="text/css">
div.dock
{
    position: fixed;
    float: bottom;
    bottom: 0;
    width: 100vh;
    height: 48px;
    background: #1C1D22;
}
div.docknormal
{
    padding: 4px;
    position: fixed;
    left: 0;
    width: 25vh;
    height: 100%;
    background: #1C1D22;
}
div.dockred
{
    padding: 4px;
    position: fixed;
    left: 25vh;
    width: 25vh;
    height: 100%;
    background: #7f8c8d;
}
div.dockblue
{
    padding: 4px;
    position: fixed;
    left: 50%;
    width: 25vh;
    height: 100%;
    background: #3B5998;
}
div.dockblanc
{
    padding: 4px;
    position: fixed;
    left: 75%;
    width: 25vh;
    height: 100%;
    background: #00ABF1;
}
img.icondock
{
    width: 40px;
}
</style>