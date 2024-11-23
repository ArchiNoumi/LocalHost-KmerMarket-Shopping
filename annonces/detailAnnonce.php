<?php 
session_start();
$_SESSION["index"]="false";
$_SESSION["annonces"]="active";
$_SESSION["mesAnnonces"]="";
$_SESSION["compte"]="";
require "../headerFooter/commonTopFilesNotIndex.php";
require '../models/model.php';
						$idAnnonce = htmlspecialchars($_GET['ann']);
						
						$offresChargementPage = getAnnoncePage($idAnnonce);
						$photos = getPhotoByIdAnnonce($idAnnonce);
			
				 $img1="img/default1.jpg";
					$img2="img/default1.jpg";
					$img3="img/default1.jpg";
				 foreach( $photos as  $photo)
				 {
					 if( $photo['filDesc']=="1")
					 {
						 $img1 = $photo;
					 }
					 else if( $photo['filDesc']=="2")
					 {
						 $img2 = $photo;
					 }
					 else if( $photo['filDesc']=="3")
					 {
						 $img3 = $photo;
					 }
				 }
				 
				 //$id_ann = htmlspecialchars($_GET['ann']);
				/*$emailAnnonceur = "";
				 foreach ($offresChargementPage as $result){
    //commandes
					 $emailAnnonceur = $result['email'];

				}*/
				
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Détails de l'annonce</title> <!-- Element spécifique -->

	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/detailMonAnnonce.css" type="text/css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	
	
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/detailAnnonce.js"></script>
	
</head>
<body >
					
		
	<?php include ("../headerFooter/header.php");?>
		
		
		
			
				<div class="sub_header row">

					
								<a  href="../index.php" class="btn btn-info" >Retour à la liste</a> 
							
				</div>

	
					<!-- Le Template de base -->
				<div class="row allIn">
				  
					
					 <?php foreach ($offresChargementPage as $offre): ?>
						 
						
							<!--Les petites images-->
								<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 image_1">
								
												<div class="row">
													
																<div class="col-xs-4 col-sm-12 col-md-12 col-lg-12 petite_image">
																	<img src="../<?php if ($img1 != "img/default1.jpg")echo $img1['filFinName']; else echo $img1;?>" alt="image principale"  class="petite-image"/>
																</div>
																
																<div class="col-xs-4 col-sm-12 col-md-12 col-lg-12 petite_image">
																	<img src="../<?php if ($img2 != "img/default1.jpg")echo $img2['filFinName']; else echo $img2;?>" alt="image deux" class="petite-image" />
																</div>
																
																<div class="col-xs-4 col-sm-12 col-md-12 col-lg-12 petite_image">
																	<img src="../<?php if ($img3 != "img/default1.jpg")echo $img3['filFinName']; else echo $img3;?>" alt="image trois" class="petite-image" />
																</div>
													
												</div>
								</div>	
						
						
						
							
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grande_image">
								
									<!-- Image active à l'ouverture de la page -->
									<img src="../<?php if ($img1 != "img/default1.jpg")echo $img1['filFinName']; else echo $img1?>" alt="image principale" class="grosse-image"/>
								</div>
							
							
						
							 <!--LE TEXTE DE L'IMAGE :)-->
						 
							<!--<a href="annonces/details.php"> -->
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4  texte_annonce">
										  
													    <h1 style="color : green"><?php echo 'N° : '.$offre['id_a'] ?></h1>
														<br/>
														<h1><?php echo $offre['ti_a'] ?></h1>
														<br/>
														<br/>
														<p><?php echo  $offre['te_a'] ?></p>
														<p class="special"><?php echo formater_Prix($offre['p_a']) ?> F CFA</p>
														
														<p>
															Ville : <?php echo  $offre['ville_nom_fr'] ?><br/>
															Annonceur : <?php echo $offre['p_s'] ?>
														</p>
														<p class="special">
															<?php if($offre['par_email']== 0)
															{
																echo 'Téléphone : '.formater_telephone($offre['tel']);
															}
															else
															{
																echo'<button class="btn btn-default " role="button"
																					data-toggle="modal"
																					data-target="#myModalEmail">
																					Envoyer un mail à l\'annonceur 
																	</button>';
																
															}
															?>
															
														</p>
														
													<?php endforeach; ?>	
													 
									</div>
						
						
						
					</div>	
					 <!-- </a> -->
				
				 
		
		
		<div class="modal fade" id="myModalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Envoi d'un mail à l'annonceur </h4>
			  </div>
			  <div class="modal-body">
				<!-- Envoyer l'email à l'annonceur -->
		
					<form class="form-horizontal ajax" action="../models/envoiEmailAnnonceur.php"   method="post">
						<fieldset>
									<div id="conclu"><span id="conclusion">hello :) !!</span></div>
						<!-- Form Name -->
								
								<!-- J'ai utilisé les fonction js de modifier_Créer_Annonce.js qui sont déjà éprouvées-->
								<!-- Text input-->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="mon_email">Mon email* :</label>  
								  <div class="col-md-7">
								  <input id="mon_email" name="mon_email" type="text" onblur="chk_email(this);" placeholder=".@." class="form-control input-md" required="">
									<span class="alert" id="alert_mail"></span>
									<span id="already_email"></span>
								  </div>
								</div>

								<!-- Text input-->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="phone_number">Mon téléphone :</label>  
								  <div class="col-md-7">
								  <input id="phone_number" name="phone_number" onblur="chk_tel(this); " type="text" placeholder="" class="form-control input-md">
								  <span class="alert" id="alert_tel"></span>
									 <span id="already_tel"></span>
								  </div>
								</div>

								<!-- Text input-->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="objet_mail">Objet du mail* :</label>  
								  <div class="col-md-7">
								  <input id="objet_mail" name="objet_mail" type="text" placeholder="" onkeyup="afficheValeur_Titre(this);" onblur="verifTitreAnnonce(this); effacerValeur_Titre(this);" class="form-control input-md" required="">
									<span id="taille_titre"></span>
									<span class="alert" id="alert_titre"></span>
								  </div>
								</div>

								<!-- Textarea -->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="message_mail">Message* :</label>
								  <div class="col-md-8">                     
									<textarea rows="5" class="form-control" id="message_mail"  name="message_mail" onkeyup="afficheValeur_Texte(this);"  onblur="verifTexteAnnonce(this); effacerValeur_Texte(this);">....</textarea>
									<span id="taille_texte"></span>
									<span class="alert" id="alert_texte"></span>
								</div>
								</div>
								
								<!-- hiden input -->
								<div class="form-group">
									<input type="hidden" name="idAnnonceur" value="<?php echo $idAnnonce?>">
								</div>	
									
								<!-- Button -->
								<div class="form-group">
								  <label class="col-md-4 control-label" for="envoyer_bouton"></label>
								  <div class="col-md-4">
									<button id="envoyer_bouton" name="envoyer_bouton" type="submit" class="btn btn-success">Envoyer</button>
								  </div>
								</div>

						</fieldset>
					</form>
			  </div>
			  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						
			  </div>
			</div>
		  </div>
		</div>
		
		

	
	
       
		 <?php include ("../headerFooter/footer.php");?>
    


 
</body>
</html>
