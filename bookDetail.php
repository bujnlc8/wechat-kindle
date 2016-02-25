<?php 
function remote_filesize($url_file){ 
    $headInf = get_headers($url_file,1); 
    return $headInf['Content-Length']; 
}
$openid = $_GET['openid'];
session_start();
$_SESSION['openid']=$openid;
$url = $_GET['bookurl'];
$writer = $_GET['writer'];
$bookName = str_replace(' ','',$_GET['bookName']);
if(!strstr($url,'链接')){
$strArr = explode('.',$url);
$fileName=$bookName.".".$strArr[4];
$fileType= $strArr[4];
}else{
  $fileType= "pan";  
}
?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="res/wechat/weui.min.css">
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<!--<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>-->
</head>
<body>
<div class="weui_cells_title">书籍详情</div>
<div class="weui_cells">
    <div class="weui_cell">
        <div class="weui_cell_ft">
            <p align="left">  <?php echo $bookName;?></p>
        </div>
    </div>
	<div class="weui_cell">
        <div class="weui_cell_ft">
            <p align="left">  <?php echo trim($writer);?></p>
        </div>
    </div>
	<!--<div class="weui_cell">
        <div class="weui_cell_ft">
            <p align="left">  <?php 
			/*if($fileType!="pan"){
		   $fileSize =remote_filesize($url);
		   if($fileSize<=1048576){
			   $s =sprintf("%.2f",$fileSize/1024)."kB";
			   echo "$s";
		   }else{
			   $s =sprintf("%.2f",$fileSize/(1024*1024))."MB";
			   echo "$s";
			};} */?></p>
        </div>
    </div>-->
    <div class="weui_cell">
        <div class="weui_cell_ft">
            <p align="left"> <?php if($fileType=="pan"){echo "<a href='".mb_substr($url,3,-7)."'>".mb_substr($url,3)."</a>"; }else{echo $url;}?></p>
        </div>
    </div>
 <?php 
if(!strstr($url,'pan')){
if($fileType=='mobi' ||$fileType=='azw'){
        echo "<div class=\"button_sp_area\"><a onclick=send2Kindle('$url','$bookName',this) class=\"weui_btn weui_btn_plain_primary\">推送至kindle</a></div>";
		//echo "<div class=\"button_sp_area\"><a onclick=send2MailUrl('$url','$bookName',this) class=\"weui_btn weui_btn_plain_primary\">发送至邮箱</a></div>";
}else{
     echo "<div class=\"button_sp_area\"><a onclick=send2MailUrl('$url','$bookName',this) class=\"weui_btn weui_btn_plain_primary\">发送至邮箱</a></div>";
}
}
    ?>
</div>
    <div class="weui_dialog_alert" id="dialog1" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">推送成功，稍后推送至您的kindle，请不要重复推送！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close2();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
    <div class="weui_dialog_alert" id="dialog2" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">sorry,推送失败！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close1();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog6" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">sorry,推送失败,电子书太大！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close6();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
     <div class="weui_dialog_alert" id="dialog3" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">发送结果</strong></div>
            <div class="weui_dialog_bd">发送成功,稍后将书籍发送至您的邮箱,请不要重复发送！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close3();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
    <div class="weui_dialog_alert" id="dialog4" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">发送结果</strong></div>
            <div class="weui_dialog_bd">sorry,发送失败！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close4();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog5" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">您还未添加kindle推送邮箱，请点击微信菜单【个人信息->kindle邮箱】添加！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close5();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog7" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">您的发送量已超出最大限额，明天继续吧！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close7();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog8" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">推送失败,您添加的不是kindle推送邮箱，请点击微信菜单【个人信息->kindle邮箱】修改！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close8();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div class="weui_dialog_alert" id="dialog9" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title">推送结果</strong></div>
            <div class="weui_dialog_bd">请不要重复发送！</div>
            <div class="weui_dialog_ft">
                <a href="javascript:close9();" class="weui_btn_dialog primary">确定</a>
            </div>
        </div>
    </div>
	<div id="loadingToast" class="weui_loading_toast" style="display:none;">
    <div class="weui_mask_transparent"></div>
    <div class="weui_toast">
        <div class="weui_loading">
            <div class="weui_loading_leaf weui_loading_leaf_0"></div>
            <div class="weui_loading_leaf weui_loading_leaf_1"></div>
            <div class="weui_loading_leaf weui_loading_leaf_2"></div>
            <div class="weui_loading_leaf weui_loading_leaf_3"></div>
            <div class="weui_loading_leaf weui_loading_leaf_4"></div>
            <div class="weui_loading_leaf weui_loading_leaf_5"></div>
            <div class="weui_loading_leaf weui_loading_leaf_6"></div>
            <div class="weui_loading_leaf weui_loading_leaf_7"></div>
            <div class="weui_loading_leaf weui_loading_leaf_8"></div>
            <div class="weui_loading_leaf weui_loading_leaf_9"></div>
            <div class="weui_loading_leaf weui_loading_leaf_10"></div>
            <div class="weui_loading_leaf weui_loading_leaf_11"></div>
        </div>
        <p class="weui_toast_content">正在发送中</p>
    </div>
</div>
<div id="toast" style="display: none;">
    <div class="weui_mask_transparent"></div>
    <div class="weui_toast">
        <i class="weui_icon_toast"></i>
        <p class="weui_toast_content">已发送</p>
    </div>
</div>
</body>
 <script>
    var isSend2Url =false;
	var isSend2Kindle = false;
    function send2Kindle(url,bookName,e){
		if(isSend2Kindle){
			$("#dialog9").show(); 
			return false;;
		}
		$("#loadingToast").show();
		isSend2Kindle = true;
        $.ajax({
            url:"kindle/send2Kindle.php",
            type:"post",
            data:{url:url,bookName:bookName},
            success:function(data){
                if(data=="y"){
				   $("#loadingToast").hide();
                   $("#toast").show();
				   setTimeout(function(){$("#toast").hide();},4000);
				   isSend2Kindle = true;
                }else if(data=="n"){
                   $("#dialog2").show(); 
                }else if(data=="noEmail"){
				   $("#dialog5").show(); 
				}else if(data=="l"){
				   $("#dialog6").show(); 
				}else if(data=="TooMany"){
				   $("#dialog7").show(); 
				}else if(data=="noKindle"){
				   $("#dialog8").show(); 
				}
            }
        });
		//$(e).hide();
		//setTimeout(function(){$(e).show();},8000);
    }
     function send2MailUrl(url,bookName,e){
		 if(isSend2Url){
			$("#dialog9").show(); 
			return false;;
		}
		$("#loadingToast").show();
		isSend2Url =true;
        $.ajax({
            url:"kindle/send2MailUrl.php",
            type:"post",
            data:{url:url,bookName:bookName},
            success:function(data){
                if(data=='y'){
                   $("#loadingToast").hide();
				   $("#toast").show();
				   setTimeout(function(){$("#toast").hide();},4000);
				   isSend2Url =true;
                }else if(data=="n"){
                   $("#dialog4").show(); 
                }else if(data=="TooMany"){
				   $("#dialog7").show(); 
				}
            }
        });
		//e.style.color = 'grey';
       // $(e).hide();
		//setTimeout(function(){$(e).show();},8000);
    }
     function close1(){
          $("#dialog2").hide(); 
     }
     function close2(){
          $("#dialog1").hide(); 
     }
     function close3(){
          $("#dialog3").hide(); 
     }
     function close4(){
          $("#dialog4").hide(); 
     }
	 function close5(){
          $("#dialog5").hide(); 
     }
	 function close6(){
          $("#dialog6").hide(); 
     }
	 function close7(){
          $("#dialog7").hide(); 
     }
	  function close8(){
          $("#dialog8").hide(); 
     }
	  function close9(){
          $("#dialog9").hide(); 
     }
</script>
</html>