<?php 
require_once '../tool/connectMysql.php';
$openid = $_POST['openid'];
$kindle = $_POST['kindle'];
$mail = $_POST['email'];
$pass = $_POST['pass'];
$con = getMysqlCon();
$sql ="update userinfo set kindle='".$kindle."',mail='".$mail."',pass='".$pass."' where user_id='".$openid."'";
mysqli_select_db($con, "app_haihuiwechat");
$result=mysqli_query($con, $sql);
if($result){
    echo "y";
}else{
    echo "n";
}
mysqli_close($con);
?>