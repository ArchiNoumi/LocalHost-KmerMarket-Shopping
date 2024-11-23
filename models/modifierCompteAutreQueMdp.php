<?php
	session_start();
	require 'model.php';
	$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
	//MODIFICATION DU COMPTE SANS TENIR COMPTE DU MOT DE PASSE
		$pseudo = (isset($POST["pseudonyme"])) ? htmlentities($POST["pseudonyme"]) : NULL;
		$mail = (isset($POST["mon_email"])) ? htmlentities($POST["mon_email"]) : NULL;
		$mdp = (isset($POST["mdp"])) ? htmlentities($POST["mdp"]) : NULL;
		$tel = (isset($POST["telephone"])) ? htmlentities($POST["telephone"]) : NULL;
		
		$Membre= getMembreByPseudo($_SESSION['pseudonyme']);
		$idMembre = $Membre['idm'];
		//Gère les msg d'erreur
		$errors_msg = "";
		//Contrôle de la qualité des données 
		  //Email
			$regex = "#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
			$regex2 = "#^[0-9][0-9]{7}[0-9]$#";
			if(!preg_match($regex,$mail))
			{
				$errors_msg .= "Mauvais format d'email ;";
				echo($errors_msg );
				
			}
			else if(strlen($mail) < 6 || strlen($mail) > 50)
			{
				$errors_msg .= " Taille email : minimum = 6 et maximum = 50;</br>";
				echo($errors_msg );
			}
			  //Telephone
			else if(!preg_match($regex2,$tel))
			{
				$errors_msg .= " Le téléphone contient 9 chiffres;</br>";
				echo($errors_msg );
			}
		  //Mot de passe
		    else if(strlen($mdp) < 6 || strlen($mdp) > 50)
			{
				$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
				echo($errors_msg );
			}
		  //Pseudonyme
		    else if(strlen($pseudo) < 6 || strlen($pseudo) > 50)
			{
				$errors_msg .= " Taille du pseudonyme : minimum = 6 et maximum = 50;</br>";
				echo($errors_msg );
			}
			else
			{
				$valeur  = compare_mdp_mdpDeLaBDD($mdp, $idMembre);
					//Get the Membre
				
				//Comparer le mot de passe
			
				if($valeur == "OK" && isset($pseudo) && isset($mail) && isset($mdp) && isset($tel) )
				{
								//Use the function
					update_Membre_sans_updaterMdp($idMembre, $tel, $pseudo, $mail);
					//echo("1");
					$fromEmail="Noreply@localhost.com";;
							$fromName="Localhost support";
							$toEmail=$mail;
							$toName=$pseudo;
							$subject="Modifications du compte :)";
							
							//AltBody = Body altbody is for those who do,n't have htm capabilities
							$AltBody="
												<h3>Cher(e) ".$pseudo.",</h3>
												<p>
												    Vos informations sont à présent :<br/>
													email : ".$mail."<br/>
													mot de passe : ".$mdp."<br/>
													téléphone : ".$tel."<br/>
													<br/>
													Avec nos remerciements,<br/>
													localhost 
												</p>";
							$Body=$AltBody;

							//Bravo l'annonce a été créée !!!!!
							echo '<body onLoad="alert(\'Bravo votre compte a correctement été modifié\')">';
							echo '<meta http-equiv="refresh" content="0;URL=../comptes/compte.php?pseu='.$pseudo.'">';
							//LOCALHOST NO NEED TO SEND INFOR IN MAIL
						
					//header('Location: /KmerMarketFinal/comptes/compte.php?pseu='.$pseudo.' ');
											
				}
				else
				{
					echo("Les modifications n'ont pas prise en compte !");
					//header('Location: /KmerMarketFinal/comptes/compte.php?pseu='.$_SESSION["pseudonyme"].' ');
				}
				
			}
		  
		
		
		
	
	
		
		


?>