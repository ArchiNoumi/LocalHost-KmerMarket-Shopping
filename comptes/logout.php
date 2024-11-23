<?php
	session_start();
	
	//destroy session
	session_destroy();
	
	//unset cookies; on crè un cookie email qui est vide et on annule le temps
	setcookie("email","",time()-7200); //en mettant une valeur négative du temps on annule le cookie ;)
	
	//On revoie l'utilisateur à la page d'enregistrement
	header('Location: ../comptes/connection.php');
?>