$(document).ready(function(dtweet,stweet,idtweet){ // Quand le document est compl�tement charg�
 
	var load = false; // aucun chargement de article n'est en cours
	var win = $(window);
	var doc = $(document);
 
	/* la fonction offset permet de r�cup�rer la valeur X et Y d'un �l�ment
	dans une page. Ici on r�cup�re la position du dernier div qui 
	a pour classe : ".article" */
	var offset = $('.article:last').offset(); 
 
	$(window).scroll(function(){ // On surveille l'�v�nement scroll
 
		/* Si l'�l�ment offset est en bas de scroll, si aucun chargement 
		n'est en cours, si le nombre de article affich� est sup�rieur 
		� 5 et si tout les articles ne sont pas affich�s, alors on 
		lance la fonction. */
		
		if(doc.height() - win.height() <= win.scrollTop() + 200 )
		{
 
			// la valeur passe � vrai, on va charger
			load = true;
 
			//On r�cup�re l'id du dernier article affich�
			var last_date = $('.article:last').attr('date');
 
 
			//On affiche un loader
			$('.loadmore').show();
			//On lance la fonction ajax
			$.ajax({
				url: 'script/ajax_index.php',
				type: 'get',
				data: 'last='+last_date,
				
				//Succ�s de la requ�te
				success: function(data) {
					if(data != '')
					{
						//On masque le loader
						$('.loadmore').fadeOut(500);
						/* On affiche le r�sultat apr�s
						le dernier article */
						$('.article:last').after(data);
						/* On actualise la valeur offset
						du dernier article */
						offset = $('.article:last').offset();
						//On remet la valeur � faux car c'est fini
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