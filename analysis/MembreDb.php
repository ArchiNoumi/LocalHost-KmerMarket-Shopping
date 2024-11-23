<?php
 class MembreDB
 {
	 
	 public $ID_MEMBRE = "";
	 public $ID_MOTIF_RADIATION = "";
	 public $ID_ADMIN = "";
	 public $EST_ACTIVE = "";
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
							$this->DATE_DERNIERE_CONNECTION =  $DATE_DERNIERE_CONNECTION;
							$this->DATE_MODIFICATION = $DATE_MODIFICATION;
							$this->DATE_DESINSCRIPTION = $DATE_DESINSCRIPTION;
							$this->DATE_INSCRIPTION = $DATE_INSCRIPTION;
							$this->TELEPHONE = $TELEPHONE;
							 
							 
							 
							 
							 
						 }
	 
 }


?>