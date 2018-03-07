{include file="header.tpl"}	
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form id ="importForm" action="{WEB_ROOT}uploadXML" method="post" enctype="multipart/form-data">
					<div class="form-group" id="fonctionnalites">
						<select class="form-control" id="selectFonct" name="selectFonct" required>
							{if $fonctionnalites|@count gt 0}
							{foreach from=$fonctionnalites item=fonct}
							<option id="{$fonct['NumFonctionnalite']}" name="test">{$fonct['Nom']}</option>
							{/foreach}
							{else}
							<option disabled>Pas de fonctionnalités disponibles</option>
							{/if}
						</select>
						<input type="text" id="inputTitre" name="inputTitre" placeholder="Titre du tutoriel" class="form-control" aria-describedby="basic-addon1" required>
						<input type="text" id="inputDescription" name="inputDescription" placeholder="Description du tutoriel" class="form-control" aria-describedby="basic-addon1" required>
						<input type="file" id="uploadXML" name="uploadXML" required>
						<button type="submit" class="btn btn-default" id="btnValider">Valider</button>
					</div>
				</form>
				<p id="msgResultat"></p>
			</div>
		</div>
	</div>
</body>
{literal}
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script type="text/javascript">

	 $(function() {
	
		$('#importForm').submit(function(e){
			e.preventDefault();

			var action = $(this).attr('action');

			var selectId = $(this).find('option:selected').attr("id");
			var inputTitre = $("#inputTitre").val();
			var inputDescription = $("#inputDescription").val();
			var uploadXML = $("#uploadXML")[0].files[0];

			var datas = new FormData();
			datas.append('selectFonct', selectId);
			datas.append('inputTitre', inputTitre);
			datas.append('inputDescription', inputDescription);
			datas.append('uploadXML', uploadXML);


			$.ajax({
				type: "POST",
				data:  datas,
				contentType: false,
				processData: false, 
				url: action
			})

			.done(function(data){
				$("#msgResultat").html(data);
			})

			.fail(function(data){
				$("#msgResultat").html(data.responseText);
			});

		});

	 });



</script>
{/literal}