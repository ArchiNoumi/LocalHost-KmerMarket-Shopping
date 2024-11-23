<?php
require '../models/model.php';
/*
$vartoo = getAll();
foreach($vartoo as $x => $x_value) {
	foreach($x_value as $y => $y_value) {
		 echo "Key=" . $y . ", Value=" . $y_value;
    echo "<br>";
	}
	echo "<br>";
   
}
echo count($vartoo);*/
	//process client request
	
	header("Content-Type:application/json");
	if(!empty($_GET['visitor']))
	{
		//
		$name=$_GET['visitor'];
		$visitor = null;
		if($name=="all")
		{
			$visitor = getAll();
			
		}
		
		if(empty($visitor) && $visitor!=null)
			deliver_response(200,"visitor not found", NULL);
		else
			deliver_response(200,"visitor found", $visitor);
			//respond visitor 
		
	}
	else
	{
		//throw invalid register_shutdown_function
		deliver_response(400,"Invalid Request", NULL);
	}
	
	function deliver_response($status, $status_message,$data)
	{
		header("HTTP/1.1 $status $status_message");
		$response['status']=$status;
		$response['status_message']=$status_message;
		$response['data']=$data;
		
		$json_response = json_encode($response);
		echo $json_response;
	}
	
?>