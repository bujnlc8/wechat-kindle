<?php 
function getMysqlCon(){
    $url = "SAE_MYSQL_HOST_M:SAE_MYSQL_PORT";
    $user = "SAE_MYSQL_USER";
    $password = "SAE_MYSQL_PASS";
    $con =  mysqli_connect ( SAE_MYSQL_HOST_M , SAE_MYSQL_USER, SAE_MYSQL_PASS ,SAE_MYSQL_DB,SAE_MYSQL_PORT);
    if (! $con) {
        die('连接出错: ' . mysql_error());
        return null;
    } else {
        return $con;
    }
}
?>