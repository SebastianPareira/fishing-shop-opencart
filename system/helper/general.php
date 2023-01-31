<?php
function token($length = 32) {
	// Create random token
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	
	$token = '';
	
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}	
	
	return $token;
}

/**
 * Backwards support for timing safe hash string comparisons
 * 
 * http://php.net/manual/en/function.hash-equals.php
 */

if(!function_exists('hash_equals')) {
	function hash_equals($known_string, $user_string) {
		$known_string = (string)$known_string;
		$user_string = (string)$user_string;

		if(strlen($known_string) != strlen($user_string)) {
			return false;
		} else {
			$res = $known_string ^ $user_string;
			$ret = 0;

			for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);

			return !$ret;
		}
	}
}

if (!function_exists('get_app_domain')) {
	function get_app_domain()
	{
		$parts = parse_url(HTTPS_SERVER);
		return !empty($parts['host'])
			? $parts['host']
			: 'localhost';
	}
}

if (!function_exists('get_guest_email')) {
	function get_guest_email()
	{
		return 'guest@' . get_app_domain();
	}
}

if (!function_exists('clear_string')) {
	function clear_string($str)
	{
		return trim(
			strip_tags(
				html_entity_decode($str, ENT_QUOTES, 'UTF-8')
			)
		);
	}
}

if (!function_exists('get_static_routes')) {
	function get_static_routes()
	{
		$routes = array(
			'account/voucher',
			'account/wishlist',
			'account/account',
			'account/login',
			'account/logout',
			'account/order',
			'account/newsletter',
			'account/forgotten',
			'account/download',
			'account/return',
			'account/transaction',
			'account/register',
			'account/edit',
			'account/password',
			'account/address',
			'account/reward',
			'account/return/insert',
			'account/return/add',

			'affiliate/account',
			'affiliate/edit',
			'affiliate/password',
			'affiliate/payment',
			'affiliate/tracking',
			'affiliate/transaction',
			'affiliate/logout',
			'affiliate/forgotten',
			'affiliate/register',
			'affiliate/login',

//		'blog/blog',

			'checkout/cart',
			'checkout/checkout',
			'checkout/voucher',
			'checkout/success',

			'information/contact',
			'information/sitemap',

			'product/special',
			'product/manufacturer',
			'product/compare',
			'product/search',
		);

		return array_combine($routes, $routes);
	}
}