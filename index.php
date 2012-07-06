 <html>
    <head>
      <title>Social Knowledge Login Page</title>
    </head>
    <link rel="stylesheet" type="text/css" media="all" href="center.css" />
    <body>
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '194472553967386',
            channelUrl : 'http://www.stevenswall.com/fbtest/channel.html', // Channel File
            status     : true,
            cookie     : true,
            xfbml      : true,
            oauth      : true,
          });



          FB.getLoginStatus(function(response) {
    	    if (response.status === 'connected') {
		      var uid = response.authResponse.userID;
		      var accessToken = response.authResponse.accessToken;
		      window.location = "http://stevenswall.com/fbtest/main.php";
		    } else if (response.status === 'not_authorized') {
		      // the user is logged in to Facebook,
		      //but not connected to the app
		      window.location = "http://apps.facebook.com/socialqs";
		    } else {
		      // the user isn't even logged in to Facebook.

		    }
 });



            FB.Event.subscribe('auth.login', function(response) {
		            window.location.reload();
		            window.location = "http://stevenswall.com/fbtest/main.php";
        });


        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
	  <table id="outer" cellpadding="0" cellspacing="0" height="10%">
  		<tr><td id="middle">
	  <p>Welcome to Social Knowledge !</p>
      <div align="center" class="fb-login-button">Login with Facebook</div>
        </td></tr>
 	  </table>

    </body>
 </html>