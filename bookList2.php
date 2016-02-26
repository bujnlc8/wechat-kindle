<?php
require_once 'getUserInfoWechat.php';
require_once 'tool/connectMysql.php';
error_reporting(E_ALL^E_NOTICE^E_WARNING);
if (isset($_GET['code'])){
$json = getAccesstokenForWeb($_GET['code']);
$output = getUserInfoForWeb($json);
if(isUserValid($output->openid)){
session_start();
$_SESSION['openid'] = $output->openid;
$openid=$output->openid;
$con = getMysqlCon();
$sql ="select kindle,mail,pass from userinfo where user_id='".$openid."' and is_valid='1'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $kindleMail=$row['kindle'];
	$email =$row['mail'];
	$pass =$row['pass'];
}
if(mysqli_num_rows($result)==0){
	$kindleMail="";
	$email ="";
	$pass ="";
 }
 mysqli_close($con);
 }else{
   echo "您还未注册！";
   exit();
}
}else{
	echo "授权失败";
	exit();
}
?> 
<html>
<head>
<head><title>书籍列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
    <style type="text/css">
        td{font-size:0.9em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;height:1.6em;cursor:pointer;}
        td .bookname{font-size:0.9em;white-space:normal;word-wrap:break-all;!important;}
        .row a{
           width:15%;font-size:0.8em;text-decoration:none;padding:2px; text-align:center;
        }
    </style>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css" />
<script src="res/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div width="100%">
<?php
$sql = "select bi.book_id,bi.book_name,bi.book_writer,bi.book_url from bookinfo bi  where book_class='2' ";
$sqlCount ="select count(*) from  bookinfo bi  where book_class='2' ";
$con = getMysqlCon();
mysqli_select_db($con, database);
$result = mysqli_query($con, $sql);
//$arr = mysqli_fetch_all($result);
$result2 =mysqli_query($con, $sqlCount);
$num = mysqli_fetch_row($result2)[0];
//$arrSize = count($arr);
if($num>0){
    echo "<div class='table-responsive'><table class='table table-striped table-condensed'  style=\"table-layout:fixed;width:100%;\" ><tr class='success'><th style='width:12%;'>序号</th><th style='width:66%;'>书名</th><th>作者</th><th style='display:none;'>链接</th></tr>";
}else{
    echo "<div class='table-responsive' style='width:100%;'><table class='table table-striped'><tr><td align='center'>未查询到书籍！</td></tr>";
}
$xuhao=0;
while($book=mysqli_fetch_row($result)) {
    $xuhao++;
	if($xuhao%2==0){
    echo "<tr class='success' onclick=toDetail(this)><td>$xuhao</td><td class='bookname' style=\"word-wrap:break-word;\" >$book[1]</td><td>$book[2]</td>";
	}else{
	echo "<tr class='warning' onclick=toDetail(this)><td>$xuhao</td><td class='bookname' style=\"word-wrap:break-word;\" >$book[1]</td><td>$book[2]</td>";	
	}
    echo  "<td style='font-size:0.8em;color:blue;display:none;' class='url'>$book[3]</td></tr>";
}
echo "</table></div>";
echo "<div class='row'><div class='input-field col s9'><div>总共为您找到 $num 本书籍。";?>
</div>
<script>
function toDetail(e){
	    var url = e.childNodes[3].innerText;
		console.log(url)
		var writer =e.childNodes[2].innerText;
		var bookName =e.childNodes[1].innerText;
		var reg=/链接/
		var reg2=/密码.*/
		if(reg.test(url)){
			var code = reg2.exec(url)
			var strArr = url.split(" ");
			alert(code)
			window.location.href=strArr[1];
		}else{
		    window.location.href="downloadFileForWechat.php?url="+url+"&bookName="+bookName+"&writer="+writer;
		}
	}
	</script>
</body>
</html>