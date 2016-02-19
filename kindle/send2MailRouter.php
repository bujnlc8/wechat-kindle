<?php
$url=$_GET['url'];
$bookName=$_GET['bookName'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<style type="text/css">
</style>
  <link rel="stylesheet" href="../res/materialize/css/materialize.min.css" />
  <link rel="stylesheet" href="../res/layer/skin/layer.css" />
  <script src="../res/materialize/js/materialize.min.js"></script>
  <script src="../res/layer/layer.js"></script>
</head>
<body>
 <div class="row">
<form  class="col s12">
 <div class="row">
        <div class="input-field col s12">
        <input type="email" id="email" name="email"  class="validate" value=""><label for="email">邮箱:</label>
        </div>
 </div>
 <div style="margin-top:1%;">
 <a class="waves-effect waves-light btn" id="sub" style="width:100%">确定</a>
 </div>
<input type="hidden" value="<?php echo $url;?>" id="url"/>
<input type="hidden" value="<?php echo $bookName;?>" id="bookName"/>
</form>
</body>
<script>
$("#sub").click(function(){
    var email= $("#email").val();
	var url= $("#url").val();
	var bookName= $("#bookName").val();
	 $.ajax({
            url:"send2MailUrl.php",
            type:"post",
            data:{url:url,bookName:bookName,email:email},
            async:false,
            success:function(data){
			if(data=="y"){
            layer.alert('发送成功', {
            skin: 'layui-layer-molv'
           ,closeBtn: 0
           ,shift: 4 //动画类型
          },function(){
			var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭			
		});	
		}else{
			layer.alert('发送失败', {
            skin: 'layui-layer-molv'
           ,closeBtn: 0
           ,shift: 3 //动画类型
          });
		}
       }
    });
});
</script>
</html>