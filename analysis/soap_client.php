<html>
	<body>
		<?php
		 $options = array("location"=>"http://localhost/analysis/soap_service.php",
						"uri"=> "http://localhost");
			
		try{
			
			$client = new $SoapClient(null, $options); // wsdl or null
			$membres = $client->getStudentNames();
			echo $membres;
			
		}
		catch(SoapFault $ex)
		var_dump($ex);

		?>
		<form action="rpc_code.php" method="post">
			Request:
			<select name="request">
				<option>Get Emails</option>
				<option>Get Pseudonyme</option>
			</select>
			<input type="submit" name="submit"/>
		</form>
	</body>
</html>