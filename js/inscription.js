
			function chk_email(field)
			{
				
				//Contrôles 
				var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
				
				var alert_mail = document.getElementById("alert_mail");
				
			   if(!regex.test(field.value) || field.value.length > 50)
			   {
				 
				  $('#already_email').val("");
				  $('#already_email').hide();
				  alert_mail.style.display="inline";
				  $('#already_email').css({color: 'green'});
				  alert_mail.innerHTML = "Merci de renseigner une adresse email valide :)";
				
			   }
			   else
			   {
				  
				  alert_mail.innerHTML = "";
				  alert_mail.style.display="none";
				  
				  $.post("../models/inscriptionAjax.php",
							{mon_email: $('#mon_email').val()},
							function(data){
								//$('#already_email').show();
								$('#already_email').html(data);
								$('#already_email').show();
								if(data.length>=12)
								{
									
									$('#already_email').css({color: 'red'});
									alert_mail.innerHTML = "0";
								}
								
								else
								{
									$('#already_email').css({color: 'green'});
									alert_mail.innerHTML = "1";
								}
								
							
							}
						);
				 
			  
				  
			   }
				
			}
			
			
			
			function chk_tel(field){
				
				//Contrôles 
				var alert_tel = document.getElementById("alert_tel");
				var regex = /^[0-9][0-9]{7}[0-9]$/;
				if(!regex.test(field.value))
				{
				  alert_tel.style.display="inline";
				  alert_tel.innerHTML = "9 chiffres :) ";
					 
					  $('#already_tel').val("");
					  $('#already_tel').hide();
					   $('#already_tel').css({color: 'green'});
					
				}
				   else
				   {
					
					  alert_tel.innerHTML = "";
					  alert_tel.style.display="none";
				  
				  $.post("../models/inscriptionAjax.php",
							{telephone: $('#telephone').val()},
							function(data){
								
								$('#already_tel').html(data);
								$('#already_tel').show();
								if(data.length>=12)
								{
									$('#already_tel').css({color:'red'});
									alert_tel.innerHTML = "0";
								}
								
								else
								{
									$('#already_tel').css({color: 'green'});
									alert_tel.innerHTML = "1";
								}
								//indisponible
							
							}
						);
				 
			  
				  
			   }
					
				
			}
			
			
			function chk_pseudonyme(field){
				
				//Contrôles 
				var alert_pseudo = document.getElementById("alert_pseudo");
				
			  if(field.value.length < 6 || field.value.length > 50 )
			
			   {
				   alert_pseudo.style.display="inline";
					alert_pseudo.innerHTML = "6 caractères minimum :) ";
				  //surline(field, true);
				  $('#already_pseudo').val("");
				  $('#already_pseudo').hide();
				   $('#already_pseudo').css({color: 'green'});
				   alert_pseudo.style.display="inline";
				 
			   }
			   else
			   {
				  //surline(field, false);
				  alert_pseudo.innerHTML = "";
				  alert_pseudo.style.display="none";
				  
				  $.post("../models/inscriptionAjax.php",
							{pseudonyme: $('#pseudonyme').val()},
							function(data){
								//$('#already_email').show();
								$('#already_pseudo').show();
								$('#already_pseudo').html(data);
								
								if(data.length>=12)
								{
									
									$('#already_pseudo').css({color:'red'});
									alert_pseudo.innerHTML = "0";
								}
								
								else
								{
									$('#already_pseudo').css({color: 'green'});
									alert_pseudo.innerHTML = "1";
								}
								
							
							}
						);
				 
			  
				  
			   }
					
				
			}
			
			function chk_mdp(field){
				
				//Contrôles 
				var alert_mdp = document.getElementById("alert_mdp");
				var result = false;
				if(field.value.length < 6 || field.value.length > 50 )
			   {
				  //surline(field, true);
				  $('#already_mdp').val("");
				  $('#already_mdp').hide();
				  alert_mdp.style.display="inline";
				  $('#already_mdp').css({color: 'green'});
				  alert_mdp.innerHTML = "6 caractères minimum :) ";
				  //alert("Merci de renseigner un adresse email valide :) ");
				 result = false;
			   }
			   else
			   {
				  //surline(field, false);
				  alert_mdp.innerHTML = "";
				  alert_mdp.style.display="none";
				  //Attention un autre dossier
				  
				  $.post("../models/inscriptionAjax.php",
							{mdp: $('#mdp').val()},
							function(data){
								//$('#already_email').show();
								$('#already_mdp').html(data);
								$('#already_mdp').show();
								if(data.length>=12)
								{
									$('#already_mdp').css({color:'red'});
									alert_mdp.innerHTML = "0";
							
								}
								
								else
								{
									$('#already_mdp').css({color: 'green'});
									alert_mdp.innerHTML = "1";
									
								}
								
							
							}
							
						);
				 
				
				  
			   }
			   
			   return result;
					
			
				
			}
			

		//Inscription
	$(function()
	{
			$('form.ajax').on('submit', function()
			{
				var that = $(this),
				url=that.attr('action'),
				type=that.attr('method'),
				data = {};
			
				that.find('[name]').each(function(index, value){
				var that = $(this),
					name = that.attr('name'),
					value = that.val();
						data[name] = value;
				});
				
				$.ajax
				({
					url: url,
					type: type,
					data: data,
					success: function(response)
					{
					if(response == 2015)
						$('#conclusion').html("Merci de consulter votre boîte email afin d'activer votre compte :)");
					else
						$('#conclusion').html(response);
						
						$('#conclusion').show();
						//console.log('l************** Réponse '+response);
						$('#already_mdp').html("");
						$('#already_pseudo').html("");
						$('#already_tel').html("");
						$('#already_email').html("");
						
						$('#already_mdp').hide();
						$('#already_pseudo').hide();
						$('#already_tel').hide();
						$('#already_email').hide();
						// Yes the message is sent
						//console.log("dans le if ?? "+$('#conclusion').html());
						if(response == 2015 )
							{
								//console.log("dans le if 2015"+$('#conclusion').html());
								return window.location.href = "../comptes/activeFollowUp.php";
							}
					}
				});
				//console.log(data);
				
			
			return false;
			});
	});	
		
////////////// COOOOOOOOOOMMMPTE ///////////
//email compte
			function chk_email_compte(field)
			{
				
				//Contrôles 
				var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
				
				var alert_mail = document.getElementById("alert_mail");
				
			   if(!regex.test(field.value) || field.value.length > 50)
			   {
				 
				  $('#already_email').val("");
				  $('#already_email').hide();
				  alert_mail.style.display="inline";
				  $('#already_email').css({color: 'green'});
				  alert_mail.innerHTML = "Merci de renseigner une adresse email valide :)";
				
			   }
			   else
			   {
				  
				  alert_mail.innerHTML = "";
				  alert_mail.style.display="none";
				  
				  $.post("../models/inscriptionAjax.php",
							{mon_email: $('#mon_email').val()},
							function(data){
								//$('#already_email').show();
								$('#already_email').html(data);
								$('#already_email').show();
								if(data.length>=12)
								{
									
									$('#already_email').css({color: 'red'});
									alert_mail.innerHTML = "0";
								}
								
								else
								{
									$('#already_email').css({color: 'green'});
									alert_mail.innerHTML = "1";
								}
								
							
							}
						);
				 
			  
				  
			   }
				
			}	
		
		
		function chk_pseudonyme_compte(field)
		{
			
			
				
				//Contrôles 
				var alert_pseudo = document.getElementById("alert_pseudo");
				
			  if(field.value.length < 6 || field.value.length > 50 )
			
			   {
				   alert_pseudo.style.display="inline";
					alert_pseudo.innerHTML = "6 caractères minimum :) ";
				  //surline(field, true);
				  $('#already_pseudo').val("");
				  $('#already_pseudo').hide();
				   $('#already_pseudo').css({color: 'green'});
				   alert_pseudo.style.display="inline";
				 
			   }
			   else
			   {
				  //surline(field, false);
				  alert_pseudo.innerHTML = "";
				  alert_pseudo.style.display="none";
				  
				  $.post("../models/inscriptionAjax.php",
							{pseudonyme: $('#pseudonyme').val()},
							function(data){
								//$('#already_email').show();
								$('#already_pseudo').show();
								$('#already_pseudo').html(data);
								
								if(data.length>=12)
								{
									
									$('#already_pseudo').css({color:'red'});
									alert_pseudo.innerHTML = "0";
								}
								
								else
								{
									$('#already_pseudo').css({color: 'green'});
									alert_pseudo.innerHTML = "1";
								}
								
							
							}
						);
				 
			  
				  
			   }
					
				
			}
			function chk_tel_compte(field){
				
				//Contrôles 
				var alert_tel = document.getElementById("alert_tel");
				var regex = /^[0-9][0-9]{7}[0-9]$/;
				if(!regex.test(field.value))
				{
				  alert_tel.style.display="inline";
				  alert_tel.innerHTML = "9 chiffres :) ";
					 
					  $('#already_tel').val("");
					  $('#already_tel').hide();
					   $('#already_tel').css({color: 'green'});
					
				}
				   else
				   {
					
					  alert_tel.innerHTML = "";
					  alert_tel.style.display="none";
				  
				  $.post("../models/inscriptionAjax.php",
							{telephone: $('#telephone').val()},
							function(data){
								
								$('#already_tel').html(data);
								$('#already_tel').show();
								if(data.length>=12)
								{
									$('#already_tel').css({color:'red'});
									alert_tel.innerHTML = "0";
								}
								
								else
								{
									$('#already_tel').css({color: 'green'});
									alert_tel.innerHTML = "1";
								}
								//indisponible
							
							}
						);
				 
			  
				  
			   }
					
				
			}
			
			function chk_mdp_compte(field){
				
				//alert(field);
				//console.log("field + "+field.name);
				var nom_mdp = field.name;
				//alert (nom_mdp.localeCompare("mdp0"));
				//Contrôles 
				var alert_mdp = document.getElementById("alert_mdp");
				var alert_mdp0 = document.getElementById("alert_mdp0");
				var alert_mdp1 = document.getElementById("alert_mdp1");
				var alert_mdp2 = document.getElementById("alert_mdp2");
				var result = false;
				if(field.value.length < 6 || field.value.length > 50 )
			   {
				  //surline(field, true);
				  if(nom_mdp.localeCompare("mdp")==0)
				  {
					   $('#already_mdp').val("");
					  $('#already_mdp').hide();
					  alert_mdp.style.display="inline";
					  $('#already_mdp').css({color: 'green'});
					  alert_mdp.innerHTML = "6 caractères minimum :) ";
				  }
				  else if(nom_mdp.localeCompare("mdp0")  == 0)
				  {
				 
					   $('#already_mdp0').val("");
					  $('#already_mdp0').hide();
					  alert_mdp0.style.display="inline";
					  $('#already_mdp0').css({color: 'green'});
					  alert_mdp0.innerHTML = "6 caractères minimum :) ";
				  }
				   else if(nom_mdp.localeCompare("mdp1")==0)
				  {
					   $('#already_mdp1').val("");
					  $('#already_mdp1').hide();
					  alert_mdp1.style.display="inline";
					  $('#already_mdp1').css({color: 'green'});
					  alert_mdp1.innerHTML = "6 caractères minimum :) ";
				  }
				   else if(nom_mdp.localeCompare("mdp2")==0)
				  {
					   $('#already_mdp2').val("");
					  $('#already_mdp2').hide();
					  alert_mdp2.style.display="inline";
					  $('#already_mdp2').css({color: 'green'});
					  alert_mdp2.innerHTML = "6 caractères minimum :) ";
				  }
				 
				  //alert("Merci de renseigner un adresse email valide :) ");
				 result = false;
			   }
			   else
			   {
				  //surline(field, false);
				  
				  //Attention un autre dossier
						   if(nom_mdp.localeCompare("mdp")==0)
						  {
							  alert_mdp.innerHTML = "";
							  alert_mdp.style.display="none";
						  }
						  else if(nom_mdp.localeCompare("mdp0")==0)
						  {
							  alert_mdp0.innerHTML = "";
							  alert_mdp0.style.display="none";
						  }
						   else if(nom_mdp.localeCompare("mdp1")==0)
						  {
							  alert_mdp1.innerHTML = "";
							  alert_mdp1.style.display="none";
						  }
						   else if(nom_mdp.localeCompare("mdp2")==0)
						  {
							  alert_mdp2.innerHTML = "";
							  alert_mdp2.style.display="none";
						  }
				  $.post("../models/modifierCompteMdpControles.php",
							{mdp: $('#mdp').val(), mdp0: $('#mdp0').val(), mdp1: $('#mdp1').val(), mdp2: $('#mdp2').val()},
							function(data){
								//$('#already_email').show();
								
								 if(nom_mdp=="mdp")
								  {
									   $('#already_mdp').html(data);
										$('#already_mdp').show();
								  }
								  else if(nom_mdp =="mdp0")
								  {
									   $('#already_mdp0').html(data);
										$('#already_mdp0').show();
								  }
								   else if(nom_mdp =="mdp1")
								  {
									   $('#already_mdp1').html(data);
										$('#already_mdp1').show();
								  }
								   else if(nom_mdp =="mdp2")
								  {
									  $('#already_mdp2').html(data);
										$('#already_mdp2').show();
								  }
								if(data.length>=12)
								{
									 if(nom_mdp=="mdp")
									  {
										  $('#already_mdp').css({color:'red'});
											alert_mdp.innerHTML = "0";
									  }
									  else if(nom_mdp =="mdp0")
									  {
										   $('#already_mdp0').css({color:'red'});
											alert_mdp0.innerHTML = "0";
									  }
									   else if(nom_mdp =="mdp1")
									  {
										   $('#already_mdp1').css({color:'red'});
											alert_mdp1.innerHTML = "0";
									  }
									   else if(nom_mdp =="mdp2")
									  {
										   $('#already_mdp2').css({color:'red'});
											alert_mdp2.innerHTML = "0";
									  }
							
								}
								
								else
								{
								
									 if(nom_mdp=="mdp")
									  {
										  $('#already_mdp').css({color: 'green'});
											alert_mdp.innerHTML = "1";
									  }
									  else if(nom_mdp =="mdp0")
									  {
										     $('#already_mdp0').css({color: 'green'});
											alert_mdp0.innerHTML = "1";
									  }
									   else if(nom_mdp =="mdp1")
									  {
										     $('#already_mdp1').css({color: 'green'});
											alert_mdp1.innerHTML = "1";
									  }
									   else if(nom_mdp =="mdp2")
									  {
										     $('#already_mdp2').css({color: 'green'});
											alert_mdp2.innerHTML = "1";
									  }
									
								}
								
							
							}
							
						);
				 
				
				  
			   }
			   
			   return result;
					
			
				
			}
		
		
		//SUBMIT MODIFICATIONS
		$(function()
	{
			$('form.compte_modif_sauf_mdp').on('submit', function()
			{
				var that = $(this),
				url=that.attr('action'),
				type=that.attr('method'),
				data = {};
			
				that.find('[name]').each(function(index, value){
				var that = $(this),
					name = that.attr('name'),
					value = that.val();
						data[name] = value;
				});
				
				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function(response){
					
						$('#conclusion').html(response);
						$('#conclusion').show();
					console.log('respons = '+response);
				if(response==2015)
					$('#conclusion1').html("Veillez consulter votre email :) !");
				else
						$('#conclusion1').html(response);
						
						$('#conclusion1').show();
						
						
						$('#already_mdp').html("");
						$('#already_pseudo').html("");
						$('#already_tel').html("");
						$('#already_email').html("");
						
						$('#already_mdp').hide();
						$('#already_pseudo').hide();
						$('#already_tel').hide();
						$('#already_email').hide();
						
						if(response == 2015)
						{
							return window.location.href ="../comptes/compteModifFollowUp.php";
						}
					}
				});
				//console.log(data);
				
			
			return false;
			});
		});		
			
		$(function()
	{		
			$('form.compte_modif_mdp').on('submit', function()
			{
				var that = $(this),
				url=that.attr('action'),
				type=that.attr('method'),
				data = {};
			
				that.find('[name]').each(function(index, value){
				var that = $(this),
					name = that.attr('name'),
					value = that.val();
						data[name] = value;
				});
				
				$.ajax({
					url: url,
					type: type,
					data: data,
					success: function(response){
					//console.log(response);
						if(response == 2015)
							$('#conclusion2').html("Veillez consulter votre email :) !");
					   else
						$('#conclusion2').html(response);
						
						$('#conclusion2').show();
						
						$('#already_mdp0').html("");
						$('#already_mdp1').html("");
						$('#already_mdp2').html("");
						
						$('#already_mdp0').hide();
						$('#already_mdp1').hide();
						$('#already_mdp2').hide();
						
						if(response == 2015)
						{
							return window.location.href ="../comptes/passModifFollowUp.php";
						}
					}
				});
				//console.log(data);
				
			
			return false;
			});
			
	});	