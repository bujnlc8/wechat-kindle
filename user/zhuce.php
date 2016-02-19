<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$r = $_SESSION['r1'];
$r5 = $_SESSION['r6'];
if($r==""||$r5!=md5($r)){
   echo "亲，邀请码呢！";
   exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<title>注册</title>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
<script type="text/javascript" src="../res/js/city.js"></script>
</head>
<body>
     <div class="row">
       <div><p style="font-family:Tahoma;font-style:italic;">欢迎 <?php session_start();echo $_SESSION['nickname'];?>注册! Books are human's friends.</p></div>
	  <form id="zhuceForm" action="doZhuce.php" method="post">
		 <div class="row">
	    <div class="input-field col s12">
			<label for="userId">注册ID</label><input type="text" name="userId"
				id="userId"  onblur="checkValid();" value="<?php session_start();echo  $_SESSION['openid']; ?>" class="validate"  style="display:inline-block;" readonly /><span
				id="userIdTip" style="font-size: 100%; width: 20%;display:inline-block;"></span>
		</div>
		</div>
		 <div class="row">
	     <div class="input-field col s12">
			  <label >用户名</label><input type="text" name="userName" id="userName" class="validate" onblur="checkUserName();"/><span id="userNameTip" style="font-size:0.6em; width:30%;">3位以上的数字或字母~</span>
		</div>
		</div>
          <div class="row">
              <label style="margin-left:1%;">性&nbsp;&nbsp;&nbsp;&nbsp;别</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			   <input class="with-gap" type="radio" name="sex" value="0"  <?php session_start();  if($_SESSION['sex']=='1') echo "checked=\"checked\"";  ?>
				 id="m"  style="display:inline;"/><label for="m">M</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input  class="with-gap" type="radio" name="sex" value="1" id="f"  <?php session_start();  if($_SESSION['sex']=='2') echo "checked=\"checked\"";  ?>><label for="f">F</label>
		</div>
		<div class="row">
		<div class="input-field col s12">
			    <select onchange="chinaChange(this,document.getElementById('city'));"
				name="province" id="province"
				onblur="provinceCheck();">
				<option value="" <?php session_start();  if($_SESSION['province']=='') echo "selected=\"selected\"";  ?>>请选择省份</option>
				<option value="北京市" <?php session_start();  if($_SESSION['province']=='北京') echo "selected=\"selected\"";  ?>>北京市</option>
				<option value="天津市" <?php session_start();  if($_SESSION['province']=='天津') echo "selected=\"selected\"";  ?>>天津市</option>
				<option value="上海市" <?php session_start();  if($_SESSION['province']=='上海') echo "selected=\"selected\"";  ?>>上海市</option>
				<option value="重庆市" <?php session_start();  if($_SESSION['province']=='重庆') echo "selected=\"selected\"";  ?>>重庆市</option>
				<option value="河北省" <?php session_start();  if($_SESSION['province']=='河北') echo "selected=\"selected\"";  ?>>河北省</option>
				<option value="山西省" <?php session_start();  if($_SESSION['province']=='山西') echo "selected=\"selected\"";  ?>>山西省</option>
				<option value="辽宁省" <?php session_start();  if($_SESSION['province']=='辽宁') echo "selected=\"selected\"";  ?>>辽宁省</option>
				<option value="吉林省" <?php session_start();  if($_SESSION['province']=='吉林') echo "selected=\"selected\"";  ?>>吉林省</option>
				<option value="黑龙江省" <?php session_start();  if($_SESSION['province']=='黑龙江') echo "selected=\"selected\"";  ?>>黑龙江省</option>
				<option value="江苏省" <?php session_start();  if($_SESSION['province']=='江苏') echo "selected=\"selected\"";  ?>>江苏省</option>
				<option value="浙江省" <?php session_start();  if($_SESSION['province']=='浙江') echo "selected=\"selected\"";  ?>>浙江省</option>
				<option value="安徽省" <?php session_start();  if($_SESSION['province']=='安徽') echo "selected=\"selected\"";  ?>>安徽省</option>
				<option value="福建省" <?php session_start();  if($_SESSION['province']=='福建') echo "selected=\"selected\"";  ?>>福建省</option>
				<option value="江西省" <?php session_start();  if($_SESSION['province']=='江西') echo "selected=\"selected\"";  ?>>江西省</option>
				<option value="山东省" <?php session_start();  if($_SESSION['province']=='山东') echo "selected=\"selected\"";  ?>>山东省</option>
				<option value="河南省" <?php session_start();  if($_SESSION['province']=='河南') echo "selected=\"selected\"";  ?>>河南省</option>
				<option value="湖北省" <?php session_start();  if($_SESSION['province']=='湖北') echo "selected=\"selected\"";  ?>>湖北省</option>
				<option value="湖南省" <?php session_start();  if($_SESSION['province']=='湖南') echo "selected=\"selected\"";  ?>>湖南省</option>
				<option value="广东省" <?php session_start();  if($_SESSION['province']=='广东') echo "selected=\"selected\"";  ?>>广东省</option>
				<option value="海南省" <?php session_start();  if($_SESSION['province']=='海南') echo "selected=\"selected\"";  ?>>海南省</option>
				<option value="四川省" <?php session_start();  if($_SESSION['province']=='四川') echo "selected=\"selected\"";  ?>>四川省</option>
				<option value="贵州省" <?php session_start();  if($_SESSION['province']=='贵州') echo "selected=\"selected\"";  ?>>贵州省</option>
				<option value="云南省" <?php session_start();  if($_SESSION['province']=='云南') echo "selected=\"selected\"";  ?>>云南省</option>
				<option value="陕西省" <?php session_start();  if($_SESSION['province']=='陕西') echo "selected=\"selected\"";  ?>>陕西省</option>
				<option value="甘肃省" <?php session_start();  if($_SESSION['province']=='甘肃') echo "selected=\"selected\"";  ?>>甘肃省</option>
				<option value="青海省" <?php session_start();  if($_SESSION['province']=='青海') echo "selected=\"selected\"";  ?>>青海省</option>
				<option value="台湾省" <?php session_start();  if($_SESSION['province']=='台湾') echo "selected=\"selected\"";  ?>>台湾省</option>
				<option value="广西壮族自治区" <?php session_start();  if($_SESSION['province']=='广西') echo "selected=\"selected\"";  ?>>广西壮族自治区</option>
				<option value="内蒙古自治区" <?php session_start();  if($_SESSION['province']=='内蒙古') echo "selected=\"selected\"";  ?>>内蒙古自治区</option>
				<option value="西藏自治区" <?php session_start();  if($_SESSION['province']=='西藏') echo "selected=\"selected\"";  ?>>西藏自治区</option>
				<option value="宁夏回族自治区" <?php session_start();  if($_SESSION['province']=='宁夏') echo "selected=\"selected\"";  ?>>宁夏回族自治区</option>
				<option value="新疆维吾尔自治区" <?php session_start();  if($_SESSION['province']=='新疆') echo "selected=\"selected\"";  ?>>新疆维吾尔自治区</option>
				<option value="香港特别行政区" <?php session_start();  if($_SESSION['province']=='香港') echo "selected=\"selected\"";  ?>>香港特别行政区</option>
				<option value="澳门特别行政区" <?php session_start();  if($_SESSION['province']=='澳门') echo "selected=\"selected\"";  ?>>澳门特别行政区</option>
				</select>
		</div>
		</div>
		<div class="row">
		<div class="input-field col s12">
			<select name="city" id="city" onblur="cityCheck();">
				<option value="" <?php session_start();  if($_SESSION['city']=='') echo "selected=\"selected\"";  ?>>请选择市区</option>
				<option value="<?php session_start(); if($_SESSION['city']!='') echo  $_SESSION['city']."市";  ?>" selected="selected"><?php session_start(); if($_SESSION['city']!='') echo  $_SESSION['city']."市";?></option>
			</select><span id="aTip" style="display: none; width: 20%;"></span>
		</div>
		</div>
		<div class="row">
        <div class="input-field col s12">
			<label for="email">Email</label><input type="email" name="email" id="email"
				onblur="checkEmail();"  class="validate"/><span id="emailTip"
				style="font-size: 0.6em; width:  30%;">输入的邮箱将作为电子书推送邮箱~</span>
		</div>
		</div>
		<div class="row">
        <div class="input-field col s12">
			 <label for="passwd">输入密码</label><input type="password" 
				name="passwd" id="passwd" onblur="checkPassword();" class="validate" /><span
				id="passwordTip" style="font-size: 0.6em; width:  30%;">输入不少于6位的密码~</span>
		</div>
		</div>
	 <div class="row">
	 <div class="input-field col s12">
			<label for="re-password">重新输入</label><input type="password"
				name="re-password" id="re-password"
				onblur="checkPass()"  class="validate"/><span id="tip"
				style="display: none; width: 30%;" ></span>
     </div>
	 </div>
	  <div class="row">
	   <div class="input-field col s12">
	   <a id="sub" class="waves-effect waves-light btn-large" onclick="subForm()" style="display: block;width: 100%;">Submit</a>
		</div>
		</div>
        <input type="hidden" name="nickname" value="<?php session_start();echo $_SESSION['nickname'];?>" />
	</form>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function() {
     $('select').material_select();
    //$('select').material_select('destroy');
  });
function checkValid(){
    var i =true;
	if($("#userId").val().trim()==""){
		 $("#userIdTip").html("<b style=\"color:red;font-size:8px;\">请输入注册id!</b>");
         $("#userIdTip").show(); 
         return false;
		}else{
			var userId = $("#userId").val();
			var reg =/^[a-z A-Z _ 1-9]{3,32}/
				if(!reg.test(userId)){
					$("#userIdTip").html("<b style=\"color:red;font-size:8px;\">id由至少3位字母数字和下划线组成!</b>");
			         $("#userIdTip").show(); 
			         return false;
				} else{
		$.ajax({
        url:"checkUserIdValid.php",
        type:"post",
        async:false,
        data:{userId:$("#userId").val().trim()},
        dataType:"json",
        success:function(data){
           if(data){
               if(data.isExist=='y'){
                $("#userIdTip").html("<b style=\"color:red;font-size:8px;\">您已经注册过啦！</b>");
                $("#userIdTip").show();  
                i=false;
            }else if(data.isExist=='n'){
           	 $("#userIdTip").html("<b style=\"color:cyan;font-size:8px;\">恭喜您，id可用！</b>");
             $("#userIdTip").show(); 
                 i= true;
             }
           }
         }
		});
	}
  }
	return i;
}
function checkPass(){
	var password =$("#passwd").val().trim();
	var repassword = $("#re-password").val().trim();
	if(password!=repassword){
		$("#tip").html("<b style='color:red;font-size:8px;'>repassword error!</b>");
		$("#tip").show();
		return false;
	}else{
		$("#tip").hide();
		}
	 return true;
}
function checkEmail(){
	var email = $("#email").val();
	if($.trim(email)==""){
		$("#emailTip").html("<b style=\"color:red;font-size:8px;\">请输入email!</b>");
        $("#emailTip").show(); 
        return false;  
		}else{	
			var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
			console.log(reg.test(email))
			if(!reg.test(email)) {
				$("#emailTip").html("<b style=\"color:red;font-size:8px;\">请输入正确格式的email!</b>");
		        $("#emailTip").show(); 
		        return false;
			}else{
				$("#emailTip").hide(); 
				}	
	}
	 return true;
}
function provinceCheck(){
	var province =$("#province :selected").val();
	if(province==""){
		$("#aTip").html("<b style=\"color:red;font-size:8px;\">请选择省份!</b>");
        $("#aTip").show(); 
        return false;  
	}else{
		$("#aTip").hide(); 
		}
	 return true;
}
function cityCheck(){
	var city =$("#city :selected").val();
	if(city==""){
		$("#aTip").html("<b style=\"color:red;font-size:8px;\">请选择城市!</b>");
        $("#aTip").show(); 
        return false;  
	}else{
		$("#aTip").hide(); 
		}
	 return true;
}

function checkPassword(){
	var password = $("#passwd").val().trim();
	if(password.length<6){
		$("#passwordTip").html("<b style=\"color:red;font-size:8px;\">请输入不少于6位的密码!</b>");
        $("#passwordTip").show(); 
        return false;
		}else{
			  $("#passwordTip").hide(); 
	}
	 return true;
}
function checkUserName(){
if($("#userName").val().trim()==""){
         var i = true;
		 $("#userNameTip").html("<b style=\"color:red;font-size:8px;\">请输入用户名!</b>");
         $("#userNameTip").show(); 
         return false;
		}else{
			var userName = $("#userName").val();
			var reg =/^[a-z A-Z _ 1-9]{3,32}/
				if(!reg.test(userName)){
					$("#userNameTip").html("<b style=\"color:red;font-size:8px;\">用户名由至少3位字母数字和下划线组成!</b>");
			        $("#userNameTip").show(); 
			         return false;
				} else{
		$.ajax({
        url:"checkUserNameValid.php",
        type:"post",
        async:false,
        data:{userName:$("#userName").val().trim()},
        dataType:"json",
        success:function(data){
           if(data){
               if(data.isExist=='y'){
                $("#userNameTip").html("<b style=\"color:red;font-size:8px;\">这个用户名已经被占用啦！</b>");
                $("#userNameTip").show();  
                i= false;
            }else if(data.isExist=='n'){
           	 $("#userNameTip").html("<b style=\"color:cyan;font-size:8px;\">恭喜您，用户名可用！</b>");
             $("#userNameTip").show();  
                i= true;
             }
           }
         }
		});
	}

  }
    return i;
}
function subForm(){
	var valid=checkValid();
	var pss = checkPassword();
	var city =cityCheck();
	var province = provinceCheck();
	var email = checkEmail();
	var p =checkPass();
    var user = checkUserName();
	if(valid&&pss&city&&province&&email&&p&&user){
	 $("#zhuceForm").submit();
    }
}
</script>
</html>