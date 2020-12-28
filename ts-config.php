<?php
date_default_timezone_set("Asia/Bangkok");
define('PRODUCTION_APP','PRODUCTION_APP');//PRODUCTION_APP ,LOCAL_APP
if( defined('PRODUCTION_APP') ){//ถ้ามีการนิยาม

	define('TS_SITEURL','https://csd.go.th/dev/csdocto/mods/jbasset');
	define('TS_BSURL','https://csd.go.th/dev/csdocto/adminlte');

}else{

	define('TS_SITEURL','http://localhost/dev/dopaws');

}


if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) );


define('TS_UPLOAD_PATH',ABSPATH. '/uploads' );


if ( !defined('DS') )
	define('DS', DIRECTORY_SEPARATOR );

define('DOCUMENT_ROOT' ,dirname(__FILE__) . DIRECTORY_SEPARATOR);


$mts_lookup=array();

$mts_config = array(

	'lookup'=>$mts_lookup
	
	,'options'=>array(
		'sitedescription'=>'JB Asset System(JBA)'
		,'siteemail'=>'masteriii_2@hotmail.com'
		,'sitekeyword'=>'JBA ยืม คืน พัสดุ'
		,'sitename'=>'JB Asset System'
		,'sitetel'=>'0876675547'
		,'sitetitle'=>'JB Asset System - ระบบยืมพัสดุ'
		,'siteurl'=>TS_SITEURL
		,'author'=>'Masteriii'
		,'address'=>'©2020 Royal Thai Police กองบังคับการปราบปราม ( Crime Suppression Division) ถนนพหลโยธิน แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร 10900'
		,'reloaddata'=>false
	)
	
);
?>