<?php 
				session_start();
				
				//session_cache_limiter('none');
				$_SESSION["index"]="false";
				$_SESSION["annonces"]="";
				$_SESSION["mesAnnonces"]="active";
				$_SESSION["compte"]="";
				$_SESSION["meteo"]="";
				require "../headerFooter/commonTopFilesNotIndex.php";
				require_once '../models/model.php';
					
						$theLinkToRedirect = '../comptes/connection.php';
						$titleButtonAnnonce = 'Nvel Annonce/Inscription';
						$typeAnnonces = getTypeAnnonces();
						$pseudo = $_SESSION['pseudonyme'];
						

						$idM = getIdMembreByPseudo($pseudo);
						//echo 'Identifiant du membre = '.$idM;
						$Manou = 0;
						if($idM == 94)
						{
							$Manou = 1;
						}							
						
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Mes Annonces</title> <!-- Element spécifiwue -->
	
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/index.css" type="text/css" />
	<link rel="stylesheet" href="../css/mesAnnonces.css" type="text/css" />
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	<link rel="stylesheet" href="../css/index.css" type="text/css" />
	
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	 <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/mesAnnonces.js"></script>

	
</head>
<body onload="requestMesAnnonces('<?php echo($pseudo) ?>'); chargerPagesMesAnnonces('<?php echo($pseudo) ?>')">
					<!-- A rajouter juste dans le onload !! chargerAnnoncesChargementPage()-->
		
		<?php 
		include ("../headerFooter/header.php");
		?>
		<br/>
	<div class="rowd">	<!-- form-horizontal col-xs-12 col-md-2 id="menu_gauche" -->
		<div class="form-inline" style="background-color: rgba(255,255,255,0.1); text-align: center; width: 80%; margin-left: 10%; padding-bottom: 10px;">
					
					<h1 style="Color: green; font-weight: bolder">Rechercher</h1>
				
				
					<!-- Multiple Radios (inline) -->
					<div class="form-group" >
					  <label class="col-md-6 control-label" for="Type_Annonce">Type :</label>
						<br>
					  <div class="col-md-8"> 
						<label class="radio-inline" for="Type_Annonce-0">
						  <input type="radio" name="Type_Annonce" id="offre" value="1" checked="checked" onchange="requestMesAnnonces('<?php echo($pseudo) ?>')">
						  Offres
						</label> 
						<label class="radio-inline" for="Type_Annonce-1" >
						  <input type="radio" name="Type_Annonce" id="demande" value="0" onchange="requestMesAnnonces('<?php echo($pseudo) ?>')">
						  Demandes
						</label>
					  </div>
					</div>
					
					
					
					<!-- Select Basic of Etat-->
					<div class="form-group">
					  <label class="control-label" for="Etat">Etat :</label><br/>
					  <div class="col-md-12">
						<select id="Etat" name="Etat" class="form-control" onchange="requestMesAnnonces('<?php echo($pseudo) ?>')" >
							<option value="en_cours">En cours</option>
							<option value="vendues">Vendues</option>
							<option value="supprimees">Supprimées</option>
							<!-- Pas pour le moment <option value="masquees">Masquées</option>	-->		
						</select>
					  </div>
					</div>

					<!-- Select Basic Classer par -->
					<div class="form-group">
					  <label class="control-label" for="classe_par">Classer par :</label><br/>
					  <div class="col-md-12">
						<select id="classe_par" name="classe_par" class="form-control" onchange="requestMesAnnonces('<?php echo($pseudo) ?>')" >
							<option value="recentes_anciennes">Récentes aux anciennes</option>
							<option value="anciennes_recentes">Anciennes aux récentes</option>
							<option value="prix_decroissants">Prix décroissants</option>
							<option value="prix_croissants">Prix croissants</option>
							<option value="villes_croissants">Villes ordre alphabétique</option>
							<option value="villes_decroissants">Villes ordre alphabétique inversé</option>
							<option value="titres_croissants">Titres ordre alphabétique</option>
							<option value="titres_decroissants">Titres ordre alphabétique inversé</option>	
						</select>
					  </div>
					</div>

					<!-- Select Basic Categorie -->
					<div class="form-group">
					  <label class="control-label" for="Categorie_annonce">Catégorie :</label><br/>
					  <div class="col-md-12">
						<select id="Categorie_annonce" name="Categorie_annonce" class="form-control" onchange="requestMesAnnonces('<?php echo($pseudo) ?>')">
						  <?php foreach ($typeAnnonces as $typeAnnonce): ?>
									<option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
							<?php endforeach; ?>
						</select>
					  </div>
					</div>

		
				
		</div>
		
		<div class="col-xs-12 " id="menu_centre">
			<!-- Liste de résultats col-md-12-->
			
			
					<!-- Le Template de base -->
			<div id="super_annonce">
			  <!-- Chargé dynamiquement :) -->
			  
				<h2 class="row" style="font-weight:bold">
					<!--span id="total" class=" btn btn-default col-sm-2"></span-->
					<!-- Ajout de la pagination :) cool -->
					
					<div class="col-sm-2">
							<div class="input-group recrer" >
								    <span class="input-group-btn">
										<button class="btn btn-warning" type="button">
											Pages :
										</button>
									
								    </span>
									
									<select id="Pages" name="Pages" class="form-control" onchange="requestByNumberPage('<?php echo($pseudo) ?>')" >
							
								
										
									</select>
									 
								
									
							</div>
						</div>
					<form class="form-horizontal col-sm-4 ">
				
						
							<div class="input-group">
							  <input id="recherche_titre" type="text" class="form-control" placeholder="Entrez le titre recherché">
							  <span class="input-group-btn ">
								<button class="btn btn-success" type="button" onclick="requestMesAnnonces('<?php echo($pseudo) ?>')">
									<span class="glyphicon glyphicon-search"> </span>
								</button>
							  </span>
							</div><!-- /input-group -->
						
					</form> 
					
					<?php 
					if($Manou == 1) 
						echo '<a id= "crerAnn" href="../ks/index.php" class="btn btn-warning col-sm-2 " role="button">MULTIPLES ANNONCES</a>'; 
					?>
					<?php 
					
					 if($pseudo !='')
					 {
						//You need to connect before you create an annonce
						$theLinkToRedirect = 'creerAnnonce.php?pseu='.$pseudo;
						$titleButtonAnnonce = 'Nouvelle Annonce';
					 }
					 
					?>
					<a id= "crerAnn" href="<?php echo($theLinkToRedirect)?>" class="btn btn-primary <?php 
					if($Manou == 0){ echo 'col-sm-offset-2'; }else{ echo 'col-sm-offset-1';}?> col-sm-2" role="button"><?php echo($titleButtonAnnonce)?></a> 
				</h2>
				<p id="titre_tableau">
					
				</p>
				<table class="table table-hover" data-toggle="table"  data-url="data1.json" data-cache="true" data-height="70">
					 <thead>
						  <tr>
								<th>N°</th>
								<th>Titre</th>
								<th>Description</th>
								<th>Prix (F CFA)</th>
								<th>Catégorie</th>
								<th>Région</th>
								<th>Ville</th>
								<th>Nombre de photo</th>
								<th>Date de création</th>
								
								<!-- Supprimer et modifier sont dans détails -->
						  </tr>
					 </thead>
					 <tbody id="dynamique">
					 
					 </tbody>
				</table>
			</div>
			<div class="row" id="super_pagination">
				<?php //echo paginate('mesAnnonces.php', '?p=', $nbPages, $current); ?>
			</div>
			<!--When loading the data-->
			<span id="loader" style="display: none;">
					<img src="../img/loader.GIF"  alt="loading" />
			</span><!--loader.gif-->
			
		</div>
	
	</div>
	
      <?php include ("../headerFooter/footer.php");?>
		
	
	
</body>
</html>
