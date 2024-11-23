
<?php
	session_start();
	require 'model.php';
	//require_once '../libs/PHPMailer/PHPMailerAutoload.php';
	 
	
	//MODIFICATION DU COMPTE UNIQUEMENT MOT DE PASSE
	
	//---------------------SUBMIT SUBMIT SUBMIT---------------------
	
		
		//Get the Membre
		
		$Membre= getMembreByPseudo($_SESSION['pseudonyme']);
		$idMembre = $Membre['idm'];
        $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
		//$mdp = (isset($_POST["mdp"])) ? htmlentities($_POST["mdp"]) : NULL;
		$mdp0 = (isset($POST["mdp0"])) ? htmlentities($POST["mdp0"]) : NULL;
		$mdp1 = (isset($POST["mdp1"])) ? htmlentities($POST["mdp1"]) : NULL;
		$mdp2 = (isset($POST["mdp2"])) ? htmlentities($POST["mdp2"]) : NULL;
		//Stocker la message d'erreur :D
		$errors_msg = "";
		//Checker les mots de passe sont au bon format
		
		 if($mdp0 !=NULL && $mdp1 !=NULL && $mdp2 !=NULL)
		{
			$valeur = compare_mdp_mdpDeLaBDD($mdp0, $idMembre);
			$valeur1 = control_mot_de_passe($mdp1); //1 -> il est indisponible ou 0 -> c bon tho
			if(strlen($mdp0) < 6 || strlen($mdp0) > 50 || strlen($mdp1) < 6 || strlen($mdp1) > 50 || strlen($mdp2) < 6 || strlen($mdp2) > 50)
			{
				$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
				echo($errors_msg );
			}
			if($valeur != "OK" )
			{
				echo ("Le mot de passe renseigné n'est pas le bon");
			}
		   else if($valeur1 == 1)
			{
				echo ("Veuillez choisir un autre mot de passe !");
			}
			else if($mdp0 == $mdp1) // It's a new password ! so it must be different from the previous
			{
				echo("Le nouveau mot de passe doit être différent de l'ancien :)");
			}
			else if($mdp1 != $mdp2) //they must be equal tho
			{
				echo("Les mots de passe ne sont pas égaux");
			}
			else if($mdp1 == $mdp2) //Send the mail and modify the password
			{
			
				update_mdp($mdp1, $idMembre) ;
					$email = getMembreByMotDePasse($mdp1)['mail'];
					$pseudonyme = getMembreByMotDePasse($mdp1)['pseudo'];
					//Envoyer un email
					$fromEmail="Noreply@localhost.com";;
							$fromName="Localhost support";
							$toEmail=$email ;
							$toName=$pseudonyme;
							$subject="Nouveau mot de passe :)";
							
							//AltBody = Body altbody is for those who do,n't have htm capabilities
							$AltBody="
												<h3>Cher(e) ".$pseudonyme.",</h3>
												<p>
												    Vos identifiants sont à présent :<br/>
													email : ".$email."<br/>
													mot de passe : ".$mdp1."<br/>
													
													<br/>
													Avec nos remerciements,<br/>
													localhost 
												</p>";
							$Body=$AltBody;
							//LOCALHOST NO mAIL TO SUBMIT
							
							//Bravo l'annonce a été créée !!!!!
							echo '<body onLoad="alert(\'Bravo votre Mot de Passe a correctement été modifié\')">';
							echo '<meta http-equiv="refresh" content="0;URL=../comptes/compte.php?pseu='.$pseudo.'">';
					
			}
		}
		else
		{
			echo ("Veuillez remplir tous les champs :)");
		
		}
			

?>