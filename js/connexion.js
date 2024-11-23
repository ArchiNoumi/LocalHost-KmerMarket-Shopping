
			

			function chk_email(field){
				
				//Contrôles 
				var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
				
				var alert_mail = document.getElementById("alert_mail");
				
			   if(!regex.test(field.value) || field.value.length > 50)
			   {
				 
				  $('#already_email').val("");
				  $('#already_email').hide();
				  alert_mail.style.display="inline";
				  $('#already_email').css({color: 'green'});
				  alert_mail.innerHTML = "Merci de renseigner un adresse email valide :)";
				 
				  return false;
			   }
			   else
			   {
				  
				  alert_mail.innerHTML = "";
				  alert_mail.style.display="none";
				  
				  $.post("../models/connexionAjax.php",
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
			
			//forgot password
			function chk_email2(field){
				
				//Contrôles 
				var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
				
				var alert_mail = document.getElementById("alert_mail2");
				
			   if(!regex.test(field.value) || field.value.length > 50)
			   {
				 
				  $('#already_email2').val("");
				  $('#already_email2').hide();
				  alert_mail.style.display="inline";
				  $('#already_email2').css({color: 'green'});
				  alert_mail.innerHTML = "Merci de renseigner un adresse email valide :)";
				 return false;
				  
			   }
			   else
			   {
				  
				  alert_mail.innerHTML = "";
				  alert_mail.style.display="none";
				  
				  $.post("../models/connexion.php",
							{mon_email: $('#mon_email2').val()},
							function(data){
								
								$('#already_email2').html(data);
								$('#already_email2').show();
								if(data.length>=12)
								{
									
									$('#already_email2').css({color: 'red'});
									alert_mail.innerHTML = "0";
								}
								
								else
								{
									$('#already_email2').css({color: 'green'});
									alert_mail.innerHTML = "1";
								}
								
							
							}
						);
				 
			  
				  
			   }
				
			}
			
			
			//email compte
			function chk_email_compte(field){
				
				//Contrôles 
				var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
				
				var alert_mail = document.getElementById("alert_mail");
				
			   if(!regex.test(field.value) || field.value.length > 50)
			   {
				 
				  $('#already_email').val("");
				  $('#already_email').hide();
				  alert_mail.style.display="inline";
				  $('#already_email').css({color: 'green'});
				  alert_mail.innerHTML = "Merci de renseigner un adresse email valide :)";
				 
				  return false;
			   }
			   else
			   {
				  
				  alert_mail.innerHTML = "";
				  alert_mail.style.display="none";
				  
				  $.post("../models/connexionAjax.php",
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
				  
				  $.post("../models/connexionAjax.php",
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
			
		
	
		
				
	
		
	
		
		
		//Connexion :)
		$(function()
		{
			$('form.ajaxConnexion').on('submit', function()
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
						success: function(response)
						{
							$('#already_mdp').html("");
							$('#already_email').html("");
							$('#already_mdp').hide();
							$('#already_email').hide();
							console.log('response'+response);
							//Success all the controls 
							if(response.includes("prepre"))
							{
								
								return window.location.href = "../index.php?pseu="+response; //$('#conclusion').html();
							}
							else
							{
								$('#conclusion').html(response);
								
								$('#conclusion').show();
							}
							
						}
					});
					//console.log(data);
					
				
				return false;
		    });
	    });	
		
		
		
		//MOT DE¨PASSE OUBLIE ENVOI DU NOUVEAU MOT DE PASSE :)
		$(function()
		{
			$('form.ajaxPassForget').on('submit', function()
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
						if(response == 2015)
							$('#conclusion2').html("Merci de consulter votre boîte email :)");
						else
							$('#conclusion2').html(response);
							
							$('#conclusion2').show();
							
						
							
							$('#already_email2').html("");
							
							
							
							$('#already_email2').hide();
							//console.log("Reponse-----X> "+response);
							//console.log("$('#conclusion2').html()-----X> "+$('#conclusion').html());
							if($('#conclusion2').html() == 1)
							{
								//console.log("dans le if conclusion 2 do?? "+$('#conclusion2').html());
								return window.location.href = "../index.php";
							}
							else if(response == 2015)
							{
								return window.location.href = "./comptes/connection.php";
							}
						}
					});
					//console.log(data);
					
				
				return false;
		    });
	    });	
		