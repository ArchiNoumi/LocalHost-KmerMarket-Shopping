<?php
	session_start();
	//Si problème d'encodage, utiliser utf8_encode($var);
	//For sharing
				require_once '../libs/MobileDetect/Mobile_Detect.php';	
?>
<?php

header("Content-Type: text/xml");
$xml = new DOMDocument("1.0", 'UTF-8');
$xml->formatOutput=true;
$list=$xml->createElement("list");
$xml->appendChild($list);

$id_valueTypeAnn = (isset($_POST["Type_Annonce"])) ? htmlentities($_POST["Type_Annonce"]) : NULL;
$id_Region = (isset($_POST["Region"])) ? htmlentities($_POST["Region"]) : NULL;
$id_Ville = (isset($_POST["Ville"])) ? htmlentities($_POST["Ville"]) : NULL;
$id_categorie_annonce = (isset($_POST["Categorie_annonce"])) ? htmlentities($_POST["Categorie_annonce"]) : NULL;
$titre_rechercher = (isset($_POST["title"])) ? htmlentities($_POST["title"]) : NULL;

if($titre_rechercher != NULL)
{
	$titre_rechercher = trim($titre_rechercher);
}

$choix_tri_annonce = (isset($_POST["Tri_ann"])) ? htmlentities($_POST["Tri_ann"]) : NULL;
//préparation de la liste des annonces en fonction du choix de tri !

$string_requete = "";
if($choix_tri_annonce != null)
{
	if($choix_tri_annonce =="recent_ancien")
	{
		$string_requete = " annonce.ID_ANNONCE DESC";
	}
	else if($choix_tri_annonce =="ancien_recent")
	{
		$string_requete = " annonce.ID_ANNONCE";
	}
	else if($choix_tri_annonce =="prix_decroissants")
	{
		$string_requete = " PRIX_ANNONCE DESC";
	}
	else if($choix_tri_annonce =="prix_croissants")
	{
		$string_requete = " PRIX_ANNONCE ";
	}
	else
	{
		$string_requete = " annonce.ID_ANNONCE DESC";
	}

	require 'model.php';
	//Attention on a pas idRegion :)
		if ($id_valueTypeAnn != null && $id_Ville != null && $id_categorie_annonce != null && $choix_tri_annonce != null && $id_Region != null)// && $titre_rechercher != "") 
		{
			
					
				
						$query = get_annonces_multiparam_AVEC_titre_no_pagination( $id_Ville, 
											$id_valueTypeAnn, $id_categorie_annonce, 
											$titre_rechercher, $string_requete, $id_Region);
					
				//Le total est calculé directement au nivo du Js :  Comptage du nombre de lignee de ma liste :)
				
				//Get is mobile or PC
								$detect = new Mobile_Detect;
								$isMobile = false;
								if($detect->isMobile())
								{
								   $isMobile = true;
								}	
								


					foreach($query as $back)
					{
						$photo = getPhotoPrincipaleByIdAnnonce($back["id_a"]);
								if($photo != null)
								{
									
								
										$item=$xml->createElement("item");
										$list->appendChild($item);
										
										$href=$xml->createElement("href",$back["id_a"]);
										$src=$xml->createElement("src", htmlspecialchars($photo["filFinName"]));
										$alt=$xml->createElement("alt", "principale");
										$h3=$xml->createElement("h3",htmlspecialchars($back["ti_a"]));
										$em=$xml->createElement("em",$back["ville_nom_fr"]);
										$h5=$xml->createElement("h5", formater_Prix($back["p_a"]));
										$p_p_p=$xml->createElement("p",formater_Texte_Annonce_Index($back["te_a"]));
										
										//Share it stuff urldecode(url link)
										//ATTENTION AJout de (https://) localhost
										$textLink = urlencode("localhost/annonces/detailAnnonce.php?ann=".$back["id_a"]);
										
										//Est ce du mobile
										if($isMobile)
										{
												//Twitter
											$shareTwitter=$xml->createElement("shareTwitter","https://twitter.com/intent/tweet?ref_src=".$textLink);
													//Whatsapp
											$shareWhatsapp=$xml->createElement("shareWhatsapp","https://web.whatsapp.com/send?text=".$textLink);
													//Facebook
																/*
																"https://www.facebook.com/plugins/share_button.php?href=".$textLink."
															http://chillyfacts.com/create-facebook-share-button-for-website-webpages/&l
															ayout=button&size=small&mobile_iframe=true&width=60&height=20&appId" */
										    //L'autre lien est fait dans le JS
											$shareFacebook=$xml->createElement("shareFacebook","https://www.facebook.com/plugins/share_button.php?href=".$textLink);
										}
										else
										{
											//Twitter
											//Twitter
											$shareTwitter=$xml->createElement("shareTwitter","https://twitter.com/intent/tweet?ref_src=".$textLink);
											
													//Whatsapp
											$shareWhatsapp=$xml->createElement("shareWhatsapp","whatsapp://send?text=".$textLink);
													//Facebook
											$shareFacebook=$xml->createElement("shareFacebook","https://www.facebook.com/plugins/share_button.php?href=".$textLink);
										}
										
										
									
										$item->appendChild($href);
										$item->appendChild($src);
										$item->appendChild($alt);	
										$item->appendChild($h3);
										$item->appendChild($em);
										$item->appendChild($h5);
										$item->appendChild($p_p_p);
										//share stuff
										$item->appendChild($shareTwitter);
										$item->appendChild($shareWhatsapp);
										$item->appendChild($shareFacebook);
										
										
									
									
								}
								else
								{
									/*echo"<item>
										<href>".$back["id_a"]. "</href>
										<src>#</src>
										<alt>#</alt>
										<h3>".($back["ti_a"])."</h3>
										<em>".($back["ville_nom_fr"])."</em>
										<h5>".formater_Prix($back["p_a"])."</h5>
										<p>".(formater_Texte_Annonce_Index($back["te_a"]))."</p>
										</item>";
										*/
										
										$item=$xml->createElement("item");
										$list->appendChild($item);
										
										$href=$xml->createElement("href",$back["id_a"]);
										$src=$xml->createElement("src", "#");
										$alt=$xml->createElement("alt", "#");
										$h3=$xml->createElement("h3",htmlspecialchars(($back["ti_a"])));
										$em=$xml->createElement("em",$back["ville_nom_fr"]);
										$h5=$xml->createElement("h5", formater_Prix($back["p_a"]));
										$p_p_p=$xml->createElement("p",formater_Texte_Annonce_Index($back["te_a"]));
										
									
									
									
										
										 //s'il n'y a pas de foto pas besoin de partager ???
										$textLink = urlencode("localhost/annonces/detailAnnonce.php?ann=".$back["id_a"]);
										
										//Est ce du mobile
										if(isMobile)
										{
												//Twitter
											$shareTwitter=$xml->createElement("shareTwitter","https://twitter.com/intent/tweet?ref_src=".$textLink);
											
													//Whatsapp
											$shareWhatsapp=$xml->createElement("shareWhatsapp","https://web.whatsapp.com/send?text=".$textLink);
													//Facebook
											$shareFacebook=$xml->createElement("shareFacebook","https://www.facebook.com/plugins/share_button.php?href=".$textLink);
										}
										else
										{
											//Twitter
											$shareTwitter=$xml->createElement("shareTwitter","https://twitter.com/intent/tweet?ref_src=".$textLink);
											
											//Whatsapp
											$shareWhatsapp=$xml->createElement("shareWhatsapp","whatsapp://send?text=".$textLink);
											//Facebook
											$shareFacebook=$xml->createElement("shareFacebook","https://www.facebook.com/plugins/share_button.php?href=".$textLink);
										}
										
										$item->appendChild($href);
										$item->appendChild($src);
										$item->appendChild($alt);	
										$item->appendChild($h3);
										$item->appendChild($em);
										$item->appendChild($h5);
										$item->appendChild($p_p_p);
										//share stuff
										$item->appendChild($shareTwitter);
										$item->appendChild($shareWhatsapp);
										$item->appendChild($shareFacebook);
										
								}
						
					}
		}	
}

echo $xml->saveXML();
?>
