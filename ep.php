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
	
	/*
	สอบถามไปที่  database ว่ามี ip นี้มั้ย ถ้ามีขอรายละเอียด
	*/
	private function _fetch_from_db($ip){
		
		$resp=$errs=array();
		//call
		$arr_user_agent=array(

		// 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246'
		// ,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3'
		// ,'Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36'
		// ,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/601.3.9 (KHTML, like Gecko) Version/9.0.2 Safari/601.3.9'
		// ,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36'
		// ,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1'
		// ,'Mozilla/5.0 (compatible; MSIE 9.0; AOL 9.7; AOLBuild 4343.19; Windows NT 6.1; WOW64; Trident/5.0; FunWebProducts)'
		// ,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
		// ,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 OPR/72.0.3815.320'

		'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0'

		);
		$idx=rand(0,(count($arr_user_agent)-1));
		$user_agent = $arr_user_agent[$idx];
		$content='';//json string
		
		
		$url='https://csddev.csd.go.th/ws/ipspiderdb/ep.php';
		$token = MTSSpiderBroker::get_param('token');
		$post = array('ip'=>$ip,'action'=>'get_ip_info','token'=>$token);
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
	
			
		return $content;//return as json
		
	}//fn
	
	private function _update_ip_info($params){
	
		$arr_user_agent=array(

		// 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246'
		// ,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3'
		// ,'Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36'
		// ,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/601.3.9 (KHTML, like Gecko) Version/9.0.2 Safari/601.3.9'
		// ,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36'
		// ,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1'
		// ,'Mozilla/5.0 (compatible; MSIE 9.0; AOL 9.7; AOLBuild 4343.19; Windows NT 6.1; WOW64; Trident/5.0; FunWebProducts)'
		// ,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
		// ,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 OPR/72.0.3815.320'

		'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0'

		);
		$idx=rand(0,(count($arr_user_agent)-1));
		$user_agent = $arr_user_agent[$idx];

		while(true){
			
			// 0: Permalink : https://www.ip2location.com/49.229.36.170
			// 1: IPAddress : 49.229.36.170
			// 2: Country : Thailand[TH]
			// 3: Region : KrungThepMahaNakhon
			// 4: City : Bangkok
			// 5: CoordinatesofCity : 13.750000,100.516670(13°45'0"N   100°31'0"E)
			// 6: ISP : AdvancedInfoServicePublicCompanyLimited
			// 7: LocalTime : 24Nov,202008:23PM(UTC+07:00)
			// 8: Domain : ais.co.th
			// 9: NetSpeed : (DSL)Broadband/Cable/Fiber/Mobile
			// 10: IDD&AreaCode : (66)02
			// 11: ZIPCode : 10200
			// 12: WeatherStation : Bangkok(THXX0002)
			// 13: MobileCarrier : AIS
			// 14: MobileCountryCode-MCC : 520
			// 15: MobileNetworkCode-MNC : 01/03
			// 16: Elevation : 10m
			// 17: UsageType : (ISP)FixedLineISP,(MOB)MobileISP
			// 18: AnonymousProxy : No
			// 19: ProxyType : -
			// 20: ASN : -
			// 21: Threat : -
			// 22: LastSeen : -
			// 23: OlsonTimeZone : Asia/Bangkok
			// 24: ip : 49.229.36.170
			// 25: title : รายละเอียดของ ip 49.229.36.170
			$result=$params['result'];
			$ip=$result['ip'];
			$isp=$result['isp'];
			$organization=$result['organization'];
			$country=$result['country'];
			$region=$result['region'];
			$city=$result['city'];
			$lat=$result['lat'];
			$lng=$result['lng'];
			
			$spider_name=$params['spider_detail']['name'];
			
			
			$url='https://csddev.csd.go.th/ws/ipspiderdb/ep.php';
			$token = MTSSpiderBroker::get_param('token');
			$post = array(
			
			'ip'=>$ip
			,'isp'=>$isp
			,'organization'=>$organization
			,'country'=>$country
			,'region'=>$region
			,'city'=>$city
			,'lat'=>$lat
			,'lng'=>$lng
			,'spider_name'=>$spider_name
	
			,'action'=>'update_ip_info','token'=>$token);
			
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

		}//while

		return json_decode($content,true);//return as array
		
	}
	
	public function fetch_from_db(){
		$ip = self::get_param('ip');
		$content=$this->_fetch_from_db($ip);
		return $content;
	}
	
	
	public function get_ip_info(){
		
		$content='';
		global $arr_webservice;//array เก็บรายการ webservice ในระบบ
		$webservice_num = count($arr_webservice);
		$errs=$resp=$errs=array();
		while(true){
			
			$ip = self::get_param('ip');
			$content=$this->_fetch_from_db($ip);
			$resp=json_decode($content,true);
			$status=$resp['status'];
			if($status == 'found' || $status == '' ){//found or error
				break;
			}
			
			//do process when not found fetch from webservice
			if($webservice_num<=0){
				
				$errs[]=('ไม่มี webservice เลยสักตัว');
				break;
				
			}
			
			if($ip==''){
				
				$errs[]=('IP can not blank (ipspiderbroker)');
				break;
				
			}
			
			$arr_webservice_key = array_keys($arr_webservice);//เอาเฉพาะคีย์มาใช้
			
			//random webservices
			mt_srand((double)microtime() * 1000000);
			$webservice_idx = mt_rand(0,($webservice_num-1));
			
			$url = $arr_webservice[ $arr_webservice_key[$webservice_idx] ]['ep'];//สุ่มได้ ep
			
			//call ip info from webservice
			$arr_user_agent=array(
			
				// 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246'
				// ,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3'
				// ,'Mozilla/5.0 (X11; CrOS x86_64 8172.45.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.64 Safari/537.36'
				// ,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/601.3.9 (KHTML, like Gecko) Version/9.0.2 Safari/601.3.9'
				// ,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36'
				// ,'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:15.0) Gecko/20100101 Firefox/15.0.1'
				// ,'Mozilla/5.0 (compatible; MSIE 9.0; AOL 9.7; AOLBuild 4343.19; Windows NT 6.1; WOW64; Trident/5.0; FunWebProducts)'
				// ,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
				// ,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 OPR/72.0.3815.320'
				
				'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:83.0) Gecko/20100101 Firefox/83.0'
				
			);
			$idx=rand(0,count($arr_user_agent)-1);
			$user_agent = $arr_user_agent[$idx];
			$token = MTSSpiderBroker::get_param('token');
			$post = array('ip'=>$ip,'action'=>'get_ip_info','token'=>$token);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 180);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			
			//https://csd.go.th/dev/ws/ipspiderbroker/ep.php
			
			
			
			$content=curl_exec($ch);//json
			curl_close($ch);
		
			//insert to database
			$params = json_decode($content,true);
			if(count($params['errs']) <= 0){
				$resp=$this->_update_ip_info($params);	
			}
				
			break;
			
		}
		
		return $resp;//return as array
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
		$resp=$oMTSSpiderBroker->get_ip_info();//ไม่ต้องอะไร เพราะไปเก็บค่าในฟังก์ชัน
		die(json_encode(  $resp ,JSON_UNESCAPED_UNICODE ));	
		
	}break;
	
	case 'fetch_from_db':{
		
		$oMTSSpiderBroker=new MTSSpiderBroker();
		$content=$oMTSSpiderBroker->fetch_from_db();
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