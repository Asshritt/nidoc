{include file="sidebar.tpl"}
<body>
	<div class="container">
		<div class="row">
			<div class="row">
				<ul class="list-group">
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading">Affecter les fonctionnalités :</div>

						<!-- Table -->
						<table class="table" id="table">
							{$table}
						</table>
					</div>
				</ul>
			</div>
		</div>
		<button type="button" id="btnValider" class="btn btn-primary">Confirmer</button>
	</div>
</body>

{literal}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">


	$( "#btnValider" ).click(function() {

		{/literal}
		var WEB_ROOT = '{$WEB_ROOT}';
		var ADMIN_DIR = '{$ADMIN_DIR}'
		{literal}

		var check = new Object();
		var i=0;
		// Parcours de chaque case du tableau
		$('#table td input').each(function () {
			//console.log(this);
			// Création d'un objet contenant les informations de la case
			var o = new Object(); 
			o.module = $('#'+this.id).data('idmodule');
			o.fonctionnalite = $('#'+this.id).data('idfonctionnalite');
			o.checked = this.checked ? true : false;
			check[i] = o;
			i++;
		});
		//console.log(check);
		// Transformation en JSON
		check = JSON.stringify(check);

		// Appel Ajax
		$.ajax({
			type: "POST",
			data: "check=" + check,
			url: WEB_ROOT + ADMIN_DIR + "/updateFonctionnaliteModule"
		})

		.done(function(data){
			alert(data);
		})

		.fail(function(data){
		});


	});

</script>
{/literal}