<?php 
session_start();
require ('model.php');
	
	$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
	$email = (isset($POST["mon_email"])) ? htmlentities($POST["mon_email"]) : NULL;
	
	$mdp = (isset($POST["mdp"])) ? htmlentities($POST["mdp"]) : NULL;
	
	$result = 0;
	
	if($email!=NULL)
	{
		$result = control_email($email);
		if($result!=1)
		{
			echo ("cet email n'ai pas reconnu :)");
		}
		else echo ("OK !!");
	}
	

	if($mdp!=NULL)
	{
		$result = control_mot_de_passe($mdp);
		if($result!=1)
		{
			echo ("Ce mot de passe n'est pas reconnu :)");
		}
		else echo ("OK !!");
	}
	
	

?>

