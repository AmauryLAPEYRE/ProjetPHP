<?php
require_once("public/config.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(isset($_GET['action']) && $_GET['action'] == "deconnexion")
{
	session_destroy();
}
if(isConnected())
{
	header("location:profil.php");
}
if($_POST)
{
    $resultat = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
    if($resultat->num_rows != 0)
    {
        $membre = $resultat->fetch_assoc();
        if($membre['mdp'] == $_POST['mdp'])
        {
            foreach($membre as $indice => $element)
            {
                if($indice != 'mdp')
                {
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header("location:profil.php");
        }
        else
        {
            $contenu .= '<div class="erreur">Mot de passe incorrect</div>';
        }
    }
    else
    {
        $contenu .= '<div class="erreur">Identifiant incorrect</div>';
    }
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
?>
<?php require_once("layouts/header.php"); ?>
<?php echo $contenu; ?>

<form method="post" action="">
    <label for="pseudo">Identifiant</label><br />
    <input type="text" id="pseudo" name="pseudo" /><br /> <br />
    <label for="mdp">Mot de passe</label><br />
    <input type="text" id="mdp" name="mdp" /><br /><br />
    <input type="submit" value="Se connecter"/>
</form>

<?php require_once("layouts/footer.php"); ?>
