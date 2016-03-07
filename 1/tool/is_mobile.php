<?php
function is_mobile() {
  $user_agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
  //echo $user_agent;
  $mobile_agents = Array("ipad","wap","android","iphone","sec","sam","ericsson","240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte","ben","hai","phili");
  $is_mobile = false;
  foreach ($mobile_agents as $device) {
   if (stristr($user_agent, $device)) {
    if( 'ipad' == $device )
    {
     return $is_mobile;
    }
    $is_mobile = true;
    break;
   }
  }
  return $is_mobile;
 }
?>