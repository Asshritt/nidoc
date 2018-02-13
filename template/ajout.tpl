{include file="header.tpl"}	
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form action="{WEB_ROOT}uploadXML" method="post" enctype="multipart/form-data">
					<div class="form-group" id="fonctionnalites">
						<select class="form-control" id="selectFonct" name="selectFonct" required>
							{if $fonctionnalites|@count gt 0}
							{foreach from=$fonctionnalites item=fonct}
							<option id="{$fonct['NumFonctionnalite']}">{$fonct['Nom']}</option>
							{/foreach}
							{else}
							<option disabled selected>Pas de fonctionnalités disponibles</option>
							{/if}
						</select>
						<input type="text" id="inputTitre" name="inputTitre" placeholder="Titre du tutoriel" class="form-control" aria-describedby="basic-addon1" required>
						<input type="text" id="inputDescription" name="inputDescription" placeholder="Description du tutoriel" class="form-control" aria-describedby="basic-addon1" required>
						<input type="file" id="uploadXML" name="uploadXML" required>
						<button type="submit" class="btn btn-default" id="btnValider">Valider</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>