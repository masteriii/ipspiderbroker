<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
}else{
	$err="Support post method only.";
	die($err);
}
require_once dirname(__FILE__) . '/ts-load.php'; //config file

//ที่ clinet ต้องส่ง token มา และ เป็น token ที่ได้รับอนุญาตจึงจะใช้ service ได้
$allowed_tokens=array(

'GTa6Tac4Y4LFDNz979HHJgkt'
,'t5Zq2xp7YN4cp99RGW34YhVg'
,'RVU2M8f9U6kjNEvnn7696bbB'
,'94AP4UYLJqQyhaWvf2VjLqKP'
,'yZ6VKJq9nRykcdnVfgHptnTD'

);

/*###################################################################################
ไฟล์นี้ทำหน้าที่เป็น broker ติดต่อระหว่าง clinet กับ ส่วนที่จะไปดึง ข้อมูลจากเว็บไซต์อื่นๆ
    Client ----> WS Broker ----> Web Spider ----> Target Website
	main
/*###################################################################################*/
$action = isset($_POST['action'])?$_POST['action']:'';
$token = isset($_POST['token'])?$_POST['token']:'';
if(!in_array($token ,$allowed_tokens)){
	$resp['errs'][]="token: $token not allowed.";
	die(json_encode(  $resp ,JSON_UNESCAPED_UNICODE ));	
}
switch($action){

	case 'get_ip_info':{
		
		$resp=array('hello world get_ip_info');
		die(json_encode(  $resp ,JSON_UNESCAPED_UNICODE ));	
		
	}break;
	
	case 'fetch_from_db':{
		
		$resp=array('hello world fetch_from_db');
		die(json_encode(  $resp ,JSON_UNESCAPED_UNICODE ));	
		
	}break;
	
	
	
	default:{
		die('Invalid method.'.$action);
	}
		
}
die(0);
?>