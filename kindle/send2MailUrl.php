<?php
require_once '../tool/connectMysql.php';
require_once '../tool/sendmail.php';
$url =$_POST['url'];
$bookName =$_POST['bookName'];
$email =$_POST['email'];
if(trim($email)==""){
$con = getMysqlCon();
session_start();
$openid=$_SESSION['openid'];
$sql ="select email from userinfo where user_id='".$openid."' and is_valid='1'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $to=$row['email'];
 }
}else{
	$to=$email;
}
$strArr = explode('.',$url);
$fileName = $bookName.".".$strArr[4];
$subject ="$bookName 电子书推送";
$con ="尊敬的用户，<br>&nbsp;&nbsp;&nbsp;&nbsp;您要的电子书 $bookName 的链接为: <i>$url</i>。<br>&nbsp;&nbsp;&nbsp;&nbsp;祝您生活愉快！";
$email="75124771@qq.com";
$pass="75124771@qq.cn";
$re = sendMail($url,$fileName,$to,$email,$pass,$subject,$con);
echo $re;