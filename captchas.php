<?php

////////sweet captcha
require_once('sweetcaptcha.php');
require_once('recaptchalib.php');
require_once("ayah.php");
require_once("ayah.php");

//////recaptcha stuff
/*require_once('recaptchalib.php');
// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6Lf3kAYTAAAAAGJpD5oRTiwMHDF2Enp5jjDCxOAh";
$privatekey = "6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;
*/

/////playtrecaptcha stuff
/*require_once("ayah.php");
$ayah = new AYAH();
*/

////secure image stuff

require_once('securimage.php');

	//class captchas{
	
	/*public function __captchas(){
	
	}*/
	
	function getHtmlByName($captcha){
	
		if($captcha=='sweet'){
		//sweet-captcha
		//$sweetcaptcha = new $sweetcaptcha(237528,'1bdea965d3b5c76f8e181497c7f13a42','22e2f639510c142c5217bc7324fb0ba2','sweetcaptcha.php');
		//require_once('sweetcaptcha.php');
		return $sweetcaptcha->get_html();
		
		}elseif($captcha=='re'){
		//recaptcha
		$publickey = "6Lf3kAYTAAAAAGJpD5oRTiwMHDF2Enp5jjDCxOAh";
		$privatekey = "6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5";
		return recaptcha_get_html($publickey, null);
		
		}elseif($captcha=='playtrue'){
		////playtruecaptcha stuff
		$ayah = new AYAH();
		return $ayah->getPublisherHTML();
		
		}elseif($captcha=='secureimage'){
		///secure image suff
		$options = array();
		$options['input_name'] = 'ct_captcha';
		return Securimage::getCaptchaHtml($options);
		}
	}
	
	//}

?>