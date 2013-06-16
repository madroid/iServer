<?php

$response = array();

if(isset($_POST['loginUsername']) && isset($_POST['passwd']))
{
	$loginUsername = $_POST['loginUsername'];
	$loginPassword = sha1(md5($_POST['passwd']));
	
	require_once("connect.php");
	$db= new DB_CONNECT();
	
	$query_search_email = "SELECT * FROM ".TABLE_USER_DETAIL." WHERE email='$loginUsername' ";
	$query_search_mob = "SELECT * FROM ".TABLE_USER_DETAIL." WHERE mobile='$loginUsername' ";
	//$query_search_username = "SELECT * FROM ".TABLE_USER_DETAIL." WHERE username='$loginUsername' ";
	
	$result_email = mysql_query($query_search_email);
	if(mysql_num_rows($result_email>0))
	{
		$row = mysql_fetch_array($result_email);
		if($row['email']=$loginUsername && $row['passwd']=$loginPassword)
		{
			$response['success']=1;
			$response['message']= "Login Successfull";
		}
		else
		{
			$response['success']=0;
			$response['message']= "Incorrect e-mail or password!";
		}
	}
	else
	{
		$result_mob = mysql_query($query_search_mob);
		if(mysql_num_rows($result_mob>0))
		{
			$row = mysql_fetch_array($result_mob);
			if($row['mobile']=$loginUsername && $row['passwd']=$loginPassword)
			{
				$response['success']=1;
				$response['message']= "Login Successfull";
			}
			else
			{
				$response['success']=0;
				$response['message']= "Incorrect e-mail or password!";
			}
		}
		else
		{
				$response['success']=0;
				$response['message']= "Not a Registered user! Please sign-up";
		}
	}
	
	
	
}
else
{
	$response['success']=0;
	$response['message']= "Login Fields Unavailable!";
}

echo "'login.php' ran successfully!";
?>