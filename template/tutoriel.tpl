{include file="header.tpl"}
{$debut|@var_dump}
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="etapes">
					{if $debut|@count gt 0}
					{foreach from=$debut item=etape}
					{if $etape['Description'] == "Début"}
					{/if}
					<button id="{$etape['NumEtape']}" type="button" class="list-group-item">{$etape['Description']}</button>
					{/foreach}
					{else}
					<button id="" type="button" class="list-group-item"><i>Pas d'étapes pour ce tutoriel</i></button>
					{/if}
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="medias">
					<button type="button" class="list-group-item" disabled="true"><i>Afficher les médias </i></button>
				</div>
			</div>
		</div>
	</div>
</body>