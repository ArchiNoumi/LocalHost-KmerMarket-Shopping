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
	
    <title>Localhost - Inscription</title> <!-- Element spécifiwue -->
	
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
				<img src="../img/kmermarket.png" alt="lelogodekmermarket"/>
				</a>
				<h1>Mbom, tu peux acheter et vendre tout ici, njoooh!!</h1>
			</header>
			<div id="super_inscrit">	
			
					<fieldset>
				<form class="form-horizontal ajax"  action="../models/inscription.php"   method="post" >
						<!-- Form Name -->
						<legend>S'inscrire</legend>
						<div id="conclu"><span id="conclusion">hello :) !!</span></div>
						<!-- Text input-->
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="mon_email">Email* :</label>  
						  <div class="col-sm-9">
						  <input id="mon_email" name="mon_email" onblur="chk_email(this)"
						  type="text" placeholder="joe@exemple.com" 
						  class="form-control input-md" > <!--onblur="verifMail(this)"--> 
						  <span class="alert" id="alert_mail"></span>
						  <span id="already_email"></span>
											
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="telephone">Téléphone* :</label>  
						  <div class="col-sm-9">
						  <input id="telephone" name="telephone" type="text" 
									placeholder="123456789" class="form-control input-md"
									onblur="chk_tel(this)"
									>
									 <span class="alert" id="alert_tel"></span>
									 <span id="already_tel"></span>
								
							
						  </div>
						</div>

						<!-- Text input-->
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="pseudonyme">Pseudonyme* :</label>  
						  <div class="col-sm-9">
						  <input id="pseudonyme" name="pseudonyme" type="text" onblur="chk_pseudonyme(this)"
						  placeholder="mon nom sur le site" 
								class="form-control input-md" 
									>
									<span class="alert" id="alert_pseudo"></span>
									 <span id="already_pseudo"></span>
									
							
						  </div>
						</div>

						<!-- Password input-->
						<div class="form-group">
						  <label class="col-sm-3 control-label" for="mdp">Mot de passe* :</label>
						  <div class="col-sm-9">
							<input id="mdp" name="mdp" type="password" onblur="chk_mdp(this)"
							placeholder="mot de passe" class="form-control input-md"  >
							<span class="alert" id="alert_mdp"></span>
							 <span id="already_mdp"></span>
							
						  </div>
						</div>

						<!-- Button  -->
						<div class="form-group">
						 
							  <div class="col-sm-offset-3 col-sm-7 ">
								<input  type ="submit" id="envoyer_bouton" value="Créer un compte"  class="btn btn-success">
								  <a class="btn btn-link"  id="Connexion"
									href="connection.php">Connexion</a>
							  </div>
							
						</div>
					</form>
				</fieldset>
			
			</div>
			
			
			
			      <?php 
							include ("../headerFooter/footer.php");
				  ?>
				
				 
				
		</body>
</html>
