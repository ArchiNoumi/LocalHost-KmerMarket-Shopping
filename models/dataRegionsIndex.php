<?php


header("Content-Type: text/xml");
/*
echo '<?xml version="1.0" ?>';
echo "<list>";
*/
$id_Region = (isset($_POST["Region"])) ? htmlentities($_POST["Region"]) : NULL;

		
$xml = new DOMDocument("1.0", 'UTF-8');
//$xml = loadHTML(mb_convert_encoding($profile, 'HTML-ENTITIES', 'UTF-8'));
$xml->formatOutput=true;
$list=$xml->createElement("list");
$xml->appendChild($list);
$item=$xml->createElement("item");
$list->appendChild($item);

$regionfr=$xml->createElement("regionfr","Toutes");
$regionEng=$xml->createElement("regionEng", "All");
$idRegion=$xml->createElement("idRegion", 5000);

$item->appendChild($regionfr);
$item->appendChild($regionEng);
$item->appendChild($idRegion);
	if ($id_Region != NULL )
	{
		
		
			require 'model.php';
		$regions = getRegions();
			foreach ($regions as $region) 
			{
				$item=$xml->createElement("item");
				$list->appendChild($item);
				$regionfr=$xml->createElement("regionfr",htmlspecialchars($region["n_fr"]));
				$regionEng=$xml->createElement("regionEng", htmlspecialchars($region["n_eng"]));
				$idRegion=$xml->createElement("idRegion", htmlspecialchars($region["id_r"]));
			
				$item->appendChild($regionfr);
				$item->appendChild($regionEng);
				$item->appendChild($idRegion);
			
			
			}

	}		
	
//echo"<xmp>".$xml->saveXML()."</xmp>";
echo $xml->saveXML();
//$xml->save("data/reportsRegions.xml");
		

?>