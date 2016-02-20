<?php 
require_once '../tool/connectMysql.php';
$con = getMysqlCon();
$yaoqingCode = $_POST['yaoqingCode'];
$sql = "select code from yaoqingCode  where  isvalid ='1' and code ='".$yaoqingCode."'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
$resultNum = mysqli_num_rows($result);
if($resultNum > 0){
        echo "y";
  }else{
    echo "n";
}
mysqli_close($con);
?>