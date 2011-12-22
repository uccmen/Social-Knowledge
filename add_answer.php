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

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// Get value of id that sent from hidden field
$id=$_POST['id'];

// Find highest answer number.
$sql="SELECT MAX(a_id) AS Maxa_id FROM $tbl_name WHERE question_id='$id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

// add + 1 to highest answer number and keep it in variable name "$Max_id". if there no answer yet set it = 1
if ($rows) {
$Max_id = $rows['Maxa_id']+1;
}
else {
$Max_id = 1;
}

// get values that sent from form

$a_answer=$_POST['a_answer'];

$datetime=date("d/m/y H:i:s"); // create date and time


if(empty($a_answer))
{
  echo "<br>";
  echo "<a href='view_question.php?id=".$id."'>Go back !</a>";
  echo "<br>";
  echo "<br>";
  die("Please type an answer !");
}

// Insert answer
$sql2="INSERT INTO $tbl_name(fbid,question_id, a_id, a_answer, a_datetime)VALUES(".$user.",'$id', '$Max_id','$a_answer', '$datetime')";
$result2=mysql_query($sql2);

if($result2){
echo "Thank you for your answer !<BR>";
echo "<a href='view_question.php?id=".$id."'>View your answer</a>";

// If added new answer, add value +1 in reply column
$tbl_name2="socialqs_question";
$sql3="UPDATE $tbl_name2 SET reply='$Max_id' WHERE id='$id'";
$result3=mysql_query($sql3);

}
else {
echo "ERROR";
}

mysql_close();
?>