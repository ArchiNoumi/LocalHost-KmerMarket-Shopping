<?php
	session_start();
	//call the functions
	require '../models/model.php';
	
	
	$id_ann = htmlspecialchars($_GET['ann']);
	
	//In v�rifie si nos variables du formulaire sont d�finies
	if(!empty($id_ann)) 
	{
		$id_ann = $_GET['ann'];
		$annonces = update_date_vente_annonce($id_ann);
			if($annonces != null)
			{
				echo '<body onLoad="alert (\' Bravo !! \n Votre annonce est à présent vendue/achetée :) \')">';
				//puis on le redirige vers la page d'accueil
				echo '<meta http-equiv="refresh" content="0;URL=../annonces/mesAnnonces.php">';
			}
			else
			{
				echo '<body onLoad="alert (\'Désolé !, \n Une erreur s\'est produite :) \')">';
				//puis on le redirige vers la page d'accueil
				//header('Location: /KmerMarketFinal/annonces/modifierAnnonce.php');
				echo '<meta http-equiv="refresh" content="0;URL=../annonces/modifierAnnonce.php">';
			}

			
		
	}	
	//header('Location: /KmerMarketFinal/annonces/mesAnnonces.php');
	echo '<meta http-equiv="refresh" content="0;URL=../annonces/mesAnnonces.php">';
	
	

?>