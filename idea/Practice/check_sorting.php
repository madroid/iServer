<?php

$arr = array();
$arr[0] = array("Sagar","Agar","gar","r");
$arr[1] = array(4,3,2,1);

function cmp($a,$b)
{
	return strcmp($a[0],$b[0]);
}

usort($arr,cmp);

echo json_encode($arr);


?>