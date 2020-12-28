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

class MTSSpiderBroker{

	public static function get_param($name){
		
		$str='';
		while(true){
			
			$str=isset($_POST[$name])?$_POST[$name]:'';
			if($str==''){
				//$str=isset($_GET[$name])?$_GET[$name]:'';
			}
			break;
			
		}
		return $str;

	}//fn
	

	public function get_ip_info(){
		
		$content='';
		global $arr_webservice;//array เก็บรายการ webservice ในระบบ
		while(true){
			
			$ip = self::get_param('ip');
			$user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0';
			$token = self::get_param('token');
			$post = array('ip'=>$ip,'action'=>'get_ip_info','token'=>$token);
			$url = 'https://ipspiderws6.herokuapp.com/ep.php';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 180);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			$content=curl_exec($ch);//json
			curl_close($ch);
		
			
			break;
			
		}
		
		return $content;//return as array
	} 
	
	
	public function test(){
		
		$content='';
		$errs=$resp=$errs=array();
		while(true){
		
			//call ip info from webservice
			$arr_user_agent=array(
			
				'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0'
				
			);
			$ip = self::get_param('ip');
			$idx=rand(0,count($arr_user_agent)-1);
			$user_agent = $arr_user_agent[$idx];
			$token = MTSSpiderBroker::get_param('token');
			$post = array('ip'=>$ip,'action'=>'test','token'=>$token);
			$url = 'https://ipspiderws6.herokuapp.com/ep.php';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 180);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			$content=curl_exec($ch);//json
			curl_close($ch);
	
			break;
			
		}
		
		return $content;//return as array
	} 
	
}//class




/*###################################################################################
ไฟล์นี้ทำหน้าที่เป็น broker ติดต่อระหว่าง clinet กับ ส่วนที่จะไปดึง ข้อมูลจากเว็บไซต์อื่นๆ
    Client ----> WS Broker ----> Web Spider ----> Target Website
	main
/*###################################################################################*/
$action = MTSSpiderBroker::get_param('action');
$token = MTSSpiderBroker::get_param('token');
if(!in_array($token ,$allowed_tokens)){
	$resp['errs'][]="token: $token not allowed.";
	die(json_encode(  $resp ,JSON_UNESCAPED_UNICODE ));	
}
switch($action){
	
	case 'get_ip_info':{
		
		$oMTSSpiderBroker=new MTSSpiderBroker();
		$content=$oMTSSpiderBroker->get_ip_info();//ไม่ต้องอะไร เพราะไปเก็บค่าในฟังก์ชัน
		die($content);	
		
	}break;

	case 'google':{
		
		die(file_get_contents('https://www.google.com/'));
		
	}break;
	
	case 'test':{
		
		$oMTSSpiderBroker=new MTSSpiderBroker();
		$content=$oMTSSpiderBroker->test();
		die($content);
		
	}break;
	
	
	default:{
		die('Invalid method.'.$action);
	}
		
}
die(0);
?>