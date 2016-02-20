<?php 
require_once '../tool/connectMysql.php';
$con = getMysqlCon();
$userName = $_POST['userName'];
$sql = "select user_name from userinfo where user_name='".$userName."'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
if($result){
    $resultNum = mysqli_num_rows($result);
    if($resultNum>0){
        $output = array("isExist"=>"y");
        echo json_encode($output);
        exit();
    }
}
$output = array("isExist"=>"n");
echo json_encode($output);
exit();
?>