<?php
$host="INSERT HOST NAME"; // Host name
$username="INSERT USERNAME"; // Mysql username
$password="INSERT PASSWORD"; // Mysql password
$db_name="INSERT DATABASE NAME"; // Database name
$tbl_name="INSERT TABLE NAME"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// get value of id that sent from address bar
$id=$_GET['id'];

$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$result=mysql_query($sql);

$rows=mysql_fetch_array($result);
?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td><table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="1" bgcolor="#FFFFFF">
<tr>
<h1>Question : <? echo $rows['question']; ?></h1>
<td bgcolor="#F8F7F1"><strong><? echo $rows['fbid']; ?></strong></td>
</tr>

<tr>
<td bgcolor="#F8F7F1"><strong>Date/time : </strong><? echo $rows['datetime']; ?></td>
</tr>
</table></td>
</tr>
</table>
<BR>




<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td width="6%" align="center" bgcolor="#E6E6E6"><strong>FB ID</strong></td>
<td width="6%" align="center" bgcolor="#E6E6E6"><strong>A ID</strong></td>
<td width="53%" align="center" bgcolor="#E6E6E6"><strong>Answer</strong></td>
<td width="13%" align="center" bgcolor="#E6E6E6"><strong>Date/Time</strong></td>
</tr>
<?php
$tbl_name2="socialqs_answer"; // Switch to table "socialqs_answer"

$sql2="SELECT * FROM $tbl_name2 WHERE question_id='$id' ORDER BY a_datetime DESC";
$result2=mysql_query($sql2);

while($rows=mysql_fetch_array($result2)){
?>
<tr>
<td bgcolor="#F8F7F1"><? echo $rows['fbid']; ?></td>
<td bgcolor="#F8F7F1"><? echo $rows['a_id']; ?></td>
<td bgcolor="#F8F7F1"><? echo $rows['a_answer']; ?></td>
<td bgcolor="#F8F7F1"><? echo $rows['a_datetime']; ?></td>
</tr>


<?
}


$sql3="SELECT view FROM $tbl_name WHERE id='$id'";
$result3=mysql_query($sql3);

$rows=mysql_fetch_array($result3);
$view=$rows['view'];

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
<tr>
<td colspan="4" align="right" bgcolor="#E6E6E6"><a href="main.php"><strong>Back to Main</strong> </a></td>
</tr>
</table><br>
<BR>

<form name="form1" action="add_answer.php" method="post" align="center">
<input name="id" type="hidden" value="<? echo $id; ?>">
<input type="text" name="a_answer" id="a_answer" style="width:1000px; height:100px; font-size:35"/>
<input type="submit" value="Submit Answer !" style="height: 50px; width: 350px; font-size:32"/>
</form>