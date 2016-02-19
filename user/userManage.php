<?php 
define("database", "app_haihuiwechat");
require_once '../tool/valid.php';
require_once '../tool/connectMysql.php';
require_once '../tool/is_mobile.php';
$userName = $_POST['userName'];
$yema = $_REQUEST['yema'];
?>
<html>
<head>
<head><title>人员管理</title>
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
  <div width="100%" height="100%">
<?php 
 if(is_mobile()){
      echo  "<nav><ul id=\"slide-out\" class=\"side-nav\">";
	  echo "<li><a href=\"#\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:50px;height:50px;\"></a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtai.php\">电子书上传</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtaiBig.php\">电子书上传(大)</a></li> ";
      echo "<li><a href=\"../book/bookList.php?yema=1\">书籍列表</a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"userManage.php?yema=1\">人员管理</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../yaoqingma/yaoqingmaAdd.php\">邀请码</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../log/logList.php?yema=1\">日志管理</a></li> ";
      echo "<li><a href=\"../login/logout.php\">注销</a></li>";
	  echo "</ul>";  
      echo "<a href=\"#\" data-activates=\"slide-out\" class=\"button-collapse\"><i class=\"mdi-navigation-menu\"></i></a></nav>";
 }else{
	    echo "<nav><div class=\"nav-wrapper\"><a  href=\"../login/logout.php\" style=\"float:right;margin-right:6%;color:purple;\">注销</a><a href=\"#\" class=\"brand-logo right\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:55px;height:55px;\"></a><ul id=\"nav-mobile\" class=\"left hide-on-med-and-down\">";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtai.php\">电子书上传</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtaiBig.php\">电子书上传(大)</a></li> ";
        echo "<li><a href=\"../book/bookList.php?yema=1\">书籍列表</a></li>";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"userManage.php?yema=1\">人员管理</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../yaoqingma/yaoqingmaAdd.php\">邀请码</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../log/logList.php?yema=1\">日志管理</a></li> ";
        echo "</ul></div></nav>";
 }
?> 
<form id="userList" method="Post">
         <div class="row">
	     <div class="input-field col s6">
              <label>userName</label><input name="userName"  class="validate" id="userName" type="text" value="<?php echo $userName;?>"/>
          </div>
		 <div class="row">
		    <div class="input-field col s2">  
             <a  style="width:100%;" class="waves-effect waves-light btn" id="query" title="点击查询">Q</a></div>
             <div class="input-field col s2">  
		    <a style="width:100%;" class="waves-effect waves-light btn" id="reset" title="点击重置查询条件">R</a></div>
		</div>
		</div>
<?php
$sql = "select ui.user_id,ui.user_name,ui.nickname,ui.sex,ui.province,ui.city,ui.createdate,ui.is_valid,ui.user_class from userinfo ui  where 1=1 ";
$sqlCount ="select count(*) from  userinfo  ui  where 1=1 ";
$con = getMysqlCon();
mysqli_select_db($con, database);
if ($userName != "") {
    $sql .= "  and ui.user_name like '%" . addslashes($userName) . "%' ";
    $sqlCount .= " and ui.user_name like '%" . addslashes($userName) . "%'";
}
 $sql .= " order by ui.createdate";
$start =((intval($yema,10))-1) * 6;
$sql.=" limit ".$start.",6";
$result = mysqli_query($con, $sql);
//$arr = mysqli_fetch_all($result);
$result2 =mysqli_query($con, $sqlCount);
$num = mysqli_fetch_row($result2)[0];
//$arrSize = count($arr);
if($num>0){
    //echo "<div style='float:right;'><input type=\"button\" value=\"删除\" class=\"btn btn-default btn-sm\"  onclick='deleteUsers();' /></div>";
    echo "<div class='table-responsive'><table class='bordered highlight' width='100%'><tr><th width=4%><input type='checkbox' id='allc' onclick='checkAll();'><label for='allc'></label></th><th  width=4%>序号</th><th width=15%>OpenID</th><th  width=12%>userID</th><th  width=12%>nickName</th><th  width=8%>性别</th><th  width=10%>城市</th><th  width=15%>创建时间</th><th  width=30%>操作</th><tr>";
}else{
    echo "<div class='table-responsive'><table class='bordered highlight'><tr><td align='center'>未查询到人员！</td></tr>";
}
$xuhao=0;
while($user=mysqli_fetch_row($result)) {
        $xuhao++;
    echo "<tr class='success'><td><input type='checkbox' value='$user[0]' id='$user[0]' name='userids'  class='userids'/><label for='$user[0]'></label><td>$xuhao</td><td>$user[0]</td><td>$user[1]</td><td>$user[2]</td>";
		if($user[3]=='0'){
			echo "<td width=15%>男</td>";
		}else{
			echo "<td width=15%>女</td>";
		}
    echo "<td>$user[4]-$user[5]</td><td>$user[6]</td><td><a onclick=deleteUser('$user[0]')>删除</a>&nbsp;";
	if($user[7]=='1'){
		echo "<a onclick=forbidUser('$user[0]')>禁用</a>&nbsp;";
	}else if($user[7]=='0'){
		echo "<a onclick=openUser('$user[0]')>启用</a>&nbsp;";
	}
	if($user[8]=='1'){
		echo "<a onclick=aadmin('$user[0]')>移除管理员</a></td></tr>";
	}else if($user[8]=='0'){
		echo "<a onclick=admin('$user[0]')>管理员</a></td></tr>";
	}
}
echo "</table></div>";
if (is_int($num / 6)){ $yeshu= $num/6;}else{$yeshu=floor($num/6+1);}
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
 $("#userName").val("");
});
$("#query").click(function(){
	$("#yema").val("1");
	$("#userList").attr("action","userManage.php").submit();
});
$("#first").click(function(){
	if(1==$("#yema").val()){
		alert("已是首页!");
	}else{
	$("#yema").val("1");
	$("#userList").attr("action","userManage.php").submit();
  }
});
$("#next").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
     if($zongyeshu=="0"){
        return;
    }
	if($zongyeshu==$("#yema").val()){
		alert("已到最后一页!");
	}else{
	   $("#yema").val(parseInt($("#yema").val())+1+"");
	   $("#userList").attr("action","userManage.php").submit();
	}
});
$("#up").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
     if($zongyeshu=="0"){
        return;
    }
	if(1==$("#yema").val()){
		alert("已到首页!");
	}else{
	   $("#yema").val(parseInt($("#yema").val())-1+"");
	   $("#userList").attr("action","userManage.php").submit();
	}
});
$("#last").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
	if($zongyeshu==$("#yema").val()){
		alert("已到最后一页!");
	}else{
	   $("#yema").val($zongyeshu);
	   $("#userList").attr("action","userManage.php").submit();
	}
});
var flag = true;
function checkAll(){
	if(flag){
	$(".userids").prop("checked",true);
	flag =false;
	}else if(!flag){
		$(".userids").prop("checked",false);
		flag =true;
     }
}
function deleteusers(){
	console.log($(".userids:checked").length);
}
function modifyUserStat(id,stat){
	$.ajax({
		url:"modifyUserStat.php",
		method:"post",
		data:{id:id,stat:stat},
		async:false,
		success:function(data){
			console.log(data);
			if(data=="y"){
				alert("更改成功");
				window.location.href="userManage.php?yema=1";
			}else{
				alert("更改失败");
			}
		}
	});
}
//0删除
function deleteUser(id){
    console.log(id)
   if(window.confirm("确定删除id为"+id+"的用户吗？"))
    modifyUserStat(id,"0");
}
//1管理员
function admin(id){
if(window.confirm("确定更改id为"+id+"的用户为管理员吗？"))
   modifyUserStat(id,"1");
}
function forbidUser(id){
 if(window.confirm("确定禁用id为"+id+"的用户吗？"))
	modifyUserStat(id,"2");
}
function openUser(id){
	 if(window.confirm("确定启用id为"+id+"的用户吗？"))
	modifyUserStat(id,"3");
}
function aadmin(id){
	if(window.confirm("确定更改id为"+id+"的用户为非管理员吗？"))
   modifyUserStat(id,"4");
}
</script>
</html>