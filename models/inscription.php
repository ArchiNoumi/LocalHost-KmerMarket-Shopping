<?php 
	require ('model.php');
	$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

	$email = (isset($POST["mon_email"])) ? htmlentities($POST["mon_email"]) : NULL;
	$telephone = (isset($POST["telephone"])) ? htmlentities($POST["telephone"]) : NULL;
	$mdp = (isset($POST["mdp"])) ? htmlentities($POST["mdp"]) : NULL;
	$pseudonyme = (isset($POST["pseudonyme"])) ? htmlentities($POST["pseudonyme"]) : NULL;
	$errors_msg = "";
	

	 


	 //Les variables
	
	 if($email !=null && $email !="" && 
		$telephone != null && $telephone !="" &&
		$mdp != null && $mdp !="" &&
		$pseudonyme != null && $pseudonyme !="")
	   
	{
		
		//Contr�le de la quality data email
		$regex = "#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
		$regex2 = "#^[0-9][0-9]{7}[0-9]$#";
		if(!preg_match($regex,$email))
		{
			$errors_msg .= "Mauvais format d'email ;";
			echo($errors_msg );
			
		}
		else if(strlen($email) < 6 || strlen($email) > 50)
		{
			$errors_msg .= " Taille email : minimum = 6 et maximum = 50;</br>";
			echo($errors_msg );
		}
		
		//Contr�le de la quality data tel
		
		else if(!preg_match($regex2,$telephone))
		{
			$errors_msg .= " Le téléphone contient 9 chiffres;</br>";
			echo($errors_msg );
		}
		
		
		//Contr�le de la quality data pseudonyme
	
	
		else if(strlen($pseudonyme) < 6 || strlen($pseudonyme) > 50 )
		{
			$errors_msg .= " Taille du pseudonyme : minimum = 6 et maximum = 50;</br>";
			echo($errors_msg );
		}
		
		
		//Contr�le de la quality data mdp

		else if(strlen($mdp) < 6 || strlen($mdp) > 50)
		{
			$errors_msg .= " Taille du mot de passe : minimum = 6 et maximum = 50;</br>";
			echo($errors_msg );
		}
		
		//J'enregsitre mon membre :)
		else
			
		{
			//Est-ce le mail, le pseudo, le tel et le mdp djà dans la BDD ?
			//Controls
			$res_mail = control_email($email);
			$res_tel = control_telephone($telephone);
			$res_pseudonyme = control_pseudonyme($pseudonyme);
			$res_mdp = control_mot_de_passe($mdp);
			if($res_mail == 0 && $res_tel == 0 && $res_pseudonyme==0 && $res_mdp==0)
			{
				$result = false;
				//Enter the data of the member in the database renvoie true si tout c bien pass�
				$result = saveMembre($email, $mdp, $pseudonyme, $telephone);
				if ($result)
				{
					//Creation du tocken
					$token = get_the_real_token();
					//Enregistrememnt du token
					$update_token = update_token_creation_compte_base_on_email($email, $token);
					//Evoie du mail (cr)
					if($update_token)
					{
						//For localhost
						update_is_active($email ,  $token);
						//activate the token
						$membre = getMembreByTockenActivation($token);
						//get the pseudonyme from membre
							if($membre!=null)
							{
								$pseudonyme = $membre['pseudo'];
								$_SESSION['pseudonyme'] = $pseudonyme;
								save_date_derniere_connexion($pseudonyme);
							}


							//Attention pour localhost
							$link_Connection= "../comptes/connection.php";
							echo "<script>
									window.location.href = '../comptes/connection.php';
								</script>";
							//Send Mail to the member for activation online, not offline
							
							//header('Location: '. $link_Connection);

							exit();
					}
					else //fail to save the member so delete if enter in database
					{
						//Delete compte
						if(delete_Membre($email))
						{
							echo("Nous n'avons pas pu créer votre compte, Merci de reéssayer :)");
						}
						
					}
					
				}
				else
				{
					echo ("Nous n'avons pas pu crééer votre compte, merci de reéssayer :)</br>");
				}
			}
			else
			{
				echo (" Veuillez changer votre pseudonyme et/ou mot de passe :) <br/>");
			}
			
		}
	
		
		
		
	
	}
				
	else
	{	
			echo ("Veuillez remplir tous les champs !");
		
	}
	


?>

