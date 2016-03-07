<?php 
function isWechat(){ 
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
	}	
	return false;
}