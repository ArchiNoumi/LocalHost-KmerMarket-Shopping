<?php
	session_start();
	
	//destroy session
	session_destroy();
	
	//unset cookies; on cr� un cookie email qui est vide et on annule le temps
	setcookie("email","",time()-7200); //en mettant une valeur n�gative du temps on annule le cookie ;)
	
	//On revoie l'utilisateur � la page d'enregistrement
	header('Location: ../comptes/connection.php');
?>