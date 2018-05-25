<?php
function getAccessToken(){
	$ch = curl_init(); //初始化一个CURL对象
    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx1fb297113e5d1be9&secret=b9a3e3ecf811f0f27e31172af61fbe08");//设置你所需要抓取的URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置curl参数，要求结果是否输出到屏幕上，为true的时候是不返回到网页中,假设上面的0换成1的话，那么接下来的$data就需要echo一下。
    $data = json_decode(curl_exec($ch));
	$token_file = fopen("access_token.txt","w");
	fwrite($token_file,$data->access_token.'@'.time());
	fclose($token_file);
	curl_close($ch);
	@file_put_contents("flag.txt",'1');
}


$str=@file_get_contents("access_token.txt");
if($str==''){
	getAccessToken();	
}else{
	$arr=explode("@",$str);
	if(time()>$arr[1]+7000){
		getAccessToken();
	}	
}

