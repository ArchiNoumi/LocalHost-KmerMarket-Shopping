<?php 
	session_start();
	require '../models/model.php';
	
	
	//Offre ou demande
	$offre = htmlspecialchars($_POST['Type_Annonce']);
	$region = htmlspecialchars($_POST['Region']);
	$ville = htmlspecialchars($_POST['Ville']);
	$categorie_annonce = htmlspecialchars($_POST['categorie_annonce']);
	$titre_annonce = htmlspecialchars($_POST['titre_annonce']);
	$details_annonce = htmlspecialchars($_POST['detail_annonce']);
	$prix = htmlspecialchars($_POST['prix']);
	//Remove all space from the price
	$prix = preg_replace('/\s+/', '', $prix);
	$etre_contacte_par_email = htmlspecialchars($_POST['radio_etre_contacte']);
	$langue = "FR";
	$isVisible = 1;
	$stateSave =0;
	$pseudoUser = $_SESSION['pseudonyme'];
	$errorMessage = "Erreur : \n";
	
	 //
	 //echo ('Le Prix ----------------------->  '.$prix);
	//echo ('titre annonce = '.$titre_annonce.'  offre = '.$offre. ' region = '.$region.'
	//    ville = '.$ville.' catégorie annonce = '.$categorie_annonce.' Texte annonce = '.
	//$details_annonce.' prix = '.
	//$prix.'F CFA,  être contacté par email = '.$etre_contacte_par_email);
	
	//La date du jour
	$jour = date('d');
				$mois = date('m');
				$annee = date('Y');
				$heure = date('H');
				$minute = date('i');
				$seconde = date('s');
				$dateCreation = $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute.':'.$seconde;
	
//1 Find the id of the member
	$idMembre = getIdMembreByPseudo($pseudoUser); //$_SESSION['pseudonyme']);
	if(isset($offre) &&
		isset($region) && 
		isset($ville) && 
		isset($categorie_annonce) && 
		isset($titre_annonce) && 
		isset($details_annonce) && 
		isset($prix) && 
		isset($etre_contacte_par_email) 
		&& !empty($titre_annonce )
		&& $titre_annonce !='...'
		&& !empty($titre_annonce)
		&& !empty($prix)
		
		)
		
		{
			//On check le prix est-il correct ?
			$prix = preg_replace('/\s+/', '', $prix);
			$regEntier = '#^[1-9][0-9]{0,8}[0|5]$#';
			if(!preg_match($regEntier,$prix))
			{
				echo '<body onLoad="alert(\'Le prix : \n Veuillez entrer uniquement des chiffres se terminant par 0 ou 5 \n minimum 5 F CFA\')">';
				echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
			}
			
			else
			{
				
			
				sauverAnnonce($idMembre, $ville, $categorie_annonce, $prix, $titre_annonce,
							$details_annonce, $isVisible, $offre, $dateCreation, $etre_contacte_par_email, $langue );
				
				//Récupérer la dernière annonce créée
				$id_annonce = get_derniere_id_annonce_enregistree($idMembre);
				//echo('id de la nouvelle annonce '.$id_annonce );
				
				//liste des extensions
				$extensions_autorisees = array('jpeg', 'png', 'bmp', 'gif', 'x-ms-bmp', 'jpg', 'JPEG', 'JPG', 'PNG', 'GIF', 'BMP' );
				
				//INSERER LA photo PRINCIPALE******************    1        **************************
				
				//1 Testons si les fichier a bien été envoyé et s'il n'y a pas d'erreur
				if(isset($_FILES['inputPic1']) AND $_FILES['inputPic1']['error'] == 0 )
				{
					//Testons si le fichier n'est pas trop lourd
					//echo('La taille de image broooooooooooooooo        '.$_FILES['inputPic1']['size']);
					
					//if($_FILES['inputPic1']['size'] <= 3000000)
					if($_FILES['inputPic1']['size'] <= 3000000)
					{
						//Testons si l'extension est autorisée
							$infosfichier = pathinfo($_FILES['inputPic1']['name']);
							$extension_upload = $infosfichier['extension'];
							
							$nom = "";
							
							if(in_array($extension_upload, $extensions_autorisees))
							{
								//On peut valider le fichier et le stocker définitivement à cet endroit upload est un dossier du site !!!!
								$nom = "../img/uploads/pics_1/{$id_annonce}.{$idMembre}.{$extension_upload}";
								$resultat = move_uploaded_file($_FILES['inputPic1']['tmp_name'], $nom);
								//if($resultat) echo "L'envoi a été effectué :) !!!";
							
							
									$file_name = ($_FILES['inputPic1']['name']);
									$file_size = $_FILES['inputPic1']['size'];
									$file_title =  basename($_FILES['inputPic1']['name'],$extension_upload).PHP_EOL;;
									$file_final_name = substr($nom,3);
									$date_creation_photo;
									//Date concatenate
									$jour = date('d');
									$mois = date('m');
									$annee = date('Y');
									$heure = date('H');
									$minute = date('i');
									$seconde = date('s');
									$date_creation_photo = $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute.':'.$seconde;
									//A effacer après :)
									/*
									echo('    les données de l\'image file name = '.$file_name.
											'  file_title = '.$file_title.'  file size = '.$file_size.' FILE_FINAL_NAME =  '
											.$file_final_name.' DATE_CREATION = '.$date_creation_photo);*/
									
									//Enregistrere photo annonce
									$description = "1";
									save_photo_annonce($id_annonce,
														$file_name, $file_title, $file_size, 
															$file_final_name,$date_creation_photo, $description);
								
								$stateSave = 1;
														
							}
							else
							{
								$stateSave = -1;
								//Le format d'images n'est pas bon
								echo '<body onLoad="alert(\'Mauvais format d\'image. Veuillez choisir une autre image \')">';
								echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
								//Le format d'images n'est pas bon
								//echo ("");
							}
					}
					else
					{
						$stateSave = -1;
						//echo 'L\'image principale est trop lourde, Taille maximum 3 MO';
						echo '<body onLoad="alert(\'Image principale est de 3 Méga Octets max\')">';
						echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
					}
				}
					
				//INSERER LA photo ******************    2        **************************
				
				//1 Testons si les fichier a bien été envoyé et s'il n'y a pas d'erreur
				if(isset($_FILES['inputPic2']) AND $_FILES['inputPic2']['error'] == 0)// AND $stateSave >=0)
				{
					//Testons si le fichier n'est pas trop lourd
					if($_FILES['inputPic2']['size'] <= 3000000)
					{
						//Testons si l'extension est autorisée
							$infosfichier = pathinfo($_FILES['inputPic2']['name']);
							$extension_upload = $infosfichier['extension'];
							$nom = "";
							
							if(in_array($extension_upload, $extensions_autorisees))
							{
								//On peut valider le fichier et le stocker définitivement à cet endroit upload est un dossier du site !!!!
								$nom = "../img/uploads/pics_2/{$id_annonce}.{$idMembre}.{$extension_upload}";
								$resultat = move_uploaded_file($_FILES['inputPic2']['tmp_name'], $nom);
								//if($resultat) echo "L'envoi a été effectué :) !!!";
							
							
								$file_name = ($_FILES['inputPic2']['name']);
								$file_size = $_FILES['inputPic2']['size'];
								$file_title =  basename($_FILES['inputPic2']['name'],$extension_upload).PHP_EOL;;
								$file_final_name = substr($nom,3);
								$date_creation_photo;
								//Date concatenate
								$jour = date('d');
								$mois = date('m');
								$annee = date('Y');
								$heure = date('H');
								$minute = date('i');
								$seconde = date('s');
								$date_creation_photo = $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute.':'.$seconde;
								/*echo('    les données de l\'image file name = '.$file_name.
										'  file_title = '.$file_title.'  file size = '.$file_size.' FILE_FINAL_NAME =  '
										.$file_final_name.' DATE_CREATION = '.$date_creation_photo);*/
								
								$description = "2";
								save_photo_annonce($id_annonce,
															$file_name, $file_title, $file_size, 
															$file_final_name,$date_creation_photo, $description);
									$stateSave = 2;			
							}
							else
							{
								$stateSave = -1;
								//Le format d'images n'est pas bon
								echo '<body onLoad="alert(\'Mauvais format d\'image. Veuillez choisir une autre image \')">';
								echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
							}
					}
					else
					{
						$stateSave = -1;
						echo '<body onLoad="alert(\'Image 2 est de 3 Méga Octets max\')">';
						echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
					}
				}
				
				//INSERER LA photo ******************    3        **************************
				
				//1 Testons si les fichier a bien été envoyé et s'il n'y a pas d'erreur
				if(isset($_FILES['inputPic3']) AND $_FILES['inputPic3']['error'] == 0)// AND $stateSave >=0)
				{
					//Testons si le fichier n'est pas trop lourd
					if($_FILES['inputPic3']['size'] <= 3000000)
					{
						//Testons si l'extension est autorisée
						$infosfichier = pathinfo($_FILES['inputPic3']['name']);
						$extension_upload = $infosfichier['extension'];
						$nom = "";
						
						if(in_array($extension_upload, $extensions_autorisees))
						{
							//On peut valider le fichier et le stocker définitivement à cet endroit upload est un dossier du site !!!!
							$nom = "../img/uploads/pics_3/{$id_annonce}.{$idMembre}.{$extension_upload}";
							$resultat = move_uploaded_file($_FILES['inputPic3']['tmp_name'], $nom);
							//if($resultat) echo "L'envoi a été effectué :) !!!";
						
						
							$file_name = ($_FILES['inputPic3']['name']);
							$file_size = $_FILES['inputPic3']['size'];
							$file_title =  basename($_FILES['inputPic3']['name'],$extension_upload).PHP_EOL;;
							$file_final_name = substr($nom,3);
							$date_creation_photo;
							//Date concatenate
							$jour = date('d');
							$mois = date('m');
							$annee = date('Y');
							$heure = date('H');
							$minute = date('i');
							$seconde = date('s');
							$date_creation_photo = $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute.':'.$seconde;
							/*echo('    les données de l\'image file name = '.$file_name.
									'  file_title = '.$file_title.'  file size = '.$file_size.' FILE_FINAL_NAME =  '
									.$file_final_name.' DATE_CREATION = '.$date_creation_photo);*/
									
							$description = "3";
								save_photo_annonce($id_annonce,
															$file_name, $file_title, $file_size, 
															$file_final_name,$date_creation_photo, $description);
							$stateSave = 3;
						
						}
						else
						{
							$stateSave = -1;
							//Le format d'images n'est pas bon
							echo '<body onLoad="alert(\'Mauvais format d\'image. Veuillez choisir une autre image \')">';
							echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
						}
					}
					else
					{
						$stateSave = -1;
						echo '<body onLoad="alert(\'Image 3 est supérieur est de 3 Méga Octets !\')">';
						echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
					}
				
											
						
				
				}
				
				if($stateSave>= 0 )//$stateSave==3 OR $stateSave==0)
				{
					//Bravo l'annonce a été créée !!!!!
					echo '<body onLoad="alert(\'Bravo votre annonce a correctement été enregistrée\')">';
					echo '<meta http-equiv="refresh" content="0;URL=../annonces/detailMonAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_annonce.'">';
				}
				else
				{
					//delete the offer
					supprimer_Annonce_Via_id($id_annonce);
					//Ici l'annonce n'a pas été créée ! malheureusement
					echo '<body onLoad="alert(\' L\'annonce n\'a pas été créée, veuillez essayer à nouveau\')">';
					//echo $errorMessage;
					echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
					//$idMembre = $MEMBRE['idm'];
					//echo ('id du membre = '.$idMembre.' le pseudonyme = '.$_SESSION['pseudonyme']);
				}
		}	
}
else{
				//Ici l'annonce n'a pas été créée ! malheureusement
				echo '<body onLoad="alert(\' Erreur : \n Aucune annonce créée, veuillez remplir : \n le titre; \n la description et; \n le prix (minimum 5 F CFA)\')">';
				echo '<meta http-equiv="refresh" content="0;URL=../annonces/creerAnnonce.php?pseu='.$pseudoUser.'">';
				//$idMembre = $MEMBRE['idm'];
				//echo ('id du membre = '.$idMembre.' le pseudonyme = '.$_SESSION['pseudonyme']);
	}
	
	
	
?>