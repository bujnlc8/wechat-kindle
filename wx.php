<?php
define("TOKEN", "haihuiling");
require_once 'tool/connectMysql.php';
require_once 'getUserInfoWechat.php';
require_once 'log/log.php';
$wechatObj = new wechatCallbackapiTest ();
if (!isset ($_GET ['echostr'])) {
    $wechatObj->responseMsg();
} else {
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    // 验证签名
    public function valid()
    {
        $echoStr = $_GET ["echostr"];
        $signature = $_GET ["signature"];
        $timestamp = $_GET ["timestamp"];
        $nonce = $_GET ["nonce"];
        $token = TOKEN;
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $echoStr;
            exit ();
        }
    }

     private function transmitText($object, $content)
    {
        if (!isset ($content) || empty ($content)) {
            return "";
        }
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    
    public function responseMsg()
    {
        $postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
        if (!empty ($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', 

LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            $result = "";
            switch ($RX_TYPE) {
                case "event" :
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text" :
				    if($postObj->Content=="?"||$postObj->Content=="？"){
						$result =$this->help($postObj);
					}else{
						$result = $this->returnBookurl($postObj,0);
					}
                    break;
                case "voice":
                   $result = $this->returnBookurl($postObj,1);
                    break;   

            }
            echo $result;
        } else {
            echo "";
            exit ();
        }
    }
	private function help($object){
		$out ="回复作者或书名搜索书籍，也支持语音搜索哦/::D";
		$result = $this->transmitText($object, $out);
        return $result;
	}
    private function receiveEvent($object)
    {
        switch ($object->Event) {
            case "subscribe":
                $content = "感谢您关注haihuiling的电子书分享微信号!\n回复任意字符查询相关书籍!/:rose";
                break;
            case "unsubscribe":
                $this->deleteUser($object);
                break;
            case "CLICK":
 
                $content = $object->EventKey; // 获取key
 
                if($content=='haihuilingWeixinBook'){
                     
                    $content = "这是一个个人电子书分享公众号，里面包含了这几年我收集的所有电子书，大部分为原版,大家可以根据自己的需要免费获取。由于考虑到费用问题，当前每位用户每天只能推送20次。另外,下载的书籍严禁商用，如果有任何疑问，请联系微信 haihuilingHuster ,谢谢大家的支持！最后祝大家阅读愉快！";
 
                }
                break;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }
  private function returnBookurl($object,$type){
       //insertLog($object);
      if($type==0){
       $bookName = $object->Content;
      }else if($type==1){
       $bookName = mb_substr($object->Recognition,0,-1,'utf-8');
      }
       $access_token = getAccessToken();
       $json = getInfo($access_token, $object->FromUserName);
       $openid = $json->openid;
       $nickname = $json->nickname;
       $sex =$json->sex;
       $province =$json->province;
       $city =$json->city;
       $bookurl = "sorry,未找到您要的书籍！";
       $item_str = "";
       $itemTpl = "<item><Title><![CDATA[%s]]></Title>
                             <Description><![CDATA[%s]]></Description>
                              <PicUrl><![CDATA[%s]]></PicUrl>
                              <Url><![CDATA[%s]]></Url>
                             </item>";
       $num = 0;
       if (isUserValid($openid)) {
            if (null!=$bookName&&$bookName != "") {
                $con = getMysqlCon();
                $sql = "select bi.book_url,bi.book_name,bi.book_writer from bookinfo bi where bi.book_name like '%" . trim($bookName) . "%' or bi.book_writer like '%" . trim($bookName). "%'" ;
                mysqli_select_db($con, "app_haihuiwechat");
                mysqli_set_charset($con, "utf-8");
                if ( $result = mysqli_query($con, $sql)) {
                    if (mysqli_num_rows($result) == 0) {
                        $bookurl = "sorry,未找到您要的书籍！";
                    }else{
                    $bookurl = "总共为您找到" . mysqli_num_rows($result) . "本相关书籍,点击查看"; 
					$pic =rand(0,15).".png";
                    $item_str .= sprintf($itemTpl, $bookurl, $bookurl, "http://haihuiwechat.sinaapp.com/res/img/".$pic,  "http://haihuiwechat.sinaapp.com/bookListForWechat.php?bookName=".trim($bookName)."&openid=".$openid);
                    while ($row = mysqli_fetch_array($result)) {
                        if($num%2==0){
                            $item_str .= sprintf($itemTpl, $row['book_name'] . "-" . $row['book_writer'], $row['book_name'], "http://haihuiwechat.sinaapp.com/res/img/book_brown.png", "http://haihuiwechat.sinaapp.com/bookDetail.php?bookurl=".$row['book_url']."&bookName=".$row['book_name']."&openid=".$openid."&writer=".$row['book_writer']);
                        }else{
                        $item_str .= sprintf($itemTpl, $row['book_name'] . "-" . $row['book_writer'], $row['book_name'], "http://haihuiwechat.sinaapp.com/res/img/book_green.png", "http://haihuiwechat.sinaapp.com/bookDetail.php?bookurl=".$row['book_url']."&bookName=".$row['book_name']."&openid=".$openid."&writer=".$row['book_writer']);  
                       }
                        $num++;
                        if($num==8){
                            break;
                         }
                      }
                     $item_str .= sprintf($itemTpl, $bookurl, $bookurl, "http://haihuiwechat.sinaapp.com/res/img/more1.png", "http://haihuiwechat.sinaapp.com/bookListForWechat.php?bookName=".trim($bookName)."&openid=".$openid);   
                    }
                    //mysqli_free_result($result);
                  }
                //mysqli_close($con);
            }
       }else{
           $bookurl ="sorry,您还未注册，请点击<a href=\"http://haihuiwechat.applinzi.com/user/userZhuce.php?id=".$openid."&nickname=".$nickname."&sex=".$sex."&province=".$province."&city=".$city."\">此处</a>👈注册。";
           $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
        insertLog($object,$bookurl);
        $r = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $bookurl);
        return $r;
       }
       if($bookurl != "sorry,未找到您要的书籍！"){
       $xmlTpl = "<xml>
       <ToUserName><![CDATA[%s]]></ToUserName>
       <FromUserName><![CDATA[%s]]></FromUserName>
       <CreateTime>%s</CreateTime>
       <MsgType><![CDATA[news]]></MsgType>
       <ArticleCount>%s</ArticleCount>
       <Articles>
       $item_str</Articles>
       </xml>";
       insertLog($object,$bookurl);
       $r = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $num+2 );
       return $r;
      }else{
            $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
        insertLog($object,$bookurl);
        $r = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $bookurl);
        return $r;  
        }
    }
    //取消关注的时候删除userid
    private function deleteUser($object){
      $openid = $object->FromUserName;
      $con = getMysqlCon();
      $sql ="delete from userinfo where user_id='".$openid."'";
      $sql2 ="update  yaoqingCode set restNum = restNum + 1";
      mysqli_select_db($con, "app_haihuiwechat");
      mysqli_query($con, $sql);
      if(mysqli_affected_rows($con)>0){
         mysqli_query($con, $sql2);
       }
      mysqli_close($con);  
    }
}
?>