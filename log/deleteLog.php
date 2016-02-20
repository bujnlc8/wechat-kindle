<?php
require_once '../tool/connectMysql.php';
$id =$_POST["id"];
if($id==""){
	echo "n";
	exit();
}
$con = getMysqlCon();
$sql = "delete from userlog where id = ".$id;
mysqli_select_db($con, "app_haihuiwechat");
mysqli_set_charset($con, "utf-8");
mysqli_query($con,$sql);
if (mysqli_affected_rows($con)==0) {
           echo "n";
}else {
   echo "y";
}
mysqli_close($con);
?>