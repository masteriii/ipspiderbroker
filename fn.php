<?php
class MTSSpiderHelper{
	public static function generate_token($length)
	{
		$arr=['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
		if($length>0) 
		{
			$rand_id="";
			for($i=1; $i<=$length; $i++)
			{
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(0,35);
				$rand_id .= $arr[$num];
			}
		}
		
		return $rand_id;
		
	}//fn
}
?>