<?php
    require_once '../tool/connectMysql.php';
	function getAccessToken(){
	$appid = "wx499c2c5b13385e7e";
	$appsecret = "d4624c36b6795d1d99dcf0547af5443d";
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret"; 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//查询access_token
	$con = getMysqlCon();
	$tstamp = time();
	mysqli_select_db($con, "app_haihuiwechat");
	$sql = "select UNIX_TIMESTAMP(generate_time) generate_time,access_token from accessToken ";
	$r = mysqli_query($con, $sql);
    if(mysqli_num_rows($r)==0){//如果数据库里没有数据
	        $output = curl_exec($ch);
	        curl_close($ch);
	        $jsoninfo = json_decode($output, true);
	        $access_token = $jsoninfo["access_token"];
	        $insertSql ="insert into accessToken(access_token)values('".$access_token."')";
	        mysqli_query($con, $insertSql);
	    }else{
	        while ($row = mysqli_fetch_array($r)) {
	             $generateTime = $row['generate_time'];
	             if($tstamp-$generateTime<7000){
	              $access_token =$row['access_token'];
	             }else{
	                 $deleteSql ="delete from accessToken";
	                 mysqli_query($con, $deleteSql);
	                 $output = curl_exec($ch);
	                 curl_close($ch);
	                 $jsoninfo = json_decode($output, true);
	                 $access_token = $jsoninfo["access_token"];
	                 $insertSql ="insert into accessToken(access_token)values('".$access_token."')";
	                 mysqli_query($con, $insertSql);
	        }
	    }
	  }
	mysqli_close($con);
	return  $access_token;
	}
	// 根据Openid获取单个用户信息，如nickname
	function getInfo($access_token,$openid){
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        // return $url;
		$output = https_request($url);
		$jsoninfo = json_decode($output);
		return  $jsoninfo;			
	} 
	function https_request($url)
	{       
		$curl = curl_init();       
		curl_setopt($curl, CURLOPT_URL, $url);       
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);       
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);       
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);       
		$data = curl_exec($curl);       
		if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}       
		curl_close($curl);       
		return $data;
	}
	//判断用户是否存在
	function isUserValid($userId){
	    $con = getMysqlCon();
	    $sql = "select user_id from userinfo where user_id='".$userId."' and is_valid ='1'";
	    mysqli_select_db($con, "app_haihuiwechat");
	    $result = mysqli_query($con, $sql);
	    if($result){
	        $resultNum = mysqli_num_rows($result);
	        if($resultNum>0){
				mysqli_close($con);
	            return true;
	        }
	    }
		mysqli_close($con);
	    return false;
	}
	function getAccesstokenForWeb($code){
	    $appid = "wx499c2c5b13385e7e";
	    $appsecret = "d4624c36b6795d1d99dcf0547af5443d";
	    $url ="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code"; 
	    $result = https_request($url);
	    $jsoninfo = json_decode($result);
	    return  $jsoninfo;
	}
	function  getUserInfoForWeb($json){
	   $accessToken = $json->access_token;
	   $openId =$json->openid;
	   $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$accessToken&openid=$openId&lang=zh_CN";
	   $result = https_request($url);
	   return json_decode($result);
	}
?>