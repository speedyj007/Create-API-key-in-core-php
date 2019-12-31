
<?php

$user_id = $_GET["id"];
$api_key = $_GET["api_key"];
$fields  = $_GET["fields"];

if(!isset($api_key) )
{
	echo json_encode(
	array(
		"code"=>1,
		"message"=>"api_key is required"
	)
	);
	die(); 
}

	if(strlen($api_key)!=16 )
{

	echo json_encode(
	array(
		"code"=>2,
		"message"=>"api_key is invalid"
	)
	);
	die();
}


require_once("config.php");

$q = $con->query("select date_gen from api_keys where api_key = '".$api_key."' and is_valid = 1");


if($q->num_rows==0)
{
	echo json_encode(
	array(
		"code"=>3,
		"message"=>"api_key is invalid"
	)
	);
	die();
}

$d_gen     = $q->fetch_assoc()["date_gen"];
$d_expires = strtotime($d_gen. " +7 days");
$d_today   = strtotime($date);


if($d_today >= $d_expires )
{
	$con->query("update api_keys set is_valid = 0 where api_key = '".$api_key."'");
	
}

if(!isset($user_id))
{
	echo json_encode(
	array(
		"code"   =>5,
		"message"=>"id is required"
	)
	);
	die();
}
 
 $q = $con->query("select * from demo where id = '".$user_id."'");
 
 if($q->num_rows ==0)
 {
	 echo json_encode(
	    array(
		"code"=>6,
		"message"=>"Selected record does not existed."
	)
	);
	die();
 }
 
 if(!isset($fields))
 {
	 echo json_encode($q->fetch_assoc());
	 die();
 }
 
 
 $fields = explode(',',$fields);
 
 $allowed = array(
		'name',	
		'firstname',
		'lastname',
		'mobile',
		'email',
		'password'	
 );
 
 $user = array();
 
 $q = $con->query("select * from demo where id = '".$user_id."'")->fetch_assoc();
 
 foreach($fields as $field)
 {
	 if(!in_array($field, $allowed))
	 {
	
		echo json_encode(
	    array(
		"code"=>7,
		"message"=>"Field '".$field."' does not exit."
	)
	);
	 die();
	 }
	 
	 if($field == 'name' )
 {
	$user[$field] = $q['firstname'].' '.$q['lastname']; 
	 
	 continue;
 }
 
 $user[$field] = $q[$field];
 
	 
 }
 
 print_r(
	json_encode(
		$user 
	)
 );
 
 
?> 