<?php 
define("database", "app_haihuiwechat");
require_once '../tool/connectMysql.php';
require_once '../tool/is_mobile.php';
require_once '../tool/valid.php';
$userId = $_POST['userId'];
$yema =$_REQUEST['yema'];
?>
<html>
<head>
<head><title>日志列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
    <style type="text/css">
        td{font-size:0.9em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
        .row a{
           width:15%;font-size:0.8em;text-decoration:none;padding:2px; text-align:center;
        }
    </style>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
 <link rel="stylesheet" href="../res/materialize/css/materialize.min.css" />
  <script src="../res/materialize/js/materialize.min.js"></script>
</head>
<body>
<div width="100%">
 <?php 
 if(is_mobile()){
      echo  "<nav><ul id=\"slide-out\" class=\"side-nav\">";
	  echo "<li><a href=\"#\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:50px;height:50px;\"></a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtai.php\">电子书上传</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtaiBig.php\">电子书上传(大)</a></li> ";
      echo "<li><a href=\"../book/bookList.php?yema=1\">书籍列表</a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../user/userManage.php?yema=1\">人员管理</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../yaoqingma/yaoqingmaAdd.php\">邀请码</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"logList.php?yema=1\">日志管理</a></li> ";
      echo "<li><a href=\"./login/logout.php\">注销</a></li>";
	  echo "</ul>";  
      echo "<a href=\"#\" data-activates=\"slide-out\" class=\"button-collapse\"><i class=\"mdi-navigation-menu\"></i></a></nav>";
 }else{
	    echo "<nav><div class=\"nav-wrapper\"><a  href=\"../login/logout.php\" style=\"float:right;margin-right:6%;color:purple;\">注销</a><a href=\"#\" class=\"brand-logo right\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:55px;height:55px;\"></a><ul id=\"nav-mobile\" class=\"left hide-on-med-and-down\">";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtai.php\">电子书上传</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtaiBig.php\">电子书上传(大)</a></li> ";
        echo "<li><a href=\"../book/bookList.php?yema=1\">书籍列表</a></li>";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../user/userManage.php?yema=1\">人员管理</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../yaoqingma/yaoqingmaAdd.php\">邀请码</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"logList.php?yema=1\">日志管理</a></li> ";
     echo "</ul></div></nav>";
 }
?> 
<form id="logList" method="Post">
        <div class="row">
	     <div class="input-field col s6">
            <label for="logName">userName</label><input name="userId"  class="validate" id="userId" type="text" value="<?php echo $userId;?>"/>
          </div>
            <div class="input-field col s2">  
             <a  style="width:100%;" class="waves-effect waves-light btn" id="query" title="点击查询">Q</a></div>
             <div class="input-field col s2">  
		    <a style="width:100%;" class="waves-effect waves-light btn" id="reset" title="点击重置查询条件">R</a></div>
    </div>
<?php
$sql = "SELECT ul.id,ul.user_id,ui.user_name,ul.req_word,ul.req_time,ul.response FROM userlog  ul left join userinfo ui on ul.user_id = ui.user_id  where 1=1 ";
$sqlCount ="SELECT count(*) FROM userlog  ul left join userinfo ui on ul.user_id = ui.user_id  where 1=1 ";
$con = getMysqlCon();
mysqli_select_db($con, database);
if ($userId != "") {
    $sql .= "  and ui.user_name like '%" . addslashes($userId) . "%'";
    $sqlCount .= "  and ui.user_name like '%" . addslashes($userId) . "%'";
}
$sql.=" and  ui.user_name is not null ";
$sqlCount.=" and  ui.user_name is not null ";
$start =((intval($yema,10))-1) * 15;
$sql.=" limit ".$start.",15";
$result = mysqli_query($con, $sql);
//$arr = mysqli_fetch_all($result);
$result2 =mysqli_query($con, $sqlCount);
$num = mysqli_fetch_row($result2)[0];
//$arrSize = count($arr);
if($num>0){
    echo "<div class='table-responsive'><table class='bordered highlight' style='table-layout:fixed;width:100%;'><tr><th style='width:8%'>序号</th><th style='width:16%'>userName</th><th style='width:15%'>reqWord</th>";
    if(!is_mobile()){
        echo "<th style='width:15%'>reqTime</th><th>回复</th></tr>";  
    }else{
        echo "<th style='width:28%'>reqTime</th></tr>"; 
    }   
    
}else{
    echo "<div class='table-responsive' style='width:100%;'><table class='bordered highlight'><tr><td align='center'>未查询到日志记录！</td></tr>";
}
while($log = mysqli_fetch_row($result)) {
    $xuhao++;
    echo "<tr class='success'><td>$xuhao</td><td>$log[2]</td><td>$log[3]</td><td>$log[4]</td>";
    if(!is_mobile()){
        echo " <td title='$log[5]'>$log[5]</td></tr>";
    }else{
        echo "</tr>"; 
    }
    
}
echo "</table></div>";
if (is_int($num / 15)){ $yeshu= $num/15;}else{$yeshu=floor($num/15+1);}
echo "<div class='row'><div class='input-field col s9'><div>总共 $num 条   $yeshu 页  当前第 $yema 页</div> <a   class=\"waves-effect waves-light btn\" id=\"first\">首页</a>&nbsp;&nbsp;<a   class=\"waves-effect waves-light btn\" id=\"next\">下一页</a>&nbsp;&nbsp;<a  class=\"waves-effect waves-light btn\" id=\"up\">上一页</a>&nbsp;&nbsp;<a  class=\"waves-effect waves-light btn\" id=\"last\">最后一页</a></div></div>";?>
        <input type="hidden" value="<?php echo $yema;?>" name="yema" id="yema" />
		<input type="hidden" value="<?php echo $yeshu ;?>" name="zongyeshu" id="zongyeshu" />
	</form>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function() {
    $(".button-collapse").sideNav();
	$('.collapsible').collapsible();
 });
$("#reset").click(function(){
 $("#userId").val("");
});
$("#query").click(function(){
	$("#yema").val("1");
	$("#logList").attr("action","logList.php").submit();
});
$("#first").click(function(){
    if(1==$("#yema").val()){
		alert("已是首页!");
    }else{
	$("#yema").val("1");
	$("#logList").attr("action","logList.php").submit();
    }
});
$("#next").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
    console.log($zongyeshu);
    if($zongyeshu=="0"){
        return;
    }
	if($zongyeshu==$("#yema").val()){
		alert("已到最后一页!");
	}else{
	   $("#yema").val(parseInt($("#yema").val())+1+"");
	   $("#logList").attr("action","logList.php").submit();
	}
});
$("#up").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
	if(1==$("#yema").val()){
		alert("已到首页!");
	}else{
	   $("#yema").val(parseInt($("#yema").val())-1+"");
	   $("#logList").attr("action","logList.php").submit();
	}
});
$("#last").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
    if($zongyeshu=="0"){
        return;
    }
	if($zongyeshu==$("#yema").val()){
		alert("已到最后一页!");
	}else{
	   $("#yema").val($zongyeshu);
	   $("#logList").attr("action","logList.php").submit();
	}
});
var flag = true;
function checkAll(){
	console.log(flag);
	if(flag){
	$(".logids").prop("checked",true);
	flag =false;
	}else if(!flag){
		$(".logids").prop("checked",false);
		flag =true;
     }
}
function deletelogs(){
	console.log($(".logids:checked").length);
}
</script>
</html>