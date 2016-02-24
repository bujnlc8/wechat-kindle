<?php 
require_once '../tool/connectMysql.php';
require_once '../tool/sendmail.php';
require_once '../kindle/doTheNumToSend.php';
resetTheNum();
$con = sendMailToMe();
$con2 =sendMailToMe2();
sendmailOfSend("75124771@qq.com","haihuiling2016@qq.com","301415926o198915",date('y-m-d',time())."电子书推送汇总",$con);
sendmailOfSend("75124771@qq.com","haihuiling2016@qq.com","301415926o198915",date('y-m-d',time())."未查询到电子书汇总",$con2);
?>