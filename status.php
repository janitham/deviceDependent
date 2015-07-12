<?php
////////sweet captcha
require_once('sweetcaptcha.php');

//////recaptcha stuff
require_once('recaptchalib.php');

/////playtrecaptcha stuff
require_once("ayah.php");
$ayah = new AYAH();

////secure image stuff
require_once('securimage.php');

	
	if($_SERVER['REQUEST_METHOD'] == "GET"){
		header('Content - type: application/text');
		
		$captcha='secureimage';
		
		if($captcha=='sweet'){
			echo $sweetcaptcha->get_html();
		
		}elseif($captcha=='re'){
			//recaptcha
			$publickey = "6Lf3kAYTAAAAAGJpD5oRTiwMHDF2Enp5jjDCxOAh";
			$privatekey = "6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5";
			echo recaptcha_get_html($publickey, null);
		
		}elseif($captcha=='playtrue'){
			////playtruecaptcha stuff
			//$ayah = new AYAH();
			echo $ayah->getPublisherHTML();
		
		}elseif($captcha=='secureimage'){
		///secure image suff
		$options = array();
		$options['input_name'] = 'ct_captcha';
		echo Securimage::getCaptchaHtml($options);
		}
		
		

	
	}else if($_SERVER['REQUEST_METHOD'] == "POST"){
		
		//sweet captcha
		header('Content-type: application/json');
		$jsonData= file_get_contents('php://input');
		
		$dataDecoded = json_decode($jsonData);
		
		
		//$capt=$cap;
		
		$capt =$dataDecoded->captchaName;
		
		if('sweet'==$capt){
		//$dataDecoded = json_decode($jsonData);
		echo $sweetcaptcha->check(array('sckey' => $dataDecoded->sckey, 'scvalue' => $dataDecoded->scvalue));
		} 
		elseif($capt=='re'){
		
		
		//recaptcha stuff
		var_dump($dataDecoded);
		
		$resp = recaptcha_check_answer ($dataDecoded->privatekey,
                                        $dataDecoded->REMOTE_ADDR,
                                        $dataDecoded->recaptcha_challenge_field,
                                        $dataDecoded->recaptcha_response_field);
										
		echo $resp->is_valid;
		}
		elseif($capt=='playtrue'){								
		
		/////////////playtruecatpcah stuff
		var_dump($dataDecoded);

		$resp=$ayah->scoreResultWrapper($dataDecoded->session_secret);
		echo $resp;
		
		//echo true;
		
		} 
		elseif($capt=='secureimage'){
		var_dump($dataDecoded);
		
		$captcha = $dataDecoded->ct_captcha;
		$securimage = new Securimage();

		//echo $securimage->check($captcha); 
		
			if ($securimage->check($captcha) == false) {
				echo false;
			}else{
				echo true;
			}   
		echo true;
		}
	}

?>