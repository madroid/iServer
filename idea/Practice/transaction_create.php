<?php

$response = array();

if(isset($_POST['from_id']) && isset($_POST['to_id']) && isset($_POST['amount']))
{
	$from = $_POST['from_id'];
	$to = $_POST['to_id'];
	$amt = $_POST['amount'];
	date_default_timezone_set("Asia/Calcutta");
	$date = date("jS F\,Y");
	$time = date("h:i A");
	$month = date("F");
	$year = date("Y");
	$timestamp = time();

	require_once("connect.php");
	$db= new DB_CONNECT();

	
	$query = "INSERT INTO transactions (from_id,to_id,amount,timestamp,month,year,date,time)".
			 "VALUES                    ('$from','$to','$amt','$timestamp','$month','$year','$date','$time')";
	
	$query_result = mysql_query($query);
	
	if($query_result)
	{
		$response["success"] = 1;
		$response["message"] = "Transaction Successful";
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Oops! Some error Occurred.";
	}
	
	
}
else
{
	$response['success']=0;
	$response['message']= "Fields Unavailable!";
}

echo json_encode($response);

function getMonthName($monthid){
	if($monthid=='01'){
		return "January";
	}
	else if($monthid=='02'){
		return "February";
	}
	else if($monthid=='03'){
		return "May";
	}
	else if($monthid=='04'){
		return "April";
	}
	else if($monthid=='05'){
		return "May";
	}
	else if($monthid=='06'){
		return "June";
	}
	else if($monthid=='07'){
		return "July";
	}
	else if($monthid=='08'){
		return "August";
	}
	else if($monthid=='09'){
		return "September";
	}
	else if($monthid=='10'){
		return "October";
	}
	else if($monthid='11'){
		return "November";
	}
	else{
		return "December";
	}
}

?>