<?php

$response = array();

function cmp($a,$b)
{
	return strcmp($a['name'],$b['name']);
}

if(isset($_POST['user_id_self']) )
{
	$selfID = $_POST['user_id_self'];

	require_once('connect.php');
	$db = new DB_CONNECT();
	
	$query = "SELECT * FROM contacts WHERE my_id='$selfID'";
	$result = mysql_query($query);

	
	if(!empty($result))
	{
		$length = mysql_num_rows($result);
		if($length>0)
		{
			$row = mysql_fetch_assoc($result);
			$arr1 = explode("#",$row['frnd_id']);
			$arr2 = explode("#",$row['frnd_name']);
			$len = count($arr1)-1;
			$output = array();
			for($i=0;$i<$len;$i++)
			{
				$row = array('id'=>$arr1[$i],'name'=>$arr2[$i]);
				array_push($output,$row);
			}
			usort($output,"cmp");
			$response['success'] = 1;
			$response['message']= "Succesfully got Contacts details";
			$response['contacts'] = $output;	
		}
		else
		{
			$response['success']=2;
			$response['message']= "Some Error Occurred. Null result found!";
			$response['contacts'] = null;
			
		}
	}	
	else
	{
		$response['success']=3;
		$response['message']= "Got empty result! No such user found!";
		$response['contacts'] = null;
		

	}
}
else
{
	$response['success']=4;
	$response['message']= "Fields Unavailable!";
	$response['contacts'] = null;
}


echo json_encode($response);
?>