<?php
function getJsapiTicket(){
	$access_token=file_get_contents("access_token.txt");
	$arr=explode("@",$access_token);
	$ch = curl_init(); //初始化一个CURL对象
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$arr[0]."&type=jsapi");//设置你所需要抓取的URL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置curl参数，要求结果是否输出到屏幕上，为true的时候是不返回到网页中,假设上面的0换成1的话，那么接下来的$data就需要echo一下。
	$data = json_decode(curl_exec($ch));
	$ticket_file = fopen("jsapi_ticket.txt","w") or die("Unable to open file!");//打开jsapi_ticket.txt文件，没有会新建
	fwrite($ticket_file,$data->ticket);
	fclose($ticket_file);//关闭文件流
	curl_close($ch);
}


$str=@file_get_contents("flag.txt");
if($str=="1"){
	getJsapiTicket();
	file_put_contents("flag.txt",'0');
}