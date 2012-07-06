<?php


include 'facebook.php';
$app_id = "194472553967386";
$app_secret = "c1c717bae764f6942cab276638886fd0";
$facebook = new Facebook(array(
    'appId' => $app_id,
    'secret' => $app_secret,
    'cookie' => true
));


$host="stevenswallcom.ipagemysql.com"; // Host name
$username="socialqs"; // Mysql username
$password="323232"; // Mysql password
$db_name="socialqs_db"; // Database name
$tbl_name="socialqs_question"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// get value of id that sent from address bar
$id=$_GET['id'];



$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$result=mysql_query($sql);

$rows=mysql_fetch_array($result);


$user = $facebook->getUser();


$url = 'http://stevenswall.com/fbtest/view_question.php?id='.$rows['id'].'';



$title= $rows['question'];
$image=urlencode("http://i.istockimg.com/file_thumbview_approve/3411056/2/stock-photo-3411056-i-have-a-question.jpg");
$summary=urlencode("Do you know the answer to this question?");
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>
<? echo $rows['question']; ?>
</title>

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# socialqs: http://ogp.me/ns/fb/socialqs#">
  <meta property="fb:app_id"      content="194472553967386" />
  <meta property="og:type"        content="socialqs:question" />
  <meta property="og:url"         content="http://stevenswall.com/fbtest/view_question.php?id=<? echo $rows['id']; ?>" />
  <meta property="og:title"       content="<? echo $rows['question']; ?>" />
  <meta property="og:description" content="Do you know the answer to this question?" />
  <meta property="og:image"       content="http://i.istockimg.com/file_thumbview_approve/3411056/2/stock-photo-3411056-i-have-a-question.jpg" />
  <meta property="fb:admins" content="1222117589" />

</head>
<link rel="stylesheet" type="text/css" href="share.css" />


<div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
        FB.init({
            appId:'194472553967386',
            channelUrl : 'http://www.stevenswall.com/fbtest/channel.html', // Channel File
            cookie:true,
            status:true,
            xfbml:true,
            frictionlessRequests : true,
            oauth:true
        });
        
        function sendRequestViaMultiFriendSelector() {
  	        FB.ui({method: 'apprequests',
		          message: 'Please answer a question I have for you via Social Knowledge'
		        }, requestCallback);
		      }
		
		       function requestCallback(response)
			  	  {
			  	      if(response && response.request) {
			  	           // Here, requests have been sent, facebook gives you the request and the array of recipients
			  	           console.log(response.request);
			  	      } else {
			  	           // No requests sent, you can do what you want (like...nothing, and stay on the page).
			  	      }
				  }


          FB.getLoginStatus(function(response) {
			  		    if (response.status === 'connected') {
			  		      var uid = response.authResponse.userID;
			  		      var accessToken = response.authResponse.accessToken;

			  		    } else if (response.status === 'not_authorized') {
			  		      // the user is logged in to Facebook,
			  		      //but not connected to the app
			  		      window.location = "http://apps.facebook.com/socialqs";
			  		    } else {
			  		      window.location = "http://stevenswall.com/fbtest/index.php";
			  		    }
		 });


		  FB.Event.subscribe('comment.create', function(response)
		  {
		    alert('Thank you for your comment!');
});
</script>



        <script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=194472553967386";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>


<link rel="stylesheet" type="text/css" media="all" href="center.css" />
<link rel="stylesheet" type="text/css" media="all" href="tables.css" />



<center>
<table id="one-column-emphasis">

    <colgroup>

    	<col class="oce-first" />

    </colgroup>

    <thead>

    	<tr>

        	<th scope="col">Question :</th>

            <th scope="col" colspan="7" align="left"><? echo $rows['question']; ?></th>

        </tr>

    </thead>

    <tbody>

    	<tr>

        	<td>Asked by</td>

            <td colspan="7" align="left"><a target="_blank" href="http://www.facebook.com/<? echo $rows['fbid']; ?>"><img src="https://graph.facebook.com/<? echo $rows['fbid']; ?>/picture"></a></td>

        </tr>

        <tr>

        	<td>Name</td>

            <td colspan="7" align="left"><? echo $rows['name']; ?></td>

        </tr>

        <tr>

		        	<td>Date and Time</td>

		            <td colspan="7" align="left"><? echo $rows['datetime']; ?></td>

        </tr>

        <tr>

        	<td>Share this Question</td>

            <td colspan="7" align="left">
            <div class="button2">
			<a id="button" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)">
			Share
			</a>
			<div class="counter">
			<div id="fbcount">
			<? echo $rows['shares']; ?>
			</div>
			</div>
			</div>
			</td>

        </tr>

        <tr>

        	<td>Like this Question</td>

            <td colspan="7" align="left"><div class="fb-like" data-href="http://stevenswall.com/fbtest/view_question.php?id=<? echo $rows['id']; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="tahoma"></div>
			</td>

        </tr>
        
         <tr>
		
		        	<td>Be Honest...</td>
		
		            <td colspan="7" align="left">
		            <form action="add_question.php" method="post">
		            
					<input type="submit" value="I don't know" style="height: 30px; width: 100px; font-size:32"/>
					
					</form>

					</td>
		
        </tr>
        
        <tr>
		
		        	<td>Ask Your Friends</td>
		
		            <td colspan="7" align="left">
		            <input type="button" onclick="sendRequestViaMultiFriendSelector(); return false;" value="Share this app!"/>
					</td>
		
        </tr>

        <tr>

		        	<td><a href="main.php">Back to Main Page</a></td>

		            <td colspan="7" align="left"></td>

        </tr>

    </tbody>

</table>


<div class="fb-comments" data-href="http://stevenswall.com/fbtest/view_question.php?id=<? echo $rows['id']; ?>" data-num-posts="5" data-width="1000" data-notify="true"></div>

</center>

</html>




<?

require 'social.php';

$sql3="SELECT view FROM $tbl_name WHERE id='$id'";
$result3=mysql_query($sql3);

$rows=mysql_fetch_array($result3);
$view=$rows['view'];

//FBDATA
$sql7="SELECT shares,likes,replies FROM $tbl_name WHERE id='$id'";
$result7=mysql_query($sql7);
$rows=mysql_fetch_array($result7);
$likes=$rows['likes'];
$shares=$rows['shares'];
$replies=$rows['replies'];

if(empty($shares)){
$shares=0;
$sql8="INSERT INTO $tbl_name(shares) VALUES('$shares') WHERE id='$id'";
$result4=mysql_query($sql8);
}
else{
$sql6="UPDATE $tbl_name set shares='$fbcount', likes='$likecount',replies='$commentcount' WHERE id='$id'";
$result6=mysql_query($sql6);
}
//FBDATA


// if have no counter value set counter = 0
if(empty($view)){
$view=0;
$sql4="INSERT INTO $tbl_name(view) VALUES('$view') WHERE id='$id'";
$result4=mysql_query($sql4);
}

// count more value
$addview=$view+1;
$sql5="update $tbl_name set view='$addview' WHERE id='$id'";
$result5=mysql_query($sql5);



mysql_close();
?>