	
	function requestMesAnnonces(thePseudo)
		{
					
			var id_valueTypeAnn = document.getElementById("offre").checked;
			if(id_valueTypeAnn)
				id_valueTypeAnn=1;
			else
				id_valueTypeAnn=0;
			
				
			var etat_annonce = document.getElementById("Etat").
							options[(document.getElementById("Etat")).
							selectedIndex].value;
			
			var choix_classe_par = document.getElementById("classe_par").
							options[(document.getElementById("classe_par")).
							selectedIndex].value;
							
			//Tenir compte du choix du tri su Select :)
			var id_categorie_annonce = document.getElementById("Categorie_annonce").
						 options[(document.getElementById("Categorie_annonce")).
						 selectedIndex].value;
						 
			var titre_Ann = document.getElementById("recherche_titre").value;
			if(titre_Ann=="")
			{
				titre_Ann = " ";
			}
			/*var numero_page = $("span.active").text();
			alert('numero_page = '+numero_page);*/
			var xhr = getXMLHttpRequest();
			xhr.open("POST","../models/dataMesAnnonces.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("Type_Annonce="+id_valueTypeAnn+
					 "&Etat_Annonce="+etat_annonce+
					 "&Classe_par="+choix_classe_par+
					 "&Categorie_Annonce="+id_categorie_annonce+
					// "&p="+numero_page+
					 "&titre="+titre_Ann+
					 "&meteorite=ello");
					 
			xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					readData(xhr.responseXML, thePseudo);
					document.getElementById("loader").style.display = "none";
					//alert('ooooooooooooooooooooooooooooooooooooooooooooooooooo');
				} else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			
					 
					/*console.log("Type_Annonce="+id_valueTypeAnn+
					 "&Etat_Annonce="+etat_annonce+
					 "&Classe_par="+choix_classe_par+
					 "&Categorie_Annonce="+id_categorie_annonce+
					 //"&p="+numero_page+
					 "&titre="+titre_Ann+
					 "&meteorite=ello");*/
					 //encodeURIComponent() on string values: &user="+encodeURIComponent(user)
		}
		
		function readData(oData, thePseudo)
		{
			//console.log("Odata + "+oData);
			if(oData != null)
			{
				
					
					
					
					var items = oData.getElementsByTagName("item");
					var socle = document.getElementById("dynamique");
					var tr, td, trInner, tdInner, bouton, boutonInner;		
					
					
					//console.log("------->Titre annonce + ----->"+items[0].getAttribute("titre"));
					
					
					//Le titre du tableau
					//var p = document.getElementsByName("p");
					var p = document.getElementById("titre_tableau");
						
						
					//console.log("la taille des items = "+items.length);
					/*total = document.getElementById("total");
					total.innerHTML ="";
					totalInner = document.createTextNode("Total : "+items.length);
					total.appendChild(totalInner);*/
					
					//Les pages franc let's go !
					var  selectPage= document.getElementById("Pages");
					//Vider le select
					selectPage.innerHTML = ""; 
					var total_pages = (items.length)/9;
					//Charger le select des pages --- appel de la fonction
					chargerPage(selectPage, total_pages);
					
					
					//Je vide le contenu du socle :)
					socle.innerHTML = ""; 
					p.innerHTML = ""
					if(items.length >0)
					{
						
						var res = items[0].getAttribute("etat");
						
						if(res == "recentes_anciennes")
						{
							p.innerHTML = "Classement : des plus récentes dates de création aux plus anciennes";
						}
						else if(res == "anciennes_recentes")
						{
							p.innerHTML = "Classement : des plus anciennes date de création aux plus récentes";
						}
						else if(res == "prix_decroissants")
						{
							p.innerHTML = "Classement : prix décroissants";
						}
						else if(res == "prix_croissants")
						{
							p.innerHTML = "Classement : prix croissants";
						}
						else if(res == "villes_croissants")
						{
							p.innerHTML = "Classement : nom de villes ordre alphabétique";
						}
						else if(res == "villes_decroissants")
						{
							p.innerHTML = "Classement : nom de villes ordre alphabétique inversé";
						}
						else if(res == "titres_croissants")
						{
							p.innerHTML = "Classement : titres ordre alphabétique";
						}
						else if(res == "titres_decroissants")
						{
							p.innerHTML = "Classement : titre ordre alphabétique inversé";
						}
						
						else
						{
							p.innerHTML = "classement : date de création décroissant";
						}
							
						var k = items.length;
							if (k > 9)
								k = 9;
							
							
						for(var i = 0, c=k; i<c; i++)
						{
							
								
									 
										 tr = document.createElement("tr");
										 trInner = items[i].getAttribute("details");
										 tr.setAttribute('onclick',"window.location.assign(\"detailMonAnnonce.php?pseu="+thePseudo+"&ann="+trInner+"\")");
										 socle.appendChild(tr);
												 
												 
												   //Les chargements :
												   
												    //ID annonces #add 08 05 2018
													 //Création du td tampon
													td = document.createElement("td");
													tdInner = document.createTextNode(trInner);
												    td.appendChild(tdInner);
													 tr.appendChild(td);
													 
													 
													 //Titre 
													 //Création du td tampon
													td = document.createElement("td");
													tdInner = document.createTextNode(items[i].getAttribute("titre"));
													
													td.appendChild(tdInner);
													 tr.appendChild(td);
													 
													 //Texte de l'annonce
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("texteAnn"));
													 
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 //Prix
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("prix"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													  
													  //Catégorie
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("categorie"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 //Région
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("region"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 //Ville
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("ville"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 //Nombre de photos
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("nombre_photo"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 
													 //Date de création
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("date_creation"));
													 td.appendChild(tdInner);
													 tr.appendChild(td);
													 
													 //Détails de l'annonce
													 /*
													 td = document.createElement("td");
													 
														//Création du bouton et su lien d'action
															
														
															
																	
																bouton = document.createElement("button");
																bouton.setAttribute('name', "détails");
																bouton.setAttribute('class', "btn btn-success");
																bouton.setAttribute('id', "details");
																boutonInner = document.createTextNode("Détails");
																bouton.appendChild(boutonInner);
																a.appendChild(bouton);
													 
													 td.appendChild(a);
													  tr.appendChild(td);*/
												
													
							 
							
							}
						
						}
					
			}
			
		}
		
		//Charger PAGES au loading de la fenêtre :) :)
		function chargerPagesMesAnnonces(thePseudo)
		{
			var id_valueTypeAnn = document.getElementById("offre").checked;
			if(id_valueTypeAnn)
				id_valueTypeAnn=1;
			else
				id_valueTypeAnn=0;
			
				
			var etat_annonce = document.getElementById("Etat").
							options[(document.getElementById("Etat")).
							selectedIndex].value;
			
			var choix_classe_par = document.getElementById("classe_par").
							options[(document.getElementById("classe_par")).
							selectedIndex].value;
							
			//Tenir compte du choix du tri su Select :)
			var id_categorie_annonce = document.getElementById("Categorie_annonce").
						 options[(document.getElementById("Categorie_annonce")).
						 selectedIndex].value;
						 
			var titre_Ann = document.getElementById("recherche_titre").value;
			if(titre_Ann=="")
			{
				titre_Ann = " ";
			}
			/*var numero_page = $("span.active").text();
			alert('numero_page = '+numero_page);*/
			var xhr = getXMLHttpRequest();
			
			xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					readDataPageMesAnnonces(xhr.responseXML, thePseudo);
					document.getElementById("loader").style.display = "none";
					//alert('ooooooooooooooooooooooooooooooooooooooooooooooooooo');
				} else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			xhr.open("POST","../models/dataPageMesAnnonces.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("Type_Annonce="+id_valueTypeAnn+
					 "&Etat_Annonce="+etat_annonce+
					 "&Classe_par="+choix_classe_par+
					 "&Categorie_Annonce="+id_categorie_annonce+
					// "&p="+numero_page+
					 "&titre="+titre_Ann+
					 "&meteorite=ello");
		}
		
		function readDataPageMesAnnonces(oData, thePseudo)
		{
			if(oData !=null)
			{
				//console.log('lLLLLLLLLLLLLLLLLLLLes DONNNEEEES '+oData);
			var items = oData.getElementsByTagName("item");
			//La select des pages
			var selectPage= document.getElementById("Pages");
			
			//Les pages (le tableau de page)
			var valeurs = oData.getElementsByTagName("page");
			//console.log("id membre est --+++++++++++++++++ ->******   "+oData.getElementsByTagName("idMembre")[0]);
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
		function requestByNumberPage(thePseudo)
		{
						//Il récupère les informations en base donc toute les lignes
						request_avec_page(thePseudo);
						//Quel est le numéro de page ?
						idPage = document.getElementById("Pages").
								 options[(document.getElementById("Pages")).
								 selectedIndex].value;
						
						
		}
		
		/////// SPECIAL TRAITEMENT DU NUMERO DE PAGE
// 1 Récupérer les données
function request_avec_page(thePseudo)
{
	var id_valueTypeAnn = document.getElementById("offre").checked;
			if(id_valueTypeAnn)
				id_valueTypeAnn=1;
			else
				id_valueTypeAnn=0;
			
				
			var etat_annonce = document.getElementById("Etat").
							options[(document.getElementById("Etat")).
							selectedIndex].value;
			
			var choix_classe_par = document.getElementById("classe_par").
							options[(document.getElementById("classe_par")).
							selectedIndex].value;
							
			//Tenir compte du choix du tri su Select :)
			var id_categorie_annonce = document.getElementById("Categorie_annonce").
						 options[(document.getElementById("Categorie_annonce")).
						 selectedIndex].value;
						 
			var titre_Ann = document.getElementById("recherche_titre").value;
			if(titre_Ann=="")
			{
				titre_Ann = " ";
			}
			/*var numero_page = $("span.active").text();
			alert('numero_page = '+numero_page);*/
			var xhr = getXMLHttpRequest();
			
			xhr.onreadystatechange = 
			function(){
				if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
				{
					readData_treat_page_affiche(xhr.responseXML, thePseudo);
					document.getElementById("loader").style.display = "none";
					//alert('ooooooooooooooooooooooooooooooooooooooooooooooooooo');
				} else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
					
				}
				
			};
			xhr.open("POST","../models/dataMesAnnonces.php" , true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("Type_Annonce="+id_valueTypeAnn+
					 "&Etat_Annonce="+etat_annonce+
					 "&Classe_par="+choix_classe_par+
					 "&Categorie_Annonce="+id_categorie_annonce+
					// "&p="+numero_page+
					 "&titre="+titre_Ann+
					 "&meteorite=ello");
				
}
//2 Filtrer les données par numéro de page
function readData_treat_page_affiche(oData, thePseudo)
{
	if(oData != null)
	{
		
	
	// Quel est le numéro de page ???
			var pageNumber = document.getElementById("Pages").
						options[(document.getElementById("Pages")).
						selectedIndex].value;
			//Les données en base :)
			var items = oData.getElementsByTagName("item");
					var socle = document.getElementById("dynamique");
					var tr, td, trInner, tdInner, bouton, boutonInner;		
					
					//Le titre du tableau
					//var p = document.getElementsByName("p");
					var p = document.getElementById("titre_tableau");
						
						
					//console.log("la taille des items = "+items.length);
					/*total = document.getElementById("total");
					total.innerHTML ="";
					totalInner = document.createTextNode("Total : "+items.length);
					total.appendChild(totalInner);*/
					
					//Je vide le contenu du socle :)
					socle.innerHTML = ""; 
					p.innerHTML = ""
					var k = items.length;
							if(k>pageNumber*9)
								k = pageNumber*9;
							
					if(items.length >0)
					{
						
						var res = items[0].getAttribute("etat");
						
						if(res == "recentes_anciennes")
						{
							p.innerHTML = "Classement : des plus récentes dates de création aux plus anciennes";
						}
						else if(res == "anciennes_recentes")
						{
							p.innerHTML = "Classement : des plus anciennes date de création aux plus récentes";
						}
						else if(res == "prix_decroissants")
						{
							p.innerHTML = "Classement : prix décroissants";
						}
						else if(res == "prix_croissants")
						{
							p.innerHTML = "Classement : prix croissants";
						}
						else if(res == "villes_croissants")
						{
							p.innerHTML = "Classement : nom de villes ordre alphabétique";
						}
						else if(res == "villes_decroissants")
						{
							p.innerHTML = "Classement : nom de villes ordre alphabétique inversé";
						}
						else if(res == "titres_croissants")
						{
							p.innerHTML = "Classement : titres ordre alphabétique";
						}
						else if(res == "titres_decroissants")
						{
							p.innerHTML = "Classement : titre ordre alphabétique inversé";
						}
						
						else
						{
							p.innerHTML = "classement : date de création décroissant";
						}
							
						
						for(var i = (pageNumber-1)*9; i<k; i++)
						{
							
								
									 
										 tr = document.createElement("tr");
										 trInner = items[i].getAttribute("details");
										 tr.setAttribute('onclick',"window.location.assign(\"detailMonAnnonce.php?pseu="+thePseudo+"&ann="+trInner+"\")");
										 socle.appendChild(tr);
												 //Création du td tampon
												
												 
												   //Les chargements :
												   //ID annonces #add 08 05 2018
													 //Création du td tampon
													td = document.createElement("td");
													tdInner = document.createTextNode(trInner);
												    td.appendChild(tdInner);
													 tr.appendChild(td);
													 
													 
													 //Titre 
													  td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("titre"));
													 td.appendChild(tdInner);
													 tr.appendChild(td);
													 
													 //Texte de l'annonce
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("texteAnn"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 //Prix
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("prix"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													  
													  //Catégorie
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("categorie"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 //Région
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("region"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 //Ville
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("ville"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 //Nombre de photos
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("nombre_photo"));
													 td.appendChild(tdInner);
													  tr.appendChild(td);
													 
													 
													 //Date de création
													 td = document.createElement("td");
													 tdInner = document.createTextNode(items[i].getAttribute("date_creation"));
													 td.appendChild(tdInner);
													 tr.appendChild(td);
													 
													 //Détails de l'annonce
													 /*
													 td = document.createElement("td");
													 
														//Création du bouton et su lien d'action
															
														
															
																	
																bouton = document.createElement("button");
																bouton.setAttribute('name', "détails");
																bouton.setAttribute('class', "btn btn-success");
																bouton.setAttribute('id', "details");
																boutonInner = document.createTextNode("Détails");
																bouton.appendChild(boutonInner);
																a.appendChild(bouton);
													 
													 td.appendChild(a);
													  tr.appendChild(td);*/
												
													
							 
							
						}
						
					}
					
			
	}
			
			
		
}
		