<?php
require_once 'getUserInfoWechat.php';
require_once 'tool/connectMysql.php';
require_once 'tool/isWechat.php';
error_reporting(E_ALL^E_NOTICE^E_WARNING);
if(!isWechat()){
	echo "请在微信中打开！";
	exit();
}
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="res/wechat/weui.min.css">
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <input type="hidden" id="openid" value="<?php session_start();echo $_SESSION['openid'];?>"/>
<div class="weui_cells_title">添加kindle推送邮箱</div>
<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">kindle邮箱</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input"  id='kindle' placeholder="请输入kindle邮箱" value="<?php echo $kindleMail; ?>"/>
                </div>
            </div>
			 <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">信任 邮箱</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="email" id="email"  placeholder="请输入信任的QQ邮箱" value="<?php echo $email; ?>"/>
                </div>
            </div>
			<div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">邮箱 密码</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="password" id="pass" placeholder="请输入邮箱密码" value="<?php echo $pass; ?>"/>
                </div>
            </div>
</div>
<div class="weui_cells_tips">信息的准确性关乎到是否推送成功，保证不会泄漏您的个人信息！</div>
<div class="weui_btn_area">
            <a class="weui_btn weui_btn_primary"  href="javascript:addKindleEmail()" id="showTooltips">确定</a>
</div>
     <div class="weui_dialog_alert" id="dialog1" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">添加结果</strong></div>
            <div class="weui_dialog_bd">添加成功，您可以推送电子书到kindle设备上啦！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close1();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
    <div class="weui_dialog_alert" id="dialog2" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">添加结果</strong></div>
            <div class="weui_dialog_bd">sorry,添加失败！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close2();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog3" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">添加结果</strong></div>
            <div class="weui_dialog_bd">请添加QQ邮箱！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close3();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog4" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">添加结果</strong></div>
            <div class="weui_dialog_bd">请添加以@kindle.cn结尾的邮箱！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close4();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
</body>
    <script>
   function addKindleEmail(){
       if($.trim($("#openid").val())==""||$.trim($("#kindle").val())==""||$.trim($("#email").val())=="") return;
	   var reg = /^([a-zA-Z0-9_-])+@qq.com/; 
	   if(!reg.test($.trim($("#email").val()))){$("#dialog3").show();return; }
	   var reg2 = /^([a-zA-Z0-9_-])+@kindle.cn/; 
	   if(!reg2.test($.trim($("#kindle").val()))){$("#dialog4").show();return; }
        $.ajax({
            url:"kindle/doAddKindleEmail.php",
            type:"post",
            data:{openid:$("#openid").val(),kindle:$.trim($("#kindle").val()),email:$.trim($("#email").val()),pass:$.trim($("#pass").val())},
            success:function(data){
                if(data=="y"){
                   $("#dialog1").show();
                }else if(data=="n"){
                   $("#dialog2").show(); 
                }
            }
        });
    } 
         function close1(){
          $("#dialog1").hide(); 
     }
         function close2(){
          $("#dialog2").hide(); 
     }
	  function close3(){
          $("#dialog3").hide(); 
     }
	  function close4(){
          $("#dialog4").hide(); 
     }
    </script>
</html>