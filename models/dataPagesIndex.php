<?php
	session_start();
	//Si problème d'encodage, utiliser utf8_encode($var);
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
		$string_requete = " annonce.DATE_CREATION DESC";
	}
	else if($choix_tri_annonce =="ancien_recent")
	{
		$string_requete = " annonce.DATE_CREATION";
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
		$string_requete = " annonce.DATE_CREATION DESC";
	}

	require 'model.php';
	//Attention on a pas idRegion :)
		if ($id_valueTypeAnn != null && $id_Ville != null && $id_categorie_annonce != null && $choix_tri_annonce != null && $id_Region != null)// && $titre_rechercher != "") 
		{
			
					
				
						$query = get_annonces_multiparam_AVEC_titre_no_pagination( $id_Ville, 
											$id_valueTypeAnn, $id_categorie_annonce, 
											$titre_rechercher, $string_requete, $id_Region);
					
				//Le total est calculé directement au nivo du Js :  Comptage du nombre de lignee de ma liste :)
					
						foreach($query as $back)
					{
						// pas besoin de çà :D $photo = getPhotoPrincipaleByIdAnnonce($back["id_a"]);
								$item=$xml->createElement("item");
								$list->appendChild($item);
								
								$pageEl=$xml->createElement("page",($back['id_a']));
								$item->appendChild($pageEl);
						
					
					}
					
					
		}	

}


echo $xml->saveXML();
?>
