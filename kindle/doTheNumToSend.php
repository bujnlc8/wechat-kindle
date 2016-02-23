<?php 
function updateTheNum($openid){
$con = getMysqlCon();
$sql ="update userinfo set num=num+1 where user_id='".$openid."'";
mysqli_select_db($con, "app_haihuiwechat");
mysqli_query($con, $sql);
mysqli_close($con);
}
function getTheNum($openid){
$con = getMysqlCon();
$sql ="select num from userinfo  where user_id='".$openid."'";
mysqli_select_db($con, "app_haihuiwechat");
$result=mysqli_query($con, $sql);
while($row=mysqli_fetch_array($result)){
	$num = $row['num'];
}
mysqli_close($con);
return $num;
}
function resetTheNum(){
$con = getMysqlCon();
$sql ="update userinfo set num= 0 ";
mysqli_select_db($con, "app_haihuiwechat");
$result = mysqli_query($con, $sql);
if($result){
	mysqli_close($con);
	return "y";
}else{
	mysqli_close($con);
	return "n";
  }
}
function sendMailToMe(){
	$con = getMysqlCon();
	$today = strtotime(date('y-m-d'));
    $todayEnd = strtotime(date('y-m-d')." +1 day")-1;
    $sql="select response from  userlog where  response like '%成功%' and  (unix_timestamp(req_time) between $today and  $todayEnd )";
	mysqli_select_db($con,"app_haihuiwechat");
	$result = mysqli_query($con,$sql);
	$size = mysqli_num_rows($result);
	$out= date('y-m-d',time())."总共为用户发送了 <b> $size </b>本书,如下：<br/>";
	while($row = mysqli_fetch_array($result)){
		$num++;
		$out.= ($num.".".$row['response'] .";<br/>");
	}
	return $out;
}
?>