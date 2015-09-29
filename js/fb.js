var facebook = false ;
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
     
     
     FB.api('/me', 'GET', {
        "fields": "id,name,email"
    },function(response) {
    console.log(JSON.stringify(response));
facebook = true;
$('#facebook-button').hide();

var str = response['name'];

$('#nom').val(str.substr(0,str.indexOf(' ')));
$('#prenom').val(str.substr(str.indexOf(' ')+1));
$('#email').val(response['email']);
     });

     
    } 
  }

  function checkLoginState() {
    
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

   window.fbAsyncInit = function() {
    FB.init({
      appId      : '1640244866232203',
      xfbml      : true,
      version    : 'v2.4'
    });
    /*FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });*/
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
