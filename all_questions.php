<?php
$host="INSERT HOST NAME"; // Host name
$username="INSERT USERNAME"; // Mysql username
$password="INSERT PASSWORD"; // Mysql password
$db_name="INSERT DATABASE NAME"; // Database name
$tbl_name="INSERT TABLE NAME"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

$sql="SELECT * FROM $tbl_name ORDER BY datetime DESC";
// OREDER BY id DESC is order result by descending
$result=mysql_query($sql);
?>

<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td colspan="6" align="center" bgcolor="#E6E6E6"><strong><font size=16>LIST OF ALL QUESTIONS ASKED</font></strong></td>
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
<td colspan="6" align="right" bgcolor="#E6E6E6"><a href="main.php"><strong>Back to Main</strong> </a></td>
</tr>
</table>