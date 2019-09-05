<?php
require_once("public/config.php");
if(!isConnectedAsAdmin())
{
	header("location:connexion.php");
	exit();
}
require_once("layouts/header.php"); ?>
<div class="container">
	<div class='table-wrapper'>
		<div class='table-title'>
			<div class='row'>
				<div class='col-sm-8'>
					<h2>Commandes passées</h2>
				</div>
			</div>
		</div>
		<table class='table table-bordered'>
		<?php $information_sur_les_commandes = executeRequete("select c.*, m.pseudo, m.adresse, m.ville, m.code_postal from commande c left join membre m on  m.id_membre = c.id_membre");?>
		<p>Nombre de commande(s) : <?php echo $information_sur_les_commandes->num_rows ?>
			<thead>
				<tr>
					<?php while($colonne = $information_sur_les_commandes->fetch_field())
					{ ?>
						<th><?php echo $colonne->name ?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php $chiffre_affaire = 0;
				while ($commande = $information_sur_les_commandes->fetch_assoc())
				{
					$chiffre_affaire += $commande['montant']; ?>
						<tr>
							<td><a href="gestion_commande.php?suivi='<?php $commande['id_commande']?>'">Voir la commande <?php $commande['id_commande'] ?></a></td>
							<td><?php echo $commande['id_membre'] ?></td>
							<td><?php echo $commande['montant']?></td>
							<td><?php echo $commande['date_enregistrement'] ?></td>
							<td><?php echo $commande['etat'] ?></td>
							<td><?php echo $commande['pseudo'] ?></td>
							<td><?php echo $commande['adresse'] ?></td>
							<td><?php echo $commande['ville'] ?></td>
							<td><?php echo $commande['code_postal'] ?></td>
						</tr>
				<?php } ?>
			</tbody>
		</table>
		<h5>Montant total des revenus : <?php echo $chiffre_affaire ?> €</h5>
	</div>
</div>

	<?php if(isset($_GET['suivi']))
	{ ?>
		<div class="container">
			<div class='table-wrapper'>
				<div class='table-title'>
					<div class='row'>
						<div class='col-sm-8'>
							<h2>Détail de la commande</h2>
						</div>
					</div>
				</div>
				<table class='table table-bordered'>
					<?php $information_sur_une_commande = executeRequete("select * from details_commande where id_commande=$_GET[suivi]");
					$nbcol = $information_sur_une_commande->field_count; ?>
					<thead>
						<tr>
							<?php for ($i=0; $i < $nbcol; $i++)
							{
								$colonne = $information_sur_une_commande->fetch_field(); ?>
									<th><?php echo $colonne->name ?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php while ($details_commande = $information_sur_une_commande->fetch_assoc())
						{ ?>
							<tr>
								<td><?php echo $details_commande['id_details_commande']?></td>
								<td><?php echo $details_commande['id_commande'] ?></td>
								<td><?php echo $details_commande['id_produit'] ?></td>
								<td><?php echo $details_commande['quantite'] ?></td>
								<td><?php echo $details_commande['prix'] ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
	<?php } ?>
		</div>
	</div>
