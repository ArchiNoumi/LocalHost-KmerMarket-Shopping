<?php

header("Content-Type: text/xml");
$xml = new DOMDocument("1.0", 'UTF-8');
$xml->formatOutput=true;
$list=$xml->createElement("list");
$xml->appendChild($list);
$item=$xml->createElement("item");
$list->appendChild($item);

$typefr=$xml->createElement("typefr","Toutes");
$typeEng=$xml->createElement("typeEng", "All");
$idTypeAnn=$xml->createElement("idTypeAnn", 5000);

$item->appendChild($typefr);
$item->appendChild($typeEng);
$item->appendChild($idTypeAnn);
	
		require 'model.php';

			$typesAnnonces = getTypeAnnonces();
	
	
			foreach ($typesAnnonces as $typeAnn) 
			{
				$item=$xml->createElement("item");
				$list->appendChild($item);

				$typefr=$xml->createElement("typefr",htmlspecialchars($typeAnn["n_fr"]));
				
				$typeEng=$xml->createElement("typeEng", htmlspecialchars($typeAnn["n_eng"]));
				$idTypeAnn=$xml->createElement("idTypeAnn",htmlspecialchars($typeAnn["id_t"]));

				$item->appendChild($typefr);
				$item->appendChild($typeEng);
				$item->appendChild($idTypeAnn);
				
			}
			
echo $xml->saveXML();

?>