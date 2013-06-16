<?php

require_once('connect.php');
$db = new DB_CONNECT();

$fname= "Sagar Patidar";
$mob = 9873803931;
$email = "defdsa@gmail.com";
$pass = 1234 ;

$query_insert = "INSERT INTO user_detail (fullName, mobile, email, passwd)".
				"VALUES 				 ('$fname', '$mob', '$email', '$pass')";
				
//$execute_insert = mysql_query($query_insert) or die(mysql_error());

//$query_delete = "DELETE FROM user_detail where mobile='$mob'";

//$query_update = "UPDATE user_detail SET fullName='Sachin Goel' where mobile='9873803931'";

$query_search = "SELECT * FROM user_detail where mobile = '$mob'";

$result = mysql_query($query_search) or die(mysql_error());

// while($row = mysql_fetch_array($result)){
	// echo "$row[4]";
	// echo "<br>";
// }

//$e1= md5("rhythmgupta");
//$e2=sha1($e1);

echo "<br>";
echo "$e2";
echo "<br>";

//$execute_insert = mysql_query($query_delete) or die(mysql_error());

echo "Script 'edit.php' ran successfully!";

?>