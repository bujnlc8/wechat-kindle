<?php 
require_once '../tool/connectMysql.php';
$yaoqingCode = $_POST['yaoqingCode'];
$num = $_POST['num'];
$con = getMysqlCon();
$sql ="insert into yaoqingCode(code,isvalid,restNum)values('".$yaoqingCode."','1',".$num.")";
mysqli_select_db($con, "app_haihuiwechat");
$result=mysqli_query($con, $sql);
if($result){
    echo "y";
}else{
    echo "n";
}
mysqli_close($con);
?>