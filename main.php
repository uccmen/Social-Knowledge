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
$user_profile = $facebook->api('/me');
echo "<p>Welcome : " . $user_profile['name'];
echo "<p>";
echo "Your FB ID is: " . $user;
} else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>

<head>


    <script>


      window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?= YOUR_APP_ID ?>',
          status     : true,
          cookie     : true,
          xfbml      : true
        });

        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
      };


      function sendRequestViaMultiFriendSelector() {
        FB.ui({method: 'apprequests',
          message: 'My Great Request'
        }, requestCallback);
      }


      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
    </script>


</body>
</html>

<?php
$host="INSERT HOST NAME"; // Host name
$username="INSERT USERNAME"; // Mysql username
$password="INSERT PASSWORD"; // Mysql password
$db_name="INSERT DATABASE NAME"; // Database name
$tbl_name="INSERT TABLE NAME"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

$sqla="SELECT * FROM $tbl_name ORDER BY datetime DESC LIMIT 10";
// OREDER BY datetime DESC is order result by descending
$result=mysql_query($sqla);
?>

<form action="add_question.php" method="post" align="center">
<input type="text" name="question" id="question" style="width:1000px; height:100px; font-size:35"/>
<input type="submit" value="Ask !" style="height: 50px; width: 350px; font-size:32"/>
</form>

<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td colspan="6" align="center" bgcolor="#E6E6E6"><strong><font size=16>MOST RECENT ASKED QUESTIONS (TOP 10)</font></strong></td>
</tr>
<tr>
<td width="6%" align="center" bgcolor="#E6E6E6"><strong>FB ID</strong></td>
<td width="4%" align="center" bgcolor="#E6E6E6"><strong>ID</strong></td>
<td width="53%" align="center" bgcolor="#E6E6E6"><strong>Question</strong></td>
<td width="6%" align="center" bgcolor="#E6E6E6"><strong>Views</strong></td>
<td width="6%" align="center" bgcolor="#E6E6E6"><strong>Replies</strong></td>
<td width="13%" align="center" bgcolor="#E6E6E6"><strong>Date/Time</strong></td>
</tr>

<?php
while($rows=mysql_fetch_array($result)){ // Start looping table row
?>

<tr>
<td bgcolor="#FFFFFF"><? echo $rows['fbid']; ?></td>
<td bgcolor="#FFFFFF"><? echo $rows['id']; ?></td>
<td bgcolor="#FFFFFF"><a href="view_question.php?id=<? echo $rows['id']; ?>"><? echo $rows['question']; ?></a><BR></td>
<td align="center" bgcolor="#FFFFFF"><? echo $rows['view']; ?></td>
<td align="center" bgcolor="#FFFFFF"><? echo $rows['reply']; ?></td>
<td align="center" bgcolor="#FFFFFF"><? echo $rows['datetime']; ?></td>
</tr>

<?php
// Exit looping and close connection
}
mysql_close();
?>
<tr>
<td colspan="6" align="right" bgcolor="#E6E6E6"><a href="all_questions.php"><strong>View All Questions</strong> </a></td>
</tr>
</table>