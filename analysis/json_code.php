<?php
//header ('Content-Type: application/json');
require_once('MembreDB.php');
/*
$json_data = json_decode('{"EMAIL" : "Franc"}');

var_dump($json_data);

Class Address{
	public $street ="";
	public $city = "";
	public $state = "";
	
	function __construct($street, $city, $state)
	{
		$this->street = $street;
		$this->city = $city;
		$this->state = $state;
		
	}


	
	
}

class Membre{
	 public $ID_MEMBRE = 0;
	 public $ID_MOTIF_RADIATION = null;
	 public $ID_ADMIN = "";
	 public $EST_ACTIVE = 0;
	 public $PSEUDONYME = "";
	 public $EMAIL = "";
	 public $MOT_DE_PASSE = "";
	 public $LANGUE = "";
	 public $TOKEN_ACTIVATION = "";
	 public $TOKEN_MDP_FORGET = "";
	 public $DATE_INSCRIPTION = "";
	 public $DATE_DERNIERE_CONNECTION = "";
	 public $DATE_MODIFICATION = "";
	 public $DATE_DESINSCRIPTION = "";
	 public $DATE_RADIATION = "";
	 public $TELEPHONE = "";
	 
	 function __construct($ID_MEMBRE, 
						 $ID_MOTIF_RADIATION, 
						 $ID_ADMIN, 
						 $EST_ACTIVE, 
						 $PSEUDONYME, 
						 $EMAIL, 
						 $MOT_DE_PASSE, 
						 $LANGUE, 
						 $TOKEN_ACTIVATION,
						 $TOKEN_MDP_FORGET,
						 $DATE_INSCRIPTION,
						 $DATE_DERNIERE_CONNECTION,
						 $DATE_MODIFICATION,
						 $DATE_DESINSCRIPTION,
						 $DATE_INSCRIPTION,
						 $TELEPHONE)
						 {
							$this->ID_MEMBRE = $ID_MEMBRE; 
							$this->ID_MOTIF_RADIATION = $ID_MOTIF_RADIATION;
							$this->ID_ADMIN = $ID_ADMIN; 
							$this->EST_ACTIVE = $EST_ACTIVE; 
							$this->PSEUDONYME = $PSEUDONYME; 
							$this->EMAIL = $EMAIL; 
							$this->MOT_DE_PASSE = $MOT_DE_PASSE; 
							$this->LANGUE = $LANGUE; 
							$this->TOKEN_ACTIVATION = $TOKEN_ACTIVATION;
							$this->TOKEN_MDP_FORGET = $TOKEN_MDP_FORGET;
							$this->DATE_INSCRIPTION = $DATE_INSCRIPTION;
							$this->DATE_DERNIERE_CONNECTION =  $DATE_DERNIERE_CONNECTION;
							$this->DATE_MODIFICATION = $DATE_MODIFICATION;
							$this->DATE_DESINSCRIPTION = $DATE_DESINSCRIPTION;
							$this->DATE_INSCRIPTION = $DATE_INSCRIPTION;
							$this->TELEPHONE = $TELEPHONE;
							 
							 
							 
							 
							 
						 }
	 
 }
 
 $dale_cooper = new Membre(50, null, null, 0, 
							"YvanVole", "dale@yahoo.fr", 
							"DaleCoop255", "", "8882524748ff22",
							"","2016-02-06 01:41:37", null, null,
							null, null,
							"0647463069"
							);
	echo "<br /><br />";
	$dale_data = json_encode($dale_cooper);
*/	
	require_once("../models/model.php");
	$query = "SELECT * FROM Membre WHERE ID_Membre";// IN (1, 2)";
	
	$membre_array = array();
	$bdd = getBdd();
	if($result = $bdd->query($query)){
		while($obj = $result->fetch(PDO::FETCH_OBJ))
		{
			/*printf("%s %s %s %s %s %s %s %s %s %s %s %s %s <br />",
			    $obj->ID_MEMBRE,
				$obj->ID_MOTIF_RADIATION,
				$obj->ID_ADMIN,
				$obj->EST_ACTIVE,
				$obj->PSEUDONYME,
				$obj->EMAIL,
				$obj->MOT_DE_PASSE,
				$obj->LANGUE,
				$obj->TOKEN_ACTIVATION,
				$obj->TOKEN_MDP_FORGET,
				$obj->DATE_INSCRIPTION ,
				$obj->DATE_DERNIERE_CONNECTION,
				$obj->DATE_MODIFICATION,
				$obj->DATE_DESINSCRIPTION,
				$obj->DATE_INSCRIPTION,
				$obj->TELEPHONE);*/
				
				$temp_member = new MembreDB($obj->ID_MEMBRE,
				$obj->ID_MOTIF_RADIATION,
				$obj->ID_ADMIN,
				$obj->EST_ACTIVE,
				$obj->PSEUDONYME,
				$obj->EMAIL,
				$obj->MOT_DE_PASSE,
				$obj->LANGUE,
				$obj->TOKEN_ACTIVATION,
				$obj->TOKEN_MDP_FORGET,
				$obj->DATE_INSCRIPTION,
				$obj->DATE_DERNIERE_CONNECTION,
				$obj->DATE_MODIFICATION,
				$obj->DATE_DESINSCRIPTION,
				$obj->DATE_INSCRIPTION,
				$obj->TELEPHONE);
				
				$membre_array[] = $temp_member;
				
				
				
		}
		
		echo '<?xml version="1.0" encoding = "UTF-8" ?>';
		echo '<membres>';
		
		foreach($membre_array[0] as $key=>$value)
		{
			echo '<'.$key.'>'.$value.'</>'.$key.'>';
		}
		echo '</students>';
		/*echo "<br/><br />";
		
		echo '{"students": [';
		
		$dale_data = json_encode($membre_array[0]);
		echo $dale_data;
		
		echo ",<br/>";
		
		$dale_data = json_encode($membre_array[1]);
		echo $dale_data. "<br />";
		
		echo ']}';
		
		$result->close;
		*/
		//$bdd->close();
	}
	


?>