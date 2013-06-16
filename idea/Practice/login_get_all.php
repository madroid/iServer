<?php
// The final output
$response = array();
$response['user_detail'] = array();
$response['contacts_detail'] = array();
$response['notes_detail'] = array();
$response['trans_detail'] = array();
//*******************************************************************************************************************
// Helper function of contact details 
function cmp($a,$b)
{
	return strcmp($a['name'],$b['name']);
}
// Function to get contact details
function getContacts($userID){
	$response_contacts = array();
	$query = "SELECT * FROM contacts WHERE my_id='$userID'";
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
			$response_contacts['success'] = 1;
			$response_contacts['message']= "Succesfully got Contacts details";
			$response_contacts['contacts'] = $output;	
		}
		else
		{
			$response_contacts['success']=2;
			$response_contacts['message']= "Some Error Occurred. 0 contacts found!";
			$response_contacts['contacts'] = array();
		}
	}
	else
	{
		$response_contacts['success']=3;
		$response_contacts['message']= "Got empty result! No such user found!";
		$response_contacts['contacts'] = array();
	}
	
	return $response_contacts;
}
//*******************************************************************************************************************

function getTransactions($userID){
	$response_trans = array();
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
			
			$response_trans['success']=1;
			$response_trans['message']= "Succesfully got transaction details";
			$response_trans['trans'] = $output;
		}
		else
		{
			$response_trans['success']=2;
			$response_trans['message']= "Some Error Occurred. Null result found!";
			$response_trans['trans'] = array() ;	
		}
	}	
	else
	{
		$response_trans['success']=3;
		$response_trans['message']= "Got empty result! No transaction found!";
		$response_trans['trans'] = array() ;			
	}
	
	return $response_trans ;
}

//*******************************************************************************************************************

function getNotes($userID){
	$response_notes = array();

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
			$response_notes['success']=1;
			$response_notes['message']= "Succesfully got Notes details";
			$response_notes['notes'] = $output;
		}
		else
		{
			$response_notes['success']=2;
			$response_notes['message']= "Some Error Occurred. Null result found!";
			$response_notes['notes'] = array() ;	
		}
	}	
	else
	{
		$response_notes['success']=3;
		$response_notes['message']= "Got empty result! No note found!";
		$response_notes['notes'] = array() ;			
	}
	return $response_notes ;

}

//*******************************************************************************************************************

function getUserDetails($row1){
	$response_details = array();
	$response_details['user_name'] = $row1['fullName'];
	$response_details['user_id'] = $row1['mobile'];
	$response_details['user_balance'] = $row1['balance'];
	return $response_details ;
}

//*******************************************************************************************************************
// Main code for user authentication 
if(isset($_POST['loginUsername']) && isset($_POST['passwd']))
{
	$loginUsername = $_POST['loginUsername'];
	$loginPassword = sha1(md5($_POST['passwd']));
	require_once("connect.php");
	$db= new DB_CONNECT();
	
	$query_search_email = "SELECT * FROM ".TABLE_USER_DETAIL." WHERE email='$loginUsername' ";
	$query_search_mob = "SELECT * FROM ".TABLE_USER_DETAIL." WHERE mobile='$loginUsername' ";
	
	$result_email = mysql_query($query_search_email);
	if(mysql_num_rows($result_email)>0)
	{
		$row = mysql_fetch_assoc($result_email);
		if($row['email']==$loginUsername && $row['passwd']==$loginPassword)
		{
			$response['success']=1;
			$response['message']= "Login Successful";
			$response['user_detail'] = getUserDetails($row);
			$response['contacts_detail'] = getContacts($row['mobile']);
			$response['notes_detail'] =  getNotes($row['mobile']);
			$response['trans_detail'] =  getTransactions($row['mobile']);
		}
		else
		{
			$response['success']=2;
			$response['message']= "Incorrect e-mail or password!";
		}
	}
	else
	{
		$result_mob = mysql_query($query_search_mob);
		if(mysql_num_rows($result_mob)>0)
		{
			$row = mysql_fetch_assoc($result_mob);
			if($row['mobile']==$loginUsername && $row['passwd']==$loginPassword)
			{
				$response['success']=1;
				$response['message']= "Login Successfull";
				$response['user_detail'] = getUserDetails($row);
				$response['contacts_detail'] = getContacts($row['mobile']);
				$response['notes_detail'] =  getNotes($row['mobile']);
				$response['trans_detail'] =  getTransactions($row['mobile']);
			}
			else
			{
				$response['success']=3;
				$response['message']= "Incorrect e-mail or password!";				
			}
		}
		else
		{
				$response['success']=4;
				$response['message']= "Not a Registered user! Please sign-up";
		}
	}
}
else
{
	$response['success']=5;
	$response['message']= "Login Fields Unavailable!";
}
echo json_encode($response);
?>