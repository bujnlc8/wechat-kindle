<?php
define("database", "app_haihuiwechat");
require_once 'tool/connectMysql.php';
$bookName = $_GET['bookName'];
$openid = $_GET['openid'];
session_start();
$_SESSION['openid']=$openid;
?>
<html>
<head>
<head><title>书籍列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
    <style type="text/css">
        td{font-size:0.9em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
        .bookname{font-size:0.9em;white-space:pre-line;overflow:visible !important;}
        .row a{
           width:15%;font-size:0.8em;text-decoration:none;padding:2px; text-align:center;
        }
    </style>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
 <link rel="stylesheet" href="res/materialize/css/materialize.min.css" />
  <script src="res/materialize/js/materialize.min.js"></script>
</head>
<body>
<div width="100%">
<?php
$sql = "select bi.book_id,bi.book_name,bi.book_writer,bi.book_url from bookinfo bi  where 1=1 ";
$sqlCount ="select count(*) from  bookinfo bi  where 1=1 ";
$con = getMysqlCon();
mysqli_select_db($con, database);
if ($bookName != "") {
    $sql .= "  and (bi.book_name like '%" . addslashes($bookName) . "%' or bi.book_writer like '%".addslashes($bookName) . "%') ";
    $sqlCount .= " and bi.book_name like '%" . addslashes($bookName) . "%' or bi.book_writer like '%".addslashes($bookName) . "%'";
}
$result = mysqli_query($con, $sql);
//$arr = mysqli_fetch_all($result);
$result2 =mysqli_query($con, $sqlCount);
$num = mysqli_fetch_row($result2)[0];
//$arrSize = count($arr);
if($num>0){
    // echo "<div><input type='button' value='删除'  onclick='deleteBooks();'/>";
    echo "<div class='table-responsive'><table class='bordered highlight' style='table-layout:fixed;width:100%;'><tr><th style='width:10%'>序号</th><th width=20%>书名</th><th width=15%>作者</th><th>链接</th><tr>";
}else{
    echo "<div class='table-responsive' style='width:100%;'><table class='bordered highlight'><tr><td align='center'>未查询到书籍！</td></tr>";
}
$xuhao=0;
while($book=mysqli_fetch_row($result)) {
    $xuhao++;
    echo "<tr class='success'><td>$xuhao</td><td class='bookname'>$book[1]</td><td>$book[2]</td>";
    if(!strstr($book[3],'链接')){
       // echo  "<td style='font-size:0.7em;color:blue;'><a href='$book[3]'>$book[3]</a></td></tr>";
		 echo  "<td style='font-size:0.7em;color:blue;' class='url'><a href='downloadFileForWechat.php?url=$book[3]&bookName=$book[1]' target='_blank'>$book[3]</a></td></tr>";
    }else{
        $strArr =explode(" ",$book[3]);
        $u =$strArr[1];
        echo  "<td style='font-size:0.7em;color:blue;'><a href='$u'>";echo mb_substr($strArr[1],7,18)."...密码:$strArr[3]</a></td></tr>";
    }
}
echo "</table></div>";
echo "<div class='row'><div class='input-field col s9'><div>总共为您找到 $num 本书籍。";?>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function() {
    $(".button-collapse").sideNav();
	$('.collapsible').collapsible();
	$('select').material_select();
 });
</script>
</html>