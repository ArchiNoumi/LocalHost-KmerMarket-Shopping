<html>
	<body>
		<?php
		  require_once('Membres.php');
		
		  $membre_data = new Membres();
		if(isset($_POST['submit'])){
			switch($_POST['request']){
				case "Get Emails" :
				$membre_info = $membre_data->getMembreEmail();
				break;
				
				case "Get Pseudonyme" :
				$membre_info = $membre_data->getMembrePseudonyme();
				break;
				
				default:
				 http_response_code(400);
			}
			
			echo json_encode($membre_info);
			
		}

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