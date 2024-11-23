<?php
		  require_once('Membres.php');
		  $options = array("uri" => "http://localhost");
		  $server = new SoapServer(null, $options);
		  $server->setClass('Membres');
		  $server->handle();
		  
?>