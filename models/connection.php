<?php
	ini_set('session.cookie_domain', '.kmermarket.com');
	session_start();
	require ('model.php');
	$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

	$email = (isset($POST["mon_email"])) ? htmlentities($POST["mon_email"]) : NULL;
	$email2 = (isset($POST["mon_email2"])) ? htmlentities($POST["mon_email2"]) : NULL;
	$mdp = (isset($POST["mdp"])) ? htmlentities($POST["mdp"]) : NULL;
	
	$errors_msg = "";
	
	//echo ('$email =  '.$email.'	$mdp = '.$mdp);
	
	
	//Les variables
	
	
	if($email !=null && $email !="" && $mdp !=null && $mdp !="")
	{
		//Email controls :)
		$regex = "#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
		if(!preg_match($regex,$email))
		{
			$errors_msg .= "Mauvais format d'email";
			echo($errors_msg );
			
		}
		else if(strlen($email) < 6 || strlen($email) > 50)
		{
			$errors_msg .= " Taille email : minimum = 6 et maximum = 50;</br>";
			echo($errors_msg );
		}
		//Mdp controle
		else if(strlen($mdp) < 6 || strlen($mdp) > 50)
		{
			$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
			echo($errors_msg );
		}
		//je v�rifie que le mail et le mdp appartiennent au m�me membre
		else
		{
			//Est ce qu'il est activé ? 1 = oui, 0 = non
			$isActiveAccount = get_activation_account_status($email, $mdp);
			$pseudonyme = email_et_mdp_au_meme_membre($email, $mdp);
			//echo('$pseudonyme  = '.$pseudonyme );
			
			if($isActiveAccount==0 && $pseudonyme != null)
			{
				$errors_msg .= " Veuillez consulter votre couriel, afin d'activer votre compte;</br>";
				echo($errors_msg );
			}
			//est ce que le mail et le mot de passe ont un pseudo ?
			
			else if($pseudonyme != null)
			{
				$_SESSION['pseudonyme'] = $pseudonyme;
				//set the isConnected to
				//echo('$pseudonyme = '.$_SESSION['pseudonyme']); 
				
				
				//1 c'est on c'est ok pour la connection :)
				//enregistrer la date de derniere connection :) important pour le cleaning the la base :)
				//connection only when it's 1
				//echo($pseudonyme);
					$vatt =  save_date_derniere_connexion($pseudonyme);
					if($vatt== 1)
					{
						echo ($pseudonyme.'&prepre=preprerat');
					}
				//echo(save_date_derniere_connexion($pseudonyme));
				
				//echo ("1");
			}
			else
			{
				echo ("Le mot de passe et l'email ne sont pas reconnus :)".$pseudonyme.$mdp);
			}
			
			
			
		}
	}
	//MOT DE PASSE OUBLIE :)
	else if($email2 != null && $email2 !="")
	{
		$res1 = control_email($email2);
		if($res1 == 1)
		{
			//Create mdp
			$mdp2=generate_random_password();
			
			//update the password
			$res2 = update_mdp_forget_base_on_email($email2, $mdp2);
			//trouver le pseudonyme à partir du mail et du mot de passe
			$pseudonyme = email_et_mdp_au_meme_membre($email2, $mdp2);
			if($res2 ) //that's good sign
			{
				$fromEmail="Noreply@localhost.com";
							$fromName="Localhost support";
							$toEmail=$email2;
							$toName=$pseudonyme;
							$subject="Nouveau mot de passe :)";
							
							//AltBody = Body altbody is for those who do,n't have htm capabilities
							$AltBody="
												<h3>Cher(e) ".$pseudonyme.",</h3>
												<p>
												    Vos identifiants sont à présent :<br/>
													email : ".$email2."<br/>
													mot de passe : ".$mdp2."<br/>
													
													<br/>
													Avec nos remerciements,<br/>
													localhost 
												</p>";
							$Body=$AltBody;
							send_km_mails($fromEmail, $fromName, $toEmail, $toName, $subject, $AltBody, $Body);
			
				//echo("veuillez consulter votre boîte email, puis connectez vous de nouveau :)");
				
			}
			else
			{
				echo("Nous n'avons pas pu traiter votre demande, merci de renseigner de nouveau votre mot de passe :)");
			}
			//Update mdp
			
		}
		else //Mbom cet email n'est pas reconnu
		{
			echo("Cet email n'est pas reconnu :) ");
		}
	}
	else
	{
		echo("Veuillez remplir tous les champs :)");
	}

	
?>