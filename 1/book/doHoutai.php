<?php
require_once '../tool/connectMysql.php';
$bookName = $_POST['bookName'];
$writer = $_POST['writer'];
$bookClass = trim($_POST['bookClass']);
$bookDesc = $_POST['bookDesc'];
//echo $_FILES["book"]["name"];
if ($_FILES["book"]["error"] > 0) {
    echo "出错代码: " . $_FILES["book"]["error"] . "<br />";
}else{
    $s = new SaeStorage();
    $booName_ = $_FILES["book"]["name"];
    $fileType = substr($booName_, strripos($booName_, ".") + 1);
    $bookNameMd5 = md5($bookName);
    if ($fileType == "mobi") {
        $upResult =$s->upload("weixinbook","mobi/" . $bookNameMd5 . "." . $fileType, $_FILES['book']['tmp_name']);
                     $bookUrl =$s->getUrl("weixinbook", "mobi/" . $bookNameMd5 . "." . $fileType);
    }else if ($fileType == "azw3") {
          $upResult =$s->upload("weixinbook","azw3/" . $bookNameMd5 . "." . $fileType, $_FILES['book']['tmp_name']);
                     $bookUrl =$s->getUrl("weixinbook", "azw3/" . $bookNameMd5 . "." . $fileType);
        } else if ($fileType == "epub") {
               $upResult =$s->upload("weixinbook","epub/" . $bookNameMd5 . "." . $fileType, $_FILES['book']['tmp_name']);
                     $bookUrl =$s->getUrl("weixinbook", "epub/" . $bookNameMd5 . "." . $fileType);
            } else if ($fileType == "txt") {
                     $upResult =$s->upload("weixinbook","txt/" . $bookNameMd5 . "." . $fileType, $_FILES['book']['tmp_name']);
                     $bookUrl =$s->getUrl("weixinbook", "txt/" . $bookNameMd5 . "." . $fileType);
                } else if ($fileType == "pdf") {
                    $upResult =$s->upload("weixinbook","pdf/" . $bookNameMd5 . "." . $fileType, $_FILES['book']['tmp_name']);
                     $bookUrl =$s->getUrl("weixinbook", "pdf/" . $bookNameMd5 . "." . $fileType);
                }else {
                  $upResult =$s->upload("weixinbook","other/" . $bookNameMd5 . "." . $fileType, $_FILES['book']['tmp_name']);
                     $bookUrl =$s->getUrl("weixinbook", "other/" . $bookNameMd5 . "." . $fileType);
                }
    if ($upResult) {
        $con = getMysqlCon();
        $sql = "insert into bookinfo values('" . $bookNameMd5 . "','" .addslashes($bookName) . "','" . addslashes($writer) . "','" .addslashes($bookDesc). "','" . $bookClass . "','" . $bookUrl . "')";
        mysqli_select_db($con, "app_haihuiwechat");
         mysqli_set_charset($con, "utf-8");
        if (! ($result = mysqli_query($con, $sql))) {
            header("location:../error.php");
        }else {
            header("location:houtai.php");
        }
        mysqli_close($con);
    }else{
        header("location:../error.php");
    }
}
?>