
<?php
	session_start();
	require 'model.php';
	//require_once '../libs/PHPMailer/PHPMailerAutoload.php';
	 
	
	//MODIFICATION DU COMPTE UNIQUEMENT MOT DE PASSE
	
	//LES CONTROLES UNIQUEMENTS
	
		
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
		if($mdp0 != null )
		{
			$valeur = compare_mdp_mdpDeLaBDD($mdp0, $idMembre);
			if(strlen($mdp0) < 6 || strlen($mdp0) > 50)
			{
				$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
				echo($errors_msg );
			}
		//Est ce que le mdp0 est affecté au membre ??
			
			else if($valeur != "OK" )
			{
				echo ("Le mot de passe renseigné n'est pas le bon");
			}
			/*else if ($valeur == "OK" )
			{
				echo ("OK !");
			}	*/
		}
		 if($mdp1 != null)
		 {
				//check if the mdp1 is already in the database ! :)
			$valeur1 = control_mot_de_passe($mdp1);
			if(strlen($mdp1) < 6  || strlen($mdp1) > 50)
			{
				$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
				echo($errors_msg );
			}
			else if($valeur1 == 1) //is the mdp1 already in the database ? si 1 alors le mdp est déjà là
			{
				echo("mot de passe indisponible, veuillez saisir un nouveau");
			}
			/*else if($valeur1 == 0)
			{
				echo ("OK !");
			}*/
		}
	 
		 if($mdp2 != null)
			 {
					//check no because mdp1 is already checked
				if(strlen($mdp2) < 6  || strlen($mdp2) > 50)
				{
					$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
					echo($errors_msg );
				}
				/*else
				 echo("OK !");*/
			}
		

?>