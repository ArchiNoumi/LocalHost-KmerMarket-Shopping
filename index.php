<?php 
				session_start();
				require_once "headerFooter/commonTopFilesIndexOnly.php";
				require_once 'models/model.php';
				$theLinkToRedirect = 'comptes/connection.php';
				$titleButtonAnnonce = 'Nvel Annonce/Inscription';

				
				if($userPseudo != null && $userPseudo !='')
				{
					//You need to connect before you create an annonce
					$theLinkToRedirect = 'annonces/creerAnnonce.php?pseu='.$userPseudo;
					$titleButtonAnnonce = 'Nouvelle Annonce';
				} 
						$regions = getRegions();
						
						//SUPER VILLE!!
					   
						$typeAnnonces = getTypeAnnonces();
						/*<option value= "5000" >Tous</option>
							 <?php foreach ($regions as $typeAnnonce): ?>
										<option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
								<?php endforeach; ?>*/
								
								
								
				//FOR THE VIDITORS :D 08 11 2017
				$IP = getVisitorIp();

				//$location = file_get_contents('http://freegeoip.net/json/193.248.229.130');//.$IP);
				$location = file_get_contents('http://ip-api.com/json/'.$IP);

				$data = json_decode($location);

				saveVisitor($data);
				//checked if the status is success :D
	
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-type" charset="UTF-8" content="text/html">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/trueLogoKmerMarket.png">
	
    <title>Localhost - les annonces</title> <!-- Element spécifiwue -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/header.css" type="text/css" />
	<link rel="stylesheet" href="css/index.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="ajax/ajax.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
	
	
	
	
</head>
<body onload='chargerRegions(); chargerVilles(); chargerPages()'>
		
<?php include ("headerFooter/header.php");?>


      
	
	<div class="rowd row">
		
			<div class="row">
			
				
				<!-- display/hide-->
				<div class="col-xs-offset-1 col-xs-4   small_screen">
						  <p  class="btn-light col-xs-9 col-sm-2 col-md-4 ">
										<button id="dispSearch" class="btn btn-default displayMenu_gauche" 
										type="button" data-toggle="collapse" 
										data-target="#menu_gauche" aria-expanded="false" 
										aria-controls="menu_gauche" onclick="afficheMasque();">
													Masquer Recherche
										</button>
						  </p>
						  
				</div>
				
				<!-- create annonces-->
				<div  class="col-xs-offset-1 col-xs-3 col-sm-offset-2  col-sm-2 col-md-6 col-lg-2">
				<!-- id= "crerAnn" -->
							<a  href="<?php echo($theLinkToRedirect)?>" >
								<button class="btn btn-warning" type="button">
									<strong><?php echo($titleButtonAnnonce)?></strong>
								</button>
							</a> 
			    </div>
				
			
				<div class="col-xs-offset-3 col-xs-5  col-sm-2 col-md-6 col-lg-2 ">
								<button class="btn btn-info" role="button"
															data-toggle="modal"
															data-target="#myModalAide">
															<strong>Aide : Annonce ?</strong>
													</button>
				</div>
					  
			</div>
			
			
			<div class="rowd_enfant row ">
					<div class="form-horizontal col-xs-12 col-sm-2 col-md-2 col-lg-2" id="menu_gauche">
								
							<h1>Rechercher</h1>
								
							
							
								<!-- Multiple Radios (inline) -->
								<div class="form-group ">
								  <label class="col-md-4 control-label" for="Type_Annonce">Type :</label>
								  <div class="col-md-8 "> 
									<label class="radio-inline " for="Type_Annonce-0">
									  <input type="radio" name="Type_Annonce" value="1" id="offre" value="1" checked="checked">
									  Offres
									</label> 
									<label class="radio-inline" for="Type_Annonce-1">
									  <input type="radio" name="Type_Annonce" value="0" id="demande" value="0">
									  Demandes
									</label>
								  </div>
								</div>
								
								<!-- Select Basic -->
								<div class="form-group">
								  <label class="control-label" for="Region">Région :</label><br/>
								  <!-- <span class="col-md-3input-group-addon" id="sizing-addon1">Région</span>-->
								  <div class="col-md-12">
								 
									<select id="Region" name="Region" class="form-control" onchange='chargerVilles()' >
										
										
												
									</select>
								  </div>
								</div>

								<!-- Select Basic -->
								<div class="form-group ">
								  <label class="control-label" for="Ville">Ville :</label><br/>
								  <div class="col-md-12">
									<select id="Ville" name="Ville" class="form-control">
													
									 
									</select>
								  </div>
								</div>

								<!-- Select Basic -->
								<div class="form-group">
								  <label class="control-label" for="Categorie_annonce">Catégorie :</label><br/>
								  <div class="col-md-12">
									<select id="Categorie_annonce" name="Categorie_annonce" class="form-control">
											<option value= "5000" >Tous</option>
									 <?php foreach ($typeAnnonces as $typeAnnonce): ?>
												<option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
										<?php endforeach; ?>
									</select>
								  </div>
								</div>

								<!-- Button -->
								<div class="form-group ">
								  <div class="col-md-5">
										<button id="Valider" name="Valider" class="btn btn-success" onclick='request()'><strong>Rechercher</strong></button>
								  </div>

								  
								 <div class="col-md-4 ">
									<a  href="<?php echo($theLinkToRedirect)?>" >
										<button class="btn btn-warning" type="button">
											<strong><?php echo($titleButtonAnnonce)?></strong>
									    </button>
									</a> 
								  </div >
									
								  
								</div>

							
					</div>
					
				
					<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" id="menu_centre">
				
					 
				
				<!-- Tris des résultats -->
				<form class="form-horizontal row" id="tri_par">
				
						<div class="col-xs-offset-1 col-xs-9 col-sm-offset-0 col-sm-4 col-md-4 col-lg-5">
							<div class="input-group recrer">
							  <input id="recherche_titre" type="text" class="form-control" placeholder="Entrez le titre recherché">
							  <span class="input-group-btn ">
								<button class="btn btn-success" type="button" onclick="request()">
									<span class="glyphicon glyphicon-search"> </span>
								</button>
							  </span>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
						
						<!--  select page -->
						<div class="col-xs-offset-1 col-xs-9 col-sm-offset-0 col-sm-4 col-md-4 col-lg-3">
							<div class="input-group recrer" >
								    <span class="input-group-btn">
										<button class="btn btn-warning" type="button">
											Pages :
										</button>
									
								    </span>
									
									<select id="Pages" name="Pages" class="form-control" onchange='requestByNumberPage()' >
							
								
										
									</select>
							</div>
						</div >
						
						<!-- Select trier par Basic -->
						<div class="col-xs-offset-1 col-xs-9 col-sm-offset-0 col-sm-4 col-md-4 col-lg-4">
							<div class="input-group recrer" >
								    <span class="input-group-btn">
										<button class="btn btn-warning" type="button">
											Trier Par :
										</button>
									
								    </span>
									
									<select id="tri_resultat" name="tri_resultat" class="form-control" onchange="request()">
									  <option value="recent_ancien">Plus récentes aux plus anciennes</option>
									  <option value="ancien_recent">Plus anciennes aux plus récentes</option>
									  <option value="prix_decroissants">Prix décroissants</option>
									  <option value="prix_croissants">Prix croissants</option>
									</select>
									
							</div>
						</div>
							
						
				</form>	
			
				<!-- Modal Information offre vs demande -->
											
				<div class="modal fade" id="myModalAide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">
							<img src="img/questionMark.png" alt="question sur offre ou demande"/>
						</h4>
					  </div>
					  <div class="modal-body">
					  <h1> ? Annonce  ?!?</h1>
							<p>
								Il existe 2 types :<br/>
								les <strong>Offres</strong> et les <strong>demandes</strong>
							</p>
							
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
						
				<!-- Liste de résultats -->
						<!-- Le Template de base -->
				<div class="row" id="super_annonce">
				  <!-- Chargé dynamiquement :) -->	
				</div>
				
			
				
				
				<!--When loading the data-->
				<span id="loader" style="display: none;"><img src="img/loader.GIF"  alt="loading" /></span><!--loader.gif-->
			</div>
		
			</div>
			<!--div class="col-md-2  " id="menu_droit">
					<img src="img/question.jpg" alt="question sur offre ou demande"/>
					<h1> ? Offre  ?!?</h1>
					<p>
						C'est la proposition de vente d'un bien, d'un service, d'un matériel, d'un produit ou autre à un prix donné. Ex: Je vends une voiture à 2 500 000 F CFA ..
					</p>
					
					<h1> ? Demande  ?!?</h1>
					<p>
						C'est la proposition d'achat d'un service, d'un bien, matériel, produit ou autre à un prix donné. Ex: Je veux acheter une mercédès à 2 500 000 F CFA, je recherche un pickup pour transporter ma récolte de maïs de .. à .. au prix de 5 000 F CFA
					</p>
				<p>
				
				
				</p>
			</div>
			
		</div-->
		
	
       
	<?php include ("headerFooter/footer.php");?>
		
	</div>
	
	<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>

</body>
</html>
