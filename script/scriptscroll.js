$(document).ready(function(dtweet,stweet,idtweet){ // Quand le document est complètement chargé
 
	var load = false; // aucun chargement de article n'est en cours
	var win = $(window);
	var doc = $(document);
 
	/* la fonction offset permet de récupérer la valeur X et Y d'un élément
	dans une page. Ici on récupère la position du dernier div qui 
	a pour classe : ".article" */
	var offset = $('.article:last').offset(); 
 
	$(window).scroll(function(){ // On surveille l'évènement scroll
 
		/* Si l'élément offset est en bas de scroll, si aucun chargement 
		n'est en cours, si le nombre de article affiché est supérieur 
		à 5 et si tout les articles ne sont pas affichés, alors on 
		lance la fonction. */
		
		if(doc.height() - win.height() <= win.scrollTop() + 200 )
		{
 
			// la valeur passe à vrai, on va charger
			load = true;
 
			//On récupère l'id du dernier article affiché
			var last_date = $('.article:last').attr('date');
 
 
			//On affiche un loader
			$('.loadmore').show();
			//On lance la fonction ajax
			$.ajax({
				url: 'script/ajax_index.php',
				type: 'get',
				data: 'last='+last_date,
				
				//Succès de la requête
				success: function(data) {
					if(data != '')
					{
						//On masque le loader
						$('.loadmore').fadeOut(500);
						/* On affiche le résultat après
						le dernier article */
						$('.article:last').after(data);
						/* On actualise la valeur offset
						du dernier article */
						offset = $('.article:last').offset();
						//On remet la valeur à faux car c'est fini
						load = false;
					}
				}
			});
		} 
	}); 
});

$(window).load(function() {
	$(".imageload").fadeOut("1000");
})