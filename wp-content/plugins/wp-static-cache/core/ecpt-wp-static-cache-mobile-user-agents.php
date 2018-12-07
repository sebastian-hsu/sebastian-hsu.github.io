<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

/* Smartphones */
global $static_cache_wptouch_smartphone_list;
$static_cache_wptouch_smartphone_list = array(
	array( 'iPhone' ), 								// iPhone
	array( 'iPod', 'Mobile' ),						// iPod touch
	array( 'Android', 'Mobile' ), 					// Android devices
	array( 'Opera', 'Mini/7' ), 					// Opera Mini 7
	array( 'BB', 'Mobile Safari' ), 				// BB10 devices
	array( 'BlackBerry', 'Mobile Safari' ),			// BB 6, 7 devices
	array( 'IEMobile/10', 'Touch' ),				// Windows IE 10 touch devices
	array( 'IEMobile/11', 'Touch' ),				// Windows IE 11 touch devices
	array( 'Firefox', 'Mobile' ),					// Firefox OS devices
	'IEMobile/7.0',									// Windows Phone OS 7
	'IEMobile/9.0',									// Windows Phone OS 9
	'webOS'											// Palm Pre/Pixi
);
function static_cache_user_agent_matches( $browser_user_agent, $user_agent_to_check ) {
	$is_detected = true;
	if ( is_array( $user_agent_to_check ) ) {
		$check_against = $user_agent_to_check;
	} else {
		$check_against = array( $user_agent_to_check );
	}
	foreach( $check_against as $this_user_agent ) {
		$friendly_agent = preg_quote( $this_user_agent );

		if ( !preg_match( "#$friendly_agent#i", $browser_user_agent ) ) {
			$is_detected = false;
			break;
		}
	}
	return $is_detected;
}
// 判断是否来自手机端
function static_cache_is_from_mobile_device() {
	global $static_cache_wptouch_smartphone_list;
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	// Figure out the active device type and the active device class
	foreach( $static_cache_wptouch_smartphone_list as $agent ) {
		if ( static_cache_user_agent_matches( $user_agent, $agent ) ) {
			$agent_ok = true;

			return true;
		} 
	}

	return false;
}
?>