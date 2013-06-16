<?php
if(isset($_POST['user_id_self']) && isset($_POST['frnd_id']) && isset($_POST['frnd_name']))
{
	$selfID = $_POST['user_id_self'];
	$frndID = $_POST['frnd_id'];
	$frnd_name = $_POST['frnd_name'];
	
	require_once('connect.php');
	$db = new DB_CONNECT();
	
	//Getting data corresponding to my_id
	$get_query = "SELECT * FROM contacts where my_id='$selfID'";
	$get_number = mysql_query($get_query) ;
	$row = mysql_fetch_assoc($get_number);
	$totalContacts = $row['total_contacts'];
	
	//Check if contact already exists
	$checkArray = explode("#",$row['frnd_id']);
	$len = count($checkArray)-1;
	$contact_exists = false ;
	for($i=0;$i<$len;$i++)
	{	
		if($checkArray[$i] == $frndID)
		{
			$contact_exists = true;
			break;
		}	
		
	}
	
	$query = "";
	if(!$contact_exists){
		if($totalContacts == 0)
		{
			$frndID = $frndID."#";
			$frnd_name = $frnd_name."#";
			$query = "UPDATE contacts SET  frnd_id = '$frndID', frnd_name='$frnd_name', total_contacts = total_contacts+1 WHERE my_id = '$selfID'";
		}
		else
		{
			$frndID = $row['frnd_id'].$frndID."#";
			$frnd_name = $row['frnd_name'].$frnd_name."#";
			$query = "UPDATE contacts SET  frnd_id = '$frndID', frnd_name='$frnd_name', total_contacts = total_contacts+1 WHERE my_id = '$selfID'";
		}	
		$result = mysql_query($query);
		echo "$result";
		if(($result)>0)
		{
			$response['success']=1;
			$response['message']= "Contacts Updated successfully!";		
		}
		else
		{
			$response['success']=1;
			$response['message']= "Got 0 updated row from query! Some error occurred!";	
		}
	}
	else
	{
		$response['success']=3;
		$response['message']= "Contact Already exists";	
	}
}
else
{
	$response['success']=4;
	$response['message']= "Fields Unavailable!";
}

echo json_encode($response);

?>