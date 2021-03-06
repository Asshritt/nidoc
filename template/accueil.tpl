{include file="header.tpl"}
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
					<label>Projets disponibles :</label>
					{if $projets|@count gt 0}
					{foreach from=$projets item=projet}
					<button id="{$projet['NumProjet']}" type="button" class="list-group-item">{$projet['Nom']}</button>
					{/foreach}
					{else}
					<button id="" type="button" class="list-group-item"><i>Pas de projets</i></button>
					{/if}
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="modules">
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="fonctionnalites">
				</div>
			</div>
		</div>
	</div>
</body>

{literal}
<script type="text/javascript">
	// Appel Ajax pour recuperer les modules apres selection d'un projet
	$('#projets>button').click(function() {
		$.ajax({
			url : 'data',
			type : 'POST',
			data : 'projet=' + this.id,
			dataType : 'json',
			success : function(html, statut){
				// Vider les liste des modules et fonctionnalites au cas ou changement d'avis
				$('#modules').empty();
				$('#fonctionnalites').empty();
				// Ajout du "titre"
				$('#modules').append('<label>Modules disponibles :</label>');
				// Ajout des modules dans le tableau
				for (var i = 0; i < html.length; i++) {
					$('#modules').append('<button id="' + html[i]['NumModule'] + '" type="button" class="list-group-item" onClick="getData(' + html[i]['NumModule'] + ');">' + html[i]['Nom'] + '</button>');
				}
			},
			error : function(resultat, statut, erreur){
				console.log(erreur);
			}
		});
	});
	function getData(id) {
	// Appel Ajax pour recuperer les fonctionnalites apres selection d'un module
		$.ajax({
			url : 'data',
			type : 'POST',
			data : 'module=' + id,
			dataType : 'json',
			success : function(html, statut){
				// Vider la liste des fonctionnalites au cas ou changement d'avis
				$('#fonctionnalites').empty();
				// Ajout du "titre"
				$('#fonctionnalites').append('<label>Fonctionnalités disponibles :</label>');
				// Ajout des fonctionnalites dans le tableau
				for (var i = 0; i < html.length; i++) {
					$('#fonctionnalites').append('<a href="fonctionnalite/' + html[i]['NumFonctionnalite'] + '"><button id="' + html[i]['NumFonctionnalite'] + '" type="button" class="list-group-item">' + html[i]['Nom'] + '</button></a>');
				}
			},
			error : function(resultat, statut, erreur){
				console.log(erreur);
			}
		});
	};
		/* NE MARCHE PAS DEMANDER
		$('#modules>button').click(function() {
			alert(this.id);
		});
		*/
	</script>
	{/literal}