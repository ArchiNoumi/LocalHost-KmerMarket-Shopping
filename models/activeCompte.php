<?php
	session_start();
	$maxime = (isset($_POST["maxime"])) ? htmlentities($_POST["maxime"]) : NULL;
	if($maxime != null)
	{
		//get account by token
		$membre = getMembreByTockenActivation($maxime);
		if($membre != null)
		{
			header('Location: ../comptes/connection.php');
		}
	}
	else
	{
		header('Location: ../comptes/inscription.php');
	}
	
	exit();
?>