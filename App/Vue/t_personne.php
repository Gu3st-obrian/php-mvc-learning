<?php foreach ($personnes as $personne) : ?>
	
	<div class="row">
		<div class="col-md-12" id="Personne">
			<div class="col-md-12">
				<?php var_dump($personne); ?>
			</div>
			<div class="col-md-2">
				<a href="<?=$response->pathFor('personne.edition') . '&id=' . $personne->id ;?> ">
					<button type="button" class="btn btn-warning">Edition</button>
				</a>
			</div>
			<div class="col-md-2">
				<a href="<?=$response->pathFor('personne.supprimer') . '&id=' . $personne->id ;?> ">
					<button type="button" class="btn btn-danger">Supprimer</button>
				</a>
			</div>
		</div>
	</div><br>

<?php endforeach; ?>