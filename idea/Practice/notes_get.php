<?php

$response = array();

if(isset($_POST['user_id']))
{
	$userID = $_POST['user_id'];
	require_once('connect.php');
	$db = new DB_CONNECT();
	
	$query = "SELECT * FROM notes WHERE user_id='$userID' ORDER BY serial DESC";
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
			$response['message']= "Succesfully got Notes details";
			$response['notes'] = $output;
		}
		else
		{
			$response['success']=2;
			$response['message']= "Some Error Occurred. Null result found!";
			$response['notes'] = null ;	
		}
	}	
	else
	{
		$response['success']=3;
		$response['message']= "Got empty result! No note found!";
		$response['notes'] = null ;			
	}
}
else
{
	$response['success']=4;
	$response['message']= "Fields Unavailable!";
	$response['notes'] = null ;
}


echo json_encode($response);
?>