<?php
require_once '../tool/sendmail.php';
require_once '../tool/connectMysql.php';
session_start();
$openid=$_SESSION['openid'];
$con = getMysqlCon();
$sql ="select kindle,mail,pass from userinfo where user_id='".$openid."' and is_valid='1'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
/*if(mysqli_num_rows($result)==0){//如果未添加邮箱{
	echo "noEmail";
	exit();
}*/
while ($row = mysqli_fetch_array($result)) {
    $kindleMail=$row['kindle'];
	$email =$row['mail'];
	$pass =$row['pass'];
	if($kindleMail==null){
		echo "noEmail";
	    exit();
	}
}
$url =$_POST['url'];
//$url="http://haihuiwechat-weixinbook.stor.sinaapp.com/mobi/2656eeb0024309f61bae2641d3526c62.mobi";
$bookName =$_POST['bookName'];
//$bookName="古董局中局2:清明上河图之谜（mobi）";
$strArr = explode('.',$url);
$fileName = $bookName.".".$strArr[4];
$re = sendMail($url,$fileName,$kindleMail,$email,$pass,"kindle电子书",$fileName." 见附件。");
echo $re;

/*$contents = fread(fopen($url,"r"),20000);
$to ="75124771@qq.com";
$subject ="推送测试pdf";
$con ="新浪推送附件测试pdf!";
$email="75124771@qq.com";
$pass="75124771@qq.cn";
$mail = new SaeMail();
$mail->setAttach(array("bookData" => "$contents"));
$ret = $mail->quickSend($to,$subject,$con,$email,$pass);
if($ret === false) {
    echo "abcdef";
}else{
    echo "ghijkl";
}
var_dump($mail);
*/
