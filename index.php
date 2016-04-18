<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="UTF-8">
	<title>Login no Facebook</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.js"></script>
	<script type="text/javascript">
		function callBackMudancasStatus(response){
			//o objeto de resposta é retornado como o campo de status, que faz com que 
			// o aplicativo saiba o status de login da atual
			if(response.status === 'connected'){
				// caso esteja logado, execute minha api, recuperando as informações de login
				$('#logar').hide();
				$('#status').append('<a href="javascript:void(0);" id="logOut" onclick="logOut();">Sair</a>');
				testAPI();
			}else if(response.status === 'not_authorized'){
				$('#status').html('<p>Por favor, faça login no aplicativo</p>');
				$('#logOut').remove();
			}else{
				// a pessoa não está logada no app e facebook
				$('#status').html('');
				$('#logOut').remove();
			}
		}
		
		window.fbAsyncInit = function(){
			FB.init({
				appId: '148879012176205',
				cookie: true,
				version:'v2.6'
			});

			FB.getLoginStatus(function(response){
				callBackMudancasStatus(response);
			});

		};	

		(function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
			
			function testAPI(){
				FB.api('/me?fields=name,email,picture', function(response){
					$('#status').append('<p>Olá, '+response.name+
						' seja bem vindo!</p><p> Seu id é: '+response.id+
						'</p><p> Seu email: '+response.email+
						'</p><img src="https://graph.facebook.com/'+response.id+'/picture?type=large"></img>');
					console.log(response);
				});
			}

			function logOut(){
				FB.logout(function(response){
					callBackMudancasStatus(response);
					$('#status').append('Você acaba de Sair! <a href="http://buscafestas.esy.es/"> Deseja fazer Login?</a>');
				});
			}

			function login(){
							
				FB.login(function(response) {
   				// permissões necessária
   					callBackMudancasStatus(response);
 				}, {scope: 'public_profile,email'});
 				
			}

	</script>
</head>
<body bgcolor="#ebebeb">

	<a href="javascript:void(0)" onclick="login();" id="logar">Efetuar Login</a>
	<div id="status"></div>
	
</body>
</html>


