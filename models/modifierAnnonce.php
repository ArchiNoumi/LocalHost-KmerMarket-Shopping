<?php

	session_start();
	require '../models/model.php';
	//connection à la bdd
	
	//entier
	$id_ann = intval(htmlspecialchars($_GET['ann']));
	
	$offre = htmlspecialchars($_POST['Type_Annonce']);
	//echo("offre ".$offre);
	$region = htmlspecialchars($_POST['Region']);
	
	$ville = htmlspecialchars($_POST['Ville']);
	
	$categorie_annonce = htmlspecialchars($_POST['categorie_annonce']);
	
	//Suppression des espaces en début et fin
	$titre_annonce = trim(htmlspecialchars($_POST['titre_annonce']));
	
	$details_annonce = trim(htmlspecialchars($_POST['detail_annonce']));
	
	$prix = htmlspecialchars($_POST['prix']);
	//Enlever les espaces 
	$prix = preg_replace('/ /', '', $prix);
	
	$etre_contacte_par_email = htmlspecialchars($_POST['radio_etre_contacte']);
	$pseudoUser = $_SESSION['pseudonyme'];
	$idMembre = getIdMembreByPseudo($pseudoUser);
	
	$stateSave =0;
	
	
	//In vérifie si nos variables du formulaire sont définies
	
	if(!empty($id_ann) && 
		isset($offre) &&
		isset($region) &&
		isset($ville) &&
		isset($categorie_annonce) &&
		isset($titre_annonce) &&
		isset($details_annonce) &&
		isset($prix) &&
		isset($etre_contacte_par_email) &&
		isset($idMembre)
		) 
	{
		
		
		//Contrôlele du prix
		$regex_prix = "#^[1-9][0-9]{0,8}[0|5]$#";
		
		//1 le titre :)
		if(strlen($titre_annonce)-1 > 50)
		{
			echo("Le titre compte 50 caractères maximum :) ".strlen($titre_annonce));
		}
		//2 Le Texte :) -4 pour des raisons encore inconnues ??
		else if(strlen($details_annonce)-4 > 300)
		{
			echo("Le détails compte 300 caractères maximum :) ".strlen($details_annonce));
			
		}
		//3 Le prix :)
		else if(!preg_match($regex_prix, $prix) OR $prix%5!=0)
		{
			echo("Le prix compte 10 chiffres maximum, et se termine par 0 ou 5 :)");
		}
		else //Je peux enregistrer mon ANNONCE Wéééééééééééééééé
		{
			//MoDIFIER L'ANNONCE
			update_Annonce_multiparam($id_ann, $ville, $categorie_annonce, $prix, $titre_annonce, $details_annonce, $offre, $etre_contacte_par_email);
			//récupérons les photo existances
			
					//S'il y en a alors on update sinon on insert 
					
					//La liste des photos
					$photos = getPhotoByIdAnnonce($id_ann);
					$pic_premier = "";
					$pic_deuxieme = "";
					$pic_troisieme = "";
				
				if($photos != null)
				{
					foreach ($photos as $photo)
					{
						if($photo['filDesc']=="1")
						{
							$pic_premier = "1";
						}
						else if($photo['filDesc']=="2")
						{
							$pic_deuxieme = "2";
						}
						else if($photo['filDesc']=="3")
						{
							$pic_troisieme = "3";
						}
					}
					
				}
				$job=true;
				while($job)
				{
					$extensions_autorisees = array('jpeg', 'png', 'bmp', 'gif', 'x-ms-bmp', 'jpg', 'JPEG', 'JPG', 'PNG', 'GIF', 'BMP' );
					
					//********************************************************* CREATION DES PHOTOS ***************************************************************************//		
								//1 Testons si les fichier a bien 굩 envoy顥t s'il n'y a pas d'erreur
						if(isset($_FILES['inputPic1']) AND $_FILES['inputPic1']['error'] == 0 AND $pic_premier=="" )
						{
							//echo("a");
							//Testons si le fichier n'est pas trop lourd
							if($_FILES['inputPic1']['size'] <= 3000000)
							{
								//Testons si l'extension est autorisꥍ
									$infosfichier = pathinfo($_FILES['inputPic1']['name']);
									$extension_upload = $infosfichier['extension'];
									//$extensions_autorisees = array('jpeg', 'png', 'bmp', 'x-ms-bmp', 'jpg' );
									$nom = "";
									
								if(in_array($extension_upload, $extensions_autorisees))
								{
										//On peut valider le fichier et le stocker dꧩnitivement ࡣet endroit upload est un dossier du site !!!!
										$nom = "../img/uploads/pics_1/{$id_ann}.{$idMembre}.{$extension_upload}";
										$resultat = move_uploaded_file($_FILES['inputPic1']['tmp_name'], $nom);
										//if($resultat) echo "L'envoi a été effectué:) !!!";
									
									
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
									$description = "1";
									//save pic
									
									/*echo("id ann = ".$id_ann."file name = ".
										$file_name."file_title = ".$file_title." file size = ".$file_size." file final name = ". 
										$file_final_name." date creation = ".$date_creation_photo." description = ".$description);*/
									//check if there is already à photo at this position for the announce
									//checkExisting
									save_photo_annonce($id_ann,
										$file_name, $file_title, $file_size, 
										$file_final_name,$date_creation_photo, $description);
									
									$stateSave = 1;
								}
								else
								{
									$stateSave = -1;
									//Le format d'images n'est pas bon
									echo '<body onLoad="alert(\'Mauvais format d\'image. Veuillez choisir une autre image \')">';
									
									echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
								}									
									
							}
							else
							{
									$stateSave = -1;
									//echo 'L\'image principale est trop lourde, Taille maximum 3 MO';
									echo '<body onLoad="alert(\'Image principale est de 3 Méga Octets max\')">';
									echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
							}
						}
							
						//INSERER LA PHOTO ******************    2        **************************
						
						//1 Testons si les fichier a bien 굩 envoy顥t s'il n'y a pas d'erreur
						if(isset($_FILES['inputPic2']) AND $_FILES['inputPic2']['error'] == 0 AND $pic_deuxieme=="")
						{
							//Testons si le fichier n'est pas trop lourd
							if($_FILES['inputPic2']['size'] <= 3000000)
							{
								//Testons si l'extension est autorisꥍ
									$infosfichier = pathinfo($_FILES['inputPic2']['name']);
									$extension_upload = $infosfichier['extension'];
									//$extensions_autorisees = array('jpeg', 'png', 'bmp', 'x-ms-bmp', 'jpg' );
									$nom = "";
									
									if(in_array($extension_upload, $extensions_autorisees))
									{
										//On peut valider le fichier et le stocker dꧩnitivement ࡣet endroit upload est un dossier du site !!!!
										$nom = "../img/uploads/pics_2/{$id_ann}.{$idMembre}.{$extension_upload}";
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
										$description = "2";
										//save pic
										
									 save_photo_annonce($id_ann,
										$file_name, $file_title, $file_size, 
										$file_final_name,$date_creation_photo, $description);
										$stateSave = 2;
									}
									else
									{
										$stateSave = -1;
										//Le format d'images n'est pas bon
										echo '<body onLoad="alert(\'Mauvais format d\'image. Veuillez choisir une autre image \')">';
										echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
										
									}


										
									
							}
							else
							{
								$stateSave = -1;
								echo '<body onLoad="alert(\'Image 2 est de 3 Méga Octets max\')">';
								echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
							}
						}
						
						//INSERER LA PHOTO ******************    3        **************************
						
						//1 Testons si les fichier a bien 굩 envoy顥t s'il n'y a pas d'erreur
						if(isset($_FILES['inputPic3']) AND $_FILES['inputPic3']['error'] == 0 AND $pic_troisieme =="")
						{
							//Testons si le fichier n'est pas trop lourd
							if($_FILES['inputPic3']['size'] <= 3000000)
							{
								//Testons si l'extension est autorisꥍ
								$infosfichier = pathinfo($_FILES['inputPic3']['name']);
								$extension_upload = $infosfichier['extension'];
								//$extensions_autorisees = array('jpeg', 'png', 'bmp', 'x-ms-bmp', 'jpg' );
								$nom = "";
								
								if(in_array($extension_upload, $extensions_autorisees))
								{
									//On peut valider le fichier et le stocker dꧩnitivement ࡣet endroit upload est un dossier du site !!!!
									$nom = "../img/uploads/pics_3/{$id_ann}.{$idMembre}.{$extension_upload}";
									$resultat = move_uploaded_file($_FILES['inputPic3']['tmp_name'], $nom);
									//if($resultat) echo "L'envoi a 굩 effectu頺) !!!";
								
								
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
									
									$description = "3";
									//save pic
									 save_photo_annonce($id_ann,
										$file_name, $file_title, $file_size, 
										$file_final_name,$date_creation_photo, $description);
													
									$stateSave = 3;
								}
								else
								{
										$stateSave = -1;
										//Le format d'images n'est pas bon
										echo '<body onLoad="alert(\'Mauvais format d\'image. Veuillez choisir une autre image \')">';
										echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
								}
							}
							else
							{
								$stateSave = -1;
								echo '<body onLoad="alert(\'Image 3 est de 3 Méga Octets max\')">';
								echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
							}
						}
						if($stateSave>= 0 )//$stateSave==3 OR $stateSave==0)
						{
							//Bravo l'annonce a été créée !!!!!
							echo '<body onLoad="alert(\'Bravo votre annonce a correctement été modifiée\')">';
							echo '<meta http-equiv="refresh" content="0;URL=../annonces/detailMonAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
						}
						else
						{
							//delete the offer
							//supprimer_Annonce_Via_id($id_annonce);
							//Ici l'annonce n'a pas été créée ! malheureusement
							echo '<body onLoad="alert(\' L\'annonce n\'a pas été modifiée, veuillez essayer à nouveau\')">';
							//echo $errorMessage;
							echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php?pseu='.$pseudoUser.'&ann='.$id_ann.'">';
							//$idMembre = $MEMBRE['idm'];
							//echo ('id du membre = '.$idMembre.' le pseudonyme = '.$_SESSION['pseudonyme']);
						}
						
					
								$job=false;
				}//end while
		
			
					//echo("1");	
					//echo '<body onLoad="alert(\'Bravo votre annonce a correctement été modifiée\')">';
					//echo '<meta http-equiv="refresh" content="0;URL=../annonces/mesAnnonces.php">';
		}
		
		
					
	}	
	else
	{
		echo ("Veuillez remplir tous les champs :)");
	}	
	
?>