<?php
require_once 'tool/is_mobile.php';

if(!is_mobile()){
    header("location:login/login.php");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />  
<title>Sign in to WKS</title>
<style>
h1{
    font-size: 20px;
    font-weight: 300;
    letter-spacing: -0.5px;
}
.btn-block {
    display: block;
    text-align: center;
    width: 45%;
}
.btn-primary {
    background-color: #60b044;
    background-image: linear-gradient(#8add6d, #60b044);
    border-color: #5ca941;
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.15);
}
.btn {
    -moz-user-select: none;
    background-color: #eee;
    background-image: linear-gradient(#fcfcfc, #eee);
    border: 1px solid #d5d5d5;
    border-radius: 3px;
    color: #333;
    cursor: pointer;
    display: inline-block;
    font-size: 13px;
    font-weight: bold;
    line-height: 20px;
    padding: 6px 12px;
    position: relative;
    vertical-align: middle;
    white-space: nowrap;
}
.auth-form-body {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #fff;
    border-color:  #d8dee2;
    border-image: none;
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    font-size: 14px;
    padding: 20px;
}
.flash {
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    font-size: 13px;
    margin:   auto;
    padding: 15px 20px;
    width: 340px;
}
.flash-full {
    border-radius: 3px;
    border-width: 1px;
    margin-top: 10px;
}
.flash-error {
    background-color: #fcdede;
    border-color: #d2b2b2;
    color: #911;
}
</style>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
  <link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css" />
  <script src="res/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="flash flash-full flash-error" style="display:none;" id="tip"></div>
  <div style="width:100%;margin:auto;"><h1 style="text-align:center;">Sign in to WKS</h1></div>
  <div style="width:100%;margin:auto;margin-top:1em;" class="auth-form-body">
  <form>
  <div class="form-group">
    <label for="userId">Username or email address </label>
    <input type="email" class="form-control" id="userId"  name="userId">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
 <input type="button" id="sub" value="Sign in" class="btn btn-primary btn-block" >
 <input type="button" id="sign" value="Sign up" class="btn btn-primary btn-block" >
</form>
</div> 
   
</body>
<script type="text/javascript">
   document.onkeydown=keyDownSearch;   
    function keyDownSearch(e) {    
        // 兼容FF和IE和Opera    
        var theEvent = e || window.event;    
        var code = theEvent.keyCode || theEvent.which || theEvent.charCode;    
        if (code == 13) {    
            sub();   
        }    
    }  
document.getElementById('sub').onclick = function(){
	sub();
}

function sub(){
    var userId = $("#userId").val();
	var password = $("#password").val();
	if(userId==""){
        $("#tip").html("<b>请输入用户名或邮箱!</b>")
        $("#tip").show();
        return;
	}else if(password==""){
		    $("#tip").html("<b>请输入密码!</b>")
	        $("#tip").show();
	        return;
	}else{
		 $("#tip").hide(); 
	}
	var yes = false;
	$.ajax({
       url:"login/doLogin.php",
       type:"post",
       async:false,
       data:{userId:userId,password:password},
       success:function(data){
            if(data=="n"){
           	   yes=false; 
              }
            if(data=="y"){
            	  yes=true; 
               }    
            }
		});
	if(!yes){
		 $("#tip").html("<b>用户名或密码错误!</b>")
         $("#tip").show();
	}else{
		window.location.href="book/houtaiSuccess.php";
	 }
}
document.getElementById('sign').onclick = function(){
	window.location.href ="eWeima.php";
}
</script>
</html>