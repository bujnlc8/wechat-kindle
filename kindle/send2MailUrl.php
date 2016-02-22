<?php
require_once '../tool/connectMysql.php';
require_once '../tool/sendmail.php';
require_once '../log/log.php';
require_once 'doTheNumToSend.php';
$url =$_POST['url'];
$bookName =$_POST['bookName'];
$email =$_POST['email'];
session_start();
$openid=$_SESSION['openid'];
if(trim($email)==""||null==$email){
$num = getTheNum($openid);
if($num=="20"){
	echo "TooMany";
	exit();
}
$con = getMysqlCon();
$sql ="select email,user_name from userinfo where user_id='".$openid."' and is_valid='1'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $to=$row['email'];
	$userName=$row['user_name'];
 }
}else{
	$to=$email;
	$userName="用户";
}
$strArr = explode('.',$url);
$fileName = $bookName.".".$strArr[4];
$subject ="$bookName 电子书推送";
if(remote_filesize($url)<8380000){
$con ="亲爱的 $userName,<br>&nbsp;&nbsp;&nbsp;&nbsp;您要的电子书 <b>$bookName </b>见附件。<br>&nbsp;&nbsp;&nbsp;&nbsp;祝您生活愉快！";
}else{
$con ="亲爱的 $userName,<br>&nbsp;&nbsp;&nbsp;&nbsp;您要的电子书 <b>$bookName </b>的链接为: <i>$url</i>。<br>&nbsp;&nbsp;&nbsp;&nbsp;祝您生活愉快！";
}
$email="haihuiling2016@qq.com";
$pass="301415926o198915";
$re = sendMail($url,$fileName,$to,$email,$pass,$subject,$con);
if($re=="y"){
	insertBookLog($openid,$fileName,$userName."于". date("Y-m-d H:i:s", time())."成功发送《".$bookName."》到".$to);
	if($userName!="用户"){
		updateTheNum($openid);
	}
}
echo $re;