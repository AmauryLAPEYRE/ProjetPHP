<!Doctype html>
<html>
    <head>
        <title>Boutique</title>
        <link rel="stylesheet" href="public/css/style.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
        <body>
  				<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
              <a class="navbar-brand" href="boutique.php">Shop</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
      					<?php
      					if(isConnectedAsAdmin()) // admin
      					{ ?>
                  <li class="nav-item">
                    <a class="nav-link" href="gestion_membre.php">Gestion Membres</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="gestion_commande.php">Gestion Commandes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="gestion_boutique.php?action=affichage">Gestion Boutique</a>
                  </li>
                <?php }
      					if(isConnected()) // membres et admin
      					{ ?>
                  <li class="nav-item">
      						  <a class="nav-link" href="boutique.php">Boutique</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="panier.php">Panier</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="profil.php">Profil</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="connexion.php?action=deconnexion">Deconnexion</a>
                  </li>
      					<?php }
      					else // visiteurs
      					{ ?>
                  <li class="nav-item">
                    <a class="nav-link" href="boutique.php">Accueil</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="inscription.php">Inscription</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="connexion.php">Connexion</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="boutique.php">Boutique</a>
                  </li>
                  <li class="nav-item">
      						  <a class="nav-link" href="panier.php">Panier</a>
                  </li>
      					<?php } ?>
                </ul>
              </div>
            </div>
  				</nav>
