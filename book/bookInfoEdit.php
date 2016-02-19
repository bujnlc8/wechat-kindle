<?php
$id=$_GET['id'];
$bookName=$_GET['bookName'];
$bookWriter=$_GET['bookWriter'];
$bookClass=$_GET['bookClass'];
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
        <div class="input-field col s8">
        <input type="text" id="bookName" name="bookName"  class="validate" value="<?php echo $bookName;?>"><label for="bookName">书名</label>
        </div>
 </div>
 <div class="row">
        <div class="input-field col s8">
        <input type="text" id="writer" name="writer"  class="validate" value="<?php echo $bookWriter;?>"> <label for="writer">作者</label>
        </div>
 </div>
 <div class="row">
 <input type="radio"  <?php if($bookClass=="1") echo "checked=\"checked\"";?> name="bookClass" value="1"  id="1"/><label for="1">IT编程</label>&nbsp;
 <input type="radio" <?php if($bookClass=="2") echo "checked=\"checked\"";?>  name="bookClass" value="2"  id="2"/><label for="2">文学传记</label>&nbsp;
 <input type="radio"  <?php if($bookClass=="3") echo "checked=\"checked\"";?> name="bookClass" value="3"  id="3"/><label for="3">诗歌散文</label>&nbsp;
 <input type="radio"  <?php if($bookClass=="4") echo "checked=\"checked\"";?> name="bookClass" value="4"  id="4"/><label for="4">杂志</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="radio"  <?php if($bookClass=="5") echo "checked=\"checked\"";?> name="bookClass" value="5"  id="5"/><label for="5">经济金融</label>&nbsp;
 <input type="radio"  <?php if($bookClass=="6") echo "checked=\"checked\"";?> name="bookClass" value="6"  id="6"/><label for="6">哲理读物</label>&nbsp;
 <input type="radio" <?php if($bookClass=="7") echo "checked=\"checked\"";?>  name="bookClass"  value="7"    id="7"/><label for="7">历史地理</label>&nbsp;
 </div> 
 <div class="row">
        <div class="input-field col s8">
          <textarea id="textarea1" class="materialize-textarea" name="bookDesc" id="bookDesc"></textarea>
          <label for="textarea1">简介</label>
        </div>
 </div>
 <div style="margin-top:1%;">
 <a class="waves-effect waves-light btn" id="sub">确定</a>
 </div>
<input type="hidden" value="<?php echo $id;?>" id="bookId"/>
</form>
</body>
<script>
$("#sub").click(function(){
    var bookId= $("#bookId").val();
	var bookName= $("#bookName").val();
	var writer= $("#writer").val();
	var bookClass= $("input[name='bookClass']:checked").val();
	var bookDesc= $("#bookDesc").val();
    $.ajax({
	  url:"doEditBookInfo.php",
	  type:"post",
	  data:{bookId:bookId,bookName:bookName,bookClass:bookClass,bookDesc:bookDesc,writer:writer},
	  success:function(data){
		if(data=="y"){
			layer.alert('修改成功', {
            skin: 'layui-layer-molv'
           ,closeBtn: 0
           ,shift: 4 //动画类型
          },function(){
			var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭			
		});	
		}else{
			layer.alert('修改失败', {
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