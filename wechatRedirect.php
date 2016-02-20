<?php
require_once 'getUserInfoWechat.php';
require_once 'tool/connectMysql.php';
if (isset($_GET['code'])){
  $json = getAccesstokenForWeb($_GET['code']);
  $output = getUserInfoForWeb($json);
    if(isUserValid($output->openid)){
     session_start();
     $_SESSION['openid'] = $output->openid;
     header("location:book/houtaiSuccess.php");
    }else{
        $openid= $output->openid;
        $nickname=$output->nickname;
        $sex =$output->sex;
        $province =$output->province;
        $city =$output->city;
        echo "<!DOCTYPE html><html lang=\"en\"><head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width,initial-scale=1,user-scalable=0\">
        <title>请您注册</title>
        <link rel=\"stylesheet\" href=\"res\wechat\weui.min.css\"/></head><body>";
        echo "sorry,您还未注册，请点击<a class='weui_btn weui_btn_mini weui_btn_default' href=\"http://haihuiwechat.applinzi.com/user/userZhuce.php?id=".$openid."&nickname=".$nickname."&sex=".$sex."&province=".$province."&city=".$city."\">此处</a>注册。";
        echo "</body></html>";
    }
}else{
    echo "授权失败！";
}
?>
