<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx499c2c5b13385e7e", "d4624c36b6795d1d99dcf0547af5443d");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  
</body>
<script src="../res/js/jweixin.js"></script>
<script>
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      'hideOptionMenu'
    ]
  });
  wx.ready(function () {
    wx.hideOptionMenu();
  });
</script>
</html>
