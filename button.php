<div>
    <span onclick="javascript:tw_share('<?php echo urlencode($tranche['titre']); ?>', '<?php echo $tranche['bitly']; ?>')">
        <img class="anim_button" src="/images/twitter.png" alt="Partager sur Twitter" />
    </span>
    <span onclick="javascript:fb_share('<?php echo $tranche['bitly']; ?>')">
        <img class="anim_button" src="/images/facebook.png" alt="Partager sur Facebook" />
    </span>
</div>
<script type="text/javascript">
function fb_share(bitly) 
{
    var source = "https://www.facebook.com/sharer/sharer.php?u=" + bitly ; 
    var width = 450;
    var height = 400;
    var pos = centerPosition(width, height);
    window.open(source,'Partagez sur Facebook','menubar=no,scrollbars=no,top='+pos['top']+',left='+pos['left']+',resizable=yes,width='+width+',height='+height);
    return false;
}
function tw_share(titre, bitly) 
{
    var source = "http://twitter.com/home?status=" + titre + " : "+ bitly ; 
    var width = 850;
    var height = 450;
    var pos = centerPosition(width, height);
    window.open(source,'Partagez sur twitter','menubar=no,scrollbars=no,top='+pos['top']+',left='+pos['left']+',resizable=yes,width='+width+',height='+height);
    return false;
}
</script>