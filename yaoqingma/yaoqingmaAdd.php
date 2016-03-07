<?php 
require_once '../tool/valid.php';
require_once '../tool/is_mobile.php';
?>
<html>
<head><title>邀请码</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<link rel="shortcut icon" href="../res/img/favorite.ico"/>
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
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtai.php\">电子书上传</a></li> ";
     session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtaiBig.php\">电子书上传(大)</a></li> ";
      echo "<li><a href=\"../book/bookList.php?yema=1\">书籍列表</a></li>";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../user/userManage.php?yema=1\">人员管理</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"yaoqingmaAdd.php\">邀请码</a></li> ";
      session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../log/logList.php?yema=1\">日志管理</a></li> ";
	  echo "<li><a href=\"../login/logout.php\">注销</a></li>";
      echo "</ul>";  
     echo "<a href=\"#\" data-activates=\"slide-out\" class=\"button-collapse\"><i class=\"mdi-navigation-menu\"></i></a></nav>";
 }else{
	    echo "<nav><div class=\"nav-wrapper\"><a  href=\"../login/logout.php\" style=\"float:right;margin-right:6%;color:purple;\">注销</a><a href=\"#\" class=\"brand-logo right\"><img alt=\"维\"  title=\"扫扫关注微信公众号！\" src=\"../res/img/0.jpg\" style=\"border-radius:50px;width:55px;height:55px;\"></a><ul id=\"nav-mobile\" class=\"left hide-on-med-and-down\">";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtai.php\">电子书上传</a></li> ";
     session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../book/houtaiBig.php\">电子书上传(大)</a></li> ";
        echo "<li><a href=\"../book/bookList.php?yema=1\">书籍列表</a></li>";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../user/userManage.php?yema=1\">人员管理</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"yaoqingmaAdd.php\">邀请码</a></li> ";
        session_start();if($_SESSION['userLogined']=='admin') echo "<li><a href=\"../log/logList.php?yema=1\">日志管理</a></li> ";
     echo "</ul></div></nav>";
 }?>
   <div class="row">
     <div class="input-field col s8">
    <div><label>邀请码</label><input type="text" id="yaoqingCode"/>
    </div>
    </div>
     <div class="row">
        <div class="input-field col s8"><label>人次</label>
      <p class="range-field">
      <input type="range"  min="0" max="10" id="num" />
      </p>
     </div>
     </div>
      <div class="row">
     <a style="width:66%;" class="waves-effect waves-light btn" id="yaoqingCodeSub">确定</a>
     </div>
       <div class="row">
       <div class="input-field col s8">
      <div>当前邀请码<input type="text" id="cryaoqingCode"/>
       </div>
       </div>
       </div>
       <div class="row">
       <div class="input-field col s8">
      <div>剩余人次<input type="text" id="restNum"/>
       </div>
       </div>
       </div>
  </body>
  <script type="text/javascript">
      $(function(){
       $(".button-collapse").sideNav();
	   $('.collapsible').collapsible();
          $.ajax({
              url:"getyaoqingma.php",
              type:"post",
              dataType:"json",
              success:function(data){
               $("#cryaoqingCode").val(data.code);
               $("#restNum").val(data.restNum);
              }
          });
      
      });
 
  $("#yaoqingCodeSub").click(function(){
	if($("#yaoqingCode").val()==""){
      alert("输入邀请码！");
	}else if($("#num").val()==""){}else{
       $.ajax({
        url:"addYaoqingCode.php",
        data:{yaoqingCode:$("#yaoqingCode").val(),num:$("#num").val()},
        type:"post",
        success:function(data){
          if(data=="y"){
              alert("添加成功！");
              }
            }
           });
	  }
});
</script>
  </html>   


