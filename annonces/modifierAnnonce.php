<?php

	session_start();

	$_SESSION["index"]="false";
	$_SESSION["annonces"]="";
	$_SESSION["mesAnnonces"]="active";
	$_SESSION["compte"]="";
	$_SESSION["meteo"]="";
	require "../headerFooter/commonTopFilesNotIndex.php";
	require '../models/model.php';	
	
	$offresChargementPage = getAnnoncePage($_GET['ann']);
	
	$id_ann = $_GET['ann'];
	$pseudoUser = $_GET['pseu'];
	$typeAnnonces = getTypeAnnonces();
	
	$type_annonce_par_id_Annonce = get_TypeAnnonce_par_IdAnnonce($id_ann);
	
	$regions = getRegions();
	$villes = getToutesLesVilles();

	
	$photos = getPhotoByIdAnnonce($id_ann);
	//echo ($photos->rowCount());
	$var = 1;
	$pic1 = null; $pic2 = null; $pic3 = null;
	echo ($pic1);
	foreach($photos as $photo)
	{
		if($photo['filDesc'] == "1")
		{
			$pic1 = $photo;
			
		}
		if($photo['filDesc'] == "2")
		{
			$pic2 = $photo;
		}
		if($photo['filDesc'] == "3")
		{
			$pic3 = $photo;
		}
	}
	

?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>sirus.kmermarket - Modifier mon annonce</title> <!-- Element spécifiwue -->
	
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/alert.css" />
	<link rel="stylesheet" href="../css/modifCreerAnnonce.css" />
	<link rel="stylesheet" href="../css/footer.css" />
	
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	
	<script type="text/javascript" src="../js/modifier_Creer_Annonce.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	
	
	
</head>
<body >
			<?php include ("../headerFooter/header.php");?>		
		
		
		<br/>
		<div id="annonce">
		<h1>Modification </h1>
		<?php foreach ($offresChargementPage as $offre): ?>
		<form class="form-horizontal ajaxModif" method="post" action="../models/modifierAnnonce.php?ann=<?php echo $id_ann?>" enctype="multipart/form-data">
				
			
					<!-- Form Name -->
					<span id="conclusion">Hello</span>

					<!-- OFFRE OU DEMANDE (inline) DONE-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="Type_Annonce">Type d'annonce* :</label>
					  <div class="col-md-4"> 
						<label class="radio-inline" for="Type_Annonce-0">
						  <input type="radio" name="Type_Annonce" id="radios_type_annonce-0" value="1" 
								<?php if($offre['e_offre']==1){?> 
											checked="checked"
											<?php 
										}?>
							>
						  offre
						</label> 
						<label class="radio-inline" for="Type_Annonce-1">
						  <input type="radio" name="Type_Annonce" id="radios_type_annonce-1" value="0"
						  <?php if($offre['e_offre']==0)
										{?> 
											checked="checked"
											<?php 
										}?>
						  
						  >
						  demande
						</label>
					  </div>
					</div>

					<!-- Titre annonce DONE -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="titre_annonce">Titre de l'annonce* :</label>  
					  <div class="col-md-4">
					  <input id="titre_annonce" name="titre_annonce" type="text" 
					  placeholder="" class="form-control input-md" 
					  onblur="verifTitreAnnonce(this); effacerValeur_Titre(this);"  
					  onkeyup="afficheValeur_Titre(this);"
							value="<?php echo $offre['ti_a'] ?>"/>
								
						<span id="taille_titre"></span>
						<span class="alert" id="alert_titre"></span>
					  </div>
					</div>

					<!-- CATEGORIE ANNONCE DONE -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="categorie_annonce">Catégorie* :</label>
					  <div class="col-md-4">
						<select id="categorie_annonce" name="categorie_annonce" class="form-control">
						 <?php foreach ($typeAnnonces as $typeAnnonce): ?>
									<option value= "<?php echo $typeAnnonce['id_t'] ?>" 
										<?php if($typeAnnonce['id_t'] == $type_annonce_par_id_Annonce['id_typ'] ) {?>
											selected
										<?php }?>
										
										> 
										<?php echo  $typeAnnonce['n_fr'] ?> 
									</option>
						   <?php endforeach; ?>
						</select>
					  </div>
					</div>

					<!-- TEXTE ANNONCE DONE-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="detail_annonce">Détails* :</label>
					  <div class="col-md-4">                     
						<textarea 
							class="form-control" id="detail_annonce" 
							name="detail_annonce"	
							onblur="verifTexteAnnonce(this); effacerValeur_Texte(this);"
							onkeyup="afficheValeur_Texte(this);" 
							rows="6"
						><?php echo trim($offre['te_a'])?></textarea>
						 
						<span id="taille_texte"></span>
						<span class="alert" id="alert_texte"></span>
					  </div>
					</div>

					<!-- ETRE CONTACTE PAR (DONE) -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="radio_etre_contacte">Etre contacté par* :</label>
					  <div class="col-md-4"> 
						<label class="radio-inline" for="radio_etre_contacte-0">
						  <input type="radio" name="radio_etre_contacte" id="radio_etre_contacte-0" value="0" 
						  <?php if($offre['par_email']==0)
										{?> 
											checked="checked"
											<?php 
										}?>
							>
						  Téléphone
						</label> 
						<label class="radio-inline" for="radio_etre_contacte-1">
						  <input type="radio" name="radio_etre_contacte" id="radio_etre_contacte-1" value="1"
						    <?php if($offre['par_email']==1)
										{?> 
											checked="checked"
											<?php 
										}?>
							>
						  Email
						</label>
					  </div>
					</div>

					<!-- REGIONS  DONE -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="Region">Région* :</label>
					  <div class="col-md-4">
						<select id="Region" name="Region" class="form-control" onchange='chargerVilles()'>
						  <?php foreach ($regions as $region): ?>
								
							<option value= "<?php echo $region['id_r'] ?>"
								<?php if($region['id_r'] == $offre['id_r_r'] ) {?>
											selected
										<?php }?>
							> <?php echo $region['n_fr'] ?> </option>
							
							<?php endforeach; ?>
						</select>
					  </div>
					</div>

					<!-- VILLE DONE -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="Ville" >Ville* :</label>
					  <div class="col-md-4">
						<select id="Ville" name="Ville" class="form-control">
							<?php foreach ($villes as $ville): ?>
								
							<option value= "<?php echo $ville['id_v'] ?>"
								<?php if($ville['id_v'] == $offre['id_v_v'] ) {?>
											selected
										<?php }?>
							> <?php echo $ville['n_fr'] ?> </option>
							
							<?php endforeach; ?>
							
						</select>
					  </div>
					</div>

					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="prix">Prix (F CFA)* :</label>  
					  <div class="col-md-4">
					  <input id="prix" name="prix" type="text" placeholder="7 000" class="form-control input-md"
					  onkeyup="afficheValeur_Prix(this);" 
					  onblur="verifPrixAnnonce(this); effacerValeur_Prix(this)"
					  value="<?php echo $offre['p_a']?>">
					  
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
							<img  id ="premier" src="../<?php echo $pic1['filFinName']?>" alt="image principale" height="200" width="200"/>
							 <input class="inputClass " name="inputPic1" type="file" onchange="readURL(this);"
							 accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
										image/x-ms-bmp, image/PNG, image/JPEG, image/JPG, image/GIF, image/BMP" 
							 style="cursor: pointer;" id="imgInput1">
							 <a  href="#" id="<?php echo $pic1['idPho']?>" onclick="requestMesImages(this)" class="test1">Supprimer</a>
						</div>
						
						<div class="divClas col-sm-4" id="iim2">
							 <label>Photo 2 (3 Mo max)</label>
							 <br/>
							 <img id="deuxieme" src="../<?php echo $pic2['filFinName']?>" alt="image 2" height="200" width="200"/>
							 <input class="inputClass " name="inputPic2" type="file" onchange="readURL(this);"
							 accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
										image/x-ms-bmp, image/PNG, image/JPEG, image/JPG, image/GIF, image/BMP" 
							 style="cursor: pointer;" id="imgInput2">
							  <a href="#" id="<?php echo $pic2['idPho']?>" onclick="requestMesImages(this)" class="test2">Supprimer</a>
						</div>
						
						<div class="divClas col-sm-4" id="iim3">
							 <label>Photo 3 (3 Mo max)</label>
							 <br/>
							 <img id="troisieme" src="../<?php echo $pic3['filFinName']?>" alt="image 3" height="200" width="200"/>
							 <input class="inputClass " name="inputPic3" type="file" onchange="readURL(this);"
							 accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
										image/x-ms-bmp, image/PNG, image/JPEG, image/JPG, image/GIF, image/BMP" 
							 style="cursor: pointer;" id="imgInput3">
							 <a href="#" id="<?php echo $pic3['idPho']?>" onclick="requestMesImages(this)" class="test3">Supprimer</a>
						</div>
					
					</div>
					
					<!-- Button -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="envoyer_bouton"></label>
					  <div class="col-md-4">
						<a id="envoyer_bouton" href="detailMonAnnonce.php?pseu=<?php echo $pseudoUser ?>&ann=<?php echo $id_ann?>" name="envoyer_bouton" class="btn btn-warning">Annuler</a>
						<button type="submit" id="traiter"  name="traiter" value="Envoyer" class="btn btn-success">Envoyer</button>
						
					  </div>
					</div>
				
		</form>
		
<?php endforeach; ?>
	</div>
       
	 <?php include ("../headerFooter/footer.php");?>
    
</body>
</html>
