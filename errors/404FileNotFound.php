<?php 
				session_start();
				$_SESSION["index"]="true";
				$_SESSION["annonces"]="active";
				$_SESSION["mesAnnonces"]="";
				$_SESSION["compte"]="";
				$_SESSION["meteo"]="";
				//echo($_SESSION['pseudonyme']."je suis le pseudonyme?");
				require_once '../models/model.php';
						$regions = getRegions();
						
						//SUPER VILLE!!
					   
						$typeAnnonces = getTypeAnnonces();
						/*<option value= "5000" >Tous</option>
							 <?php foreach ($regions as $typeAnnonce): ?>
										<option value= "<?php echo $typeAnnonce['id_t'] ?>" > <?php echo $typeAnnonce['n_fr'] ?> </option>
								<?php endforeach; ?>*/
	
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<meta http-equiv="Content-type" charset="UTF-8" content="text/html">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
    <title>kmermarketshopping - page non accessible</title> <!-- Element spécifiwue -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/header.css" type="text/css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	
	
	
	
	
</head>
<body >
		
		<div class="row" style="text-align:center;">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<div class="col-md-12">
					<H1 >
						La page que vous essayez d'accéder n'existe pas :D !!
					</H1>		

			</div>
			<div class="col-md-12">
					<h3>
						<a href="../">Retour à kmermarketshopping ;) !!</a>
					</h3>
					

			</div>
			
		
		</div>
		
	
       <?php include ("../headerFooter/footer.php");?>
		

</body>
</html>
