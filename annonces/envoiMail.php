<?php require '../models/model.php';
						$regions = getRegions();
						$villes = getVilles(1);
						$toutesLesVilles = getToutesLesVilles();
						$typeAnnonces = getTypeAnnonces();
						$offresChargementPage = getAnnonceChargementPage();
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Envoi Mail :)</title> <!-- Element spꤩfique -->
	<link rel="stylesheet" href="../css/index.css" type="text/css" />
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	

	
	
	
</head>
<body >
					
	
	
		
		<form class="form-horizontal">
					
		
				<fieldset>

				<!-- Form Name -->
				<legend>Envoyer un email à l'annonceur</legend>
				

				</fieldset>
        </form>
		
		<div>

				
			
	<!-- Liste de résultats -->
					<!-- Le Template de base -->
			<div class="row">
			  
				
				 <?php foreach ($offresChargementPage as $offre): ?>
					 <h1><?php if ($offre['e_offre'] == 1)
						{
							echo'Offre';
						}	
						else
						{
							echo'Demande';
						}
						?>
					</h1>
					
					<img src="#" alt="#" onclick=""/>
					<img src="#" alt="#" onclick=""/>
					<img src="#" alt="#" onclick=""/>
					<img src="#" alt="#" class="grosse-image"/><!-- Image active à l'ouverture de la page -->
					
					
					 
						<a href="annonces/details.php"> 
								<div class="col-sm-6 col-md-4">
						  
									<div class="thumbnail">
									  <img src="" alt="">
									  <div class="caption">
									  
										<h3><?= $offre['ti_a'] ?></h3>
										<p><?= $offre['te_a'] ?></p>
										<h5><?= $offre['p_a'] ?> F CFA</h5>
										
										<p>
											<?= $offre['ville_nom_fr'] ?><br/>
											<?= $offre['p_s'] ?><br/>
											<?php if($offre['par_email']== 0)
											{
												echo $offre['tel'];
												echo'<br/>';
											}
											?>
											<a href="#" class="btn btn-primary" role="button" onclick='envoiEmail()'>Envoyer un message à l'annonceur</a> <br/>
											
										</p>
										
										<p>
											<a href="#" class="btn btn-primary" role="button">Button</a> 
											<a href="#" class="btn btn-default" role="button">Button</a></p>
									  </div>
									</div>
									</div>	
					  </a>
				
				 <?php endforeach; ?>
					
				
			</div>



		
		</div>
	
	
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
