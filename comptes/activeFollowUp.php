<?php
	session_start();
	$_SESSION["index"]="false";
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>kmermarketshopping - Inscription</title> <!-- Element spécifiwue -->
	
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	<link rel="stylesheet" href="../css/inscription.css" type="text/css" />
	<link rel="stylesheet" href="../css/errorMsg.css" type="text/css" />
	
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/inscription.js"></script>

		<script>
					
				</script>
	
</head>
		<body>
			<header>
				<a href="../index.php">
				<img src="../img/trueLogoKmerMarket.png" alt="lelogodekmermarket"/></a>
				
				<h1>Buy and sell all day, everyday!!  </h1>
			</header>
			<div id="super_inscrit" style='background-color:white;'>	
			
				<fieldset >
					<h1 >
						Bravo, votre compte a été enregistré ! <br/>
						Rendez-vous, dans votre boîte email, pour l'activer ! <br/>
						:)
					</h1>
				
				</fieldset>
			
			</div>
			
			
			
			      <?php include ("../headerFooter/footer.php");?>
				
				 
				
		</body>
</html>
