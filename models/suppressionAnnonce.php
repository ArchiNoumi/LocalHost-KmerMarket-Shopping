<?php
	session_start();
	//Suppression d'une annonce
	require '../models/model.php';
	$id_ann = htmlspecialchars($_GET['ann']);
	$userPseudo = htmlspecialchars($_GET['pseu']);
	//url to redirect
	$redirectLinkMesAnnonces = "../annonces/mesAnnonces.php?pseu=".$userPseudo; 
	
	//echo('redirectLinkMesAnnonces = '.$redirectLinkMesAnnonces);
	//In vérifie si nos variables du formulaire sont d�finies
	if(!empty($id_ann)) 
	{ 
			$id_ann = $_GET['ann'];
			//appel de la fonction suppression annonces et photos annonce
			suppression_annonces_et_photoAnnonces($id_ann);
			
	}	

	header('Location: '. $redirectLinkMesAnnonces);
	
	exit();
?>