<?php

$response = array();

if(isset($_POST['user_id']) && isset($_POST['subject']) && isset($_POST['note']))
{
	$userID = $_POST['user_id'];
	$subject = $_POST['subject'];
	$note = $_POST['note'];
	
	require_once('connect.php');
	$db = new DB_CONNECT();
	date_default_timezone_set("Asia/Calcutta");
	$date = date("jS F\,Y");
	$time = date("h:i A");
	
	$query = "INSERT INTO notes(user_id,subject,note,date,time)".
			 "VALUES		   ('$userID','$subject','$note','$date','$time')";
	$query_result = mysql_query($query);
	
	if($query_result)
	{
		$response["success"] = 1;
		$response["message"] = "Note added Successfully!";
	}
	else
	{
		$response["success"] = 2;
		$response["message"] = "Oops! Some error Occurred.";
	}
	
	
}
else
{
	$response['success']=3;
	$response['message']= "Fields Unavailable!";
}

echo json_encode($response);

?>