<?php 
require ('model.php');
	$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

	$email = (isset($POST["mon_email"])) ? htmlentities($POST["mon_email"]) : NULL;
	$telephone = (isset($POST["telephone"])) ? htmlentities($POST["telephone"]) : NULL;
	$mdp = (isset($POST["mdp"])) ? htmlentities($POST["mdp"]) : NULL;
	$pseudo = (isset($POST["pseudonyme"])) ? htmlentities($POST["pseudonyme"]) : NULL;
	$result = 0;
	
	if($email!=NULL)
	{
		$result = control_email($email);
		if($result==1)
		{
			echo ("indisponible");
		}
		else echo ("OK !!");
	}
	
	if($telephone != NULL)
	{
		$result = control_telephone($telephone);
		if($result==1)
		{
			echo ("indisponible");
		}
		else echo ("OK !!");
	}
	
	if($mdp!=NULL)
	{
		$result = control_mot_de_passe($mdp);
		if($result==1)
		{
			echo ("indisponible");
		}
		else echo ("OK !!");
	}
	
	if($pseudo !=NULL)
	{
		$result = control_pseudonyme($pseudo);
		if($result==1)
		{
			echo ("indisponible");
		}
		else echo ("OK !!");
	}

?>

