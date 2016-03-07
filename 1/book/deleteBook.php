<?php 
require_once '../tool/connectMysql.php';
use sinacloud\sae\Storage as Storage;
$url = $_POST['url'];
$id = $_POST['id'];
$con = getMysqlCon();
$sql ="delete from bookinfo where book_id='".$id."'";
mysqli_select_db($con, "app_haihuiwechat");
$result=mysqli_query($con, $sql);
if($result){
    echo "y";
}else{
    echo "n";
}
mysqli_close($con);
$file =substr($url,48);
$s = new Storage();
$s->deleteObject("weixinbook", $file);
?>