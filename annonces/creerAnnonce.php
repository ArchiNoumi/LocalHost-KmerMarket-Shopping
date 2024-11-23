<?php
	session_start();
	$_SESSION["index"]="false";
	$_SESSION["annonces"]="";
	$_SESSION["mesAnnonces"]="active";
	$_SESSION["compte"]="";
	$_SESSION["meteo"]="";
	
	require "../headerFooter/commonTopFilesNotIndex.php";

	require '../models/model.php';
	$regions = getRegions();				
	
	$typeAnnonces = getTypeAnnonces();
						
						
?>
<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Créer une annonce</title> <!-- Element spécifiwue -->
	
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/alert.css" />
	<link rel="stylesheet" href="../css/modifCreerAnnonce.css" />
	<link rel="stylesheet" href="../css/footer.css" />
	
	
	<script src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	
	<script type="text/javascript" src="../js/modifier_Creer_Annonce.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	
	
	
	
</head>
<body onload='chargerVillesCreerAnn();' >
					
		<?php include ("../headerFooter/header.php");?>		
		<br/>
		<div id="annonce">
		<h1>Création </h1>
		<div class="form-group ">
						<button class="btn btn-info" role="button"
													data-toggle="modal"
													data-target="#myModalAide">
													Aide : Offre ? Demande ?
											</button>
					</div>
			<form class="form-horizontal" method="POST" action="../models/creationAnnonce.php" enctype="multipart/form-data">
				
					<!-- Form Name -->
					<span id="conclusion">Hello</span>
					
					<!-- Multiple Radios (type d'annonce) -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="Type_Annonce">Type d'annonce* :</label>
					  <div class="col-md-4"> 
						<label class="radio-inline" for="Type_Annonce-0">
						  <input type="radio" name="Type_Annonce" id="offre" value="1" checked="checked">
						  offre
						</label> 
						<label class="radio-inline" for="Type_Annonce-1">
						  <input type="radio" name="Type_Annonce" id="demande" value="0">
						  demande
						</label>
					  </div>
					</div>

					<!-- Text input titre-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="titre_annonce">Titre de l'annonce* :</label>  
					  <div class="col-md-4">
					  <input id="titre_annonce" name="titre_annonce" type="text" placeholder="" 
					  class="form-control input-md"  onblur="verifTitreAnnonce(this); effacerValeur_Titre(this);"  onkeyup="afficheValeur_Titre(this);">
					
						<span id="taille_titre"></span>
						<span class="alert" id="alert_titre"></span>
					  </div>
					</div>

					<!-- Select Catégorie -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="categorie_annonce">Catégorie* :</label>
					  <div class="col-md-4">
						<select id="categorie_annonce" name="categorie_annonce" class="form-control">
						    <?php foreach ($typeAnnonces as $typeAnnonce): ?>
									<option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
						    <?php endforeach; ?>
						</select>
					  </div>
					</div>

					<!-- Textarea Détails-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="detail_annonce">Détails* :</label>
					  <div class="col-md-4">                     
						<textarea class="form-control" id="detail_annonce" name="detail_annonce" 
							onblur="verifTexteAnnonce(this); effacerValeur_Texte(this);" onkeyup="afficheValeur_Texte(this);" rows="6">...</textarea>
					
						<span id="taille_texte"></span>
						<span class="alert" id="alert_texte"></span>
					  </div>
					</div>

					<!-- Multiple Radios (inline) -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="radio_etre_contacte">Etre contacté par* :</label>
					  <div class="col-md-4"> 
						<label class="radio-inline" for="radio_etre_contacte-0">
						  <input type="radio" name="radio_etre_contacte" id="radio_etre_contacte-0" value="0" checked="checked">
						  Téléphone
						</label> 
						<label class="radio-inline" for="radio_etre_contacte-1">
						  <input type="radio" name="radio_etre_contacte" id="radio_etre_contacte-1" value="1">
						  Email
						</label>
					  </div>
					</div>

					<!-- Select Régions -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="Region">Région* :</label>
					  <div class="col-md-4">
						<select id="Region" name="Region" class="form-control" onchange='chargerVillesCreerAnn()'>
						  <?php foreach ($regions as $region): ?>
								
							<option value= "<?php echo $region['id_r'] ?>" > <?php echo $region['n_fr'] ?> </option>
							
							<?php endforeach; ?>
						</select>
					  </div>
					</div>

					<!-- Select Ville -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="Ville">Ville* :</label>
					  <div class="col-md-4">
						<select id="Ville" name="Ville" class="form-control" help="">
						  
						</select>
						<span class="help-block">choisir la ville la plus proche, si vous ne trouvez pas votre ville</span>
					  
					  </div>
					</div>

					<!-- PRIX-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="prix">Prix (F CFA)* :</label>  
					  <div class="col-md-4">
					  <input id="prix" name="prix" type="text" placeholder="ex.: 10 000" 
					  class="form-control input-md"  onkeyup="afficheValeur_Prix(this);" onblur="verifPrixAnnonce(this); effacerValeur_Prix(this)">
						
						<span id="taille_prix"></span>
						<span class="alert" id="alert_prix"></span>
					  </div>
					  
					</div>
					<!-- IMAGES -->
					<label>Augmentez vos chances avec des photo ;)</label>
					<div class="row form-group">
						
						<div class="divClas col-sm-4" id="iim1">
							<label>Photo principale (3 Mo max)</label>
							<br/>
							<img  id ="premier" src="#" alt="image principale" height="200" width="200"/>
							 <input class="inputClass" name="inputPic1" type="file" onchange="readURL(this)"
							 accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
										image/x-ms-bmp, image/PNG, image/JPEG, image/JPG, image/GIF, image/BMP" 
							 style="cursor: pointer;" id="imgInput1">
							
						</div>
						
						<div class="divClas col-sm-4" id="iim2">
							 <label>Photo 2 (3 Mo max)</label>
							 <br/>
							 <img id="deuxieme" src="#" alt="image 2" height="200" width="200"/>
							 <input class="inputClass" name="inputPic2" type="file" onchange="readURL(this)"
							 accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
										image/x-ms-bmp, image/PNG, image/JPEG, image/JPG, image/GIF, image/BMP" 
							 style="cursor: pointer;" id="imgInput2">
						</div>
						
						<div class="divClas col-sm-4" id="iim3">
							 <label>Photo 3 (3 Mo max)</label>
							 <br/>
							 <img id="troisieme" src="#" alt="image 3" height="200" width="200"/>
							 <input class="inputClass" name="inputPic3" type="file" onchange="readURL(this)"
							 accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
										image/x-ms-bmp, image/PNG, image/JPEG, image/JPG, image/GIF, image/BMP" 
							 style="cursor: pointer;" id="imgInput3">
						</div>
					
					</div>
					
					
					
					
					<!-- Button -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="envoyer_bouton"></label>
					  <div class="col-md-4">
					  <button type="submit" id="envoyer_bouton" name="envoyer_bouton" class="btn btn-success" >Enregistrer</button>
					    <a id="envoyer_bouton" href="mesAnnonces.php?pseu=<?php echo $userPseudo ?>" name="envoyer_bouton" class="btn btn-warning">Annuler</a>
						
					  </div>
					</div>
				
		</form>

		</div>
			<!-- Modal Information offre vs demande -->
											
				<div class="modal fade" id="myModalAide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">
							<img src="../img/questionMark.png" alt="question sur offre ou demande"/>
						</h4>
					  </div>
					  <div class="modal-body">
							<h1> ? Offre  ?!?</h1>
							<p>
								C'est la proposition de vente d'un bien, d'un service, 
								d'un matériel, d'un produit ou autre à un prix donné. 
								Ex : Je <strong>vends</strong> une voiture à 2 500 000 F CFA ..
							</p>
							
							<h1> ? Demande  ?!?</h1>
							<p>
								C'est la proposition d'achat d'un service, d'un bien, d'un matériel, 
								d'un produit ou autre à un prix donné. 
								Ex : Je <strong>veux acheter</strong> une mercédès à 2 500 000 F CFA, je <strong>recherche</strong> une voiture pickup pour transporter ma récolte de maïs de .. à .. au prix de 5 000 F CFA
							</p>
							
					  </div>
					  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
								
					  </div>
					</div>
				  </div>
				</div>
       
	 <?php include ("../headerFooter/footer.php");?>
		
   
</body>
</html>
