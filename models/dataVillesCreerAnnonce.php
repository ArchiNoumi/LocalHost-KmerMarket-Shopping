<?php


header("Content-Type: text/xml");
$id_Region = (isset($_POST["Region"])) ? htmlentities($_POST["Region"]) : NULL;

$xml = new DOMDocument("1.0", 'UTF-8');
$xml->formatOutput=true;
$list=$xml->createElement("list");
$xml->appendChild($list);
$item=$xml->createElement("item");
$list->appendChild($item);

$villefr=$xml->createElement("villefr","Toutes");
$villeEng=$xml->createElement("villeEng", "All");
$idVille=$xml->createElement("idVille", 500);

$item->appendChild($villefr);
$item->appendChild($villeEng);
$item->appendChild($idVille);
		

		if ($id_Region != NULL ) 
		{
			require 'model.php';
			$villes = getVilles(intval($id_Region));
			
			foreach ($villes as $ville) 
			{
				$item=$xml->createElement("item");
				$list->appendChild($item);
				$villefr=$xml->createElement("villefr",$ville["n_fr"]);
				$villeEng=$xml->createElement("villeEng", $ville["n_eng"]);
				$idVille=$xml->createElement("idVille", $ville["id_v"]);
			
				$item->appendChild($villefr);
				$item->appendChild($villeEng);
				$item->appendChild($idVille);				
			}
			
		}
echo $xml->saveXML();
?>