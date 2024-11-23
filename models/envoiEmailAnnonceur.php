<?php 
	require ('model.php');
	$monEmail = (isset($_POST["mon_email"])) ? htmlentities($_POST["mon_email"]) : NULL;
	$telephone = (isset($_POST["phone_number"])) ? htmlentities($_POST["phone_number"]) : NULL;
	$idAnnonceur = (isset($_POST["idAnnonceur"])) ? htmlentities($_POST["idAnnonceur"]) : NULL;
	$emailAnnonceur = "";
	$pseudonyme ="";
	$titreAnnonce = "";
	$est_une_offre=7;
	$offre="";
	$date_Creation;
	$objet= (isset($_POST["objet_mail"])) ? htmlentities($_POST["objet_mail"]) : NULL;
	$message= (isset($_POST["message_mail"])) ? htmlentities($_POST["message_mail"]) : NULL;
	
	//Get the annonceur mail
	
	$offresChargementPage = getAnnoncePage($idAnnonceur);

		foreach ($offresChargementPage as $result){
			//commandes
				 $emailAnnonceur = $result['email'];
				 $pseudonyme = $result['p_s'];
				 $titreAnnonce = $result['ti_a'];
				 $est_une_offre = $result['e_offre'];
				 $date_Creation = $result['date_crea'];
		//echo ("++++++++++++----------->  - ". $emailAnnonceur);

			}
			
			if($est_une_offre == 0)
			{
				$offre = "demande";
			}
			else
				$offre = "offre";
	
	$errors_msg = "";
	

	 


	 //Les variables
	
	 if($monEmail !=null && $monEmail !="" && 
		$telephone != null  &&
		$emailAnnonceur != null && $emailAnnonceur !="" &&
		$objet != null && $objet !="" &&
		$message != null && $message !="")
	   
	{
		
		//Pas besoin de checker ll'email de l'annonceur
		
		//Contr�le de la quality data email
		$regex = "#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
		$regex2 = "#^[0-9][0-9]{7}[0-9]$#";
		if(!preg_match($regex,$monEmail))
		{
			$errors_msg .= "Mauvais format d'email ;";
			echo($errors_msg );
			
		}
		else if(strlen($monEmail) < 6 || strlen($monEmail) > 50)
		{
			$errors_msg .= " Taille email : minimum = 6 et maximum = 50;</br>";
			echo($errors_msg );
		}
		
		//Contr�le de la quality data tel
		else if(!preg_match($regex2,$telephone))
		{
			 if(!preg_match($regex2,$telephone))
			{
				$errors_msg .= " Le téléphone contient 9 chiffres ;) </br>";
				echo($errors_msg );
			}
		}
		
		
		//Contr�le de la quality data pseudonyme
	
	
		else if(strlen($objet) < 3 || strlen($objet) > 50 )
		{
			$errors_msg .= " Taille de l'objet : minimum = 3 et maximum = 50;</br>";
			echo($errors_msg );
		}
		
		
		//Contr�le de la quality data mdp

		else if(strlen($message) < 1 || strlen($message) > 300)
		{
			$errors_msg .= " Taille du message : minimum = 1 et maximum = 300;</br>";
			echo($errors_msg );
		}
		
		//J'envoie le mail :)
		else
			
		{
			
						//Attention mettre le bon site :)
						
							$fromEmail=$monEmail;
							$fromName="Localhost";
							$toEmail=$emailAnnonceur;
							$toName="";
							$subject=html_entity_decode($objet);
							//AltBody = Body altbody is for those who do,n't have htm capabilities
							$AltBody="
												<h3>Cher(e) ".$pseudonyme.",</h3>
												<p>
												    Vous avez reçu un message concernant : <br/>
													<u>Type annonce</u> : ".$offre." <br/>
													<u>Titre annonce</u> : ".$titreAnnonce." <br/>
													 <u>Date de création</u> : ".$date_Creation ."<br/><br/>
													 </u>Message reçu de</u> :<br/>
													Email : ".$monEmail."  <br/>
													Téléphone :".$telephone." <br/><br/>
													<u>Message</u> : <br/><br/>
													".$message."
													<br/><br/><br/>
													Avec nos remerciements,<br/>
													localhost 
												</p>";
							$Body=$AltBody;
							send_km_mails($fromEmail, $fromName, $toEmail, $toName, $subject, $AltBody, $Body);
			
				
			}
	}			
	else
	{	
			echo ("Veuillez remplir tous les champs !");
		
	}
	


?>

