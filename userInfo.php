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
$sql ="select user_name,province,city,email,num from userinfo where user_id='".$openid."' and is_valid='1'";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $userName=$row['user_name'];
	$email =$row['email'];
	$province =$row['province'];
	$city =$row['city'];
	$num =20-$row['num'];
}
if(mysqli_num_rows($result)==0){
	$userName="";
	$email ="";
	$province ="";
	$city ="";
	$num =20;
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
<div class="weui_cells_title">我的信息</div>
<div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">ID</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input"  id='userName'  value="<?php echo $userName; ?>"  readonly />
                </div>
            </div>
			 <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">省份</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input"  id="province"   value="<?php echo $province; ?>"/>
                </div>
            </div>
			<div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">城市</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" id="city"   value="<?php echo $city; ?>"/>
                </div>
            </div>
			<div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">邮箱</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="email" id="email"  value="<?php echo $email; ?>"/>
                </div>
            </div>
			<div class="weui_cells_tips">此邮箱用于接收电子书的链接或附件，非kindle邮箱！</div>
			<div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">当日 剩余 推送 次数</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="text" value="<?php echo $num."次"; ?>" readonly />
                </div>
            </div>
</div>
<div class="weui_btn_area">
            <a class="weui_btn weui_btn_primary"  href="javascript:editUserInfo()" id="showTooltips">确定</a>
</div>
<?php
  if($openid=="o7rxEuF0Ne325LNSXlqNVzSdr_vA"){
	  echo "<div class=\"weui_btn_area\"><a class=\"weui_btn weui_btn_primary\"  href=\"javascript:resetTheNum()\" id=\"showTooltips\">重置次数</a></div>";
  }
?>
     <div class="weui_dialog_alert" id="dialog1" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">修改结果</strong></div>
            <div class="weui_dialog_bd">修改成功！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close1();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
    <div class="weui_dialog_alert" id="dialog2" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">修改结果</strong></div>
            <div class="weui_dialog_bd">sorry,修改失败！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close2();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog3" style="display: none;">
        <div class="weui_mask"></div>
	    <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">修改结果</strong></div>
            <div class="weui_dialog_bd">请不要输入kindle邮箱！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close3();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
</body>
    <script>
   function editUserInfo(){
       if($.trim($("#openid").val())==""||$.trim($("#email").val())==""||$.trim($("#userName").val())==""||$.trim($("#province").val())==""||$.trim($("#city").val())=="") return;
	   var reg = /^([a-zA-Z0-9_-])+@kindle.cn/; 
	   if(reg.test($.trim($("#email").val()))){$("#dialog3").show(); $("#email").val("");return; }
        $.ajax({
            url:"user/editUserInfo.php",
            type:"post",
            data:{openid:$("#openid").val(),email:$("#email").val(),province:$("#province").val(),city:$("#city").val()},
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
	 function resetTheNum(){
		 $.ajax({
            url:"kindle/resetTheNum.php",
            type:"post",
            success:function(data){
                if(data=="y"){
                   $("#dialog1").show();
                }else if(data=="n"){
                   $("#dialog2").show(); 
                }
            }
        });
	 }
    </script>
</html>