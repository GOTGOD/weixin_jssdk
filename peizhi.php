<?php
//nonceStr生成
function createNonceStr($length=16){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	for($i=0;$i<$length;$i++){
		$str = $str.substr($chars,mt_rand(0,strlen($chars)-1),1);	
	}
	return $str;		
}

//Signature等生成
function getCarr(){	
	$jsapiTicket = file_get_contents("jsapi_ticket.txt");
	$timeStamp = time();
	$nonceStr = createNonceStr();
	$url="http://www.flybaba.cn/leaf/index.php";	
	
	$string="jsapi_ticket=".$jsapiTicket."&noncestr=".$nonceStr."&timestamp=".$timeStamp."&url=".$url;
	$signature=sha1($string);
	$Carr=array("timeStamp"=>$timeStamp,"nonceStr"=>$nonceStr,"signature"=>$signature);
	return $Carr;
}

echo json_encode(getCarr());
