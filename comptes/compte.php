<?php 
		session_start();
		$_SESSION["index"]="false";
		$_SESSION["annonces"]="";
		$_SESSION["mesAnnonces"]="";
		$_SESSION["compte"]="active";
	    $_SESSION["meteo"]="";
		require '../headerFooter/commonTopFilesNotIndex.php';	
		require '../models/model.php';
		
		$membre = getMembreByPseudo($_SESSION['pseudonyme']);
		
			$idMembre = $membre['idm'];		
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Mon compte</title> <!-- Element spécifique -->
	
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/compte.css" type="text/css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	<link rel="stylesheet" href="../css/errorMsg.css" type="text/css" />
	
	 <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	 <script type="text/javascript" src="../ajax/ajax.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	 <script type="text/javascript" src="../js/inscription.js"></script>
	

	
	
</head>
<body >
		<?php include ("../headerFooter/header.php");?>
	
		
					<!-- Le Template de base -->
					
			<div class="row" id="mes_donnees">
			
						<!--<a href="annonces/details.php"> -->
								<div class="col-sm-12 total">
						  
									<div class="thumbnail">
									  <img src="" alt="">
									  <div class="caption ">
									  
											  <div class="col-xs-12" >
													<span class="libel">Pseudonyme : </span><span class="res_libel"><?php echo $membre['pseudo'] ?></span>
												  <br/>
													<span class="libel">Email : </span><span class="res_libel"><?php echo $membre['mail'] ?></span>
												  <br/>
													<span class="libel">Date inscription : </span><span class="res_libel"><?php echo $membre['date_ins'] ?></span>
												  <br/>
													<span class="libel">Téléphone : </span><span class="res_libel"><?php echo  formater_telephone($membre['tel']) ?></span>
												  <br/>
											  </div>
											<button class="btn btn-success" role="button"
													data-toggle="modal"
													data-target="#myModalModifier">
													Modifier
											</button>
											
											
										
									  </div>
									  
									  
									  <div class="caption ">
										
										 <div class="col-xs-12"> 
												<span class="libel">Mot de passe : </span><span class="res_libel">*******</span>
											  <br/>
										  </div>
										 	
												
										 
											
											<button class="btn btn-success" 
												role="button"
												data-toggle="modal"
												data-target="#myModalModifierMotDePasse">
												Nouveau Mot de passe
											</button>
										
										
									  </div>
									</div>
								</div>	
					 <!-- </a> -->
				
				
					
				
			</div>

	<form class="form-horizontal compte_modif_sauf_mdp" action="../models/modifierCompteAutreQueMdp.php" method="post" >
		
		<!-- Modal Modifier les autres données -->									
		<div class="modal fade" id="myModalModifier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modifier les infos du compte :)</h4>
			  </div>
			  <div class="modal-body">
				<div id="conclu"><span id="conclusion">hello :) !!</span></div>
				  <!-- Pseudonyme-->
						<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="pseudonyme">Pseudonyme* :</label>  
					  <div class="col-md-4">
					     <input id="pseudonyme" name="pseudonyme" type="text" placeholder="" 
							class="form-control input-md" help="nom sur le site :)" 
								onblur="chk_pseudonyme_compte(this)" value="<?php echo $membre['pseudo']?>">
								<span class="alert" id="alert_pseudo"></span>
									 <span id="already_pseudo"></span>
						
					  </div>
					</div>
					
					<!-- Email -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="mon_email">Email* :</label>  
						  <div class="col-md-4">
						  <input id="mon_email" name="mon_email" type="text" placeholder="" 
						  class="form-control input-md"  onblur="chk_email_compte(this)" value="<?php echo $membre['mail']?>">
								  <span class="alert" id="alert_mail"></span>
								  <span id="already_email"></span>			
						  </div>
						</div>
						
					<!-- Téléphone -->
						<div class="form-group">
						  <label class="col-md-4 control-label" for="telephone">Téléphone* :</label>  
						  <div class="col-md-4">
						  <input id="telephone" name="telephone" type="text" 
									placeholder="" class="form-control input-md"
									onblur="chk_tel_compte(this)"
									value="<?php echo $membre['tel']?>">
								<span class="alert" id="alert_tel"></span>
								<span id="already_tel"></span>
							
						  </div>
						</div>
				
			  
			  </div>
			  <div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
						<a href="#" type="button" class="btn btn-success" 
									data-toggle="modal"
												data-target="#myModalConfirmerMotDePasse"
												>Enregistrer</a>
						
			  </div>
			</div>
		  </div>
		</div>
	 
			<!-- Modal Veuillez saisir votre Mot de passe -->
											
		<div class="modal fade" id="myModalConfirmerMotDePasse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Saisir le mot de passe :)</h4>
			  </div>
				
				  <div class="modal-body">
					<div id="conclu"><span id="conclusion1">hello :) !!</span></div>
						<!-- Password input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="mdp">Mot de passe* :</label>
					  <div class="col-md-4">
						<input id="mdp" name="mdp" type="password" placeholder="" class="form-control input-md"  onblur="chk_mdp_compte(this)">
							<span class="alert" id="alert_mdp"></span>
							 <span id="already_mdp"></span>
					  </div>
					</div>
					
				  </div>
				    <div class="modal-footer">
				  
						<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						
						<!-- il envoie les données pour traitement-->
						<button  class="btn btn-warning" type="submit" >Enregistrer</a>
					</div>
			 
			</div>
		  </div>
		</div>
		
		
	</form> 	
		
		<form class="form-horizontal compte_modif_mdp" action="../models/modifierCompteMdpSubmit.php" method="post" >
		
		
		<!-- Modal Modifier Mot de passe -->
											
		<div class="modal fade" id="myModalModifierMotDePasse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Confirmation</h4>
			  </div>
			  <div class="modal-body">
					<div id="conclu"><span id="conclusion2">hello :) !!</span></div>
					
					<div class="form-group">
					  <label class="col-md-4 control-label" for="mdp">Mot de passe Actuel* :</label>
					  <div class="col-md-4">
						<input id="mdp0" name="mdp0" type="password" placeholder="" class="form-control input-md" required="" onkeyup="chk_mdp_compte(this)" onblur="chk_mdp_compte(this)">
						<span class="alert" id="alert_mdp0"></span>
							 <span id="already_mdp0"></span>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-md-4 control-label" for="mdp1">Nouveau mot de passe* :</label>
					  <div class="col-md-4">
						<input id="mdp1" name="mdp1" type="password" placeholder="" class="form-control input-md" required="" onblur="chk_mdp_compte(this)">
						<span class="alert" id="alert_mdp1"></span>
							 <span id="already_mdp1"></span>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-md-4 control-label" for="mdp2">Confirmer le mot de passe :</label>
					  <div class="col-md-4">
						<input id="mdp2" name="mdp2" type="password" placeholder="" class="form-control input-md" required="" onblur="chk_mdp_compte(this)">
						<span class="alert" id="alert_mdp2"></span>
							 <span id="already_mdp2"></span>
					  </div>
					</div>
			  </div>
			  <div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
						<button  type="submit" class="btn btn-success" >Enregistrer</a>
			  </div>
			</div>
		  </div>
		</div>
		
</form>
									
	<!--footer-->
	 <?php include ("../headerFooter/footer.php");?>

</body>
</html>
