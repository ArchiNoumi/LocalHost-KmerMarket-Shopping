<?php 
		session_start();
		$_SESSION["index"]="false";
		$_SESSION["annonces"]="";
		$_SESSION["mesAnnonces"]="active";
		$_SESSION["compte"]="";
		$_SESSION["meteo"]="";
		require "../headerFooter/commonTopFilesNotIndex.php";
		require '../models/model.php';
						
		$idAnnonce = htmlspecialchars($_GET['ann']);
		$pseudo = $_GET['pseu'];
		$offresChargementPage = getAnnoncePage($idAnnonce );
		
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
				 
				 $id_ann = htmlspecialchars($_GET['ann']);
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Détails de mon annonce</title> <!-- Element spécifique -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/detailMonAnnonce.css" type="text/css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	
	
	 <script src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/detailAnnonce.js"></script>
	
</head>
<body >
					
		<?php include ("../headerFooter/header.php");?>
	
		
		<div class="sub_header row">
		
							<a  href="mesAnnonces.php?pseu=<?php echo $pseudo ?>" class="btn btn-info" >Retour à la liste</a> 
				
		</div>
	
			
	<!-- Liste de résultats -->
					<!-- Le Template de base -->
			<div class="row allIn">
			  
				
				 <?php foreach ($offresChargementPage as $offre): ?>
					
				
						<!--Les petites images-->
					<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 image_1">
					
							
						
									<div class="row">
												<div class="col-xs-4 col-sm-12 col-md-12 col-lg-12 petite_image">
													<img src="../<?php if ($img1 != "img/default1.jpg")echo $img1['filFinName']; else echo $img1;?>" alt="image principale"  class="petite-image"/>
												</div>
												
												<div class="col-xs-4 col-sm-12  col-md-12 col-lg-12 petite_image">
													<img src="../<?php if ($img2 != "img/default1.jpg")echo $img2['filFinName']; else echo $img2;?>" alt="image deux" class="petite-image" />
												</div>
												
												<div class="col-xs-4 col-sm-12  col-md-12 col-lg-12 petite_image">
													<img src="../<?php if ($img3 != "img/default1.jpg")echo $img3['filFinName']; else echo $img3;?>" alt="image trois" class="petite-image" />
												</div>
									 </div >
							 
							 
						</div>
					
					<!--LA GRANDE IMAGE-->
					 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 grande_image">
					 	<!-- Image active à l'ouverture de la page -->
							
							<img src="../<?php if ($img1 != "img/default1.jpg")echo $img1['filFinName']; else echo $img1?>" alt="image principale" class="grosse-image"/>
						
					 </div>
					 
					 <!--LE TEXTE DE L'IMAGE :)-->
						<!--<a href="annonces/details.php"> le texte-->
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4  texte_annonce">
				  
							    
								 <h1><?php if ($offre['e_offre'] == 1)
									{
										echo'Détail de Mon Offre :';
									}	
									else
									{
										echo'Détail de Ma Demande :';
									}
									?>
								</h1>
								<h1 style="color : green"><?php echo 'N° : '.$offre['id_a'] ?></h1>
								<br/>
								<h1><?php echo $offre['ti_a'] ?></h1>
								<br/>
								<p><?php echo  $offre['te_a'] ?></p>
								<p class="special"><?php echo  formater_Prix($offre['p_a']) ?> F CFA</p>
								
								<p>
									<?php echo $offre['ville_nom_fr'] ?><br/>
									<?php echo$offre['p_s'] ?>
								</p>
								<p class="special">
									<?php if($offre['par_email']== 0)
									{
										$id_ann = $offre['id_a'];
										echo formater_telephone($offre['tel']);
										
									}
									?>
									<?php if($offre['par_email']== 1)
									{
										$id_ann = $offre['id_a'];
										echo ($offre['email']);
										
									}
									?>
							   </p>
							   <p class="les_boutons row">
									<!--faire le test sur l'état de l'annonce
									 si annonce supprimée (donc pas vendue) aucun modal
									 si annonce vendue (donc annulation != null aussi) aucun modal
									 si annonce en cours alors je peux utiliser le modal via le button -->
									 
									 <?php 
										
										if($offre['date_annul'] == null and $offre['date_vent_achat'] == null)
										{?>
											<a href="modifierAnnonce.php?pseu=<?php echo $userPseudo ?>&ann=<?php echo $id_ann ?>" class="btn btn-default col-xs-4" role="button">Modifier</a> 
											
											<button class="btn btn-warning col-xs-4" role="button"
													data-toggle="modal"
													data-target="#myModalSupprimer">
													Supprimer
											</button>
											<?php 
												if($offre['e_offre']==1){?>
												
													<button class="btn btn-success col-xs-4" role="button"
															data-toggle="modal"
															data-target="#myModalOffreVendre">
															Offre<br/>vendue ?
													</button>
													
											<?php 	}
												else if ($offre['e_offre']==0){ ?>
													<button class="btn btn-success col-xs-6" role="button"
															data-toggle="modal"
															data-target="#myModalDemandeVendre">
															Demande<br/>obtenue ? 
													</button>		
											<?php	} ?>

									   <?php }
									   
									   
										
									?>
									
									
									
								</p>
							
								
				
				 <?php endforeach; ?>
					
				
			</div>
		</div>
	

	
		
		
		
		<!-- Modal Supprimer -->
											
		<div class="modal fade" id="myModalSupprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmer la suppression</h4>
			  </div>
			  <div class="modal-body">
				Voullez vous vraiment supprimer cette annonce ?
			  </div>
			  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
						<a href="../models/suppressionAnnonce.php?pseu=<?php echo($pseudo)?>&ann=<?php echo $id_ann ?>" type="button" class="btn btn-primary" >Oui</a>
			  </div>
			</div>
		  </div>
		</div>
		
		<!-- Modal Offre vendue -->
											
		<div class="modal fade" id="myModalOffreVendre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
			  </div>
			  <div class="modal-body">
				 J'ai vendu mon offre :) !!
			  </div>
			  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
						<a href="../models/venteAchatAnnonce.php?ann=<?php echo $id_ann ?>" type="button" class="btn btn-primary" >Oui</a>
			  </div>
			</div>
		  </div>
		</div>
		
		<!-- Modal Demande r -->
											
		<div class="modal fade" id="myModalDemandeVendre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmation </h4>
			  </div>
			  <div class="modal-body">
				J'ai obtenu ma demande :) !!
			  </div>
			  <div class="modal-footer">
					    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
						<a href="../models/venteAchatAnnonce.php?ann=<?php echo $id_ann ?>" type="button" class="btn btn-primary" >Oui</a>
			  </div>
			</div>
		  </div>
		</div>
									
	
	
       
		<?php include ("../headerFooter/footer.php");?>
		



   
</body>
</html>
