	$(function() {
			$('.petite-image').on('click', function(){
			
				$('.grosse-image').attr({
					"src": $(this).attr("src"),
					"alt": $(this).attr("alt")
				});
			});
		});
		

		//Controle dowg

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
				 $('#already_email').val("");
				  $('#already_email').hide();
			   }
			   
			  
				
}
			
	function chk_tel(field){
				
				//Contrôles 
				var alert_tel = document.getElementById("alert_tel");
				
				
				//Est ce que le téléphone est renseigné
				if(alert_tel !="")
				{
					var regex = /^[0-9][0-9]{7}[0-9]$/;
					if(!regex.test(field.value))
					{
					  alert_tel.style.display="inline";
					  alert_tel.innerHTML = "9 chiffres :) ";
						 
						  $('#already_tel').val("");
						  $('#already_tel').hide();
						   $('#already_tel').css({color: 'green'});
						
					}
				}
				
				  
	}
	
	function verifTitreAnnonce(field)
		{
				
				var alert_titre = document.getElementById("alert_titre");
				var taille = field.value.length;
			   if(taille < 1 && taille> 50)
			   {
				  //surline(field, true);
				  alert_titre.style.display="inline";
				  alert_titre.innerHTML = ("Attention 1 caractère minimum et 50 caractères maximum :)");
				
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
		
		function afficheValeur_Texte(field)
		{
			var field
			$("#taille_texte").html(field.value.length  +" / 300 max");
		}
		function effacerValeur_Texte(field)
		{
			$("#taille_texte").html("");
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
	
	
	//send email to seller !
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
					$('#conclusion').css("color", "black");
						$('#conclusion').css("font-weight", "");
						//console.log('l************** Data --------DDta'+data);
					if(response == 2015)
					{
						$('#conclusion').css("color", "green");
						$('#conclusion').css("font-weight", "bolder");
						$('#conclusion').html("Votre mail a été envoyé à l'annonceur :)");
					}
					else
						$('#conclusion').html(response);
						
						$('#conclusion').show();
						//console.log('l************** Réponse '+response);
					
						// Yes the message is sent
						//console.log("response ===******-----> "+response);
						/*if(response == 2015 )
							{
								//console.log("dans le if 2015"+$('#conclusion').html());
								return window.location.href = "../index.php";
							}
							*/
					}
				});
				//console.log(data);
				
			
			return false;
			});
	});	
					
				
			