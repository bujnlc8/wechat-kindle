<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$r = $_SESSION['r'];
$r5 = $_SESSION['r5'];
#echo $r;
if($r==""||$r5!=md5($r)){
    echo "您还未登陆！";
    exit();
}else{
   // session_destroy();
}
?>