<?php
	class Membres{
		public function getMembreEmail(){
			$membreEmail = array("toto@yahoo.fr", "ty@gmail.com",
									"remi@gmail.com"
							);
			return $membreEmail;
			
			
		}
		
		
		public function getMembrePseudonyme(){
			$membrePseudo = array("pseudoNyme", "presrtett", "ecclesiaste");
			return $membrePseudo;
			
			
		}
		
		public function getStudentNames(){
			$membreNames = "Dale Cooper, Harry Turner, Beyonce Knowles";
			return $membreNames;
		}
	
	
	}

?>