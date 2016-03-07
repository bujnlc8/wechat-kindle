<?php 
require_once '../tool/connectMysql.php';
$userId = $_POST['userId'];
$password =$_REQUEST['password'];
if($userId!=null){
$sql ="select t.passwd,t.user_class,t.user_id from userinfo t where  (t.user_name='".$userId."' or t.email='".$userId."') and is_valid='1' and user_class='1'";
$con = getMysqlCon();
mysqli_select_db($con,"app_haihuiwechat");
$result = mysqli_query($con, $sql);
$passMd5=null;
while ($row = mysqli_fetch_array($result)) {
    $passMd5 =$row['passwd'];
    $user_class =$row['user_class'];
    $openid=$row['user_id'];
}
if(null!=$passMd5&&$passMd5==md5($password)){
     session_start();
    $_SESSION['user'] = $userId;
    $_SESSION['openid'] = $openid;
    if( $user_class=='1'){
     $_SESSION['userLogined'] = 'admin';
    }
   echo "y";
}else{
    echo "n";
  }
}
?>