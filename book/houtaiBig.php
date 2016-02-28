<?php 
require_once '../tool/valid.php';
require_once '../tool/is_mobile.php';
?>
<html>
<head><title>电子书上传(大)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<style type="text/css">
</style>
  <link rel="stylesheet" href="../res/materialize/css/materialize.min.css" />
  <script src="../res/materialize/js/materialize.min.js"></script>
</head>
<body bgcolor="#F0F8FF">
 <?php 
 if(is_mobile()){
      echo  "<nav><ul id=\"slide-out\" class=\"side-nav\">";
	  echo "<li><a href=\"#\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:50px;height:50px;\"></a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"houtai.php\">电子书上传</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"houtaiBig.php\">电子书上传(大)</a></li> ";
      echo "<li><a href=\"bookList.php?yema=1\">书籍列表</a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../user/userManage.php?yema=1\">人员管理</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../yaoqingma/yaoqingmaAdd.php\">邀请码</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../log/logList.php?yema=1\">日志管理</a></li> ";
	  echo "<li><a href=\"../login/logout.php\">注销</a></li>";
      echo "</ul>";  
      echo "<a href=\"#\" data-activates=\"slide-out\" class=\"button-collapse\"><i class=\"mdi-navigation-menu\"></i></a></nav>";
 }else{
	    echo "<nav><div class=\"nav-wrapper\"><a  href=\"../login/logout.php\" style=\"float:right;margin-right:6%;color:purple;\">注销</a><a href=\"#\" class=\"brand-logo right\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:55px;height:55px;\"></a><ul id=\"nav-mobile\" class=\"left hide-on-med-and-down\">";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"houtai.php\">电子书上传</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"houtaiBig.php\">电子书上传(大)</a></li> ";
        echo "<li><a href=\"bookList.php?yema=1\">书籍列表</a></li>";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../user/userManage.php?yema=1\">人员管理</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../yaoqingma/yaoqingmaAdd.php\">邀请码</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../log/logList.php?yema=1\">日志管理</a></li> ";
        echo "</ul></div></nav>";
 }	 
 ?>
 <div class="row">
<form  class="col s12" action="doHoutaiBig.php"  method="post" name="uploadFile" id="uploadFile">
 <div class="row">
        <div class="input-field col s8">
        <input type="text" id="bookName" name="bookName"  class="validate" onblur="checkBook();"><label for="bookName">书名</label>
        </div>
 </div>
 <div class="row">
        <div class="input-field col s8">
        <input type="text" id="writer" name="writer"  class="validate"> <label for="writer">作者</label>
        </div>
 </div>
 <div class="row">
 <input type="radio"  checked="checked" name="bookClass" value="1" id="1"/><label for="1">IT编程</label>&nbsp;
 <input type="radio"  name="bookClass" value="2" id="2"/><label for="2">文学传记</label>&nbsp;
 <input type="radio"  name="bookClass" value="3" id="3"/><label for="3">诗歌散文</label>&nbsp;
 <input type="radio"  name="bookClass" value="4" id="4"/><label for="4">杂志</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="radio"  name="bookClass" value="5" id="5"/><label for="5">经济金融</label>&nbsp;
 <input type="radio"  name="bookClass" value="6" id="6"/><label for="6">哲理读物</label>&nbsp;
 <input type="radio"  name="bookClass" value="7" id="7"/><label for="7">历史地理</label>&nbsp;
 </div> 
 <div class="row">
        <div class="input-field col s8">
          <textarea id="textarea1" class="materialize-textarea" name="bookDesc"></textarea>
          <label for="textarea1">简介</label>
        </div>
 </div>
 <div class="row">
        <div class="input-field col s8">
        <input type="text" id="bookUrl" name="bookUrl"  class="validate" onblur="checkBookUrl();"><label for="bookUrl">链接及密码</label>
        </div>
 </div>
 <div style="margin-top:1%;">
 <a class="waves-effect waves-light btn" id="sub">确定</a>
 </div>
</form>
</body>
<script>
function checkBook(){
    var bookName= $("#bookName").val();
    $.ajax({
	url:"isbookExist.php",
	type:"post",
	data:{bookName:bookName},
	success:function(data){
		if(data=="n"){
			 alert("书籍已经躺在服务器啦！");
		}
	}
   });
 }
function checkBookUrl(){
    var bookUrl= $("#bookUrl").val(); 
    if(!bookUrl){
        return;
    }
}
        
$(".button-collapse").sideNav();
$('.collapsible').collapsible();
$("#sub").click(function(){
    checkBookUrl();
	if($("#book").val()==""||$("#bookName").val()==""){
      return;
	}else{
    var bookName= $("#bookName").val();
    $.ajax({
	url:"isbookExist.php",
	type:"post",
	data:{bookName:bookName},
	success:function(data){
		if(data=="y"){
			 $("#uploadFile").submit();
		}else{
			alert("书籍已经躺在服务器啦！");
		}
	}
});
}
});
    function tip(){
        // $('#tip').html('<b>success!</b>');
    }
</script>
</html>