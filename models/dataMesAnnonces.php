<?php
	session_start();
	
?>
<?php

header("Content-Type: text/xml");
$xml = new DOMDocument("1.0", 'UTF-8');
$xml->formatOutput=true;
$list=$xml->createElement("list");
$xml->appendChild($list);

$id_valueTypeAnn = (isset($_POST["Type_Annonce"])) ? htmlentities($_POST["Type_Annonce"]) : NULL;
$id_categorie_annonce = (isset($_POST["Categorie_Annonce"])) ? htmlentities($_POST["Categorie_Annonce"]) : NULL;
//préparation de la liste des annonces en fonction du choix de tri !
$val_Etat = $_POST["Etat_Annonce"];
$string_requete_Etat = "";
	if($val_Etat=="en_cours")
	{
		$string_requete_Etat = " annonce.DATE_ANNULATION is null ";
	}
	else if($val_Etat=="vendues")
	{
		$string_requete_Etat = " annonce.DATE_VENTE_ACHAT is not null ";
	}
	else if($val_Etat=="supprimees")
	{
		$string_requete_Etat = " annonce.DATE_VENTE_ACHAT is null and annonce.DATE_ANNULATION is not null  ";
	}
	else if($val_Etat=="masquees")
	{
		$string_requete_Etat = " annonce.EST_VISIBLE = 0  ";
	}
	else
	{
		$string_requete_Etat = " ";
	}
	
$titre_rechercher = (isset($_POST["titre"])) ? htmlentities($_POST["titre"]) : NULL;
if($titre_rechercher != NULL)
{
	$titre_rechercher = trim($titre_rechercher);
}

$id_Membre = (isset($_POST["meteorite"])) ? htmlentities($_POST["meteorite"]) : NULL;

$Classe_par = (isset($_POST["Classe_par"])) ? htmlentities($_POST["Classe_par"]) : NULL;

$Etat = (isset($_POST["Etat_Annonce"])) ? htmlentities($_POST["Etat_Annonce"]) : NULL;


$string_requete = "";
if($Classe_par != null)
{
	if($Classe_par=="recentes_anciennes")
	{
		$string_requete = " annonce.ID_ANNONCE DESC";
	}
	else if($Classe_par=="anciennes_recentes")
	{
		$string_requete = " annonce.ID_ANNONCE";
	}
	else if($Classe_par=="prix_decroissants")
	{
		$string_requete = " annonce.PRIX_ANNONCE DESC";
	}
	else if($Classe_par=="prix_croissants")
	{
		$string_requete = " annonce.PRIX_ANNONCE ";
	}
	else if($Classe_par=="villes_croissants")
	{
		$string_requete = " ville.NOM_FR ";
	}
	else if($Classe_par=="villes_decroissants")
	{
		$string_requete = " ville.NOM_FR DESC ";
	}
	else if($Classe_par=="titres_croissants")
	{
		$string_requete = " annonce.TITRE_ANNONCE ";
	}
	else if($Classe_par=="titres_decroissants")
	{
		$string_requete = " annonce.TITRE_ANNONCE DESC ";
	}
	else
	{
		$string_requete = " annonce.ID_ANNONCE DESC";
	}

	//Appel des fonctions
		require 'model.php';
			if($Classe_par && $Etat && $id_categorie_annonce != null)
			{
				 if ($id_Membre="ello")
				 {
					 $id_Membre = getIdMembreByPseudo($_SESSION['pseudonyme']);
				 }
				 else
				 {
					 exit(0);
				 }
					
				
				$query = get_mes_annonces_no_pagination($id_Membre, 
														$id_valueTypeAnn, 
														$id_categorie_annonce, 
														$titre_rechercher, 
														$string_requete_Etat, 
														$string_requete);
			
					
					foreach($query as $back) 
					{
						$results = getAnnoncePage($back['id_a']);
						foreach($results as $back2)
						{
							
					
							$nb_photo = getNombrePhoto_Annonce($back2['id_a']);
						
							   
							$item=$xml->createElement("item");
							$list->appendChild($item);	
							
							$attribute_titre = $xml->createAttribute("titre");
							$attribute_titre->value=htmlspecialchars(formater_Texte_Annonce_Index($back2['ti_a']));
							$item->appendChild($attribute_titre);	
							
							$attribute_texteAnn = $xml->createAttribute("texteAnn");
							$attribute_texteAnn->value=htmlspecialchars(formater_Texte_Annonce_Index($back2["te_a"]));
							$item->appendChild($attribute_texteAnn);
							
							$attribute_prix = $xml->createAttribute("prix");
							$attribute_prix->value=htmlspecialchars(formater_Prix($back['p_a']));
							$item->appendChild($attribute_prix);
							
							$attribute_categorie = $xml->createAttribute("categorie");
							$attribute_categorie->value=htmlspecialchars($back["typ_n_fr"]);
							$item->appendChild($attribute_categorie);
							
							$attribute_region = $xml->createAttribute("region");
							$attribute_region->value=htmlspecialchars($back["region_n_fr"]);
							$item->appendChild($attribute_region);
							
							$attribute_ville = $xml->createAttribute("ville");
							$attribute_ville->value=htmlspecialchars($back["ville_n_fr"]);
							$item->appendChild($attribute_ville);
							
							$attribute_date_creation = $xml->createAttribute("date_creation");
							$attribute_date_creation->value=htmlspecialchars($back2["date_crea"]);
							$item->appendChild($attribute_date_creation);
							
							$attribute_details = $xml->createAttribute("details");
							$attribute_details->value=htmlspecialchars($back['id_a']);
							$item->appendChild($attribute_details);
							
							
							$attribute_date_vent_achat = $xml->createAttribute("date_vent_achat");
							$attribute_date_vent_achat->value=htmlspecialchars($back['date_vent_achat']);
							$item->appendChild($attribute_date_vent_achat);
							
							$attribute_date_annul = $xml->createAttribute("date_annul");
							$attribute_date_annul->value=htmlspecialchars($back['date_annul']);
							$item->appendChild($attribute_date_annul);
							
							$attribute_etat = $xml->createAttribute("etat");
							$attribute_etat->value=htmlspecialchars($Classe_par);
							$item->appendChild($attribute_etat);
							
							$attribute_nombre_photo = $xml->createAttribute("nombre_photo");
							$attribute_nombre_photo->value=htmlspecialchars($nb_photo['nombre']);
							$item->appendChild($attribute_nombre_photo);
						}	
							
							
						
						
						
							
					}
			//utf8_encode s'il y'a des problèmes d'encodage
			}
			
		
}

echo $xml->saveXML();

?>