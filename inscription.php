<?php
require_once("public/config.php");
if($_POST)
{
	if(empty($contenu))
	{
		$membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
		if($membre->num_rows > 0)
		{
			$contenu .= "<div class='erreur'>Pseudo indisponible. Veuillez en choisir un autre svp.</div>";
		}
		else
		{
			foreach($_POST as $indice => $valeur)
			{
				$_POST[$indice] = htmlEntities(addSlashes($valeur));
			}
			executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]')");
			$contenu .= "<div class='validation'>Vous êtes inscrit sur notre site. <a href=\"connexion.php\"><u>Cliquez ici pour vous connecter</u></a></div>";
		}
	}
}
?>
<?php require_once("layouts/header.php"); ?>
<?php echo $contenu; ?>
<div class="container">
<div class="row">
  <div class="col-lg-10 col-xl-9 mx-auto">
    <div class="card card-signin flex-row my-5">
      <div class="card-img-left d-none d-md-flex">
      </div>
      <div class="card-body">
        	<h5 class="card-title text-center">Inscription</h5>
					<form method="post" action="">
						<div class="form-label-group">
							<label for="nom">Identifiant</label><br>
	            <input name="pseudo" type="text" id="pseudo" class="form-control" placeholder="Pseudo" required autofocus>
	          </div>
						<div class="form-label-group">
							<label for="nom">Adresse mail</label><br>
	            <input name="email" type="email" id="email" class="form-control" placeholder="Adresse email" required>
	          </div>
						<div class="form-label-group">
							<label for="nom">Mot de passe</label><br>
	            <input name="mdp" type="password" id="mdp" class="form-control" placeholder="Mot de passe" required>
	          </div>
						<div class="form-row">
			        <div class="form-group col-md-6">
			    	  	<label for="date_start">Nom</label>
			    	  	<input class="form-control" type="text" id="nom" name="nom">
			        </div>
				    	<div class="form-group col-md-6">
			    	  	<label for="date_finish">Prenom</label>
			    	  	<input class="form-control" type="text" id="prenom" name="prenom">
			        </div>
			      </div>
						<div class="form-group">
						  <label for="sel1">Civilité</label>
							<div class="radio">
							  <label><input type="radio" name="civilite" value="m">Homme</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="civilite" value="f">Femme</label>
							</div>
						  </select>
						</div>
						<div class="form-row">
			        <div class="form-group col-md-6">
			    	  	<label for="date_start">Ville</label>
			    	  	<input name="ville" class="form-control" type="text" id="ville">
			        </div>
				    	<div class="form-group col-md-6">
			    	  	<label for="date_finish">Code Postal</label>
			    	  	<input name="code_postal" class="form-control" type="text" id="code_postal" name="prenom">
			        </div>
			      </div>
						<div class="form-label-group">
							<label for="nom">Adresse</label><br>
	            <input name="adresse" type="text" id="adresse" class="form-control" placeholder="Pseudo">
	          </div>
						<hr>
				    <button class="btn btn-primary" name="inscription" value="S'inscrire" type="submit">Inscription</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once("layouts/footer.php"); ?>
