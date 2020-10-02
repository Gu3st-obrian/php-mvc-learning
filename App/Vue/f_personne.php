<div class="row">
	<form class="form-horizontal col-lg-6" method="post" action="<?=($action == 'Modifier') ? $response->pathFor('personne.modifier') : $response->pathFor('personne.save'); ?>">
            <div class="form-group">
                <legend>
                    <?=($action == 'Modifier') ? 'Modifier cette personne' : 'Ajouter une personne'; ?>
                </legend>
                <input type="hidden" name="id" value="<?=($action == 'Modifier') ? $personne->id : '' ; ?>">
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="nom" class="col-lg-2">Nom : </label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="nom" name="nom" value="<?=($action == 'Modifier') ? $personne->last_name : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="prenom" class="col-lg-2">Prénom : </label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?=($action == 'Modifier') ? $personne->first_name : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="select" class="col-lg-2">Sexe : </label>
                    <div class="col-lg-10">
                        <select class="form-control" name="sexe">
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                            <option value="A">Autre</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="age" class="col-lg-2">Age : </label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="age" name="age" value="<?=($action == 'Modifier') ? $personne->age : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="pull-right btn btn-primary"><?=$action; ?></button>
            </div>
        </form>
</div>