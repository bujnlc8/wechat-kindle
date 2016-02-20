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
<title>登陆</title>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="res/materialize/css/materialize.min.css" />
  <script src="res/materialize/js/materialize.min.js"></script>
</head>
<body>
    <div>
    <div class="card-panel teal lighten-12" style="margin:auto;width:100%">
	<form id="loginForm" action="login/doLogin.php" method="post"><div>
        用户名或邮箱:<input type="text" name="userId" id="userId" style="display: block; height: 1.5em" /></div>
        密码:<input type="password" name="password" id="password"
			style="display: block; height: 1.5em; margin-top: 0.6em;" /> 
		<div id="tip" style="display: none;height:1.5em;"></div>
        <div style="width:90%;height:2.5em;"><input type="button" id="sub" value="登陆" style="width:32%;height:80%"/>
            <input type="button" id="sign" value="注册"  style="width:30%;height:80%;margin-left:35%;"/>
        </div>
	</form>
    </div>
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
        $("#tip").html("<b style=\"color:red;font-size:8px;\">请输入用户名!</b>")
        $("#tip").show();
        return;
	}else if(password==""){
		    $("#tip").html("<b style=\"color:red;font-size:8px;\">请输入密码!</b>")
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
		 $("#tip").html("<b style=\"color:red;font-size:8px;\">用户名或密码错误!</b>")
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