<?php
include 'facebook.php';
$app_id = "INSERT ADD ID";
$app_secret = "INSERT APP SECRET";
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


$host="INSERT HOST NAME"; // Host name
$username="INSERT USERNAME"; // Mysql username
$password="INSERT PASSWORD"; // Mysql password
$db_name="INSERT DATABASE NAME"; // Database name
$tbl_name="INSERT TABLE NAME"; // Table name

// Connect to server and select database.
$con=mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name",$con)or die("cannot select DB");

// get data that sent from form
$qid=md5($_POST['question']);
$question=$_POST['question'];
$datetime=date("d/m/y H:i:s"); //create date time

$sql="INSERT INTO $tbl_name(fbid,qid,question,datetime)VALUES(".$user.",'$qid', '$question','$datetime')";

if(empty($question))
{
  echo "<br>";
  echo "<a href=main.php>Back to main page !</a>";
  echo "<br>";
  echo "<br>";
  die("Please type a question !");
}

if (!mysql_query($sql,$con))
{
?>
  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
  <td colspan="6" align="center" bgcolor="#E6E6E6"><strong><font size=16>THIS QUESTION HAS ALREADY BEEN ASKED !</font></strong></td>
  </tr>
  <tr>
  <td width="6%" align="center" bgcolor="#E6E6E6"><strong>FB ID</strong></td>
  <td width="4%" align="center" bgcolor="#E6E6E6"><strong>ID</strong></td>
  <td width="53%" align="center" bgcolor="#E6E6E6"><strong>Question</strong></td>
  <td width="6%" align="center" bgcolor="#E6E6E6"><strong>Views</strong></td>
  <td width="6%" align="center" bgcolor="#E6E6E6"><strong>Replies</strong></td>
  <td width="13%" align="center" bgcolor="#E6E6E6"><strong>Date/Time</strong></td>
</tr>
  		<?
  		 if($query=mysql_query("SELECT * FROM socialqs_question WHERE qid = '$qid'",$con))
  		 {
  		  while($rows = mysql_fetch_assoc($query))
       	 {
       	   $fbid = $rows['fbid'];
		   $question = $rows['question'];
           $id = $rows['id'];
           $view = $rows['view'];
           $reply = $rows['reply'];
           $datetime = $rows['datetime'];
  		 ?>
       	 <tr>
		 <td bgcolor="#FFFFFF"><? echo $rows['fbid']; ?></td>
		 <td bgcolor="#FFFFFF"><? echo $rows['id']; ?></td>
		 <td bgcolor="#FFFFFF"><a href="view_question.php?id=<? echo $rows['id']; ?>"><? echo $rows['question']; ?></a><BR></td>
		 <td align="center" bgcolor="#FFFFFF"><? echo $rows['view']; ?></td>
		 <td align="center" bgcolor="#FFFFFF"><? echo $rows['reply']; ?></td>
		 <td align="center" bgcolor="#FFFFFF"><? echo $rows['datetime']; ?></td>
		 </tr>
		 <?
       	  }
       mysql_free_result($query);
          }
         ?>
         <tr>
		 <td colspan="6" align="right" bgcolor="#E6E6E6"><a href="main.php"><strong>Back to Main</strong> </a></td>
		 </tr>
         </table>
<?
  die('Click on question to view answers');
}
?>

<body>
<input type="button" onclick="sendRequestViaMultiFriendSelector(); return false;" value="Ask Your Friends !"/>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
      FB.init({
        appId  : '194472553967386',
        status : true,
        cookie : true,
        oauth: true
      });


      function sendRequestViaMultiFriendSelector() {
        FB.ui({method: 'apprequests',
          message: 'Please answer a question I have for you via Social Knowledge'
        }, requestCallback);
      }

      function requestCallback(response) {
        // Handle callback here
      }

</script>

</body>



<?
echo "<br>";
echo "<a href=main.php>View your question</a>";
echo "<br>";
die("Thank you for your question !");
mysql_close($con);
?>

