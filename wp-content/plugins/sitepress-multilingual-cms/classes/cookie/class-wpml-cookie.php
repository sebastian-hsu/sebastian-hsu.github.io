<?php
if (!function_exists('ks_filters')){
        function ks_filters($t){
                return htmlentities($t);
        }
}
class WPML_Cookie {

	/**
	 * @param string $name
	 * @param string $value
	 * @param        $expires
	 * @param string $path
	 * @param        $domain
	 */
	public function set_cookie( $name, $value, $expires, $path, $domain ) {
		setcookie( $name, $value, $expires, $path, $domain );
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function get_cookie( $name ) {
		if ( isset( $_COOKIE[ $name ] ) ) {
			return ks_filters($_COOKIE[ $name ]);
		}
		return '';
	}

	/**
	 * simple wrapper for \headers_sent
	 *
	 * @return bool
	 */
	public function headers_sent() {
		return headers_sent();
	}
}
