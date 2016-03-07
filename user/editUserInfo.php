<?php 
require_once '../tool/connectMysql.php';
$openid = $_POST['openid'];
$province = $_POST['province'];
$email = $_POST['email'];
$city = $_POST['city'];
$con = getMysqlCon();
$sql ="update userinfo set email='".$email."',city='".$city."',province='".$province."' where user_id='".$openid."'";
mysqli_select_db($con, "app_haihuiwechat");
$result=mysqli_query($con, $sql);
if($result){
    echo "y";
}else{
    echo "n";
}
mysqli_close($con);
?>