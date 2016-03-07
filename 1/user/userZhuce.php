<?php
$id= $_GET['id'];
session_start();
$_SESSION['openid'] =$id;
$_SESSION['nickname'] =$_GET['nickname'];
$_SESSION['sex'] =$_GET['sex'];
$_SESSION['province'] =$_GET['province'];
$_SESSION['city'] =$_GET['city'];
header("location:../yaoqingma/yaoqingma.php");