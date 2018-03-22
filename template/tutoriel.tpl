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
			<div class="col-md-8">
				<div class="list-group" id="medias">
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

		{/literal}
		var WEB_ROOT = '{$WEB_ROOT}';
		var ADMIN_DIR = '{$ADMIN_DIR}'
		{literal}

		var url = WEB_ROOT + ADMIN_DIR + '/getSuivant';
		var pathname = window.location.pathname; // Returns path only
		var pos_dernier_slash = pathname.lastIndexOf("/");
		var numFonctionnalite = pathname.substring(pos_dernier_slash + 1, pathname.length);

		var propositions_choix = [];


		//CLIC SUR UN CHOIX
		$(document).on('click', "button[id^='choix-']", function(e){


			var objet_courant = $(this);
			var numTuto = $(this)[0].name;
			var numChoix = $(this)[0].id;
			var numChoixFormate = numChoix.substring(6, numChoix.length);


			$.ajax({
				type: "POST",
				data:  {'numId' : numChoixFormate, 'numTuto' : numTuto, 'estUnChoix' : true}, 
				dataType: "JSON",
				url: url

			})
			.done(function(data){
				// Suppression des eléments suivants 
				objet_courant.nextAll().remove();

				$.each(data, function(index, value){
					propositions_choix[index] = value['NumEtape']; 

					if (index == 0)
						$libelleChoix = "Non"
					else
						$libelleChoix = "Oui"
					
					$("#etapes").append("<button id=\"etape-" + value['NumEtape'] + "\" name = " + value['NumTutoriel'] + " type=\"button\" class=\"list-group-item\"> <strong> " + $libelleChoix + " - </strong>" + value[1] + " </button>");

				});
			})

			.fail(function(data){
				$("#test").html(data.responseText);
			});
		}); // clic on "choix-" object

		//CLIC SUR UNE ETAPE
		$(document).on('click', "button[id^='etape-']", function(e){

			var numTuto = $(this)[0].name;
			var numChoix = $(this)[0].id;	
			var numChoixFormate = numChoix.substring(6, numChoix.length);


			//suppression de l'étape qui n'est pas choisie.
			cacherEtapeNonChoisie(numChoixFormate);

			enleverInteractionEtapes();

			//appel AJAX pour récupérer la suite des étapes
			$.ajax({
				type: "POST",
				data:  {'numId' : numChoixFormate, 'numTuto' : numTuto, 'estUnChoix' : false, 'numFonctionnalite' : numFonctionnalite}, 
				dataType: "JSON",
				url: url

			})
			
			.done(function(data){
				//$("#test").html(data);
				var un_choix = false
				$.each(data, function(index, value){

					if (value['NumEtape'] !== undefined)
						$("#etapes").append("<button id= " + value['NumEtape'] + " name = " + value['NumTutoriel'] + " type=\"button\" class=\"list-group-item\"> " + value[1] + " </button>");

					else
					{
						un_choix = true;
						$("#etapes").append("<button id=\"choix-" + value['NumChoix'] + "\" name = " + value['NumTutoriel'] + " type=\"button\" class=\"list-group-item\"> " + value[1] + " </button>");
					}
				});
				if (un_choix == false)
				{
					$("#etapes").append("<button type=\"button\" class=\"list-group-item\"> Fin du tutoriel.</button>");
				}
			})

			.fail(function(data){
				$("#test").html(data.responseText);
			});

		}); // click on "etape-" object


		function enleverInteractionEtapes(){

			$.each(propositions_choix, function(index,value){

				$('#etape-' + value).prop('id', value);

			});
		} 

		function cacherEtapeNonChoisie(numChoixFormate){
			$.each(propositions_choix, function(index,value){

				if (value != numChoixFormate)
					$('#etape-' + value).hide();
			});
		}

		$('button.list-group-item').click(function() {
			var id = this.id;
			$.ajax({
				type: "POST",
				data:  'id=' + id,
				url: WEB_ROOT + '/getMedia'
			}).done(function(data){
				$('#medias').html(data);
				console.log(data);
			})
		})
	}); // ajax
</script>
{/literal}