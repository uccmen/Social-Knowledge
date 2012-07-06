<?php

include 'facebook.php';
$app_id = "194472553967386";
$app_secret = "c1c717bae764f6942cab276638886fd0";
$facebook = new Facebook(array(
    'appId' => $app_id,
    'secret' => $app_secret,
    'cookie' => true
));

require 'social.php';
$user = $facebook->getUser();
$host="stevenswallcom.ipagemysql.com"; // Host name
$username="socialqs"; // Mysql username
$password="323232"; // Mysql password
$db_name="socialqs_db"; // Database name
$tbl_name="socialqs_question"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

$sql="SELECT * FROM $tbl_name ORDER BY id DESC";
// OREDER BY id DESC is order result by descending
$result=mysql_query($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="tables.css" />

<center>

<table id="gradient-style" summary="List Of All Questions Asked">

    <thead>

      <tr>
    		<th scope="col" colspan="8"><font size="30"><center>LIST OF ALL QUESTIONS ASKED<center></font></th>
    	</tr>
    	
    	<tr>

        	<th scope="col" align="center">User</th>

            <th scope="col">Name</th>

            <th scope="col">Question</th>

            <th scope="col">Views</th>
            
            <th scope="col">Replies</th>
            
            <th scope="col">Likes</th>
            
            <th scope="col">Shares</th>
            
            <th scope="col" align="center">Date/Time</th>

        </tr>

    </thead>

    <tfoot>

    	<tr>

        	<td colspan="8"><a href="main.php"><strong>Back to Main</strong></a></td>


        </tr>

    </tfoot>

    <tbody>

<?php
while($rows=mysql_fetch_array($result)){ //Start looping table row


?>
    	<tr>
		<td align="center"><a target="_blank" href="http://www.facebook.com/<? echo $rows['fbid']; ?>"><img src="https://graph.facebook.com/<? echo $rows['fbid']; ?>/picture"></a></td>
		<td><? echo $rows['name']; ?></td>
		<td><a href="view_question.php?id=<? echo $rows['id']; ?>"><? echo $rows['question']; ?></a></td>
		<td align="center"><? echo $rows['view']; ?></td>
		<td align="center"><? echo $rows['replies']; ?></td>
		<td align="center"><? echo $rows['likes']; ?></td>
		<td align="center"><? echo $rows['shares']; ?></td>
		<td align="center"><? echo $rows['datetime']; ?></td>
		</tr>


    </tbody>
    
<?php
// Exit looping and close connection
}
mysql_close();
?>

</table>
</center>
</html>