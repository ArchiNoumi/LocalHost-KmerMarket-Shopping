//LES VILLES
function chargerVilles()
	{
			
			//en ajax :)
			var idRegion = document.getElementById("Region").
						options[(document.getElementById("Region")).
						selectedIndex].value;
			
			var xhr = getXMLHttpRequest();
		
			
			xhr.onreadystatechange = 
		function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				readDataVillesIndex(xhr.responseXML);
				//document.getElementById("loader").style.display = "none";
				
			} else if (xhr.readyState < 4) {
				//document.getElementById("loader").style.display = "inline";
				
			}
			
		};
		
		xhr.open("POST","../models/dataVillesIndex.php" , true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("Region="+idRegion);
			
	}	
	
	
	function chargerVillesCreerAnn()
	{
			
			//en ajax :)
			var idRegion = document.getElementById("Region").
						options[(document.getElementById("Region")).
						selectedIndex].value;
			
			var xhr = getXMLHttpRequest();
		
			
			xhr.onreadystatechange = 
		function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				readDataVillesIndex(xhr.responseXML);
				//document.getElementById("loader").style.display = "none";
				
			} else if (xhr.readyState < 4) {
				//document.getElementById("loader").style.display = "inline";
				
			}
			
		};
		
		xhr.open("POST","../models/dataVillesCreerAnnonce.php" , true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("Region="+idRegion);
			
	}
	

		function readDataVillesIndex(oData)
		{
			//alert(oData);
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
			
			for(var i = 1, c=items.length; i<c; i++)
			{
				 
					option = document.createElement("option");
					option.setAttribute('value', valeurs[i].firstChild.nodeValue);
					option.text = villes[i].firstChild.nodeValue;
					 selectVille.add(option);
				 
			}
			
			
			
		}
		
		
		//LES CONTRÔLES



		function readURL(input) 
		 {
			 
			 var idImg ;
			 if(input.id == "imgInput1")
			 {
				 idImg = '#premier';
			 }
			 else if (input.id == "imgInput2")
			 {
				 idImg = '#deuxieme';
			 }
			 else if(input.id == "imgInput3")
			 {
				 idImg = '#troisieme';
			 }
			  //alert ('input.Id== '+input.id);
			 if(idImg == '#troisieme' || 
			idImg == '#deuxieme' ||
			idImg == '#premier')
			{
				//alert(document.getElementById(input.id).getAttribute('src'));
				 if (input.files && input.files[0]) 
				 {
					var reader = new FileReader();

					reader.onload = function (e) {
						$(idImg)
							.attr('src', e.target.result);
							
					};

					reader.readAsDataURL(input.files[0]);
				}
			}
		 }
			
	
		function requestMesImages(elt)
		{
					
			var idPic = elt.id;
			//var clasName = elt.className;
			//var divId = elt.parentNode.getAttribute("id");
			//var child = document.getElementById(divId).childNodes;
			/*var img = *///child[2].setAttribute("src","");
			//var img = div.getAttribute("id");
		//	alert("attribute = "+clasName);
			//alert('id_pic = '+idPic);
		//	alert("div "+divId);
			if(idPic == "")
			{
				var cla = elt.className;
				var oldInput, newInput;
				//console.log("class = "+cla);
				if(cla=="test1")
				{
					document.getElementById("premier").setAttribute('src', "#");
					
					//clear the input file
					 oldInput = document.getElementById("imgInput1");


					
						
				}
				else if(cla=="test2")
				{
					document.getElementById("deuxieme").setAttribute('src', "#");
					
					oldInput = document.getElementById("imgInput2");

					
				}
				else if(cla=="test3")
				{
					document.getElementById("troisieme").setAttribute('src', "#");
					
					oldInput = document.getElementById("imgInput3");
				}
				
				//Replace old file
					newInput = document.createElement("input");
					newInput.type = "file";
					newInput.id = oldInput.id;
					newInput.name = oldInput.name;
					newInput.className = oldInput.className;
					newInput.accept = oldInput.accept;
					newInput.style.cssText = oldInput.style.cssText;
					newInput.onchange = oldInput.onchange;
				// copy any other relevant attributes

					oldInput.parentNode.replaceChild(newInput, oldInput);
			}
			else
			{
			
				var xhr = getXMLHttpRequest();
				xhr.open("POST","../models/dataModifierAnnonce.php" , true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("pic="+idPic);
				xhr.onreadystatechange = 
				function(){
					if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
					{
					
						readData(xhr.responseXML);
						
						//document.getElementById("loader").style.display = "none";
						//alert('ooooooooooooooooooooooooooooooooooooooooooooooooooo ---xhr.responseXML'+xhr.responseXML);
					} else if (xhr.readyState < 4) {
						//document.getElementById("loader").style.display = "inline";
						
					}
					
				};
				
			}
				 
					 //encodeURIComponent() on string values: &user="+encodeURIComponent(user)
		}
		
		function readData(oData)
		{
			//alert(oData);
			//console.log ('oData------------------>---------------------->'+oData);
			
			var items = oData.getElementsByTagName("item");
			//console.log ('Description------------------>---------------------->'+items[0].getAttribute("description"));
			for(var i = 0, c=items.length; i<c; i++)
			{
				if(items[i].getAttribute("description")=="1")
				{
					document.getElementById("premier").setAttribute('src', "#");
				}
				else if(items[i].getAttribute("description")=="2")
				{
					document.getElementById("deuxieme").setAttribute('src', "#");
				}
				else if(items[i].getAttribute("description")=="3")
				{
					document.getElementById("troisieme").setAttribute('src', "#");
				}
			} 
				
		}
		
		 
		
		function verifTitreAnnonce(field)
		{
				
				var alert_titre = document.getElementById("alert_titre");
			   if(field.value.length > 50)
			   {
				  //surline(field, true);
				  alert_titre.style.display="inline";
				  alert_titre.innerHTML = ("Attention 50 caractères maximum :)");
				
			   }
			   else
			   {
				   alert_titre.innerHTML = "";
				  alert_titre.style.display="none";
				 
			   }
		}
												
												
		function afficheValeur_Titre(field)
		{
			
			$("#taille_titre").html(field.value.length  +" / 50 max");
		}
		function effacerValeur_Titre(field)
		{
			$("#taille_titre").html("");
		}

		function verifTexteAnnonce(field)
		{
				var alert_texte = document.getElementById("alert_texte");
			   if(field.value.length > 300)
			   {
				    alert_texte.style.display="inline";
				  alert_texte.innerHTML = ("Vous avez dépasser la taille maximum de caractères :)");
				  
				
			   }
			   else
			   {
				   alert_texte.innerHTML = "";
				  alert_texte.style.display="none";
			   }
		}
		function afficheValeur_Texte(field)
		{
			var field
			$("#taille_texte").html(field.value.length  +" / 300 max");
		}
		function effacerValeur_Texte(field)
		{
			$("#taille_texte").html("");
		}
		
		function verifPrixAnnonce(field)
		{
			var valeur = field.value.replace(/\s+/g, '');
			//alert(valeur);
			var alert_prix = document.getElementById("alert_prix");
			var regex = /^[1-9][0-9]{0,8}[0|5]$/;
			   if(!regex.test(valeur))
			   {
				  //surline(field, true);
				  alert_prix.style.display="inline";
				  alert_prix.innerHTML = (" Le prix ne commence pas par 0, est un multiple de 5 et, possède 10 chiffres au maximum :) ");
				  
			   }
			   
			  if(valeur%5!=0)
			   {
				   alert_prix.style.display="inline";
				  alert_prix.innerHTML = (" Le prix doit se terminer par 0 ou 5 :) ");
				   
				
			   }
			   else
			   {
				  alert_prix.innerHTML = "";
				  alert_prix.style.display="none";
			   }
		}
													
		function afficheValeur_Prix(field)
		{
			var valeur = field.value.replace(/\s+/g, '');
			$("#taille_prix").html(valeur.length  +" / 10 max");
		}
		function effacerValeur_Prix(field)
		{
			$("#taille_prix").html("");
		}	


	
	
	$(function()
	{
					$('form.ajaxModif').on('submit', function()
					{
						var that = $(this),
							url=that.attr('action'),
							type=that.attr('method');
						$.ajax
						(
							{
								url: url,
								type: type,
								data: new FormData(this),
								processData: false,
								contentType: false,
								success: function(response){
										$('#conclusion').html(response);
										$('#conclusion').show();
										
										$('#already_mdp').html("");
											
											$('#already_email').html("");
											
											$('#already_mdp').hide();
											
											$('#already_email').hide();
										
										//console.log("la réponse "+response);
										if($('#conclusion').html() == 1)
										{
											//console.log("dans le if ?? "+$('#conclusion').html());
											return window.location.href = "../annonces/mesAnnonces.php";
										}
										//console.log(data);
									}
							}
						);
					});
			
   });
	
		
				
										