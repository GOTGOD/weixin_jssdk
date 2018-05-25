<?php
//获取access_token 和 jsapiticket
include "getAccessToken.php";
include "getJsapiTicket.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>便捷</title>
    <meta charset="utf-8" />
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&key=XAGBZ-22P3O-DS2WX-SCPDA-7VLK3-CLBWQ"></script>
</head>
<body>
<span>经度：</span><p id="jingdu"></p>
<span>纬度：</span><p id="weidu"></p>
<button id="btn">位置解析</button>
  	<script>
    $(function(){
		$.ajax({
			url:"peizhi.php",
			type:"GET",
			dataType:"json",
			success: function(data){
				var appId = "wx1fb297113e5d1be9";  
				var noncestr = data.nonceStr;    
				var timestamp = data.timeStamp;  
				var signature = data.signature; 
				alert(signature+"\n"+noncestr+"\n"+timestamp); 
				wx.config({  
					debug: true, //开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
					appId: appId, //必填，公众号的唯一标识  
					timestamp: timestamp, // 必填，生成签名的时间戳  
					nonceStr: noncestr, //必填，生成签名的随机串  
					signature: signature,// 必填，签名，见附录1  
					jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ',  
								'onMenuShareWeibo','onMenuShareQZone','chooseImage',  
								'uploadImage','downloadImage','startRecord','stopRecord',  
								'onVoiceRecordEnd','playVoice','pauseVoice','stopVoice',  
								'translateVoice','openLocation','getLocation','hideOptionMenu',  
								'showOptionMenu','closeWindow','hideMenuItems','showMenuItems',  
								'showAllNonBaseMenuItem','hideAllNonBaseMenuItem'] //必填，需要使用的JS接口列表，所有JS接口列表 见附录2  
				});  
			    
			}	
		
		})
		
		wx.ready(function(){
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
					wx.checkJsApi({
						jsApiList: [
							'getLocation'
						],
						success: function (res) {
							// alert(JSON.stringify(res));
							// alert(JSON.stringify(res.checkResult.getLocation));
							if (res.checkResult.getLocation == false) {
								alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
								return;
							}
						}
					});
					
					
					wx.getLocation({
						type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
						success: function (res) {
						var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
						var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
						var speed = res.speed; // 速度，以米/每秒计
						var accuracy = res.accuracy; // 位置精度
						
						$("#jingdu").html(longitude);
						$("#weidu").html(latitude);
									
						global1=latitude;																								    					global2=longitude;
						}
					});										
                });	
				
				//按钮触发逆解析。
				$("#btn").click(function(){
					var url="http://apis.map.qq.com/ws/geocoder/v1"; 
					var latitude=global1;
					var longitude=global2;
					var location=encodeURI(latitude+","+longitude);
					alert(location);

					$.ajax({
							url: url,
							type:"GET",
							data:{
								key:"XAGBZ-22P3O-DS2WX-SCPDA-7VLK3-CLBWQ",//开发密钥
								location: location,//位置坐标
								get_poi:"0",//是否返回周边POI列表：1.返回；0不返回(默认)
								output:"jsonp" //mmp,干掉老子一整天时间才发现:返回的数据是jsonp时，要加这个
							},
							dataType:"jsonp",							
							success: function(data){
								alert(data.result.formatted_addresses.recommend);
							}
					})	
				})	
	})
    </script>
</body>
</html>