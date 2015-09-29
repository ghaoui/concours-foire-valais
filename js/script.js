(function($){
	function bonmail(mailteste){// fonction pour verifier l'email
		var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
		if(reg.test(mailteste)){
			return(true);
		}else{
			return(false);
		}
	}
	$(document).ready(function(){

		$("#subscribeButton").click(function(){//subscription button
			var prenom = $('#prenom').val();
			var nom = $('#nom').val();
			var cp = $('#cp').val();
			var email = $('#email').val();
			var newsletter = 0;
			if($('#newsletter').is(':checked')){
				newsletter = $('#newsletter').val();
			}
			if(prenom =="" || nom =="" || cp =="" || email==""){// verification champ vide
				alert("vous devez completer les champs");
			}else{
				if(!bonmail(email)){
					alert('E-mail non valide');
				}else{
					if($('#condition').is(':checked')){
						$.ajax({
							url: 'ajax.php',
							type: 'post',
							data: {
								task : "subscription",
								nom : nom,
								prenom : prenom,
								cp : cp,
								email : email,
								newsletter : newsletter
							},
							success: function (data) {
								if(data =="success subscription"){//charger la deuxieme page
									$.ajax({// chargement de gagnant
								        type: "POST",
								        url:'ajax.php',
								        data:{
								        	task : "getprix"
								        },
								        success: function(msg){
								          var tabPrix = msg.split('-/-');
								          var image = tabPrix[0];
								          var prix = tabPrix[1];
								          var bg = "";
								          if(image == 'perdu'){
								          	bg = image;
								          }else{
								          	bg = image+'-'+prix;
								          }
								          $( "#conteneur" ).load( "game.html", function( response, status, xhr ) {//chargement de la page game
											  if ( status == "error" ) {
											    var msg = "Sorry but there was an error: ";
											    alert( msg + xhr.status + " " + xhr.statusText );
											  }else{
												var cbon = false;
										   		var updateEtat = false;
												$('#conteneur #imgGratter').wScratchPad({ // grattage tag
												size : 20,
												bg: 'images/'+bg+'-verbier.png',
												fg: 'images/zone-grattage-verbier.png',
												cursor: 'url(images/piece.png), crosshair',
												scratchMove: function (e, percent) {
													if (!cbon && percent > 50) {
														cbon = true;														
														if(!updateEtat){
															updateEtat = true;
															$.ajax({
														        type: "POST",
														        url:'ajax.php',
														        data: {
														        	task : "setprix",
														        	etat : image,
														        	prix : prix
														        },
														        success: function(msg){
														          $('#conteneur #imgGratter').wScratchPad('clear');
														          if(image=="gagner"){
														          	$("#codeGratter").html(msg).show("slow");
														          	$("#msgMail").show("slow");
														          	$('#conteneur #imgGratter').hide();
														          }
														        },
														        beforeSend : function(){
														            
														        },
														        complete : function(){
														            
														        }
														    });
														}	
													}
												}
										    });
										}
											});
								        }
								    });
									
								}else if(data =="existed mail"){
									alert('Vous pouvez jouer qu\'une seul fois');
								}
								else if(data =="error subscription"){
									alert('veuillez répéter votre inscription');
								}
							},
					        beforeSend : function(){
					           // $("#bgloading").show();
					        },
					        complete : function(){
					           // $("#bgloading").hide();
					        }
						});
					}else{
						alert('vous devez accepter les conditions de participation')
					}
					
				}

			}
		});

		
	});
})(jQuery);