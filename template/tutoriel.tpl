{include file="header.tpl"}
<!-- {$etapes|@var_dump} -->
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="etapes">
					{if $etapes|@count gt 0}
						{foreach from=$etapes item=etape}
							{if 'NumEtape'|array_key_exists:$etape}
								<button id="{$etape['NumEtape']}" name ="{$tutoriel}" type="button" class="list-group-item">{$etape['Description']}</button>
							{else}
								<button id="choix-{$etape['NumChoix']}" name ="{$tutoriel}" type="button" class="list-group-item">{$etape['Libelle']}</button>
							{/if}
						{/foreach}
					{else}
						<button id="" type="button" class="list-group-item"><i>Pas d'étapes pour ce tutoriel</i></button>
					{/if}
					<p id="test"> </p>
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

{literal}
<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>

<script type="text/javascript">

	$(function() {

		$('[id^=choix-').click(function(){

	
			//var url = $(this).URL;
			//var slash = url.lastIndexOf('/');
			//var debutUrl = url.substring(0, slash);

			var numTuto = $(this)[0].name;


			var numChoix = $(this)[0].id;
			var str = numChoix.substring(6, numChoix.length);


			$.ajax({
				type: "POST",
				data:  {'numChoix' : numChoix, 'numTuto' : numTuto}, 
				url: "{_ADMIN_DIR_}" + '/getSuivant'
			})
			.done(function(data){
				$("#test").html(data);
				
			})
			.fail(function(data){
				$("#test").html(data.responseText);
			});
		})
	});



</script>
{/literal}