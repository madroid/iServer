<?php

$response = array();
if(isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['fullName'])&& isset($_POST['passwd']))
{
	$name = $_POST['fullName'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$password = sha1(md5($_POST['passwd']));
	
	require_once("connect.php");
	$db= new DB_CONNECT();
	
	$query_insert = "INSERT INTO ".TABLE_USER_DETAIL."(fullName,mobile,email,passwd)".
					"VALUES						   ('$name','$mobile','$email','$password')";
					
	$query_result = mysql_query($query_insert);
	
	if($query_result)
	{
		$response["success"] = 1;
		$response["message"] = "Registration Successful.";
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Oops! Some error Occurred.";
	}
	
}
else
{
	$response["success"] = 0;
	$response["message"] = "Please provide complete detail.";
}	

$output_arr['result'] = $response;

echo json_encode($output_arr);

?>