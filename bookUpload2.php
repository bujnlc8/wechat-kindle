<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
require_once 'getUserInfoWechat.php';
require_once 'tool/connectMysql.php';
require_once 'tool/isWechat.php';
if(!isWechat()){
  echo "请在微信中打开！";
  exit();
}
if(isUserValid($_GET['openid'])){
session_start();
$_SESSION['openid'] = $_GET['openid'];
}else{
  echo "you do not have signed up!";
  exit();
}
require_once 'jssdk/doJs.php';
?>
<html>
<head><title>书籍上传</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<link rel="shortcut icon" href="res/img/favorite.ico"/>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<style type="text/css">
</style>
  <link rel="stylesheet" href="res/materialize/css/materialize.min.css" />
  <script src="res/materialize/js/materialize.min.js"></script>
</head>
<body bgcolor="#F0F8FF">
 <div class="row">
<form  class="col s12" enctype="multipart/form-data" action="book/doHoutai.php"  method="post" name="uploadFile" id="uploadFile">
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
 <div style="width:30%;display: inline-block;"><input type="radio"  checked="checked" name="bookClass" value="1" id="1"/><label for="1">IT编程</label></div>
 <div style="width:30%;display: inline-block;"><input type="radio"  name="bookClass" value="2" id="2"/><label for="2">文学传记</label></div>
 <div style="width:30%;display: inline-block;"><input type="radio"  name="bookClass" value="3" id="3"/><label for="3">诗歌散文</label></div>
 <div style="width:30%;display: inline-block;"><input type="radio"  name="bookClass" value="4" id="4"/><label for="4">杂志</label></div>
 <div style="width:30%;display: inline-block;"><input type="radio"  name="bookClass" value="5" id="5"/><label for="5">经济金融</label></div>
 <div style="width:30%;display: inline-block;"><input type="radio"  name="bookClass" value="6" id="6"/><label for="6">哲理读物</label></div>
 <div style="width:30%;display: inline-block;"><input type="radio"  name="bookClass" value="7" id="7"/><label for="7">历史地理</label></div>
 </div> 
 <div class="row">
        <div class="input-field col s8">
          <textarea id="textarea1" class="materialize-textarea" name="bookDesc"></textarea>
          <label for="textarea1">简介</label>
        </div>
 </div>
 <div class="file-field input-field">
     <div class="btn">
        <span>点击添加书籍</span>
         <input type="file" id="book" name="book" onchange="tip();">
      </div>
      <div class="file-path-wrapper" style="visibility: hidden">
      <input class="file-path validate" type="text">
      </div>
</div>
 <div style="margin-top:1%;">
 <a class="waves-effect waves-light btn" id="sub">上传</a>
 </div>
</form>
</body>
<script>
function checkBook(){
    var bookName= $("#bookName").val();
    $.ajax({
	url:"book/isbookExist.php",
	type:"post",
	data:{bookName:bookName},
	success:function(data){
		if(data=="n"){
			 alert("书籍已经躺在服务器啦！");
		}
	}
   });
 }     
$(".button-collapse").sideNav();
$('.collapsible').collapsible();
$("#sub").click(function(){
	if($("#book").val()==""||$("#bookName").val()==""){
      return;
	}else{
    var bookName= $("#bookName").val();
    $.ajax({
	url:"book/isbookExist.php",
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