<?php 
require_once '../tool/connectMysql.php';
$con = getMysqlCon();
$id = $_POST['id'];
$stat =$_POST['stat'];
if($stat=='0'){
$sql ="delete from userinfo where user_id='".$id."'";
}
if($stat=="1"){
$sql  ="update userinfo set user_class='1' where user_id='".$id."'";
}
if($stat=="2"){
    $sql ="update userinfo set is_valid='0' where user_id='".$id."'";
}
if($stat=="3"){
    $sql ="update userinfo set is_valid='1' where user_id='".$id."'";
}
if($stat=="4"){
    $sql ="update userinfo set user_class='0' where user_id='".$id."'";
}
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
if($result){
    $resultNum = mysqli_affected_rows($con);
    if($resultNum>0){  
        echo "y";
        exit();
    }
}
echo "n";
?>