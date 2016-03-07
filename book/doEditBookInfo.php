<?php
require_once '../tool/connectMysql.php';
$bookId =$_POST["bookId"];
$bookName = $_POST['bookName'];
$writer = $_POST['writer'];
$bookClass = trim($_POST['bookClass']);
$bookDesc = $_POST['bookDesc'];
$bookUrl =$_POST['bookUrl'];
$con = getMysqlCon();
$sql = "update bookinfo set book_name='" .addslashes($bookName) . "',book_writer='" . addslashes($writer) . "',book_desc='" .addslashes($bookDesc). "',book_class='" . $bookClass . "',book_url='".$bookUrl."' where book_id='".$bookId."'";
mysqli_select_db($con, "app_haihuiwechat");
mysqli_set_charset($con, "utf-8");
if (! ($result = mysqli_query($con, $sql))) {
            echo "n";
        }else {
           echo "y";
        }
mysqli_close($con);
?>