<?php 
        error_reporting(E_ALL ^ E_NOTICE);
		session_start();
		$rand =rand(1, 9999999)."".time();
		$_SESSION['r6'] = md5($rand);
		$_SESSION['r1'] = $rand;
		$_SESSION['yaoqingCode'] = $_GET['yaoqingCode'];
		header("location:../user/zhuce.php");
?>