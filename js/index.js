function afficheMasque()
{
	
	var idButton = document.getElementById("dispSearch");
	var titleButton = idButton.innerHTML;
	console.log("1 "+titleButton);
	idButton.innerHTML ="Masquer Recherche";
	console.log("2 "+titleButton);
	if(titleButton=="Afficher Recherche")
	{
		console.log("3 "+titleButton);
		idButton.innerHTML ="Masquer Recherche";
	}
	else if(titleButton=="Masquer Recherche")
	{
		console.log("4 "+titleButton);
		idButton.innerHTML = "Afficher Recherche";
	}
	
}
		//Récupérer les annonces dans la bdd
		function request()
		{
			
			var id_valueTypeAnn = document.getElementById("offre").checked;
			if(id_valueTypeAnn)
				id_valueTypeAnn=1;
			else
				id_valueTypeAnn=0;
			
			
				var id_Region = 0;
			if(document.getElementById("Region").
				options[(document.getElementById("Region")).
				selectedIndex]==null)
				{
					id_Region = 5000;
				}
				else
				{
					id_Region = document.getElementById("Region").
				options[(document.getElementById("Region")).
				selectedIndex].value;
				}
			
			var id_Ville = document.getElementById("Ville").
							options[(document.getElementById("Ville")).
							selectedIndex].value;
			var id_categorie_annonce = document.getElementById("Categorie_annonce").
							options[(document.getElementById("Categorie_annonce")).
							selectedIndex].value;
							
			//Tenir compte du choix du tri su Select :)
			var choix_tri_annonce = document.getElementById("tri_resultat").
						 options[(document.getElementById("tri_resultat")).
						 selectedIndex].value;
						 
			//valeur du titre de l'annonce recherchée, et on trim
			var titre_rechercher = document.getElementById("recherche_titre").value;
			
			
			if (titre_rechercher=="")
			{
				titre_rechercher = " ";
			}
			
			//console.log("titre recherché="+titre_rechercher+"ello");
			
			
			var xhr = getXMLHttpRequest();
			xhr.open("POST","models/data.php" , true); //old models/dataTest.php
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("Type_Annonce="+id_valueTypeAnn+
					 "&Region="+id_Region+
					 "&Ville="+id_Ville+
					 "&Categorie_annonce="+id_categorie_annonce+
					 "&Tri_ann="+choix_tri_annonce+
					 "&title="+titre_rechercher);
			
			xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					//location.assign("index.php");
					readData(xhr.responseXML);
					//Ce que je reçois
					//console.log("ce que je reçois "+xhr);
					document.getElementById("loader").style.display = "none";
				} else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			
					 
					
		}
		
	
		
		function readData(oData)
		{
			if(oData != null)
			{
				
					
						//alert(oData);
						var items = oData.getElementsByTagName("item");
						var href = oData.getElementsByTagName("href");
						var src = oData.getElementsByTagName("src");
						var alt = oData.getElementsByTagName("alt");
						var h33 = oData.getElementsByTagName("h3");
						var em33 = oData.getElementsByTagName("em");
						var h533 = oData.getElementsByTagName("h5");
						var p33 = oData.getElementsByTagName("p");
						var total_annonce = oData.getElementsByTagName("total");
						
						var socle = document.getElementById("super_annonce");
						
						var a, aInner, div_sup, div_contenant;
						var	div_contenant_contenant,  img, imgSrc, imgAlt;
						var h3, h3Inner, em, emInner, h5, h5Inner,  p, pInner;	
						
						
						//Les pages franc let's go !
						var  selectPage= document.getElementById("Pages");
						//Vider le select
						selectPage.innerHTML = ""; 
						var total_pages = (items.length)/9;
						//Charger le select des pages --- appel de la fonction
						chargerPage(selectPage, total_pages);
						
						
						//new adds 03 10 2017
						var divShareIt, divLabelPartager, h5Partager, divFacebook;
                        var aFacebook, 	imgFacebook, divWhatsapp, 	aWhatsapp;
                        var imgWhatsapp, divTwitter, aTwitter, 	imgTwitter;				
						
						//Get the variables new adds 03 10 2017
						var shareTwitter=oData.getElementsByTagName("shareTwitter");
						var shareWhatsapp=oData.getElementsByTagName("shareWhatsapp");
						var shareFacebook=oData.getElementsByTagName("shareFacebook");
						var complementSahreFacebook = "/&layout=button&size=small&mobile_iframe=true&width=60&height=20&appId";
						
					
						
						//Text 04 10 2017
						var partagerText = "Partagez à vos amis :)";
						
						var dataActionFacebook = "";
						var dataActionWhatsapp = "share/whatsapp/share";
						var dataActionTwitter = "";
						
						
						var srcFacebook = "img/facebook.png";
						var srcWhatsapp = "img/whatsapp.png";
						var srcTwitter = "img/twitter.png";
						
					
						
						//On vide les contenaires
						socle.innerHTML = ""; 
						//total.innerHTML = "";
						
						if(items.length==0) 
						{
							
							
						}
						else
						{
							//Afficher du total des annonces
							
							//total.innerHTML =""+items.length+" résultats :)";
							
							
							//charger les annonces
								var k = items.length;
								if (k > 9)
									k = 9;
								
								for(var i = 0, c=k; i<c; i++)
								{
									 
									 
										div_sup = document.createElement("div");
										div_sup.setAttribute('class', "col-xs-12 col-sm-4 col-md-3");
										socle.appendChild(div_sup);
											
											div_contenant = document.createElement("div");
											div_contenant.setAttribute('class',"Thumbnail")	;
											div_sup.appendChild(div_contenant);
											
											 //done
												 a = document.createElement("a");
												 aInner = href[i].firstChild.nodeValue;
												 a.setAttribute('href', "annonces/detailAnnonce.php?ann="+aInner);
												 div_contenant.appendChild(a);
									 
												//done
													img = document.createElement("img");
													imgSrc =  src[i].firstChild.nodeValue;
													imgAlt =  alt[i].firstChild.nodeValue;
													if(imgSrc=="#")
													{
														imgSrc = "img/default1.jpg";
													}
													img.setAttribute('src',imgSrc);
													img.setAttribute('alt',imgAlt);
													a.appendChild(img);
													
													div_contenant_contenant = document.createElement("div");
													div_contenant_contenant.setAttribute('class',"caption")	;
													a.appendChild(div_contenant_contenant);
										 //Ajout 06 05 2018 numéro annonce 
										 aInner = '#'+aInner;
														h3 = document.createElement("h3");
														  h3Inner =  document.createTextNode(aInner);
														  h3.appendChild(h3Inner);
														  div_contenant_contenant.appendChild(h3);
										 //end modif :)
														  h3 = document.createElement("h3");
														  h3Inner =  document.createTextNode(h33[i].firstChild.nodeValue);
														  h3.appendChild(h3Inner);
														  div_contenant_contenant.appendChild(h3);
														  //alert("ATRIBUT DE XML H3 = "+h33[i].firstChild.nodeValue);
														  
														  em = document.createElement("em");
														  emInner =  document.createTextNode((em33[i].firstChild.nodeValue));
														  em.appendChild(emInner);
														  div_contenant_contenant.appendChild(em);
														 // alert("ATRIBUT DE XML H3 = "+em33[i].firstChild.nodeValue);
														  
														  h5 = document.createElement("h5");
														  h5Inner =  document.createTextNode(h533[i].firstChild.nodeValue+" F CFA");
														  h5.appendChild(h5Inner);
														  div_contenant_contenant.appendChild(h5);
														  
														
														  
													//new adds 03 10 2017 <div class="shareIt row"> 
														  divShareIt = document.createElement("div");
														  divShareIt.setAttribute('class',"shareIt row");
														  div_contenant_contenant.appendChild(divShareIt);
														  
															//The contents of sharing
															divLabelPartager = document.createElement("div");
															divLabelPartager.setAttribute('class','col-xs-12 labelPartager');
														    divShareIt.appendChild(divLabelPartager);
															
																//h5 texte partager
																h5Partager=document.createElement("h5");
																h5Partager.appendChild(document.createTextNode(partagerText));
																divLabelPartager.appendChild(h5Partager);
														  
														  
														   //Facebook step div is an iframe pay attention
															divFacebook=document.createElement("iframe");
															//divFacebook.setAttribute('class','col-xs-4');
															divFacebook.setAttribute("src",shareFacebook[i].firstChild.nodeValue+complementSahreFacebook);
															divFacebook.setAttribute("width","80");
															divFacebook.setAttribute("height","20");
															divFacebook.setAttribute("style","border:none;overflow:hidden; width:80px;");
															divFacebook.setAttribute("scrolling","no");
															divFacebook.setAttribute("frameborder","0");
															divFacebook.setAttribute("allowTransparency","true");															
															
															
															divShareIt.appendChild(divFacebook);
																//the link for facebook to update at work
																
																	
															
															//Whatsapp step
															divWhatsapp=document.createElement("div");
															divWhatsapp.setAttribute('class','col-xs-5');
															divShareIt.appendChild(divWhatsapp);
																//the link for facebook to update at work
																aWhatsapp=document.createElement("a");
																aWhatsapp.setAttribute("href",shareWhatsapp[i].firstChild.nodeValue);
																aWhatsapp.setAttribute("target","blank");
																aWhatsapp.setAttribute("data-action",dataActionWhatsapp);
																divWhatsapp.appendChild(aWhatsapp);
																	//image for facebook
																	imgWhatsapp=document.createElement("img");
																	imgWhatsapp.setAttribute("height","10px");
																	imgWhatsapp.setAttribute("width","10px");
																	imgWhatsapp.setAttribute("src",srcWhatsapp);
																	aWhatsapp.appendChild(imgWhatsapp);
												
									
								}
								
								
						
						}
		
			
			
			}
						
			
			
		}
	
		//Les régions
		function chargerRegions()
		{
				
				//en ajax :)
				var xhr = getXMLHttpRequest();
			
				//xhr.open("GET","http://www.kmermarket.com/dataRegionsIndex.php?Region=region", true, "dbo609046157", "Eolev2022@@" );
				//xhr.open("GET","data/reportsRegions.xml", true);
				xhr.open("POST","models/dataRegionsIndex.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("Region=region");
				xhr.onreadystatechange = 
			function(){
							if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
							{
								readDataRegionsIndex(xhr.responseXML);
								
								//document.getElementById("loader").style.display = "none";
								//console.log('dans le if des régions :) 444444 xhr.readyState'+xhr.readyState);
							} else if (xhr.readyState < 4) {
								//loader for image
								document.getElementById("loader").style.display = "inline";
								
							}
				
						};
			
			
			
				
		}	
		
		function readDataRegionsIndex(oData)
		{
			if(oData != null)
			{
				
							
							//console.log("oData = "+oData);
							var items = oData.getElementsByTagName("item");
							//console.log("la taille des régions = "+items.length);
							//le select de la ville
							var selectRegion = document.getElementById("Region");
							//la ville en français :)
							var regions = oData.getElementsByTagName("regionfr");
							var valeurs = oData.getElementsByTagName("idRegion");
							
							//les variables dynamiques 
							 var option;
							
							
							//vider le select :)
								while(selectRegion.length > 0)
								{
									selectRegion.remove(0);
								
								}
								
								
								
								
							if(items.length > 0)
							{
								for(var i = 0, c=items.length; i<c; i++)
								{
									 
										option = document.createElement("option");
										option.setAttribute('value', valeurs[i].firstChild.nodeValue);
										option.text = regions[i].firstChild.nodeValue;
										 selectRegion.add(option);
									 
								}
							}
			
			
	
			}
			
		}
		
		
		
		
		//Les villes
		/*fonction loading des villes au chargement et à la variation du select*/
		function chargerVilles()
		{
				var idRegion;
				//en ajax :)
				if(document.getElementById("Region").
				options[(document.getElementById("Region")).
				selectedIndex]==null)
				{
					idRegion = 5000;
				}
				else
				{
					idRegion = document.getElementById("Region").
				options[(document.getElementById("Region")).
				selectedIndex].value;
				}
				
				
				var xhr = getXMLHttpRequest();
				xhr.open("POST","models/dataVillesIndex.php" , true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("Region="+idRegion);
				xhr.onreadystatechange = 
				function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					readDataVillesIndex(xhr.responseXML);
					//document.getElementById("loader").style.display = "none";
					
				} else if (xhr.readyState < 4) 
				{
					
				}
				
			};
			
			
			
				
		}	

		function readDataVillesIndex(oData)
		{
			if(oData != null)
			{
				
			
				var items = oData.getElementsByTagName("item");
				//le select de la ville
				var selectVille = document.getElementById("Ville");
				//la ville en français :)
				var villes = oData.getElementsByTagName("villefr");
				var valeurs = oData.getElementsByTagName("idVille");
				
				//les variables dynamiques 
				 var option;
				
				
				//vider le select :)
					while(selectVille.length > 0)
					{
						selectVille.remove(0);
					
					}
					
					for(var i = 0, c=items.length; i<c; i++)
					{
						 
							option = document.createElement("option");
							option.setAttribute('value', valeurs[i].firstChild.nodeValue);
							option.text = villes[i].firstChild.nodeValue;
							 selectVille.add(option);
						 
					}
				
				// A DECOMMENTER
				request();
	
			}
			
		}
		

//Les TYPES D'ANNONCE

		function chargerTypeAnnonces()
		{
				
				//en ajax :)
				var xhr = getXMLHttpRequest();
				
				
				xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					readDataTypeAnnoncesIndex(xhr.responseXML);
					//document.getElementById("loader").style.display = "none";
					
				} else if (xhr.readyState < 4) {
					//document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			
			xhr.open("POST","models/dataTypeAnnoncesIndex.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			//Ne sert à rien juste un contrôle
			xhr.send("Categorie_annonce=cat");
				
		}	
		
		function readDataTypeAnnoncesIndex(oData)
		{
			if(oData != null)
			{
				
			
				alert("Hello world");
				var items = oData.getElementsByTagName("item");
				//console.log("la taille des catégories annonce = "+items.length);
				//le select de la ville
				var selectCategorieAnnonce = document.getElementById("Categorie_annonce");
				//la ville en français :)
				var typeAnnonces = oData.getElementsByTagName("typefr");
				var valeurs = oData.getElementsByTagName("idTypeAnn");
				
				//les variables dynamiques 
				 var option;
				
				
				//vider le select :)
					while(selectCategorieAnnonce.length > 0)
					{
						selectCategorieAnnonce.remove(0);
					
					}
					
					
					
					
				if(items.length > 0)
				{
					for(var i = 0, c=items.length; i<c; i++)
					{
						 
							option = document.createElement("option");
							option.setAttribute('value', valeurs[i].firstChild.nodeValue);
							option.text = typeAnnonces[i].firstChild.nodeValue;
							 selectCategorieAnnonce.add(option);
						 
					}
				}
				
			}
			
			
		}		

		
// CHARGER PAGES

function chargerPages()
{
	var id_valueTypeAnn = document.getElementById("offre").checked;
			if(id_valueTypeAnn)
				id_valueTypeAnn=1;
			else
				id_valueTypeAnn=0;
			
			
				var id_Region = 5000;
			
			
			var id_Ville = 5000;
			var id_categorie_annonce = 5000;
							
			//Tenir compte du choix du tri su Select :)
			var choix_tri_annonce = document.getElementById("tri_resultat").
						 options[(document.getElementById("tri_resultat")).
						 selectedIndex].value;
						 
			//valeur du titre de l'annonce recherchée, et on trim
			var titre_rechercher = document.getElementById("recherche_titre").value;
			
			
			if (titre_rechercher=="")
			{
				titre_rechercher = " ";
			}
			
			//console.log("titre recherché="+titre_rechercher+"ello");
			
			
			var xhr = getXMLHttpRequest();
			xhr.open("POST","models/dataPagesIndex.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("Type_Annonce="+id_valueTypeAnn+
					 "&Region="+id_Region+
					 "&Ville="+id_Ville+
					 "&Categorie_annonce="+id_categorie_annonce+
					 "&Tri_ann="+choix_tri_annonce+
					 "&title="+titre_rechercher);
			
			xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					//location.assign("index.php");
					readDataPageIndex(xhr.responseXML);
					//Ce que je reçois
					//console.log("ce que je reçois "+xhr);
					document.getElementById("loader").style.display = "none";
				} else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			
					 
}
//----------- PAAAAAAAAAAAAAAAAAAAAAAAAAAAA GGGGGGGGGGGGGGGGG EEEEEEEEEEEEEEEEEEEEE
//Le nombre de page au chargement de index
function readDataPageIndex(oData)
{
	if(oData != null)
	{
		var items = oData.getElementsByTagName("item");
			//le select des pages
			var selectPage= document.getElementById("Pages");
			
			//le tablea de pages ;)
			var valeurs = oData.getElementsByTagName("page");
			
			var nbVal = 0;
			nbVal  = valeurs.length/9;
			//les variables dynamiques 
			//console.log("################### NOMBRE DE PAGE ################" +nbVal);
			
			//vider le select
			selectPage.innerHTML="";
			chargerPage(selectPage, nbVal);
	}
	
}
//Rempli le select des pages :D
function chargerPage(selectPage, total)
{	
	
	var option;
	for(var i = 0, c=total; i<c; i++)
			{
				 
					option = document.createElement("option");
					option.setAttribute('value', i+1);
					option.text = i+1;
					selectPage.add(option);
				 
			}
	if(total == 0)
	{
		option = document.createElement("option");
					option.setAttribute('value', 1);
					option.text = 1;
					selectPage.add(option);
	}
}

//Récupérer 9 éléments selon le numéro de page sélectionné
function requestByNumberPage()
{
				//Il récupère les informations en base donc toute les lignes
				request_avec_page();
				//Quel est le numéro de page ?
				idPage = document.getElementById("Pages").
						 options[(document.getElementById("Pages")).
						 selectedIndex].value;
				
				
}

/////// SPECIAL TRAITEMENT DU NUMERO DE PAGE
// 1 Récupérer les données
function request_avec_page()
{
	var id_valueTypeAnn = document.getElementById("offre").checked;
			if(id_valueTypeAnn)
				id_valueTypeAnn=1;
			else
				id_valueTypeAnn=0;
			
			
				var id_Region = 0;
			if(document.getElementById("Region").
				options[(document.getElementById("Region")).
				selectedIndex]==null)
				{
					id_Region = 5000;
				}
				else
				{
					id_Region = document.getElementById("Region").
				options[(document.getElementById("Region")).
				selectedIndex].value;
				}
			
			var id_Ville = document.getElementById("Ville").
							options[(document.getElementById("Ville")).
							selectedIndex].value;
			var id_categorie_annonce = document.getElementById("Categorie_annonce").
							options[(document.getElementById("Categorie_annonce")).
							selectedIndex].value;
							
			//Tenir compte du choix du tri su Select :)
			var choix_tri_annonce = document.getElementById("tri_resultat").
						 options[(document.getElementById("tri_resultat")).
						 selectedIndex].value;
						 
			//valeur du titre de l'annonce recherchée, et on trim
			var titre_rechercher = document.getElementById("recherche_titre").value;
			
			
			if (titre_rechercher=="")
			{
				titre_rechercher = " ";
			}
				
			
			var xhr = getXMLHttpRequest();
			
			
			xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					//location.assign("index.php");
					readData_treat_page_affiche(xhr.responseXML);
//Ce que je reçois
					//console.log("ce que je reçois "+xhr);
					document.getElementById("loader").style.display = "none";
				} else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			xhr.open("POST","models/data.php" , true); //old models/datatest
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("Type_Annonce="+id_valueTypeAnn+
					 "&Region="+id_Region+
					 "&Ville="+id_Ville+
					 "&Categorie_annonce="+id_categorie_annonce+
					 "&Tri_ann="+choix_tri_annonce+
					 "&title="+titre_rechercher);
				
}
//2 Filtrer les données par numéro de page
function readData_treat_page_affiche(oData)
{
	if(oData != null)
	{
		

	// Quel est le numéro de page ???
	var pageNumber = document.getElementById("Pages").
				options[(document.getElementById("Pages")).
				selectedIndex].value;
	//alert(oData);
			var items = oData.getElementsByTagName("item");
			var href = oData.getElementsByTagName("href");
			var src = oData.getElementsByTagName("src");
			var alt = oData.getElementsByTagName("alt");
			var h33 = oData.getElementsByTagName("h3");
			var em33 = oData.getElementsByTagName("em");
			var h533 = oData.getElementsByTagName("h5");
			var p33 = oData.getElementsByTagName("p");
			var total_annonce = oData.getElementsByTagName("total");
			
			var socle = document.getElementById("super_annonce");
			
			var a, aInner, div_sup, div_contenant;
			var	div_contenant_contenant,  img, imgSrc, imgAlt;
			var h3, h3Inner, em, emInner, h5, h5Inner,  p, pInner;	
			
			
			//new adds 03 10 2017
						var divShareIt, divLabelPartager, h5Partager, divFacebook;
                        var aFacebook, 	imgFacebook, divWhatsapp, 	aWhatsapp;
                        var imgWhatsapp, divTwitter, aTwitter, 	imgTwitter;				
						
						//Get the variables new adds 03 10 2017
						var shareTwitter=oData.getElementsByTagName("shareTwitter");
						var shareWhatsapp=oData.getElementsByTagName("shareWhatsapp");
						var shareFacebook=oData.getElementsByTagName("shareFacebook");
						var complementSahreFacebook = "/&layout=button&size=small&mobile_iframe=true&width=60&height=20&appId";
				
						//Text 04 10 2017
						var partagerText = "Partagez à vos amis :)";
						
						var dataActionFacebook = "";
						var dataActionWhatsapp = "share/whatsapp/share";
						var dataActionTwitter = "";
						
						
						var srcFacebook = "img/facebook.png";
						var srcWhatsapp = "img/whatsapp.png";
						var srcTwitter = "img/twitter.png";
						
			//On vide les contenaires
			socle.innerHTML = ""; 
			
				
				//charger les annonces
				
					var k = items.length;
					if(k>pageNumber*9)
						k = pageNumber*9;
					
					for(var i = (pageNumber-1)*9; i<k; i++)
					{
						 
						 
							div_sup = document.createElement("div");
							div_sup.setAttribute('class', "col-xs-12 col-sm-4 col-md-4");
							socle.appendChild(div_sup);
								
								div_contenant = document.createElement("div");
								div_contenant.setAttribute('class',"Thumbnail")	;
								div_sup.appendChild(div_contenant);
								
								 //done
									 a = document.createElement("a");
									 aInner = href[i].firstChild.nodeValue;
									 a.setAttribute('href', "annonces/detailAnnonce.php?ann="+aInner);
									 div_contenant.appendChild(a);
						 
									//done
										img = document.createElement("img");
										imgSrc =  src[i].firstChild.nodeValue;
										imgAlt =  alt[i].firstChild.nodeValue;
										if(imgSrc=="#")
										{
											imgSrc = "img/default1.jpg";
										}
										img.setAttribute('src',imgSrc);
										img.setAttribute('alt',imgAlt);
										a.appendChild(img);
										
										div_contenant_contenant = document.createElement("div");
										div_contenant_contenant.setAttribute('class',"caption")	;
										a.appendChild(div_contenant_contenant);
							 //done
							 
							  //Ajout 06 05 2018 numéro annonce 
										 aInner = '#'+aInner;
														h3 = document.createElement("h3");
														  h3Inner =  document.createTextNode(aInner);
														  h3.appendChild(h3Inner);
														  div_contenant_contenant.appendChild(h3);
										 //end modif :)
										 
										 
											  h3 = document.createElement("h3");
											  h3Inner =  document.createTextNode(h33[i].firstChild.nodeValue);
											  h3.appendChild(h3Inner);
											  div_contenant_contenant.appendChild(h3);
											  //alert("ATRIBUT DE XML H3 = "+h33[i].firstChild.nodeValue);
											  
											  em = document.createElement("em");
											  emInner =  document.createTextNode((em33[i].firstChild.nodeValue));
											  em.appendChild(emInner);
											  div_contenant_contenant.appendChild(em);
											 // alert("ATRIBUT DE XML H3 = "+em33[i].firstChild.nodeValue);
											  
											  h5 = document.createElement("h5");
											  h5Inner =  document.createTextNode(h533[i].firstChild.nodeValue+" F CFA");
											  h5.appendChild(h5Inner);
											  div_contenant_contenant.appendChild(h5);
											  
											
												
												
													//new adds 03 10 2017 <div class="shareIt row"> 
														  divShareIt = document.createElement("div");
														  divShareIt.setAttribute('class',"shareIt row");
														  div_contenant_contenant.appendChild(divShareIt);
														  
															//The contents of sharing
															divLabelPartager = document.createElement("div");
															divLabelPartager.setAttribute('class','col-xs-12 labelPartager');
														    divShareIt.appendChild(divLabelPartager);
															
																//h5 texte partager
																h5Partager=document.createElement("h5");
																h5Partager.appendChild(document.createTextNode(partagerText));
																divLabelPartager.appendChild(h5Partager);
														  
														   //Facebook step div is an iframe pay attention
															divFacebook=document.createElement("iframe");
															//divFacebook.setAttribute('class','col-xs-4');
															divFacebook.setAttribute("src",shareFacebook[i].firstChild.nodeValue+complementSahreFacebook);
															divFacebook.setAttribute("width","80");
															divFacebook.setAttribute("height","20");
															divFacebook.setAttribute("style","border:none;overflow:hidden; width:80px;");
															divFacebook.setAttribute("scrolling","no");
															divFacebook.setAttribute("frameborder","0");
															divFacebook.setAttribute("allowTransparency","true");															
															
															
															divShareIt.appendChild(divFacebook);
																//the link for facebook to update at work
																
																	
															
															//Whatsapp step col-xs-2 avant mais pas centré
															divWhatsapp=document.createElement("div");
															divWhatsapp.setAttribute('class','col-xs-5');
															divShareIt.appendChild(divWhatsapp);
																//the link for facebook to update at work
																aWhatsapp=document.createElement("a");
																aWhatsapp.setAttribute("href",shareWhatsapp[i].firstChild.nodeValue);
																aWhatsapp.setAttribute("target","blank");
																aWhatsapp.setAttribute("data-action",dataActionWhatsapp);
																divWhatsapp.appendChild(aWhatsapp);
																	//image for facebook
																	imgWhatsapp=document.createElement("img");
																	imgWhatsapp.setAttribute("height","10px");
																	imgWhatsapp.setAttribute("width","10px");
																	imgWhatsapp.setAttribute("src",srcWhatsapp);
																	aWhatsapp.appendChild(imgWhatsapp);
																	
																	
																	
															
									
						
					}
					
					
			
	}
			
			
		
}