<?php
require_once '../tool/connectMysql.php';
$bookName = $_POST['bookName'];
$bookNameMd5 = Md5($bookName);
$writer = $_POST['writer'];
$bookClass = trim($_POST['bookClass']);
$bookDesc = $_POST['bookDesc'];
$bookUrl=$_POST['bookUrl'];
$con = getMysqlCon();
$sql = "insert into bookinfo values('" . $bookNameMd5 . "','" .addslashes($bookName) . "','" . addslashes($writer) . "','" .addslashes($bookDesc). "','" . $bookClass . "','" . $bookUrl . "')";
mysqli_select_db($con, "app_haihuiwechat");
mysqli_set_charset($con, "utf-8");
if (! ($result = mysqli_query($con, $sql))) {
            header("location:../error.php");
}else {
            header("location:houtaiBig.php");
}
mysqli_close($con);
?>