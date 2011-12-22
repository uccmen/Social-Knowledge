<?php
include 'facebook.php';
$app_id = "INSERT APP ID HERE";
$app_secret = "INSERT APP SECRET HERE";
$facebook = new Facebook(array(
    'appId' => $app_id,
    'secret' => $app_secret,
    'cookie' => true
));

$user = $facebook->getUser();

if ($user <> '0' && $user <> '') { /*if valid user id i.e. neither 0 nor blank nor null*/
try {
// Proceed knowing you have a logged in user who's authenticated.
$user_profile = $facebook->api('/me');
} catch (FacebookApiException $e) { /*sometimes it shows user id even if user in not logged in and it results in Oauth exception. In this case we will set it back to 0.*/
error_log($e);
$user = '0';
}
}
if ($user <> '0' && $user <> '') { /*So now we will have a valid user id with a valid oauth access token and so the code will work fine.*/
echo "<center>Welcome UserId : " . $user;

$user_profile = $facebook->api('/me');
echo "<p><center>You must be " . $user_profile['name'];
echo "<p>";


}

?>

<form action="main.php" method="post" align="center">
<input type="submit" value="Click To Proceed..." style="height: 50px; width: 350px; font-size:32"/>
</form>