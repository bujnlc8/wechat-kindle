<?php 
require_once '../tool/connectMysql.php';
$con = getMysqlCon();
$userId = $_POST['userId'];
$userName = $_POST['userName'];
$password = md5($_POST['passwd']);
$sex = $_POST['sex'];
$province =$_POST['province'];
$city =$_POST['city'];
$email =$_POST['email'];
$time =date('y-m-d h:i:s',time());
$nickname =$_POST['nickname'];
$sql = "insert into userinfo(user_id,user_name,sex,province,city,passwd,email,createDate,user_class,is_valid,nickname)values('".$userId."','".$userName."','".
$sex."','".$province."','".$city."','".$password."','".$email."','".$time
."','0','1','".$nickname."')";
mysqli_select_db($con, "app_haihuiwechat");
$result= mysqli_query($con, $sql);
if($result){
    session_start();
    $yaoqingCode = $_SESSION['yaoqingCode'];
    echo "<b style='font-size:1.3em;'>恭喜您，注册成功啦！返回微信回复书名或作者名获取电子书~</b>";
    if ($yaoqingCode != null && $yaoqingCode != "") {
        $yaoqingSql = "update yaoqingCode set restnum = restnum-1 where code='" . $yaoqingCode . "'";
        mysqli_query($con, $yaoqingSql);
        $yaoqingNumSql ="select restnum from yaoqingCode where  code='" . $yaoqingCode . "'";
        $result =mysqli_query($con, $yaoqingNumSql);
        if($result){
            while ($row = mysqli_fetch_array($result)) {
               $num =$row['restnum'];
               if($num==0){
                   $yaoqingSql = "update yaoqingCode set isvalid='0' where code='" . $yaoqingCode . "'";
                   mysqli_query($con, $yaoqingSql);
               }
            }
        }
    }
    mysqli_close($con);
}else{
    echo "sorry，注册失败！";
}
    
?>