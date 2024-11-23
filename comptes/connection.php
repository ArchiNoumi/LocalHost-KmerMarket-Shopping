<?php
session_start();
// already in fb libs :) session_start();
require ('../libs/fb/fb_init.php');
 require ('../models/model.php');
 //Facebook
 
 
   if(isset($_GET['mail']) && isset( $_GET['maxime']) )
   {
		if(get_activation_account_status_by_using_mail($_GET['mail'])==0)
		{
			update_is_active($_GET['mail'] ,  $_GET['maxime']);
			//$pseudonyme = email_et_mdp_au_meme_membre($email, $mdp);
			//get membre by token
			if($_GET['maxime']!=null)
			{
				$membre = getMembreByTockenActivation($_GET['maxime']);
			//get the pseudonyme from membre
				if($membre!=null)
				{
					$pseudonyme = $membre['pseudo'];
					$_SESSION['pseudonyme'] = $pseudonyme;
					save_date_derniere_connexion($pseudonyme);
				}
			}
			
			
		}
		
   }
   $_SESSION["index"]="false";
 
   
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/trueLogoKmerMarket.png">
	
    <title>Localhost - Connection</title> <!-- Element spécifiwue -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/footer.css" type="text/css" />
	<link rel="stylesheet" href="../css/connexion.css" type="text/css" />
	<link rel="stylesheet" href="../css/errorMsg.css" type="text/css" />
	
	
    <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
     <script type="text/javascript" src="../js/connexion.js"></script>
	
</head>
<body >

			<header>
				<a href="../index.php">
					<img src="../img/kmermarket.png" alt="lelogodekmermarket"/>
				</a>
				<h1>Mbom, tu peux acheter et vendre tout ici, njoooh!!</h1>
			</header>
			
			
		<div id="super_connecte">
		
			<fieldset>
				<form class="form-horizontal ajaxConnexion" action="../models/connection.php" method="post" >
					<!-- Form Name -->
					<legend>Connection</legend>
					<div class="conclu">
						<span id="conclusion">Hello :) !</span>
					</div>
					<!-- Text input-->
					<div class="form-group" >
						 
					  <label class="col-sm-3 control-label" for="mon_email">Email* :</label>  
					  <div class="col-sm-9">
						  <input id="mon_email" name="mon_email" type="text" 
						  placeholder="jean@exemple.com" class="form-control input-md"  
						  onblur="chk_email(this)">
						  <span class="alert" id="alert_mail"></span>
						  <span id="already_email"></span>
					  </div>
					</div>

					<!-- Password input-->
					<div class="form-group">
					  <label class="col-sm-3 control-label" for="mdp">Mot de passe* :</label>
						<div class="col-sm-9">
							<input id="mdp" name="mdp" type="password" placeholder="mot de passe" class="form-control input-md"  onblur="chk_mdp(this)">
							<span class="alert" id="alert_mdp"></span>
							<span id="already_mdp"></span>
						</div>
					</div>
					<!-- Button -->
					<div class="form-group">
					 
					  <div class="col-sm-offset-3 col-sm-9">
						<button type="submit" 
						id="envoyer_bouton" name="envoyer_bouton" 
						class="btn btn-success"
						>Connection</button>
						<a  id="mdp_oublie" name="mdp_oublie" 
							   lass="btn btn-default" role="button"
								data-toggle="modal"
								data-target="#myModalConfirmerMotDePasse"
								href="">Mot de passe oublié ?</a>
								
						<a  id="inscription"
								href="inscription.php">S'inscrire</a>
					
					  </div>
					  
					  
					</div>
					
					 
					  
					
				</form>
			</fieldset>
			
		</div >
		
		<!--
        <div id="super_connecte_social" >		
			
			<fieldset>
				<form class="form-horizontal" style="height: auto; width: auto"  >
					
					<legend>Ou Connectez vous avec</legend>
					
					
					
					<div class="form-group">
					 
					   
						<a type="submit" href="?php echo $login_url;?"
						id="envoyer_bouton" name="envoyer_bouton" 
						class="btn btn-primary btn-lg btn-block"
						>Connection avec Facebook</a>
					 
					  
						<a type="submit" 
						id="envoyer_bouton" name="envoyer_bouton" 
						class="btn btn-danger btn-lg btn-block"
						>Connection avec Google</a>
					 
					  
					  
					</div>
				</form>
			</fieldset>
		</div>
		
		-->	
			
		
		<!-- Modal Veuillez saisir votre email -->
											
		<div class="modal fade" id="myModalConfirmerMotDePasse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Saisir votre Email :)</h4>
			  </div>
			  <form class="form-horizontal ajaxPassForget" action="../models/connection.php" method="post">
			  
				  <div class="modal-body">
						<span id="conclusion2">
							Veuillez enregistrer votre email, afin de recevoir votre nouveau mot de passe :)
						</span>
						
						<div class="form-group">
						<br/>
						  <label class="col-sm-3 control-label" for="mon_email2">Email* :</label>  
						  <div class="col-sm-9">
						  <input  name="mon_email2" type="text" placeholder="..@.." 
						  class="form-control input-md"  onblur="chk_email2(this)" >
												
						  </div>
						   <span class="alert" id="alert_mail2"></span>
						  <span id="already_email2"></span>
						</div>
					<br/>
				  </div>
				    <div class="modal-footer">
				  
						<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
						
						<!-- il envoie les données pour traitement-->
						<button  class="btn btn-success" type="submit" >Enregistrer</a>
					</div>
			 </form>
			</div>
		  </div>
		</div>


		
	
	
       
		 <?php include ("../headerFooter/footer.php");?>
		
</body>

<script>
//Add everywhere we use facebook
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '525340124636805',
      cookie     : true,
      xfbml      : true,
      version    : 'v3.2'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
</html>
