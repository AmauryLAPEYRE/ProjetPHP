<?php

require_once("public/config.php");
if(!isConnectedAsAdmin())
{
	header("location:connexion.php");
	exit();
}
if(isset($_GET['msg']) && $_GET['msg'] == "supok")
{
	executeRequete("delete from membre where id_membre=$_GET[id_membre]");
	header("Location:gestion_membre.php");
}

require_once("layouts/header.php");
	$resultat = executeRequete("SELECT * FROM membre"); ?>
	<div class='container'>
		<div class='table-wrapper'>
			<div class='table-title'>
			<div class='row'>
				<div class='col-sm-8'>
					<h2>Membres <b>inscrit actuellement : <?php echo $resultat->num_rows?></b></h2>
				</div>
			</div>
			</div>
			<table class='table table-bordered'>
				<thead>
				<tr>
				<?php while($colonne = $resultat->fetch_field())
				{ ?>
					<th><?php echo $colonne->name?></th>
				<?php } ?>
				</tr>
				</thead>
				<tbody>
				<?php while ($membre = $resultat->fetch_assoc())
				{ ?>
					<tr>
					<?php foreach ($membre as $information)
					{ ?>
						<td><?php echo $information?></td>
					<?php } ?>
						<td>
						<?php echo "<a href='gestion_membre.php?msg=supok&&id_membre=" . $membre['id_membre'] . "' onclick='return(confirm(\"Etes-vous sûr de vouloir supprimer ce membre?\"));'><i class='material-icons'></i></a>"; ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
				</table>
		</div>
	</div>
