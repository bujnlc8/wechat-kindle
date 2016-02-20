<?php 
require_once '../tool/valid.php';
require_once '../tool/connectMysql.php';
require_once '../tool/is_mobile.php';
require_once '../tool/isWechat.php';
require_once '../tool/sendmail.php';
define("database", "app_haihuiwechat");
$bookName = $_POST['bookName'];
$bookClass = $_POST['bookClass'];
$yema = $_REQUEST['yema'];
?>
<html>
<head>
<head><title>书籍列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
    <style type="text/css">
        td{font-size:0.8em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
        .bookname{font-size:0.8em;white-space:pre-line;overflow:visible !important;}
        .row a{
           width:15%;font-size:0.8em;text-decoration:none;padding:2px; text-align:center;
        }
    </style>
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/1.7.2/jquery.min.js"></script>
 <link rel="stylesheet" href="../res/materialize/css/materialize.min.css" />
 <link rel="stylesheet" href="../res/layer/skin/layer.css" />
  <script src="../res/materialize/js/materialize.min.js"></script>
  <script src="../res/layer/layer.js"></script>
</head>
<body>
<div width="100%">
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
      echo "<li><a href=\"logout.php\">注销</a></li>";
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
<form id="bookList" method="Post">
        <div class="row">
	     <div class="input-field col s3">
            <label for="bookName">书名</label><input name="bookName"  class="validate" id="bookName" type="text" value="<?php echo $bookName;?>"/>
          </div>
		  <div class="input-field col s3">  
			<select id ="bookClass" name="bookClass" >
			    <option value="" <?php if($bookClass==""){ echo "selected='selected'";}?> ></option>
			    <option value="1" 
                    <?php if($bookClass=="1"){echo "selected='selected'";}?>>IT编程</option>
				<option value="2"
					<?php if($bookClass=="2"){echo "selected='selected'";}?>>文学传记</option>
				<option value="3"
					<?php if($bookClass=="3"){echo "selected='selected'";}?>>诗歌散文</option>
				<option value="4"
					<?php if($bookClass=="4"){echo "selected='selected'";}?>>杂    志</option>
				<option value="5"
					<?php if($bookClass=="5"){echo "selected='selected'";}?>>经济金融</option>
				<option value="6"
					<?php if($bookClass=="6"){echo "selected='selected'";}?>>哲理读物</option>
				<option value="7"
					<?php if($bookClass=="7"){echo "selected='selected'";}?>>历史地理</option>
			</select>
			</div>
            <div class="input-field col s2">  
             <a  style="width:100%;" class="waves-effect waves-light btn" id="query" title="点击查询">Q</a></div>
             <div class="input-field col s2">  
		    <a style="width:100%;" class="waves-effect waves-light btn" id="reset" title="点击重置查询条件">R</a></div>
    </div>
<?php
$sql = "select bi.book_id,bi.book_name,bi.book_writer,bi.book_url,bi.book_class from bookinfo bi  where 1=1 ";
$sqlCount ="select count(*) from  bookinfo bi  where 1=1 ";
$con = getMysqlCon();
mysqli_select_db($con, database);
if ($bookName != "") {
    $sql .= "  and (bi.book_name like '%" . addslashes($bookName) . "%' or bi.book_writer like '%".addslashes($bookName) . "%') ";
    $sqlCount .= " and bi.book_name like '%" . addslashes($bookName) . "%' or bi.book_writer like '%".addslashes($bookName) . "%'";
}
if ($bookClass != "") {
    $sql .= " and bi.book_class ='" . $bookClass . "'";
    $sqlCount.= " and bi.book_class ='" . $bookClass . "'";
}
$sql .=" order by bi.book_name";
//echo $sql;
$start =((intval($yema,10))-1) * 7;
$sql.=" limit ".$start.",7";
$result = mysqli_query($con, $sql);
//$arr = mysqli_fetch_all($result);
$result2 =mysqli_query($con, $sqlCount);
$num = mysqli_fetch_row($result2)[0];
//$arrSize = count($arr);
if($num>0){
    // echo "<div><input type='button' value='删除'  onclick='deleteBooks();'/>";
    echo "<div class='table-responsive'><table class='bordered highlight' style=\"table-layout:fixed;width:100%;\"><tr><th style='width:6%'>序号</th><th width=25%>书名</th><th width=18%>作者</th><th style='width:25%'>链接</th>";
	if(!is_mobile()){
		echo "<th style='width:10%'>大小</th><th>操作</th></tr>";
	}else{
		echo "</tr>";
	}
}else{
    echo "<div class='table-responsive' style='width:100%;'><table class='bordered highlight'><tr><td align='center'>未查询到书籍！</td></tr>";
}
$xuhao=0;
while($book=mysqli_fetch_row($result)) {
    $xuhao++;
    echo "<tr class='success'><td>$xuhao</td><td class='bookname'>$book[1]</td><td>$book[2]</td>";
    if(!strstr($book[3],'链接')){
		if(!isWechat()){
		  if(!is_mobile()){
           echo  "<td style='font-size:0.7em;color:blue;' class='url'><a href='downloadFile.php?url=$book[3]&bookName=$book[1]' >".substr($book[3],48)."</a></td>";
		   $fileSize =remote_filesize($book[3]);
		   if($fileSize<=1048576){
			   $s =sprintf("%.2f",$fileSize/1024)."kB";
			   echo "<td>$s</td>";
		   }else{
			   $s =sprintf("%.2f",$fileSize/(1024*1024))."MB";
			   echo "<td>$s</td>";
		   }
		  if(strstr($book[3],'mobi')||(strstr($book[3],'azw')&&!strstr($book[3],'azw3'))){
              echo "<td><a href=\"javascript:sendTokindle('$book[3]','$book[1]')\">推送至kindle</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:deleteBook('$book[3]','$book[0]')\">删除</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:updateBookInfo('$book[0]','$book[1]','$book[2]','$book[4]')\">更新</a></td></tr>";
		  }else{
			  echo "<td><a href=\"javascript:sendTomail('$book[3]','$book[1]')\">发送到邮箱</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:deleteBook('$book[3]','$book[0]')\">删除</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:updateBookInfo('$book[0]','$book[1]','$book[2]','$book[4]')\">更新</a></td></tr>";
		  }
		 }else{
	         echo  "<td style='font-size:0.7em;color:blue;' class='url'><a href='downloadFile.php?url=$book[3]&bookName=$book[1]' >$book[3]</a></td></tr>";  
		 }
		}else{
		   echo  "<td style='font-size:0.7em;color:blue;' class='url'><a href='../downloadFileForWechat.php?url=$book[3]&bookName=$book[1]&writer=$book[2]' target='_blank'>$book[3]</a></td></tr>";
		}
    }else{
        $strArr =explode(" ",$book[3]);
        $u =$strArr[1];
        echo  "<td style='font-size:0.7em;color:blue;'><a href='$u' target='_blank'>";echo mb_substr($strArr[1],7,18)."...密码:$strArr[3]</a></td><td></td></tr>";
    }
   
}
echo "</table></div>";
if (is_int($num / 7)){ $yeshu= $num/7;}else{$yeshu=floor($num/7+1);}
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
	$('select').material_select();
});
$("#reset").click(function(){
 $("#bookName").val("");
 $("#bookClass").val("");
 $('select').material_select();
});
$("#query").click(function(){
	$("#yema").val("1");
	$("#bookList").attr("action","bookList.php").submit();
});
$("#first").click(function(){
    if(1==$("#yema").val()){
		alert("已是首页!");
    }else{
	$("#yema").val("1");
	$("#bookList").attr("action","bookList.php").submit();
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
	   $("#bookList").attr("action","bookList.php").submit();
	}
});
$("#up").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
	if(1==$("#yema").val()){
		alert("已到首页!");
	}else{
	   $("#yema").val(parseInt($("#yema").val())-1+"");
	   $("#bookList").attr("action","bookList.php").submit();
	}
});
$("#last").click(function(){
	var $zongyeshu =$("#zongyeshu").val();
     if($zongyeshu=="0"){
        return;
    }
	if($zongyeshu==$("#yema").val()){
		alert("已到最后一页!");
	}else{
	   $("#yema").val($zongyeshu);
	   $("#bookList").attr("action","bookList.php").submit();
	}
});
var flag = true;
function checkAll(){
	console.log(flag);
	if(flag){
	$(".bookids").prop("checked",true);
	flag =false;
	}else if(!flag){
		$(".bookids").prop("checked",false);
		flag =true;
     }
}
function deleteBook(url,id){
	$.ajax({
            url:"deleteBook.php",
            type:"post",
            data:{url:url,id:id},
            success:function(data){
                if(data=="y"){
                  alert("删除成功！");
                  window.location.reload();
                }else if(data=="n"){
                   alert("删除失败！");
                }
            }
        });
}
function sendTokindle(url,bookName){
    $.ajax({
            url:"../kindle/send2Kindle.php",
            type:"post",
            data:{url:url,bookName:bookName},
            success:function(data){
                if(data=="y"){
                  alert("推送成功！");
                }else if(data=="n"){
                   alert("推送失败！");
                }else if(data=="noEmail"){
				   alert("未添加kindle邮箱！");
				}else if(data=="l"){
				   alert("推送失败！，电子书太大");
				}
            }
        });
}
function sendTomail(url,bookName){
	layer.open({
            type: 2,
            title: "添加发送邮箱",
            shadeClose: true,
            shade: false,
           // maxmin: true, //开启最大化最小化按钮
            area: ['350px', '220px'],
            content: '../kindle/send2MailRouter.php?url='+url+"&bookName="+bookName
        });
}
function updateBookInfo(id,bookName,bookWriter,bookClass){
	layer.open({
            type: 2,
            title: bookName+'  书籍信息编辑',
            shadeClose: true,
            shade: false,
            maxmin: true, //开启最大化最小化按钮
            area: ['700px', '550px'],
            content: 'bookInfoEdit.php?id='+id+"&bookName="+bookName+"&bookWriter="+bookWriter+"&bookClass="+bookClass
        });
}
</script>
</html>