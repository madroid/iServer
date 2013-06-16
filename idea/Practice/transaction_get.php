<?php

$response = array();

if(isset($_POST['user']))
{
	$userID = $_POST['user'];
	require_once('connect.php');
	$db = new DB_CONNECT();
	
	$query = "SELECT * FROM transactions WHERE from_id='$userID' OR to_id='$userID' ORDER BY serial DESC";
	$result = mysql_query($query);
	
	if(!empty($result))
	{
		$length = mysql_num_rows($result);
		if($length>0)
		{
			$output = array();
			
			while($row = mysql_fetch_assoc($result))
			{
				array_push($output,$row);
			}
			
			$response['success']=1;
			$response['code'] = 0;
			$response['message']= "Succesfully got transaction details";
			$response['trans'] = $output;
		}
		else
		{
			$response['success']=0;
			$response['code'] = 1;
			$response['message']= "Some Error Occurred. Null result found!";
			$response['trans'] = null ;	
		}
	}	
	else
	{
		$response['success']=0;
		$response['code'] = 2;
		$response['message']= "Got empty result! No transaction found!";
		$response['trans'] = null ;			
	}
}
else
{
	$response['success']=0;
	$response['code'] = 3;
	$response['message']= "Fields Unavailable!";
	$response['trans'] = null ;
}


echo json_encode($response);
?>