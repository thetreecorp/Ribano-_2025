<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI =& get_instance();
$recaptcha = $CI->db->select('*')->from('dbt_security')->where('keyword', 'capture')->get()->row();
$security_decode = json_decode($recaptcha->data, TRUE);


$language = $CI->db->select('language')->get('setting')->row();

if ($language->language=='french') {
	$lang = 'fr';
}
else{
	$lang = 'en';
}

// To use reCAPTCHA, you need to sign up for an API key pair for your site.
// link: http://www.google.com/recaptcha/admin
$config['recaptcha_site_key']   = @$security_decode['site_key'];
$config['recaptcha_secret_key'] = @$security_decode['secret_key'];

// reCAPTCHA supported 40+ languages listed here:
// https://developers.google.com/recaptcha/docs/language
$config['recaptcha_lang'] = @$lang;

/* End of file recaptcha.php */
/* Location: ./application/config/recaptcha.php */