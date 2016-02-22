<?php
require_once '../res/PHPMailer/PHPMailerAutoload.php';
function sendMail($url,$filename,$kindleMail,$email,$pass,$subject,$con){
if(remote_filesize($url)<8380000){
	httpcopy($url,SAE_TMP_PATH.$filename);
}else{
	if($subject=="kindle电子书"){
		return "l";
	}
}
$mail = new PHPMailer;
$mail->setLanguage('zh', 'res/PHPMailer/language/');                            // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.qq.com';                // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $email;                   // SMTP username
$mail->Password = $pass;                  // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$mail->CharSet = "utf-8";
$mail->setFrom($email, "电子书分享微信号");
$mail->addAddress($kindleMail, 'Kindle');     // Add a recipient        
$mail->addReplyTo('75124771@qq.com', 'Information');
//$mail->addCC('18602739340@163.com');
//$mail->addBCC('bcc@example.com');
$mail->addAttachment(SAE_TMP_PATH.$filename,$filename);  // Add attachments  
//$mail->addAttachment('img/1.png', 'bug.png');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $con;
$mail->AltBody = $con;

if(!$mail->send()) {
    return 'n';
} else {
    return 'y';
 }
}
function remote_filesize($url_file){ 
    $headInf = get_headers($url_file,1); 
    return $headInf['Content-Length']; 
}
function httpcopy($url, $file="", $timeout=100) {
    $file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
    $dir = pathinfo($file,PATHINFO_DIRNAME);
    !is_dir($dir) && @mkdir($dir,0755,true);
    $url = str_replace(" ","%20",$url);
 
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $temp = curl_exec($ch);
        if(@file_put_contents($file, $temp) && !curl_error($ch)) {
            return $file;
        } else {
            return false;
        }
    } else {
        $opts = array(
            "http"=>array(
            "method"=>"GET",
            "header"=>"",
            "timeout"=>$timeout)
        );
        $context = stream_context_create($opts);
        if(@copy($url, $file, $context)) {
            return $file;
        } else {
            return false;
        }
    }
}
?>