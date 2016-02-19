<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />  
<script type="text/javascript"
	src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
   </style>
  <link rel="stylesheet" href="../res/materialize/css/materialize.min.css" />
  <script src="../res/materialize/js/materialize.min.js"></script>
</head>
<body>
    <div style="margin-top:10%;"  class="container">
<label>输入邀请码：</label><input type="text" id="yaoqingCode" name="yaoqingCode" onblur="checkValid();" style="display:block;width:16em;"/>
 <a class="waves-effect waves-light btn" id="zhuce" style="display:none;">go注册</a><label id="tip" style="display:none;color:red" class="z-depth-2"></label>
</div>
</body>
<script type="text/javascript">
$(function(){
	$("#yaoqingCode").focus();
	$("#zhuce").click(function(){
		 window.location.href="yaoqingSuccess.php?yaoqingCode="+$("#yaoqingCode").val();
	});
});
function checkValid(){
    $.ajax({
        url:"checkYaoqingCodeValid.php",
        data:{yaoqingCode:$("#yaoqingCode").val()},
        type:"post",
        success:function(data){
            console.log(data);
            if(data=="y"){
                $("#zhuce").show();
                $("#tip").hide();
            }else if(data="n"){
          	  $("#zhuce").hide();
          	  $("#tip").html("邀请码无效！").show();
              }
          }
        });
}
</script>
</html>