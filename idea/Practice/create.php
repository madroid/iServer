<?php

require_once('connect.php');
$db = new DB_CONNECT();


$query = "CREATE TABLE IF NOT EXISTS user_detail 	(
		serial INT(11) NOT NULL AUTO_INCREMENT,
		fullName varchar(50) NOT NULL,
		mobile bigint(10) NOT NULL,
		email varchar(50) NOT NULL,
		passwd varchar(255) NOT NULL,
		balance bigint(20), 
		PRIMARY KEY(serial)
		)";

$execute_query = mysql_query($query) or die(mysql_error());	

$query1 = "CREATE TABLE IF NOT EXISTS transactions(
		 serial INT(11) NOT NULL AUTO_INCREMENT,
		 from_id bigint(10) NOT NULL,
		 to_id bigint(10) NOT NULL,
		 amount int(11) NOT NULL,
		 timestamp bigint(18) NOT NULL,
		 month varchar(15) NOT NULL,
		 year int(4) NOT NULL,
		 date varchar(25),
		 time varchar(25),
		 PRIMARY KEY(serial)
		 )";

$execute_query1 = mysql_query($query1) or die(mysql_error());			 

$query2 = "CREATE TABLE IF NOT EXISTS contacts(
		  serial INT(11) NOT NULL AUTO_INCREMENT,
		  my_id bigint(10) NOT NULL,
		  frnd_id text(65536) ,
		  frnd_name text(65536) ,
		  total_contacts int(11) default 0,
		  PRIMARY KEY(serial)
		  )";

$execute_query2 = mysql_query($query2) or die(mysql_error());
		  
$query3 = "CREATE TABLE IF NOT EXISTS notes(
		   serial INT(11) NOT NULL AUTO_INCREMENT,
		   user_id BIGINT(10) NOT NULL,
		   subject varchar(255),
		   note text,
		   date varchar(255),
		   time varchar(255),
		   PRIMARY KEY(serial)
			)";
$execute_query3 = mysql_query($query3) or die(mysql_error());
			
echo "Script Ran Successfully!... 'create.php'";

?>