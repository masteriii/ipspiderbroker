<?php
error_reporting(E_ALL ^ E_WARNING);

$cur_dir = dirname(__FILE__);
require_once $cur_dir.'/ts-config.php';
require_once $cur_dir.'/fn.php';

//โค้ดเกมือนกันทุกอัน แต่วางต่างที่
$arr_webservice = array(
'ipspiderws'=>array('ep'=>'https://ipspiderws.herokuapp.com/ep.php')
// ,'ipspiderws2'=>array('ep'=>'https://ipspiderws2.herokuapp.com/ep.php')
// ,'ipspiderws3'=>array('ep'=>'https://ipspiderws3.herokuapp.com/ep.php')
// ,'ipspiderws4'=>array('ep'=>'https://ipspiderws4.herokuapp.com/ep.php')
// ,'ipspiderws5'=>array('ep'=>'https://ipspiderws5.herokuapp.com/ep.php')
// ,'ipspiderws6'=>array('ep'=>'https://ipspiderws6.herokuapp.com/ep.php')
);
?>