<?php 
function insertLog($object,$response){
    $con = getMysqlCon();
    $content = $object->Content;
    $openid = $object->FromUserName;
    $sql ="insert into userlog(user_id,req_word,response)values('".$openid."','".$content."','".$response."')";
    mysqli_select_db($con, "app_haihuiwechat");
    mysqli_query($con, $sql);
}
?>