<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Labo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">
						<h1>Laboratoire de recherches</h1>
					</div>
				</div>
				<div class="col-md-12">
					<?php


$xml = simplexml_load_file(__DIR__ . '/publier_chaque_variation.xml');
$xml->registerXPathNamespace("UML", "omg.org/UML1.3");


echo "<h2>Activités</h2>";
echo "<ul>";
$actionStateList = $xml->xpath("//UML:ActionState");
foreach ($actionStateList as $actionState) {

	/* @var $actionState SimpleXMLElement */
	//Hydrator::hydrate("Activite", (string)$actionState->attributes()["xmi.id"], (string)$actionState->attributes()["name"]);
	echo "<li>".(string)$actionState->attributes()["name"]."</li>";
}
echo "</ul>";
echo "<h2>Décisions/Début/Fin</h2>";
echo "<ul>";
$pseudoStateList = $xml->xpath("//UML:PseudoState");
foreach ($pseudoStateList as $pseudoState) {
	/* @var $pseudoState SimpleXMLElement */
	echo "<li>".(string)$pseudoState->attributes()["name"]."</li>";
}
echo "</ul>";
echo "<h2>Liens</h2>";
echo "<ul>";
$transitionList = $xml->xpath("//UML:Transition");
foreach ($transitionList as $transition) {
	/* @var $transition SimpleXMLElement */
	echo "<li>Depuis " . (string) $transition->attributes()["source"] . " vers " . (string) $transition->attributes()["target"] . "</li>";
}
echo "</ul>";

					?>
				</div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>
