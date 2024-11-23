<?php

header("Content-Type: text/xml");
/*echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo "<list>";*/

$id_photo = (isset($_POST["pic"])) ? htmlentities($_POST["pic"]) : NULL;
//echo "<item description=\"89\" />";

$xml = new DOMDocument("1.0", 'UTF-8');
$xml->formatOutput=true;
$list=$xml->createElement("list");
$xml->appendChild($list);


if($id_photo != null && $id_photo !="")
{
    
	require 'model.php';
	
		//supprimer id de la photo de l'annonce
	   // remove_idPhoto_to_Annonce($id_photo);
		$description = supprimer_photo_par_idPhoto($id_photo);
		
		//sipprimer photo dans le répertoire
	/*if($description == 0)
	{
		echo "<item description=\"".$description."\" />";
	}*/
			$item=$xml->createElement("item");
			$list->appendChild($item);
			$descriptionAttr = $xml->createAttribute("description");
			$descriptionAttr->value=$description;
			$item->appendChild($descriptionAttr);
			
			
			$list->appendChild($item);
			
			//echo "<item description=\"".$description."\" />";
		
}
	
echo $xml->saveXML();		



?>