{include file="sidebar.tpl"}
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<ul class="list-group" id="projets">
					{if $projets|@count gt 0}
					{foreach from=$projets item=projet}
					<li class="list-group-item">
						<label>{$projet['Nom']}</label>
						<div class="material-switch pull-right">
							<button id="{$projet['NumProjet']}" class="glyphicon glyphicon-pencil" onclick="modifierProjet(this.id)" ></button>
						</div>
					</li>
					{/foreach}
					{else} 
					<script type="text/javascript">alert('Pas de projets a afficher');</script>
					{/if}
				</ul>
			</div>
		</div>
	</div>
	<input type="text" hidden id="WEB_ROOT" value="{$WEB_ROOT}">
	<input type="text" hidden id="ADMIN_DIR" value="{$ADMIN_DIR}">
	<div id="myModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Modification</h4>
				</div>
				<div class="modal-body">
					<p>Saisissez le nouveau libellé du projet :</p>
					<input type="text" id="nouveauLibelle" class="form-control" placeholder="Libellé" maxlength="64">
					<p class="text-warning"><small>64 caractères max.</small></p>
					<input type="text" name="bookId" hidden id="projetId" value=""/>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnValider" class="btn btn-primary">Confirmer</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				</div>
			</div>
		</div>
	</div>
</body>
{literal}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

	function modifierProjet(id) {
		var projetId = id;
		$(".modal-body #projetId").val( projetId ); 
		$("#myModal").modal('show');
	}

	$( "#btnValider" ).click(function() {

		var idProjet = $(".modal-body #projetId").val()
		var libelleProjet = $("#nouveauLibelle").val()

		if (/\S/.test(libelleProjet)) {
			var datas = new FormData();
			datas.append('idProjet', idProjet);
			datas.append('libelleProjet', libelleProjet);

			$.ajax({
				type: "POST",
				data:  datas,
				contentType: false,
				processData: false, 
				url: $("#WEB_ROOT").val() + $("#ADMIN_DIR").val() + "/updateLibelleProjet"
			})

			.done(function(data){
				alert(data + '\nRafraîchir pour voir les changements.');
				$('#myModal').modal('hide');
			})

			.fail(function(data){
				console.log(data);
			});
		} else {
			alert("Libelle non valide.")
		}
	});

</script>
{/literal}