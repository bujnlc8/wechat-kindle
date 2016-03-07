<?php 
function insertLog($object,$response){
    $con = getMysqlCon();
    $content = $object->Content =="" ? $object->Recognition: $object->Content ;
    $openid = $object->FromUserName;
    $sql ="insert into userlog(user_id,req_word,response)values('".$openid."','".$content."','".$response."')";
    mysqli_select_db($con, "app_haihuiwechat");
    mysqli_query($con, $sql);
}
function insertBookLog($openid,$bookName,$content){
	$con = getMysqlCon();
    $sql ="insert into userlog(user_id,req_word,response)values('".$openid."','".$bookName."','".$content."')";
    mysqli_select_db($con, "app_haihuiwechat");
    mysqli_query($con, $sql);
}
?>