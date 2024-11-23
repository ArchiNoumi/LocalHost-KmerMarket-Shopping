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
		$string_requete_Etat = " DATE_VENTE_ACHAT is not null ";
	}
	else if($val_Etat=="supprimees")
	{
		$string_requete_Etat = " annonce.DATE_ANNULATION is not null  ";
	}
	else if($val_Etat=="masquees")
	{
		$string_requete_Etat = " EST_VISIBLE = 0  ";
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
		$string_requete = " annonce.DATE_CREATION DESC";
	}
	else if($Classe_par=="anciennes_recentes")
	{
		$string_requete = " annonce.DATE_CREATION";
	}
	else if($Classe_par=="prix_decroissants")
	{
		$string_requete = " PRIX_ANNONCE DESC";
	}
	else if($Classe_par=="prix_croissants")
	{
		$string_requete = " PRIX_ANNONCE ";
	}
	else if($Classe_par=="villes_croissants")
	{
		$string_requete = " VILLE.NOM_FR ";
	}
	else if($Classe_par=="villes_decroissants")
	{
		$string_requete = " VILLE.NOM_FR DESC ";
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
		$string_requete = " annonce.DATE_CREATION DESC";
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
					 //A voir si nécessaire ?
					//WE DONT DO THIS YO
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
						// pas besoin $nb_photo = getNombrePhoto_Annonce($back['id_a']);
						$item=$xml->createElement("item");
						$list->appendChild($item);
						
						$pageEl=$xml->createElement("page",htmlspecialchars($back['id_a']));
						$idMembreEl=$xml->createElement("idMembre",htmlspecialchars($id_Membre));
						
						$attribute1 = $xml->createAttribute("botte");
						$attribute1->value=$id_Membre;
						$idMembreEl->appendChild($attribute1);
						
						$item->appendChild($pageEl);
						$item->appendChild($idMembreEl);
						
							
					}
			//utf8_encode s'il y'a des problèmes d'encodage
			}
			
		
}


echo $xml->saveXML();

?>