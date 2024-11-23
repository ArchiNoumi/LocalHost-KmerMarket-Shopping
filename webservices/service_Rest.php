<?php
	
	if(isset($_POST['visitor']))
	{
		$visitor = $_POST['visitor'];
		
		//Ressourse Adress
		
		$url = "https://www.kmermarket.com/webservices/client_Rest.php?visitor=".$visitor;
		
		//Send request to Resourse
		
		$client=curl_init($url);
		
		curl_setopt($client, CURLOPT_RETURNTRANSFER,1);
		//get response from Resource
		$response=curl_exec($client);
		
		//decode
		$result = json_decode($response);
		//display only the data
		echo $result->data;
		/*
		     Treat of response
		*/
		//Get the table of table :D
			$vartoo = $result->data;
			foreach($vartoo as $x => $x_value) {
				foreach($x_value as $y => $y_value) {
				 echo "Key=" . $y . ", Value=" . $y_value;
			echo "<br>";
			}
			echo "<br>";
			}
		

		
	}
	
	
?>
<!DOCTYPE html>
<html>
	<head>
	
	<meta http-equiv="Content-type" charset="UTF-8" content="text/html">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
    <title>Kmermarket - webservice</title> <!-- Element spécifiwue -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	
	
	
	
	</head>
	<body>
		<form action="service_Rest.php" method="post">
			 <input type="text" name="visitor"><br>
			 <input type="submit" value="Submit">
		</form>
	</body>

</html>