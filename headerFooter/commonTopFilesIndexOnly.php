<?php 
//This file is used on top of other files
//to decide what navigation to used
//used to decide the dispaly we want

    $isUserConnected = false;
    $userPseudo = "";
    $_SESSION["index"]="true";
    $_SESSION["annonces"]="active";
    $_SESSION["mesAnnonces"]="";
    $_SESSION["compte"]="";
    $_SESSION["myProduct"]="";
    
    if(isset($_GET["pseu"]))
    {
      $_SESSION['pseudonyme'] = $_GET["pseu"];
      
    }
    //Check if the pseudonyme is there or not
    if(isset($_SESSION['pseudonyme']))
    {
        //Set the variables to reuse in other files
        $isUserConnected = true;
        $userPseudo = $_SESSION['pseudonyme'];
        
    }




?>