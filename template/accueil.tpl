{include file="header.tpl"}
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
					{if $projets}
						{foreach from=$projets item=foo}
						<button id="{$foo['NumProjet']}" type="button" class="list-group-item" onClick="loadModules({$foo['NumProjet']})">{$foo['Nom']}</button>
						{/foreach}
					{else}
						<button type="button" class="list-group-item" disabled="true"><i>Pas de projets...</i></button>
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

	{literal}
	<script type="text/javascript">
		function loadModules(id) {
			$('#projets>button').removeClass('active'); 
			$('#projets>#' + id).addClass('active');
			$('#modules').empty();
			$('#fonctionnalites').empty();

			// Appel AJAX Modules selon idProjet
			$.ajax({
				url : 'data',
				type : 'POST',
				data : 'projet=' + id,
				dataType : 'json',
				success : function(html, statut){
					console.log(html);
					for(i = 0; i < html.length; i++) {
						$('#modules').append("<button id='" + html[i]['NumModule'] + "' type='button' class='list-group-item' onClick='loadFonctionnalites(" + html[i]['NumModule'] + ")'>" + html[i]['Nom'] + "</button>");
					}
				},
				error : function(resultat, statut, erreur){
					console.log(resultat);
					console.log(statut);
					console.log(erreur);
					$('#modules').append("<button type='button' class='list-group-item' disabled='true'><i>Pas de modules...</i></button>");
				}
			});
		}

		function loadFonctionnalites(id) {
			$('#modules>button').removeClass('active'); 
			$('#modules>#' + id).addClass('active');
			$('#fonctionnalites').empty();

			// Appel AJAX Fonctionnalites selon idModule
			$.ajax({
				url : 'data',
				type : 'POST',
				data : 'module=' + id,
				dataType : 'json',
				success : function(html, statut){
					console.log(html);
					for(i = 0; i < html.length; i++) {
						console.log(html[i]);
						$('#fonctionnalites').append("<button id='" + html[i]['NumFonctionnalite'] + "' type='button' class='list-group-item' href='fonctionnalite/" + html[i]['NumFonctionnalite'] + "'>" + html[i]['Nom'] + "</button>");
					}
				},
				error : function(resultat, statut, erreur){
					console.log(resultat);
					console.log(statut);
					console.log(erreur);
					$('#fonctionnalites').append("<button type='button' class='list-group-item' disabled='true'><i>Pas de fonctionnalités...</i></button>");
				}
			});
		}
	</script>
	{/literal}



</body>