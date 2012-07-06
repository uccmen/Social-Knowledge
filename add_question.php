<?php
include 'facebook.php';
$app_id = "194472553967386";
$app_secret = "c1c717bae764f6942cab276638886fd0";
$facebook = new Facebook(array(
    'appId' => $app_id,
    'secret' => $app_secret,
    'cookie' => true
));


$user = $facebook->getUser();

if ($user <> '0' && $user <> '') 
{ /*if valid user id i.e. neither 0 nor blank nor null*/
	try 
	{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
		$fbname = $user_profile['name'];
	}
	catch (FacebookApiException $e) 
	{ /*sometimes it shows user id even if user in not logged in and it results in Oauth exception. In this case we will set it back to 0.*/
	error_log($e);
	}
}



$host="stevenswallcom.ipagemysql.com"; // Host name
$username="socialqs"; // Mysql username
$password="323232"; // Mysql password
$db_name="socialqs_db"; // Database name
$tbl_name="socialqs_question"; // Table name


// Connect to server and select database.
$con=mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name",$con)or die("cannot select DB");

// get data that sent from form
$qid=md5($_POST['question']);
$question=$_POST['question'];
$datetime=date("d/m/y H:i:s"); //create date time

$sql="INSERT INTO $tbl_name(name,fbid,qid,question,datetime)VALUES('".$fbname."',".$user.",'$qid', '$question','$datetime')";

if(empty($question))
{
?>
  <link rel="stylesheet" type="text/css" media="all" href="tables.css" />
  <BR>
  <BR>
  <BR>
  <center>
  <table id="hor-minimalist-b" summary="type a question">

      <thead>

      	<tr>

          	<th scope="col" colspan="4"><center><font size="6">Please type your question!</font></center></th>

          </tr>

      </thead>

      <tbody>

      	<tr>

          	<td colspan="4"><center><a href=main.php>[Back to main page]</center></a></td>

          </tr>

      </tbody>

  </table>
  </center>
<?
  die();



}

if (!mysql_query($sql,$con))
{


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link rel="stylesheet" type="text/css" media="all" href="tables.css" />

<center>
<table id="background-image" summary="asked question">

    <thead>

    	<tr>

        	<th scope="col" colspan="8"><font size="20"><center>QUESTION EXISTS</center></font></th>
        <tr>

        <tr>

            <th scope="col" align="center">User</th>

            <th scope="col" align="left">Name</th>

            <th scope="col" align="left">Question</th>

            <th scope="col" align="center">Views</th>

            <th scope="col" align="center">Replies</th>

            <th scope="col" align="center">Likes</th>

            <th scope="col" align="center">Shares</th>

            <th scope="col" align="center">Date/Time</th>

        </tr>

    </thead>


    <tbody>


    <?
	  		 if($query=mysql_query("SELECT * FROM socialqs_question WHERE qid = '$qid'",$con))
	  		 {
	  		  while($rows = mysql_fetch_assoc($query))
	       	 {

	       	 $url = 'http://stevenswall.com/fbtest/view_question.php?id='.$rows['id'].'';
			 $facebook1 = file_get_contents("http://api.facebook.com/restserver.php?method=links.getStats&urls=$url");
			 $fbbegin = '<share_count>';
			 $fbend = '</share_count>';
			 $fbpage = $facebook1;
			 $fbparts = explode($fbbegin,$fbpage);
			 $fbpage = $fbparts[1];
			 $fbparts = explode($fbend,$fbpage);
			 $fbcount = $fbparts[0];
			 if($fbcount == '') { $fbcount = '0';}


			 $likebegin = '<like_count>';
			 $likeend = '</like_count>';
			 $likepage = $facebook1;
			 $likeparts = explode($likebegin,$likepage);
			 $likepage = $likeparts[1];
			 $likeparts = explode($likeend,$likepage);
			 $likecount = $likeparts[0];
			 if($likecount == '') { $likecount = '0';}


			 $commentbegin = '<commentsbox_count>';
			 $commentend = '</commentsbox_count>';
			 $commentpage = $facebook1;
			 $commentparts = explode($commentbegin,$commentpage);
			 $commentpage = $commentparts[1];
			 $commentparts = explode($commentend,$commentpage);
			 $commentcount = $commentparts[0];
			 if($commentcount == '') { $commentcount = '0';}

  		 ?>

    	<tr>
		<td align="center"><a target="_blank" href="http://www.facebook.com/<? echo $rows['fbid']; ?>"><img src="https://graph.facebook.com/<? echo $rows['fbid']; ?>/picture"></a></td>
		<td><? echo $rows['name']; ?></td>
		<td><a href="view_question.php?id=<? echo $rows['id']; ?>"><? echo $rows['question']; ?></a></td>
		<td align="center"><? echo $rows['view']; ?></td>
		<td align="center"><?php echo $commentcount; ?></td>
		<td align="center"><?php echo $likecount; ?></td>
		<td align="center"><?php echo $fbcount; ?></td>
		<td align="center"><? echo $rows['datetime']; ?></td>
		</tr>

		<?
       	  }
       mysql_free_result($query);
          }

         ?>

    </tbody>

     <tfoot>

     		</tr>

	 	       <td colspan="8"><a href="main.php"><strong>Back to Main</strong> </a></td>

	        </tr>

	    	<tr>
	    	<td colspan="8">
	    	<?
			  die('Click on question to view answers');
			}
			?>
	    	</td>
	    	</tr>


	    </tfoot>


</table>
</center>



<link rel="stylesheet" type="text/css" media="all" href="tables.css" />
<body>

  <BR>
  <BR>
  <BR>
  <center>
  <table id="hor-minimalist-b" summary="type a question">

      <thead>

      	<tr>

          	<th scope="col" colspan="4"><center><font size="6">That's a good question!</font></center></th>

          </tr>

          <tr>

		     <th scope="col" colspan="4"><center><a href=main.php>[View Question]</a></center></th>

          </tr>

      </thead>

      <tbody>

      	<tr>

          	<td colspan="4"><center><input type="button" onclick="sendRequestViaMultiFriendSelector(); return false;" value="Share this app!"/></center></td>

          </tr>


      </tbody>

  </table>
  </center>


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
mysql_close($con);
die();



?>

</html>