<?php
require_once '../tool/connectMysql.php';
$con = getMysqlCon();
$sql ="select code,restNum from yaoqingCode";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $code =$row['code'];
    $restNum =$row['restNum'];
    $arr =array("code"=>$code,"restNum"=>$restNum);
    echo json_encode($arr);
}
