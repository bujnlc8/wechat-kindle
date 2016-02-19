<?php
//为何只能下载8192字节
function downfile($fileurl,$fileName)
{
Header( "Content-type:application/octet-stream");
Header( "Accept-Ranges:bytes");
Header( "Content-Disposition: attachment;filename=$fileName");
$file =fopen($fileurl, "rb");
// 输出文件
//fpassthru($file); 
// 关闭文件
//fclose($file);
readfile($fileurl);
}
$url = $_GET['url'];
$bookName = str_replace(' ','',$_GET['bookName']);
$strArr = explode('.',$url);
$fileName = $bookName.".".$strArr[4];
//downfile($url,$fileName);
$domain = "weixinbook";
$filename = substr($url,48);

$stor = new SaeStorage();

//if( !$stor->fileExist($domain, $filename) )
   // die();
$attr = $stor->getAttr($domain, $filename);
header('Content-type: '.$attr['content_type']);
header('Content-length: '.$attr['length']);
header('Content-Disposition: attachment; filename="'.$fileName.'"');
echo $stor->read($domain, $filename);
?> 