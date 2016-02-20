<?php 
require_once '../tool/connectMysql.php';
$con = getMysqlCon();
$bookName = $_POST['bookName'];
$sql = "select book_id  from bookinfo where book_id='".md5(trim($bookName))."'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
if($result){
    $resultNum = mysqli_num_rows($result);
    if($resultNum==0){
		mysqli_close($con);
        echo "y";
        exit();
    }
}
mysqli_close($con);
echo "n";
?>