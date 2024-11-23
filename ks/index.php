<?php 
	//Modification d'une annonce
	session_start();
	require '../models/model.php';
	//$regions = getRegions();
	
	//$typeAnnonces = getTypeAnnonces();
	$titre = "IMG-20160918-WA0028.";
	//echo(getPhotoBy_File_Title($titre));

/*	<select id="categorie_annonce" name="categorie_annonce" class="form-control">
                    <?php foreach ($typeAnnonces as $typeAnnonce): ?>
                              <option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
                      <?php endforeach; ?>

</select>
                      */
?>
<!DOCTYPE html>

<html>

	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
		 <title>Khloé Shopping Administration</title>
		 
	    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/header.css" type="text/css" />
		<link rel="stylesheet" href="../css/alert.css" />
		<link rel="stylesheet" href="../css/modifCreerAnnonce.css" />
		<link rel="stylesheet" href="../css/footer.css" />
		<link rel="stylesheet" href="../css/ks.css" />
	
		
		 <script src="../js/jquery-1.11.3.min.js"></script>
		 <script type="text/javascript" src="../ajax/ajax.js"></script>
	
	
		 <script type="text/javascript" src="../js/modifier_Creer_Annonce.js"></script>
		 	<script type="text/javascript" src="../js/modifier_Creer_Annonce.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
	
		  
	</head>
	<body >
		
		</br>
		<form class="form-horizontal" style="padding-left:10%; padding-right:10%" action="../models/uploadks.php" method="post" enctype="multipart/form-data">
		<!-- Form Name -->
					
					<!-- Khloé Shopping-->
					<div class="form-group" style="text-align: center">
					  <H1 style="color: #b900e5;; font-weight: bolder">Khloé Shopping Adminitration les <span class="glyphicon glyphicon-euro"></span> :</H1>  
					  
					  <a href="../annonces/mesAnnonces.php"  class="btn btn-primary mb-2">Mes Annonces</a>
						
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
						   <!-- <?php foreach ($typeAnnonces as $typeAnnonce): ?>
									<option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
						    <?php endforeach; ?>
                            -->


                                <option value="1"> Autres </option>
                                <option value="17"> Chaussures enfants </option>
                                <option value="18"> Chaussures femmes </option>
                                <option value="19"> Chaussures hommes </option>
                                <option value="20"> Consoles &amp; Jeux vidéo </option>
                                <option value="59"> Valises &amp; Accessoires </option>
                                <option value="60"> Vêtements enfant </option>
                                <option value="61"> Vêtements femme </option>
                                <option value="62"> Vêtements homme </option>
                                <!--<option value="2"> Alimentaire </option>
                                <option value="3"> Ameublement </option>
                                <option value="4"> Animaux </option>
                                <option value="5"> Applis &amp; Jeux </option>
                                <option value="6"> Automobiles - Voitures / Cars / Bus </option>-->
                                <option value="7"> Bagages </option>
                                <option value="8"> Bagages &amp; Sacs </option>
                                <option value="9"> Beauté et Parfum </option>
                                <option value="10"> Bébés - produits &amp; vêtements </option>
                                <option value="11"> Bijoux </option>
                                <!--<option value="12"> Bricolage </option>
                                <option value="13"> Bureaux et Commerce </option>
                                <option value="14"> Camions </option>
                                <option value="15"> CD &amp; DVD &amp; Blu-ray </option>
                                <option value="16"> CD / Musique </option>-->

                               <!-- <option value="21"> Construction - matériels &amp; produits </option>
                                <option value="22"> Constructions </option>
                                <option value="23"> Cuisine &amp; Maison </option>
                                <option value="24"> DVD / Films </option>
                                <option value="25"> Electroménager </option>
                                <option value="26"> Emplois &amp; jobs </option>
                                <option value="27"> Engins de Chantier </option>
                                <option value="28"> Engrais </option>
                                <option value="29"> Equipements - Engins industriels &amp; Engins lourds </option>
                                <option value="30"> Fournitures de bureau </option>
                                <option value="31"> Fruits </option>
                                <option value="32"> Gastronomie </option>
                                <option value="33"> High-Tech </option>-->
                                <option value="34"> Hygiène et Santé </option>
                                <option value="35"> Image &amp; Son </option>
                                <option value="36"> Informatique - Ordinateurs et autres </option>
                                <option value="37"> Instruments de musique &amp; Sono </option>
                                <option value="38"> Jeux et Jouets </option>
                                <!--<option value="39"> Légumes </option>
                                <option value="40"> Livres  </option>
                                <option value="41"> Location </option>
                                <option value="42"> Logiciels </option>
                                <option value="43"> Manutention </option>
                                <option value="44"> Matériel Agricole </option>
                                <option value="45"> Matériels et équipements Mécanique </option>
                                <option value="46"> Montres &amp; Bijoux </option>
                                <option value="47"> Motos </option>
                                <option value="48"> Pièces Moto </option>
                                <option value="49"> Pièces Automobiles </option>
                                <option value="50"> Poissons &amp; espèces aquatiques </option>
                                <option value="51"> Produits agricoles </option>
                                <option value="52"> Provenderie </option>
                                <option value="53"> Secteur industriel &amp; scientifique </option>-->
                                <option value="54"> Sports et Loisirs </option>
                                <option value="55"> Téléchargements </option>
                                <option value="56"> Téléphones </option>
                                <!--<option value="57"> Terrains </option>
                                <option value="58"> Transport - Manutention </option>-->

                                <!--<option value="63"> Vins &amp; Boissons </option>-->

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
					
					
			<div class="form-group">
				<div class="divClas col-sm-offset-4 col-sm-6" >
					<label>Sélection de plusieurs images:</label>  
					  	<br/>	
					
					<input accept ="image/png, image/jpg, image/bmp, image/gif, image/png, image/jpeg, 
												image/x-ms-bmp, 
												image/PNG, image/JPEG, image/JPG, 
												image/GIF, image/BMP"  
												type="file" 
												name="filesimg[]"  multiple ><!--  -->
				</div>
					
			</div>
			
			
			<!-- Button Envoyer-->
			<div class="form-group">
				  <label class="col-md-4 control-label" for="Upload"></label>
				  <div class="col-md-4">
				  <button type="submit" id="envoyer_bouton" name="Upload" class="btn btn-success" >Enregistrer</button>
					<a id="envoyer_bouton" href="../ks/index.php" name="envoyer_bouton" class="btn btn-warning">Annuler</a>
					
				  </div>
			</div>
			
		</form>
		

	</body>
</html>
