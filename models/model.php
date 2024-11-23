<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once (__ROOT__.'/libs/PHPMailer/class.phpmailer.php');
require_once (__ROOT__.'/libs/PHPMailer/class.smtp.php');
//Effectuer la connection à la BDD
//Instancie et renvoie l'objet PDO associé
function getBdd(){
	
	//Localhost 
	$host_name='localhost';
	$database = 'db609046157';
	$user_name='root';
	$password='';
	
	
	
	
		  
     
	
	try
	{
		$bdd = new PDO('mysql:host='.$host_name.';dbname='.$database.';charset=utf8', 
				''.$user_name.'', ''.$password.'',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
				//Permet d'afficher les dates en format français ex: Feb passe à Fév :)
				//SET lc_time_names = 'fr_FR';
		  return $bdd;
	}	
	catch(Exception $e)
	{
			die('Erreur : '.$e->getMessage());
	}
	
}

//09/04/2018 - Check images before saving
function getPhotoBy_File_Title($titre)
{
	$bdd = getBdd();
	$res = 0;
	$photo = $bdd->query("select count(id_photo) as total from
									photo where 
									file_title like '%".$titre."%'
									and date_annulation is null");
									
	foreach ($photo as $ann)
	{
		$res = $ann['total'];
	}
	
	return $res;
}

//08 11 2017 - Visitors

//For visitors
function saveVisitor($data)
{
	//json décodé :D
	$result = $data->status;
		if($result=="success")
		{
			/*echo("<br/>");
			echo('$data->as == '.$data->as);
			echo("<br/>");
			echo("<br/>");
			print_r($location);*/
			$country = $data->country;
			$countryCode = $data->countryCode;
			$region = $data->region;
			$regionName = $data->regionName;
			$city = $data->city;
			$zip = $data->zip;
			$lat = $data->lat;
			$lon = $data->lon;
			$timezone = $data->timezone;
			$isp = $data->isp;
			$org = $data->org;
			$ast = $data->as;
			$query = $data->query; //This is the ip address used for the query
			
			
			//SAVE IN DB
			$bdd=getBdd();
			
			$jour = date('d');
			$mois = date('m');
			$annee = date('Y');
			$heure = date('H');
			$minute = date('i');
			$seconde = date('s');
			$create_date = $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute.':'.$seconde;
			
			$req2 = $bdd->prepare('INSERT INTO visitor (country, countryCode, 
															region, regionName, city, 
															zip, lat, lon, timezone, 
															isp, org, ast, query, date_of_visit) 
															VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$req2 -> execute(array($country, $countryCode, $region, $regionName, $city, $zip,  $lat, $lon, $timezone, 
																$isp, $org, $ast, $query, $create_date));
			
		}
	
}

function getVisitorIp()
{
				if(!empty($_SERVER["HTTP_CLIENT_IP"]))
				{
					$IP = $_SERVER["HTTP_CLIENT_IP"];
				}
				else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
				{
					//check for ip address proxy server
					$IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}
				else if(!empty($_SERVER["HTTP_X_FORWARDED"]))
				{	
					$IP = $_SERVER["HTTP_X_FORWARDED"];
				}
				else if(!empty($_SERVER["HTTP_FORWARDED_FOR"]))
				{
					$IP = $_SERVER["HTTP_FORWARDED_FOR"];
				}
				else if(!empty($_SERVER["HTTP_FORWARDED"]))
				{
					$IP = $_SERVER["HTTP_FORWARDED"];
				}
				else{
					$IP = $_SERVER["REMOTE_ADDR"];
				}

				return $IP;
}

function getAllVisitor($name)
{
	$bdd = getBdd();
	$res = null;
	$visitors = null;
	$visitors = $bdd->query("select id_visitor, country, countryCode, region, regionName, city, zip, lat, lon,timezone, isp, org, ast, query, date_of_visit
							from visitor limit 1");
							foreach($visitors as $back) 
							{
								$res = $back["id_visitor"];
							}
    return $res;	
}

function getAll()
{
	$bdd = getBdd();
	$res = null;
	$visitors = null;
	$visitors = $bdd->query("select id_visitor, country, countryCode, region, regionName, city, zip, lat, lon,timezone, isp, org, ast, query, date_of_visit
							from visitor");
	$items = array();
	foreach($visitors as $back) 
	{
		$items [] = array(
                              'id_visitor'=>$back['id_visitor'],
                              'country'=>$back['country'],
							  'countryCode'=>$back['countryCode'],
                              'region'=>$back['region'],
                              'regionName'=>$back['regionName'],
							  'city'=>$back['city'],
                              'zip'=>$back['zip'],
							  'lat'=>$back['lat'],
							  'lon'=>$back['lon'],
                              'timezone'=>$back['timezone'],
							  'isp'=>$back['isp'],
                              'org'=>$back['org'],
							   'ast'=>$back['ast'],
                              'query'=>$back['query'],
							   'date_of_visit'=>$back['date_of_visit']
							  
                           );
	}
	
         
          return $items;
}



//ELSE
	
function loggedin()
	{
		if(isset($_SESSION['pseudonyme'])) //|| isset($_COOKIE["email"]))
		{
			$loggedin = TRUE;
			return $loggedin;
		}
		
	}
	
//20-07-2016 
function update_date_vente_annonce($idAnn)
{
	$bdd = getBdd();
	$annonces = $bdd->query('UPDATE annonce 
				 SET date_vente_achat = NOW(), date_annulation = NOW()
				 WHERE id_annonce ='.intval($idAnn).'');
	return $annonces;
}
function getPhotoByIdAnnonce($id_ann)
{
	$bdd = getBdd();
	$photo=null;
	$photo = $bdd->prepare('select id_photo as idPho,
									id_annonce as idAnn,
									file_name as fiName,
									file_title as fiTit,
									date_creation as datCrea,
									date_modification as datMod,
									file_size as filSize,
									file_description as filDesc,
									file_final_name as filFinName
									from photo where id_annonce=:ann
									and date_annulation is null');
	$photo->execute(array('ann' => $id_ann));
	return $photo;
}
function getPhotoPrincipaleByIdAnnonce($id_ann)
{
	$bdd = getBdd();
	$reponse = null;
	$photo = $bdd->prepare('select id_photo as idPho,
										id_annonce as idAnn,
										file_name as fiName,
										file_title as fiTit,
										date_creation as datCrea,
										date_modification as datMod,
										file_size as filSize,
										file_description as filDesc,
										file_final_name as filFinName
									from photo where 
										id_annonce=:ann
										and file_description = "1" ');
	$photo->execute(array('ann' => $id_ann));
	foreach($photo as $phot)
	{
		$reponse = $phot;
	}
	return $reponse;
}

function getNombrePhoto_Annonce($id_ann)
{
	$bdd = getBdd();
	$res = 0;
	$nombre_pics = $bdd->prepare('select count(id_photo) as nombre
					from photo where id_annonce=:ann and date_annulation is null');
	$nombre_pics->execute(array('ann' => $id_ann));
	foreach ($nombre_pics as $pic)
	{
		$res = $pic;
	}
	return $res;
}


function getNombreAnnonce_Viable_Total()
{
	$bdd = getBdd();
	$res = 0;
	$nombre_pics = $bdd->query('select count(id_annonce) as nombre
								from annonce where 
									date_annulation is null and 
									date_vente_achat is null');
	foreach ($nombre_pics as $pic)
	{
		$res = $pic['nombre'];
	}
	return $res;
}

//Cas mes annonces
function get_nombreMesAnnonces_multiparam($id_Membre, $id_valueTypeAnn,  $id_categorie_annonce,  $string_requete_Etat, $string_requete_classe_par )
{
	$bdd = getBdd();
	$res = 0;
	$annonces = $bdd->query("select count(id_annonce) as tot
										  from annonce, membre, ville, type_annonce, region
										  where 
										    annonce.ID_Membre = membre.ID_membre AND
											annonce.ID_ville = ville.ID_ville AND
											ville.ID_region = region.ID_region AND
											annonce.ID_type_annonce = type_annonce.ID_type_annonce AND
											annonce.ID_MEMBRE =". $id_Membre." AND
											EST_UNE_OFFRE= ".$id_valueTypeAnn." AND 
											annonce.id_type_annonce = ". $id_categorie_annonce. " AND
										    ". $string_requete_Etat ."  
											ORDER BY ".$string_requete_classe_par ."");
	foreach ($annonces as $ann)
	{
		$res = $ann['tot'];
	}
		
	return $res;
}


//Cas des annonces de la page index

	function get_nombreTotalAnnonces_multiparam( $id_Ville,  $id_valueTypeAnn,  $id_categorie_annonce)
{
	$bdd = getBdd();
	$res = 0;
	$annonces = $bdd->query("select COUNT(annonce.id_annonce) as total
								from annonce
								 Where 
								 ID_ville =".$id_Ville." AND
								 EST_UNE_OFFRE =".$id_valueTypeAnn." AND
								 EST_VISIBLE =1 AND 
								 DATE_ANNULATION is null AND
								 ID_type_annonce = ".$id_categorie_annonce." AND
								 DATE_VENTE_ACHAT is null ");
								 
								 
		foreach ($annonces as $ann)
		{
			$res = $ann['total'];
		}
	
		return $res;
}


function  get_nombreTotalAnnonces_multiparam_avecTitre($id_Ville,  $id_valueTypeAnn,  $id_categorie_annonce, $titre_rechercher)			
{
	$bdd = getBdd();
	$res = 0;
	$annonces = $bdd->query("select COUNT(annonce.id_annonce) as total
								from annonce
								 Where 
								 ID_ville =".$id_Ville." AND
								 EST_UNE_OFFRE =".$id_valueTypeAnn." AND
								 EST_VISIBLE =1 AND 
								 DATE_ANNULATION is null AND
								 ID_type_annonce = ".$id_categorie_annonce." AND
								 titre_annonce like '%".$titre_rechercher."%' AND
								 DATE_VENTE_ACHAT is null ");
		foreach ($annonces as $ann)
		{
			$res = $ann['total'];
		}
	
		return $res;
}








//save picture
function save_photo_annonce($id_ann,
							$file_name, $file_title, $file_size, 
							$file_final_name,$date_creation_photo, $description)
{
	$bdd=getBdd();
	//Get if there is already a photo at this position ?
	$req =$bdd->query("select ID_PHOTO, ID_annonce, FILE_DESCRIPTION 
								from photo
								 Where 
								 FILE_DESCRIPTION =".$description." AND
								 ID_annonce =".$id_ann."");
	if($req != null)	
	{
			foreach ($req as $ann)
		{
			$id_to_delete = $ann['ID_PHOTO'];
			//delete photo
			$anNNNNonce = $bdd->prepare("delete from photo where ID_PHOTO =:varIdPhoto");
			$anNNNNonce->execute(array('varIdPhoto'=>$id_to_delete));
		}	
		
	}		
	$req->closecursor();					 
								 
	$req2 = $bdd->prepare('insert into photo
									(ID_annonce,
									FILE_NAME,
									FILE_TITLE,
									 FILE_SIZE,
									 FILE_FINAL_NAME,
									 FILE_DESCRIPTION,
									 DATE_CREATION)
									values
									 (:id_annonce,
									 :pic_name,
									 :pic_titre,
									  :pic_size,
									   :pic_final_name,
									   :pic_description,
									   :date_creation_photo
									   )
									
								');
						$req2->execute(array(
											'id_annonce'=>$id_ann,
											'pic_name'=>$file_name,
											'pic_titre'=>$file_title,
											'pic_size'=>$file_size,
											'pic_final_name'=>$file_final_name,
											'pic_description'=>$description,
											'date_creation_photo'=>$date_creation_photo
											));
	$req2->closecursor();
	
}

function update_photo_annonce($id_ann,
							$file_name, $file_title, $file_size, 
							$file_final_name,$date_creation_photo, $description)
{
	$bdd=getBdd();
	$req2 = $bdd->prepare('UPDATE photo
											SET
												 FILE_NAME=:pic_name,
												 FILE_TITLE=  :pic_titre,
												 FILE_SIZE =  :pic_size,
												 FILE_FINAL_NAME =  :pic_final_name,
												 FILE_DESCRIPTION = :pic_description,
												 DATE_MODIFICATION = :dateModif
											WHERE
												ID_annonce  ='.$id_ann.'');	
												
	$req2->execute(array(
						'pic_name'=>$file_name,
						'pic_titre'=>$file_title,
						'pic_size'=>$file_size,
						'pic_final_name'=>$file_final_name,
						'pic_description'=>$description,
						'dateModif'=>$date_creation_photo
						));
}



function saveMembre($email, $mdp, $pseudonyme, $telephone)
{
	
	$bdd=getBdd();
	$password= hash("sha512",$mdp);
	$jour = date('d');
	$mois = date('m');
	$annee = date('Y');
	$heure = date('H');
	$minute = date('i');
	$seconde = date('s');
	$create_date = $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute.':'.$seconde;
	
	$req2 = $bdd->prepare('INSERT INTO membre (pseudonyme, email, mot_de_passe, telephone, date_inscription) VALUES(?, ?, ?, ?, ?)');
    $req2 -> execute(array($pseudonyme, $email, $password, $telephone, $create_date));
	return TRUE;
}

function save_date_derniere_connexion($pseudonyme)
{
	$bdd=getBdd();

	$req1 = $bdd->query('UPDATE membre set date_derniere_connection = NOW()
								where pseudonyme like "'.$pseudonyme.'"');
    //$req1 -> execute(array($connect_date));
	return "1";
}


function update_Annonce_multiparam($idann, $ville, $categorie_annonce, $prix, $titre_annonce, $details_annonce, $offre, $etre_contacte_par_email)
{
	$bdd = getBdd();
	$req = $bdd->prepare('UPDATE annonce 
									 SET 
										date_modification = NOW(),
										ID_ville = :idVil,
										ID_type_annonce = :id_typ_ann,
										PRIX_annonce = :prix,
										TITRE_annonce = :title,
										TEXTE_annonce = :texte,
										EST_VISIBLE = :isVisible,
										EST_UNE_OFFRE = :isOffer,
										EST_CONTACTE_PAR_EMAIL = :isContactByEmail,
										LANGUE = :langue
										WHERE id_annonce ='.$idann.'');	
		 $req->execute(array(
								  'idVil'=>$ville,
								   'id_typ_ann'=>$categorie_annonce,
								    'prix'=>$prix,
								     'title'=>$titre_annonce,
								      'texte'=>$details_annonce,
										'isVisible'=>1,
										 'isOffer'=>$offre,
										   'isContactByEmail'=>$etre_contacte_par_email,
										    'langue'=>"FR")) ;
}
function delete_Membre($email)
{
	$bdd=getBdd();
	$membre = $bdd->prepare("delete from membre where email =:varEmail");
	$membre->execute(array('varEmail'=>$email));
	return true;
}
//Activation compte
function update_token_creation_compte_base_on_email($email, $token)
{
	
		$bdd = getBdd();
	$membre = $bdd->prepare("UPDATE membre 
						 SET date_modification = NOW(), 
							token_activation =:token_fgt
						 WHERE email like '".$email."'");	
	$membre->execute(array('token_fgt'=>$token))	;
	return true;
}

function get_the_real_token()
{
	//token à 136 caractères
	//Generate a random string.
	$token='';
	//We should check if the token already exists !!!
	do{
		$token = openssl_random_pseudo_bytes(65);
	 
		//Convert the binary data into hexadecimal representation. 
		//strtoupper  -> to upper case the cars
		$token = strtoupper(bin2hex($token));
	}while(is_the_token_already_there($token));
	
	
	//We should check if the token already exists !!!
	return $token;
}

function generate_random_password()
{
	//password à 8 caractères
	//Generate a random string.
	$password='';
	//We should check if the password already exists !!!
	do{
		$password = openssl_random_pseudo_bytes(4);
	 
		//Convert the binary data into hexadecimal representation. 
		//strtoupper  -> to upper case the cars
		$password = strtoupper(bin2hex($password));
	}while(is_the_password_already_there($password));
	
	
	//We should check if the token already exists !!!
	return $password;

}


function is_the_token_already_there($token)
{
	$bdd = getBdd();
	$res = 0;
	$final = false;
	$annonces = $bdd->query("select COUNT(token_activation) as total
								from membre
								 Where 
								 token_activation like '".$token."'");
	foreach ($annonces as $ann)
		{
			$res = $ann['total'];
		}
	if($res > 0)
		$final = true;
	
		return $final;							 
}


function is_the_password_already_there($password)
{
	$bdd = getBdd();
	$res = 0;
	$final = false;
	$annonces = $bdd->query("select COUNT(mot_de_passe) as total
								from membre
								 Where 
								 mot_de_passe like '".$password."'");
	foreach ($annonces as $ann)
		{
			$res = $ann['total'];
		}
	if($res > 0)
		$final = true;
	
		return $final;							 
}
//function to activate the member 
//1 we check the token to localise the member
//2 we update the field is_active to 1
//3 we delete the token ? No no no !
//TODO phpmailer
function send_km_email()
{
	/*try
	{
		
	}
	catch(e)
	{
		print_r("Erreur :");
	}*/
}
//Tocken mdp perdu :)
function update_mdp_forget_base_on_email($email, $random_password)
{
	//on écrase l'ancien mot de passe
		$bdd = getBdd();
	$membre = $bdd->prepare("UPDATE membre 
						 SET date_modification = NOW(), 
							mot_de_passe =:mdp_fgt
						 WHERE email like '".$email."'");	
	$membre->execute(array('mdp_fgt'=>hash("sha512",$random_password)))	;
	return true;
}

//Update compte sans le updater le mdp
function update_Membre_sans_updaterMdp($idMembre, $tel, $pseudo, $email)
{
	$bdd = getBdd();
	$membre = $bdd->prepare('UPDATE membre 
						 SET date_modification = NOW(), 
							email = :email,
							pseudonyme = :pseudo,
							telephone = :telef
						 WHERE id_membre ='.intval($idMembre).'');	
	$membre->execute(array(
								'email'=>$email,
								'pseudo'=>$pseudo,
								'telef'=>$tel))		;		 
}





function update_mdp($mdpAUpdater, $idMembre)
{
	$bdd = getBdd();
	$membre = $bdd->prepare('UPDATE membre 
						 SET date_modification = NOW(), 
							mot_de_passe= :mdp
						 WHERE id_membre ='.intval($idMembre).'');	
	$membre->execute(array('mdp'=>hash("sha512",$mdpAUpdater)));
}

//Les get
function getMembreByMotDePasse($mdp)
{
	$bdd = getBdd();
		$membre=null;
        $membres = $bdd->prepare("select 
									ID_Membre as idm, 
									PSEUDONYME as pseudo, 
									EMAIL as mail, 
									DATE_FORMAT(DATE_INSCRIPTION, '%d/%m/%Y à %T') as date_ins,
									DATE_FORMAT(DATE_DERNIERE_CONNECTION, '%d/%m/%Y à %T') as date_last_conect, 
									MOT_DE_PASSE as mdp, 
									TELEPHONE as tel
							from membre
							Where MOT_DE_PASSE =:mdp  and 
								  date_desinscription is null limit 1");
		$membres->execute(array('mdp' => hash("sha512",$mdp)));
		foreach ($membres as $membreFinal)
		{
			$membre = $membreFinal;
		}
		
		return  $membre;
}

function getMembreByEmail($membreEmail)
{
	$bdd = getBdd();
		$membre=null;
        $membres = $bdd->prepare("select 
									ID_Membre as idm, 
									PSEUDONYME as pseudo, 
									EMAIL as maile, 
									DATE_FORMAT(DATE_INSCRIPTION, '%d/%m/%Y à %T') as date_ins,
									DATE_FORMAT(DATE_DERNIERE_CONNECTION, '%d/%m/%Y à %T') as date_last_conect, 
									MOT_DE_PASSE as mdp, 
									TELEPHONE as tel
							from membre
							Where EMAIL =:membreEmail  and 
								  date_desinscription is null limit 1");
		$membres->execute(array('maile' => $membreEmail));
		foreach ($membres as $membreFinal)
		{
			$membre = $membreFinal;
		}
		
		return  $membre;
}


function getAnnonces(){
	 $bdd = getBdd();
        $annonces = $bdd->query('select ID_annonce as idAnn,  Texte_Annonce as det, PRIX_annonce as prix'
          . '  from annonce'
          . ' order by ID_annonce desc');
		  return  $annonces;
}

function getRegions(){
	 $bdd = getBdd();
	 $regions = $bdd->query('select id_region as id_r, NOM_FR as n_fr, NOM_ENG as n_eng FROM region ORDER BY ID_region');
     return  $regions;
}

function getVilles($id){
	 $bdd = getBdd();
	 $villes = $bdd->prepare('select id_ville as id_v, NOM_FR as n_fr, NOM_ENG as n_eng, ID_region as id_r FROM ville where ID_region = ? ORDER BY ID_ville');
	 $villes->execute(array($id));

	 return  $villes;
}

function getToutesLesVilles(){
	$bdd = getBdd();
	 $toutesVilles = $bdd->query('select id_ville as id_v, id_region as id_r, NOM_FR as n_fr,
	 NOM_ENG as n_eng FROM ville ORDER BY id_ville');
     return  $toutesVilles;
}

function getTypeAnnonces(){
	 $bdd = getBdd();
	 $typeAnnonces = $bdd->query('select id_type_annonce as id_t, 
								NOM_FR as n_fr, 
								NOM_ENG as n_eng 
								FROM type_annonce ORDER BY ID_type_annonce');
     return  $typeAnnonces;
}

function getAnnonceChargementPage(){
	 $bdd = getBdd();
	 $annonces = $bdd->prepare('select id_annonce as id_a, annonce.id_ville as id_v, 
	                          prix_annonce as p_a, titre_annonce as ti_a, texte_annonce as te_a,
							  ville.nom_fr as ville_nom_fr, ville.nom_eng as ville_nom_eng,
							  ville.id_ville as id_v_v, region.id_region as id_r_r, ville.id_region,
							  id_type_annonce, est_une_offre as e_offre, pseudonyme as p_s, email , membre.id_membre, 
							  annonce.id_membre as id_m, telephone as tel, EST_CONTACTE_PAR_EMAIL as par_email
							  FROM annonce, ville, region, membre 
							  Where 
								 annonce.ID_ville = ville.ID_ville AND
								 ville.ID_region = region.ID_region AND
								 region.ID_region  =:idRegion AND
								 ville.ID_ville =:idVille AND
								 annonce.ID_Membre = membre.ID_Membre AND
							     EST_VISIBLE =:visible AND 
								 EST_UNE_OFFRE =:offre AND
								 DATE_ANNULATION is null AND
								 id_type_annonce =:id_type_ann AND
								 DATE_VENTE_ACHAT is null 
							  ORDER BY DATE_CREATION');
	 $annonces->execute(array('visible' => 1, 'offre' => 1, 'id_type_ann' => 1, 'idVille' => 7, 'idRegion'  => 1));
     return  $annonces;
}

function getAnnoncePage($id_annonce){
	 $bdd = getBdd();
	 $annonces = $bdd->prepare("select annonce.id_annonce as id_a, annonce.id_ville as id_v, 
	                          prix_annonce as p_a, titre_annonce as ti_a, texte_annonce as te_a,
							  ville.nom_fr as ville_nom_fr, ville.nom_eng as ville_nom_eng,
							  ville.id_ville as id_v_v, region.id_region as id_r_r, ville.id_region,
							  id_type_annonce, est_une_offre as e_offre, PSEUDONYME as p_s, email , membre.id_membre, 
							  DATE_FORMAT(annonce.DATE_CREATION, '%d-%m-%Y à %T')  as date_crea, 
							  annonce.DATE_ANNULATION as date_annul, annonce.DATE_VENTE_ACHAT as date_vent_achat,
							  annonce.id_membre as id_m, telephone as tel, EST_CONTACTE_PAR_EMAIL as par_email
							 
							  FROM annonce, ville, region, membre
							  Where 
								 annonce.ID_ville = ville.ID_ville AND
								 ville.ID_region = region.ID_region AND
								 annonce.ID_Membre = membre.ID_Membre AND
								 id_annonce = :id_ann ");
	 $annonces->execute(array('id_ann' => htmlspecialchars($id_annonce)));
     return  $annonces;
}

function get_TypeAnnonce_par_IdAnnonce($id_annonce){
	 $bdd = getBdd();
	 $result;
	 $Type_ann = $bdd->prepare('select NOM_ENG as n_eng, NOM_FR as n_fr, 
								type_annonce.ID_type_annonce as id_typ
							  FROM type_annonce, annonce
							  Where 
								 type_annonce.ID_type_annonce = annonce.ID_type_annonce AND
								 annonce.id_annonce = :id_ann ');
	 $Type_ann->execute(array('id_ann' => htmlspecialchars($id_annonce)));
	 foreach($Type_ann as $typeAnn)
	 {
		 $result = $typeAnn;
	 }
     return  $result;
}

function getAnnonceFormulaire($est_une_offre, $id_region, $id_ville, $id_type_annonce){
	 $bdd = getBdd();
	 $annonces = null;
		 $annonces = $bdd->prepare('select id_annonce as id_a, annonce.id_ville as id_v, 
	                          prix_annonce as p_a, titre_annonce as ti_a, texte_annonce as te_a,
							  ville.nom_fr as ville_nom_fr, ville.nom_eng as ville_nom_eng,
							  ville.id_ville as id_v_v, region.id_region as id_r_r, ville.id_region,
							  id_type_annonce, est_une_offre as e_offre, pseudonyme as p_s, email , membre.id_membre, 
							  annonce.id_membre as id_m, telephone as tel, EST_CONTACTE_PAR_EMAIL as par_email
							  FROM annonce, ville, region, membre 
							  Where 
								 annonce.ID_ville = ville.ID_ville AND
								 ville.ID_region = region.ID_region AND
								 region.ID_region  =:idRegion AND
								 ville.ID_ville =:idVille AND
								 annonce.ID_Membre = membre.ID_Membre AND
								 EST_UNE_OFFRE =:offre AND
							     EST_VISIBLE =:visible AND 
								 DATE_ANNULATION is null AND
								 id_type_annonce =:id_type_ann AND
								 DATE_VENTE_ACHAT is null 
							  ORDER BY DATE_CREATION');
	 $annonces->execute(
							array(
									'offre' => htmlspecialchars($est_une_offre),
									'visible' => 1, 
									'id_type_ann' => htmlspecialchars($id_type_annonce), 
									'idVille' => htmlspecialchars($id_ville), 
									'idRegion'  => htmlspecialchars($id_region)
								)
						);
     return  $annonces;
}

function get_Offres_Recentes_Anciennes()
{
	 $bdd = getBdd();
	 $annonces = $bdd->query('select id_annonce as id_a, id_ville as id_v, id_membre as id_m, 
	                          prix_annonce as p_a, titre_annonce as ti_a, texte_annonce_as te_a
							  FROM annonce 
							  Where 
							     EST_VISIBLE =:visible AND 
								 EST_UNE_OFFRE =:offre AND
								 DATE_ANNULATION is null AND
								 DATE_VENTE_ACHAT is null 
							  ORDER BY DATE_CREATION');
     return  $annonces;
}

function get_annonces_multiparam_avec_pagination_sans_photo($id_Region, $id_Ville, $id_valueTypeAnn, $id_categorie_annonce, $string_requete, $start, $epp)
{
	$bdd = getBdd();
	$annonces = $bdd->query("select  id_annonce as id_a, annonce.id_ville as id_v, 
									  prix_annonce as p_a, titre_annonce as ti_a, texte_annonce as te_a,
									  ville.nom_fr as ville_nom_fr, ville.nom_eng as ville_nom_eng,
									  ville.id_ville as id_v_v, region.id_region as id_r_r, ville.id_region,
									  id_type_annonce, est_une_offre as e_offre, pseudonyme as p_s, email , membre.id_membre, 
									  annonce.id_membre as id_m, telephone as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, region, membre 
									  Where 
										 annonce.ID_ville = ville.ID_ville AND
										 ville.ID_region = region.ID_region AND
										 region.ID_region  =" . $id_Region . " AND
										 ville.ID_ville =" . $id_Ville . " AND
										 annonce.ID_Membre = membre.ID_Membre AND
										 EST_UNE_OFFRE =" . $id_valueTypeAnn . " AND
										 EST_VISIBLE =1 AND 
										 DATE_ANNULATION is null AND
										 id_type_annonce = " . $id_categorie_annonce . " AND
										 DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. " LIMIT "
									  . ($start).", "
									  . ($epp). ""
							     );
		
	return $annonces;
}

function get_derniere_id_annonce_enregistree($id_membre)
{
	$bdd = getBdd();
	$resultat=0;
	$id_annonce = $bdd->prepare('select MAX(id_annonce) as idAnn from annonce where ID_membre =:idMembre ');
	$id_annonce->execute(array('idMembre'=>$id_membre));
	foreach ($id_annonce as $idann)
	{
		$resultat = $idann['idAnn'];
	}
	return $resultat;
}

function getPhotoByIdEvenement($id_evt)
{
	$bdd = getBdd();
	$photo = $bdd->prepare('select * from photo where id_evenement=:ann');
	$photo->execute(array('ann' => $id_evt));
	return $photo;
}
function getPhotoByIdProfessionnel($id_pro)
{
	$bdd = getBdd();
	$photo = $bdd->prepare('select * from photo where id_professionnel=:ann');
	$photo->execute(array('ann' => $id_pro));
	return $photo;
}

function getPhotoByIdPhoto($id_pro)
{
	$bdd = getBdd();
	$photo = $bdd->prepare('select 
							id_photo as idPho,
									id_annonce as idAnn,
									file_name as fiName,
									file_title as fiTit,
									date_creation as datCrea,
									date_modification as datMod,
									file_size as filSize,
									file_description as filDesc,
									file_final_name as filFinName
									from photo
							where id_photo=:ann');
	$photo->execute(array('ann' => $id_pro));
	return $photo;
}

function getIdMembreByPseudo($pseudonyme)
{
	$bdd = getBdd();
	$reponse = "";
        $idM = $bdd->prepare('select ID_membre as idm '
          . '  from membre'
          . '  Where PSEUDONYME =:pseudo  limit 1');
		 $idM->execute(array('pseudo' => $pseudonyme));
		foreach ($idM as $val)
		{
			$reponse = $val['idm'];
		}
		
		return  $reponse;
}

function getMembreByPseudo($pseudonyme)
{
		$bdd = getBdd();
		$membre=null;
        $membres = $bdd->prepare("select 
									ID_Membre as idm, 
									PSEUDONYME as pseudo, 
									EMAIL as mail, 
									DATE_FORMAT(DATE_INSCRIPTION, '%d/%m/%Y à %T') as date_ins,
									DATE_FORMAT(DATE_DERNIERE_CONNECTION, '%d/%m/%Y à %T') as date_last_conect, 
									MOT_DE_PASSE as mdp, 
									TELEPHONE as tel
							from membre
							Where PSEUDONYME =:pseudo  limit 1");
		$membres->execute(array('pseudo' => $pseudonyme));
		foreach ($membres as $membreFinal)
		{
			$membre = $membreFinal;
		}
		
		return  $membre;
}

function getMembreByTockenActivation($token)
{
		$bdd = getBdd();
		$membre=null;
        $membres = $bdd->prepare("select 
									ID_Membre as idm, 
									PSEUDONYME as pseudo, 
									EMAIL as mail, 
									DATE_FORMAT(DATE_INSCRIPTION, '%d/%m/%Y à %T') as date_ins,
									DATE_FORMAT(DATE_DERNIERE_CONNECTION, '%d/%m/%Y à %T') as date_last_conect, 
									MOT_DE_PASSE as mdp, 
									TELEPHONE as tel
							from membre
							Where TOKEN_ACTIVATION =:toktok  limit 1");
		$membres->execute(array('toktok' => $token));
		foreach ($membres as $membreFinal)
		{
			$membre = $membreFinal;
		}
		
		return  $membre;
}
//Index

function get_annonces_multiparam_AVEC_titre_no_pagination( $id_Ville, $id_valueTypeAnn, $id_categorie_annonce, $titre_rechercher, $string_requete, $id_Region)
{
	$bdd = getBdd();
	$annonces = null;
	//si les régions et les catégories sont renseignées
	if($id_Region ==5000 && $id_Ville == 5000  && $id_categorie_annonce == 5000)
	{
		$annonces = $bdd->query("select ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE = 1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.TITRE_ANNONCE like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     ); 
	}//annonce.EST_UNE_OFFRE =" .mysql_real_escape_string($id_valueTypeAnn). "
	
	
	else if($id_Region ==5000 && $id_Ville == 5000  && $id_categorie_annonce != 5000)
	{
		$annonces = $bdd->query("select  ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE =1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.id_type_annonce = " .$id_categorie_annonce. " AND
										 annonce.TITRE_ANNONCE like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     );
	}
	else if($id_Region ==5000 && $id_Ville != 5000  && $id_categorie_annonce == 5000)
	{
		$annonces = $bdd->query("select  ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 annonce.ID_VILLE = ".$id_Ville." AND
										  annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE =1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.titre_annonce like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     );
		
	}
	else if($id_Region ==5000 && $id_Ville != 5000  && $id_categorie_annonce != 5000)
	{
		$annonces = $bdd->query("select  ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  where
									  annonce.ID_VILLE = ville.ID_VILLE AND
									  annonce.ID_VILLE = ".$id_Ville." AND 
									  annonce.ID_Membre = membre.ID_membre AND
									  annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
									  annonce.EST_VISIBLE =1 AND 
									  annonce.DATE_ANNULATION is null AND
									  annonce.id_type_annonce = " .$id_categorie_annonce. " AND
									  annonce.titre_annonce like '%".$titre_rechercher."%' AND
									  annonce.DATE_VENTE_ACHAT is null
									  ORDER BY ".$string_requete. "");
										
								
							     
		
	}
	else if($id_Region != 5000 && $id_Ville == 5000 && $id_categorie_annonce == 5000)
	{
		$annonces = $bdd->query("select ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 ville.ID_REGION = " .$id_Region. " AND
										 annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE =1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.titre_annonce like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     );
		
	}
	else if($id_Region != 5000 && $id_Ville == 5000 && $id_categorie_annonce != 5000)
	{
		$annonces = $bdd->query("select  ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 ville.ID_REGION = " .$id_Region. " AND
										  annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE =1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.id_type_annonce = " .$id_categorie_annonce. " AND
										 annonce.titre_annonce like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     );
		
	}
	else if($id_Region != 5000 && $id_Ville != 5000 && $id_categorie_annonce == 5000)
	{
		$annonces = $bdd->query("select  ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 ville.ID_VILLE =" .$id_Ville. " AND
										  annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE =1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.titre_annonce like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     );
		
	}
	else if($id_Region != 5000 && $id_Ville != 5000 && $id_categorie_annonce != 5000)
	{
		$annonces = $bdd->query("select  ID_ANNONCE as id_a, annonce.ID_VILLE as id_v, 
									  prix_annonce as p_a, TITRE_ANNONCE as ti_a, TEXTE_ANNONCE as te_a,
									  ville.NOM_FR as ville_nom_fr, ville.NOM_ENG as ville_nom_eng,
									  ville.ID_VILLE as id_v_v, ville.ID_REGION,
									  ID_TYPE_ANNONCE, EST_UNE_OFFRE as e_offre, PSEUDONYME as p_s, EMAIL ,
									  annonce.ID_MEMBRE as id_m, TELEPHONE as tel, EST_CONTACTE_PAR_EMAIL as par_email
									  FROM annonce, ville, membre
									  Where 
										 annonce.ID_VILLE = ville.ID_VILLE AND
										 ville.ID_VILLE =" .$id_Ville. " AND
										  annonce.ID_Membre = membre.ID_membre AND
										 annonce.EST_UNE_OFFRE =" .$id_valueTypeAnn. " AND
										 annonce.EST_VISIBLE =1 AND 
										 annonce.DATE_ANNULATION is null AND
										 annonce.id_type_annonce = " .$id_categorie_annonce. " AND
										 annonce.titre_annonce like '%".$titre_rechercher."%' AND
										 annonce.DATE_VENTE_ACHAT is null 
									  ORDER BY ".$string_requete. ""
							     );
	}
	
		
	return $annonces;
}
function get_mes_annonces_no_pagination($id_Membre, $id_valueTypeAnn, $id_categorie_annonce, $titre_rechercher, $string_requete_Etat, $string_requete_classe_par)
{
	$bdd = getBdd();
	$annonces = null;
	$annonces = $bdd->query("select ID_ANNONCE as id_a,  annonce.ID_VILLE as id_v,DATE_FORMAT(annonce.date_creation, '%d-%m-%Y à %T') as date_crea,
											  prix_annonce as p_a, titre_annonce as ti_a, TEXTE_ANNONCE as te_a, annonce.DATE_ANNULATION as date_annul, 
											  annonce.DATE_VENTE_ACHAT as date_vent_achat, 
											  region.ID_REGION as id_r_r, region.Nom_fr as region_n_fr, 
											  region.Nom_eng as region_n_eng, ville.Nom_fr as ville_n_fr, ville.Nom_eng as ville_n_eng,
											  type_annonce.Nom_fr as typ_n_fr, type_annonce.Nom_eng as typ_n_eng
											  from annonce, membre, ville, type_annonce, region
											  where 
												
												annonce.ID_VILLE = ville.ID_VILLE AND
												ville.ID_REGION = region.ID_REGION AND
												annonce.ID_type_annonce = type_annonce.ID_type_annonce AND
												annonce.ID_Membre = membre.ID_membre AND
												membre.ID_membre =". $id_Membre." AND
												annonce.EST_UNE_OFFRE= ".$id_valueTypeAnn." AND 
												annonce.id_type_annonce = ". $id_categorie_annonce. " AND
												annonce.TITRE_annonce like '%".$titre_rechercher."%' AND
												". $string_requete_Etat ."  
												ORDER BY ".$string_requete_classe_par .""
							     );
		
	return $annonces;
	
}

function get_mes_annonces_with_pagination($id_Membre, $id_valueTypeAnn, $id_categorie_annonce, 
											$titre_rechercher, $string_requete_Etat, $string_requete_classe_par,
											$page_position, $item_per_page)
{
	$bdd = getBdd();
	$annonces = $bdd->query("select id_annonce as id_a,  annonce.id_ville as id_v,DATE_FORMAT(annonce.date_creation, '%d-%m-%Y à %T') as date_crea,
											  prix_annonce as p_a, titre_annonce as ti_a, texte_annonce as te_a, annonce.DATE_ANNULATION as date_annul, 
											  annonce.DATE_VENTE_ACHAT as date_vent_achat, 
											  REGION.ID_REGION as id_r_r, REGION.Nom_fr as region_n_fr, 
											  REGION.Nom_eng as region_n_eng, VILLE.Nom_fr as ville_n_fr, VILLE.Nom_eng as ville_n_eng,
											  type_annonce.Nom_fr as typ_n_fr, type_annonce.Nom_eng as typ_n_eng
											  from annonce, membre, ville, type_annonce, region
											  where 
												
												annonce.ID_VILLE = ville.ID_VILLE AND
												ville.ID_REGION = region.ID_REGION AND
												annonce.ID_type_annonce = type_annonce.ID_type_annonce AND
												annonce.ID_Membre = membre.ID_membre AND
												membre.ID_membre =". $id_Membre." AND
												annonce.EST_UNE_OFFRE= ".$id_valueTypeAnn." AND 
												annonce.id_type_annonce = ". $id_categorie_annonce . " AND
												annonce.TITRE_annonce like '%".$titre_rechercher."%' AND
												". $string_requete_Etat ."  
												ORDER BY ".$string_requete_classe_par ."
												LIMIT ".$page_position.", ".$item_per_page.""
							     );
		
	return $annonces;
	
}
/*
function get_annonces_multiparam_SANS_titre_no_pagination($id_Ville, $id_valueTypeAnn, $id_categorie_annonce, $string_requete)
{
	$bdd = getBdd();
	$annonces = $bdd->query("select  id_annonce as id_a, annonce.id_ville as id_v, 
										  prix_annonce as p_a, titre_annonce as ti_a, texte_annonce as te_a,
										  VILLE.nom_fr as ville_nom_fr, VILLE.nom_eng as ville_nom_eng,
										  VILLE.id_ville as id_v_v,  VILLE.id_region,
										  id_type_annonce, est_une_offre as e_offre, pseudonyme as p_s, email ,
										  annonce.id_membre as id_m, telephone as tel, EST_CONTACTE_PAR_EMAIL as par_email
										  FROM annonce, VILLE, membre
										  Where 
											 
											 annonce.ID_VILLE = VILLE.ID_VILLE AND
											 VILLE.ID_VILLE =".mysql_real_escape_string($id_Ville). " AND
											 annonce.ID_Membre = membre.ID_membre AND
											 EST_UNE_OFFRE =" .mysql_real_escape_string($id_valueTypeAnn) . " AND
											 EST_VISIBLE =1 AND 
											 DATE_ANNULATION is null AND
											 id_type_annonce = ".mysql_real_escape_string($id_categorie_annonce) . " AND
											 DATE_VENTE_ACHAT is null 
										  ORDER BY ".$string_requete. ""
							     );
		
	return $annonces;
}
*/

//Contrôles membre s'inscription



function control_email($email)
{
	$bdd = getBdd();
	$res = 0;
	$query = $bdd->prepare("select count(email) as e_email from membre where email =:email_recherche ");
	$query->execute(
					array('email_recherche' =>$email)
					);
	foreach($query as $quer)
	{
		$res = $quer["e_email"];
	}
	
	return $res;
}

function control_telephone($telephone)
{
	$bdd = getBdd();
	$res = 0;
	$query = $bdd->prepare("select count(telephone) as e_tel from membre where telephone =:tel_recherche ");
	$query->execute(
					array('tel_recherche' =>$telephone)
					);
	foreach($query as $quer)
	{
		$res = $quer["e_tel"];
	}
	
	return $res;
}

function control_mot_de_passe($mdp)
{
	$bdd = getBdd();
	$res = 0;
	$query = $bdd->prepare("select count(mot_de_passe) as e_mdp from membre where mot_de_passe =:mdp_recherche ");
	$query->execute(
					array('mdp_recherche' =>hash("sha512",$mdp))
					);
	foreach($query as $quer)
	{
		$res = $quer["e_mdp"];
	}
	
	return $res;
}

function control_pseudonyme($pseudo)
{
	$bdd = getBdd();
	$res = 0;
	$query = $bdd->prepare("select count(pseudonyme) as e_pseudo from membre where pseudonyme =:pseudo_recherche ");
	$query->execute(
					array('pseudo_recherche' =>$pseudo)
					);
	foreach($query as $quer)
	{
		$res = $quer["e_pseudo"];
	}
	
	return $res;
}

function email_et_mdp_au_meme_membre($email, $mdp)
{
	$bdd = getBdd();
	$pseudonyme = null;
	$password= hash("sha512",(htmlspecialchars($mdp)));
	$req = $bdd->prepare('SELECT  pseudonyme as e_pseudo FROM membre where est_active = 1 and email =:mail and mot_de_passe =:motdp');
		 $req->execute(array('mail' =>$email, 'motdp' =>$password));
	foreach($req as $quer)
	{
		$pseudonyme = $quer["e_pseudo"];
	}
	return $pseudonyme;
}

function get_activation_account_status_by_using_mail($email)
{
	$bdd = getBdd();
	$is_active = 0;
	$req = $bdd->prepare('SELECT  est_active as e_activ FROM membre where email =:mail ');
		 $req->execute(array('mail' =>$email));
	foreach($req as $quer)
	{
		$is_active = $quer["e_activ"];
	}
	return $is_active;
}

function get_activation_account_status($email, $mdp)
{

	try
	{
		$bdd = getBdd();
		$is_active = 0;
		$password= hash("sha512",(htmlspecialchars($mdp)));
		$req = $bdd->prepare('SELECT  est_active as e_activ FROM membre where email =:mail and mot_de_passe =:motdp');
			$req->execute(array('mail' =>$email, 'motdp' =>$password));
		foreach($req as $quer)
		{
			$is_active = $quer["e_activ"];
		}
		return $is_active;
	}
	catch(Exception $e)
	{
		console.log('Error update_is_active '.$e->getmessage());
	}
}

function update_is_active($email, $token_activ_membre)
{
	try{

	
	$bdd = getBdd();
	/*$annonces = $bdd->query("UPDATE membre 
				 SET est_active = 1
				 WHERE email like '".htmlspecialchars($email)."' and token_activatation like '".htmlspecialchars($token_activ_membre)."' ");	
		*/		 
		$membre = $bdd->prepare('UPDATE membre 
						 SET date_modification = NOW(), 
								est_active = 1
						 WHERE email = :email and token_activation = :token');	
	$membre->execute(array(
								'email'=>htmlspecialchars($email),
								'token'=>htmlspecialchars($token_activ_membre)) )	;	

							}
							catch(Exception $e)
							{
								console.log('Error update_is_active '.$e->getmessage());
							}
}

function update_is_active_facebook($email)
{
	$bdd = getBdd();
	/*$annonces = $bdd->query("UPDATE membre 
				 SET est_active = 1
				 WHERE email like '".htmlspecialchars($email)."' and token_activatation like '".htmlspecialchars($token_activ_membre)."' ");	
		*/		 
		$membre = $bdd->prepare('UPDATE membre 
						 SET date_modification = NOW(), 
								est_active = 1
						 WHERE email = :email');	
	$membre->execute(array(
								'email'=>htmlspecialchars($email)
								 ))	;	
}

function compare_mdp_mdpDeLaBDD($mdpAComprarer, $idMembre)
{
	if($mdpAComprarer != null)
	{
		$membre = getMembreByMotDePasse($mdpAComprarer);
		$idMembreTouver = $membre['idm'];
		if($idMembreTouver != null)
		{
			if(intval($idMembre) == intval($idMembreTouver))
			{
				return "OK";
			}
			else
{
			    return "KO";
			}
		}
		else
		{
			return "KO";
		}
			
	}
	else
	{
		return "KO";
	}
	
	
	
	
}
//Suppressions
function suppression_annonces_et_photoAnnonces($id_ann)
{
	supprimer_Annonce_Via_id($id_ann);
		/*Mis en commentaires
		$annonces = $bdd->query('UPDATE annonce 
				 SET date_annulation = NOW()
				 WHERE id_annonce ='.intval($_GET['ann']).'');	
				 
		*/
		
			//Et supprimons les photo de l'annonces et du repertoire
			
		supprimer_toute_photoAnnonce($id_ann);	
			//echo '<body onLoad="alert (\'Vous venez de supprimer votre annonce :) \')">';
			//puis on le redirige vers la page d'accueil
}
function supprimer_toute_photoAnnonce($id_annonce)
{
	$bdd = getBdd();
	$id=0;
	$photos = $bdd->prepare('select id_photo from photo where id_annonce =:idAnnonce');
	$photos->execute(array('idAnnonce'=>$id_annonce));
	if($photos != null)
	{
		foreach($photos as $photo)
		{
			$id=$photo['id_photo'];
			//date annulation photo à null
			supprimer_photo_par_idPhoto($id);
		}
	}
}

//create July 2016
function sauverAnnonce($idMembre, $ville, $categorie_annonce, $prix, $titre_annonce,
						$details_annonce, $isVisible, $offre, $dateCreation, $etre_contacte_par_email, $langue )
{
	$bdd = getBdd();
	$req = $bdd->prepare('INSERT INTO annonce 
											(ID_MEMBRE, 
											ID_VILLE, 
											ID_TYPE_ANNONCE, 
											PRIX_ANNONCE, 
											TITRE_ANNONCE, 
											TEXTE_ANNONCE, 
											EST_VISIBLE, 
											EST_UNE_OFFRE, 
											DATE_CREATION, 
											EST_CONTACTE_PAR_EMAIL,
											LANGUE)
							VALUES
							(
								:idMembre,
								:idVil,
								:idTypAnn,
								:prix_ann,
								:title,
								:texteAnn,
								:isVisible,
								:isOffer,
								:createDate,
								:isContactByEmail,
								:langue
							)' 
						);
						
			$req->execute(array(
								'idMembre'=>$idMembre,
								'idVil'=>$ville,
								'idTypAnn'=>$categorie_annonce,
								'prix_ann'=>$prix,
								'title'=>$titre_annonce,
								'texteAnn'=>$details_annonce,
								'isVisible'=>1,
								'isOffer'=>$offre,
								'createDate'=>$dateCreation,
								'isContactByEmail'=>$etre_contacte_par_email,
								'langue'=>$langue)) ;
			$req->closecursor();//ON FERME LA REQUETTE	
			$id_annonce = get_derniere_id_annonce_enregistree($idMembre);
}

function supprimer_Annonce_Via_id($id_Ann)
{
	$bdd = getBdd();
	
	$annonces = $bdd->query('UPDATE annonce 
				 SET date_annulation = NOW()
				 WHERE id_annonce ='.htmlspecialchars($id_Ann).'');		 
	
}

function supprimer_photo_par_idPhoto($id_photo)
{
	$bdd = getBdd();
	$description = 0;
	$chemin=$_SERVER['DOCUMENT_ROOT'];
	$var = "";
	$varChemin = "/KmerMarketFinal/";
	//$chemin='';
	$supprimeer = $bdd->prepare("SELECT file_description as description, file_final_name as final from photo where id_photo =:pot");
	$supprimeer->execute(array('pot'=>$id_photo));
	if($supprimeer !=null)
	{
		foreach($supprimeer as $super)
		{
			//variable en local host utiliser ce chemin :)!
			//$chemin =$chemin."/KmerMarketFinal/".$super['final'];
			$chemin =$chemin."/".$super['final'];
			//KmerMarketFinal
			//$chemin =$chemin."/".$super['final'];
			$description =$super['description'];
		}
	}
	$msg=false;
	//Suppression dans le dossier
	
	
	//get the link of the true name of the file :)
	//delete the file in the appropriate folder
	if(!unlink($chemin))
	{
		//echo('Not suppress');
	}
	else
	{
		$msg=true;
	}
	
	//dirname("index.php");
	//***** ATTENTION WORKING****
	if($msg)
	{
		$phot = $bdd->query('DELETE FROM photo
						WHERE id_photo ='.htmlspecialchars($id_photo).'');
		
	}
	//return $description;		
		return $description;		
	
	
	
		
}

//formatage
function formater_Texte_Annonce_Index($texte_annonce)
{
	$taille = strlen($texte_annonce);
	$part = $texte_annonce;
	if($taille > 100)
	{
		$part = substr($texte_annonce, 0, 100);
		$part = $part."...";
	}
	return $part;
}

function formater_Prix($prix)
{
	
	
	$taille = strlen($prix);
	$part_1 = $prix;
	if($taille <= 6 and $taille > 3)
	{
		$part_1 = substr_replace($prix, " ", $taille-3,0);
	}
	else if($taille <= 9 and $taille >6)
	{
		$part_1 = substr_replace($prix, " ", $taille-3,0);
		$part_1 = substr_replace($part_1, " ", $taille-6,0);
	}
	else if($taille <= 12 and $taille >9)
	{
		$part_1 = substr_replace($prix, " ", $taille-3,0);
		$part_1 = substr_replace($part_1, " ", $taille-6,0);
		$part_1 = substr_replace($part_1, " ", $taille-9,0);
	}
	else if($taille <= 15 and $taille >12)
	{
		$part_1 = substr_replace($prix, " ", $taille-3,0);
		$part_1 = substr_replace($part_1, " ", $taille-6,0);
		$part_1 = substr_replace($part_1, " ", $taille-9,0);
		$part_1 = substr_replace($part_1, " ", $taille-12,0);
	}
	else if($taille <= 18 and $taille >15)
	{
		$part_1 = substr_replace($prix, " ", $taille-3,0);
		$part_1 = substr_replace($part_1, " ", $taille-6,0);
		$part_1 = substr_replace($part_1, " ", $taille-9,0);
		$part_1 = substr_replace($part_1, " ", $taille-12,0);
		$part_1 = substr_replace($part_1, " ", $taille-15,0);
	}
	else if($taille <= 21 and $taille >18)
	{
		$part_1 = substr_replace($prix, " ", $taille-3,0);
		$part_1 = substr_replace($part_1, " ", $taille-6,0);
		$part_1 = substr_replace($part_1, " ", $taille-9,0);
		$part_1 = substr_replace($part_1, " ", $taille-12,0);
		$part_1 = substr_replace($part_1, " ", $taille-15,0);
		$part_1 = substr_replace($part_1, " ", $taille-18,0);
	}
	return $part_1 ;
	
}

//9 chiffres je pense, non 8 d'après number de diégo
function formater_telephone($tel)
{
		$taille = strlen($tel);
		$part_1 = $tel;
		$part_1 = substr_replace($tel, " ", $taille-3,0);
		$part_1 = substr_replace($part_1, " ", $taille-6,0);
		$part_1 = substr_replace($part_1, " ", $taille-9,0);
		//$part_1 = substr_replace($part_1, " ", $taille-8,0);
		return $part_1 ;
}


//PAGINATION DO

/**
* Affiche la pagination à l'endroit où cette fonction est appelée
* @param string $url L'URL ou nom de la page appelant la fonction, ex: 'index.php' ou 'http://example.com/'
* @param string $link La nom du paramètre pour la page affichée dans l'URL, ex: '?page=' ou '?&p='
* @param int $total Le nombre total de pages
* @param int $current Le numéro de la page courante
* @param int $adj (facultatif) Le nombre de pages affichées de chaque côté de la page courante (défaut : 3)
* @return La chaîne de caractères permettant d'afficher la pagination
*/



//Cette fonction génère, sauvegarde et retourne un token
//Vous pouvez lui passer en paramètre optionnel un nom pour différencier les formulaires
function generer_token($nom = 'NoumiSoc')
{
	session_start();
	$token = uniqid(rand(), true);
	$_SESSION[$nom.'_token'] = $token;
	$_SESSION[$nom.'_token_time'] = time();
	return $token;
}


//**************************************************************************//
//**************************************************************************//
//**************************************************************************//


//Cette fonction vérifie le token
//Vous passez en argument le temps de validité (en secondes)
//Le referer attendu (adresse absolue, rappelez-vous :D)
//Le nom optionnel si vous en avez défini un lors de la création du token
function verifier_token($temps, $referer, $nom = '')
{
	//Attension penser à mettre le session_start();
	if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']))
	if($_SESSION[$nom.'_token'] == $_POST['token'])
		if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
			if($_SERVER['HTTP_REFERER'] == $referer)
				return true;
return false;
}

//***********************************MAIL***********************************//


//ATTTENTION utiliser html_entity_decode si on envoi les accents voir "models/envoiEmailAnnonceur.php :) ligne 110
function send_km_mails($fromEmail, $fromName, $toEmail, $toName, $subject, $AltBody, $Body)
{
	$mail = new PHPMailer();
	$mail->CharSet = "UTF-8";
	//$mail->isSMTP();  //Decomment for localhost
	
	//Set SMTP host name                          
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "somenfranc@gmail.com";                 
$mail->Password = "Eolev2022";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";   

//Add of 31/08/2016
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);                        
//Set TCP port to connect to 
$mail->Port = 587;  
$Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line 


	//decomment to see error messages
	//$mail->SMTPDebug = 2;

	$mail->From =$fromEmail;
	$mail->FromName = $fromName;

	$mail->addAddress($toEmail, $toName);




	//Set the subject line
	$mail->Subject =  stripslashes($subject);
	$mail->AltBody = $AltBody;
	$mail->Body = $Body;

	//send the message, check for errors
	if (!$mail->send()) {
		//To uncomment though
		//echo "Mailer Error: " . $mail->ErrorInfo;
		echo ("Le mail n'a pas été envoyé. Merci de reéssayer :)");
	} else {
		echo ("2015");
	}

}
