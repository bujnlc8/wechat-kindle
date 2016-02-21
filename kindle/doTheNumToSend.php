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
	return "y";
}else{
	return "n";
}
}
?>