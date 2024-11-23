
<header>
			<!--<img  src="img/km.png" alt="KmerMarket logo"/>-->
			<ul class="nav nav-pills ">
						<!--<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>-->
						<?php 
						//On est dans Index.php
						if($_SESSION["index"] =="true")
						{
							//Big screens :)
							echo('<li role="presentation" class="big_screen"  id="loglog">');
								echo('<a id="a_brand" href="index.php">');
									echo('<img id="logoBrand" alt="KmerMarketBrand" src="img/kmermarket.png" >');	
								echo('</a>');
							echo('</li>');
							echo('<li role="presentation"  class="big_screen '.$_SESSION["annonces"].'"><a href="index.php">Annonces</a></li>');
							
							//Pour les petites tailles :)
							echo('<li role="presentation" class="small_screen" id="loglog">');
								echo('<a id="a_brand" href="index.php">');
									echo('<img id="logoBrand" alt="KmerMarketBrand" src="img/trueLogoKmerMarket.png" >');	
								echo('</a>');
							echo('</li>');
							echo('<li role="presentation" class="small_screen '.$_SESSION["annonces"].' "><a href="index.php"><img src="img/shop.png" src="home"/></a></li>');
							
							//Est ce que mon membre est connect� ???
								if ($isUserConnected)//isset($_SESSION['pseudonyme'])  )
								{
									
									echo('<li role="presentation"  class="big_screen '. $_SESSION["mesAnnonces"].'"><a href="annonces/mesAnnonces.php?pseu='.$userPseudo.'">Mes Annonces</a></li>');
									echo('<li role="presentation"  class="big_screen '. $_SESSION["compte"].'"><a href="comptes/compte.php?pseu='.$userPseudo.'">'.$userPseudo.'</a></li>');
									echo('<li role="presentation" class="big_screen" ><a href="comptes/logout.php">Déconnexion</a></li>');
									//Small screens
									
									echo('<li role="presentation"  class="small_screen '. $_SESSION["mesAnnonces"].'"><a href="annonces/mesAnnonces.php?pseu='.$userPseudo.'"><img src="img/mesAnnonces.png" alt="mes annonces"/></a></li>');
									echo('<li role="presentation" class="small_screen '. $_SESSION["compte"].' "><a href="comptes/compte.php?pseu='.$userPseudo.'"><img src="img/compte.png" alt="compte"/></a></li>');
									echo('<li role="presentation" class="small_screen" ><a href="comptes/logout.php"><img src="img/deconnexion.png" alt="deconnexion"/></a></li>');
								}
								else
								{
									
									echo('<li role="presentation"  class="big_screen"><a href="comptes/connection.php">connexion</a></li>');
									echo('<li role="presentation"  class="big_screen"><a href="comptes/inscription.php">Inscription</a></li>');
									
									//Small screens
									echo('<li role="presentation"  class="small_screen"><a href="comptes/connection.php"><img src="img/connexion.png" alt="connetion"/></a></li>');
									echo('<li role="presentation"  class="small_screen"><a href="comptes/inscription.php"><img src="img/inscription.png" alt="inscription"/></a></li>');
								}
							
							//echo('<li role="presentation"  class="big_screen '. $_SESSION["meteo"].'"><a href="meteo/meteo.php">Météo</a></li>');
							//small meteo
							//echo('<li role="presentation" class="small_screen '. $_SESSION["meteo"].' "><a href="img/meteo.php"><img src="img/meteo.png"alt="meteo"/></a></li>');
							
							
							
						
						}
						
						
						else //On est hors de index
						{
							
							
							
							//Big screen
							echo('<li role="presentation" class="big_screen" id="loglog">');
								echo('<a id="a_brand" href="../index.php">');
									echo('<img id="logoBrand" alt="KmerMarketBrand" src="../img/kmermarket.png" >');	
								echo('</a>');
							echo('</li>');
							echo('<li role="presentation" class="big_screen '.$_SESSION["annonces"].'" ><a href="../index.php">Annonces</a></li>');
							
							//small sreen
							echo('<li role="presentation" class="small_screen" id="loglog">');
								echo('<a id="a_brand" href="../index.php">');
									echo('<img id="logoBrand" alt="KmerMarketBrand" src="../img/trueLogoKmerMarket.png" >');	
								echo('</a>');
							echo('</li>');
							echo('<li role="presentation" class="small_screen '.$_SESSION["annonces"].'" ><a href="../index.php"><img src="../img/shop.png" src="home"/></a></li>');
							
								
							
							//Est ce que mon membre est connecté ???
								if ($isUserConnected)//isset($_SESSION['pseudonyme'])  )
								{
									
									echo('<li role="presentation" class="big_screen '. $_SESSION["mesAnnonces"].'"><a href="../annonces/mesAnnonces.php?pseu='.$userPseudo.'">Mes Annonces</a></li>');
									echo('<li role="presentation" class="big_screen '. $_SESSION["compte"].'"><a href="../comptes/compte.php?pseu='.$userPseudo.'">'.$userPseudo.'</a></li>');
									echo('<li role="presentation" class="big_screen" ><a href="../comptes/logout.php">Déconnexion</a></li>');
									
									//small screens
									echo('<li role="presentation"  class="small_screen '. $_SESSION["mesAnnonces"].'"><a href="../annonces/mesAnnonces.php?pseu='.$userPseudo.'"><img src="../img/mesAnnonces.png" alt="mes annonces"/></a></li>');
									echo('<li role="presentation"  class="small_screen '. $_SESSION["compte"].'"><a href="../comptes/compte.php?pseu='.$userPseudo.'"><img src="../img/compte.png" alt="compte"/></a></li>');
									echo('<li role="presentation"  class="small_screen"><a href="../comptes/logout.php"><img src="../img/deconnexion.png" alt="deconnexion"/></a></li>');
									
								}
								else
								{
									
									echo('<li role="presentation" class="big_screen" ><a href="../comptes/connection.php">connexion</a></li>');
									echo('<li role="presentation"  class="big_screen"><a href="../comptes/inscription.php">Inscription</a></li>');
									
									//small screens
									
									echo('<li role="presentation"  class="small_screen"><a href="../comptes/connection.php"><img src="../img/connexion.png" alt="connexion"/></a></li>');
									echo('<li role="presentation" class="small_screen" ><a href="../comptes/inscription.php"><img src="../img/inscription.png" alt="inscription"/></a></li>');
									
								}
							
							//echo('<li role="presentation" class="big_screen '. $_SESSION["meteo"].'"><a href="../meteo/meteo.php">Météo</a></li>');
							//small screens
							//echo('<li role="presentation" class="small_screen '. $_SESSION["meteo"].'"><a href="../meteo/meteo.php"><a href="../img/meteo.php"><img src="../img/meteo.png"alt="meteo"/></a></li>');
					    
						}
						?>
					  
						
			</ul>
			
</header>


