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
							<button class="glyphicon glyphicon-pencil"></button>
							<button class="glyphicon glyphicon-remove"></button>
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
</body>