<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Class Personne - L3AL</title>
	<link rel="stylesheet" type="text/css" href="<?=$_SESSION['radical'].'app/Vue/css/bootstrap.css'; ?>"/>
	<style type="text/css">
	header {
		margin-bottom: 20px;
		padding: 20px;
		vertical-align: 20px;
		background-color: black;
	}

	#Personne {
		border: 1px solid black;
	}
	#gestion_personne {
		color: white;
	}
	</style>
</head>
<body>
	<div class="container">
		<header class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-6 col-xs-12"><h4 id="gestion_personne">Gestion de la classe Personne</h4></div>
					<div class="col-lg-6 col-xs-12">
						<nav class="row">
							<div class="col-lg-2 col-xs-4 pull-right">
								<a href="<?=$response->pathFor('personne.nouveau'); ?>">
									<button type="button" class="btn btn-info">Nouveau</button>
								</a>
							</div>
							<div class="col-lg-2 col-xs-4 pull-right">
								<a href="<?=$response->pathFor('personne.liste'); ?>">
									<button type="button" class="btn btn-success">Liste</button>
								</a>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</header>
		<?=$content; ?>
	</div>
</body>
</html>
