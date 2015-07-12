<?php
////////sweet captcha
require_once('sweetcaptcha.php');

//////recaptcha stuff
require_once('recaptchalib.php');

/////playtrecaptcha stuff
require_once("ayah.php");
//$ayah = new AYAH();

////secure image stuff
require_once('securimage.php');

	
	if($_SERVER['REQUEST_METHOD'] == "GET"){
		header('Content - type: application/text');
		
		$captcha='playtrue';
		
		if($captcha=='sweet'){
			echo $sweetcaptcha->get_html();
		
		}elseif($captcha=='re'){
			//recaptcha
			$publickey = "6Lf3kAYTAAAAAGJpD5oRTiwMHDF2Enp5jjDCxOAh";
			$privatekey = "6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5";
			echo recaptcha_get_html($publickey, null);
		
		}elseif($captcha=='playtrue'){
			////playtruecaptcha stuff
			$ayah = new AYAH();
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
		} elseif($capt=='re'){
		
		
		//recaptcha stuff
		//header('Content-type: application/json');
		//$jsonDat= file_get_contents('php://input');
		
		//$jsonData = json_decode($jsonDat);
		 
		// Result: object(stdClass)#1 (2) { ["foo"]=> string(3) "bar" ["cool"]=> string(4) "attr" }
		var_dump($dataDecoded);
		
		$resp = recaptcha_check_answer ($dataDecoded->privatekey,
                                        $dataDecoded->REMOTE_ADDR,
                                        $dataDecoded->recaptcha_challenge_field,
                                        $dataDecoded->recaptcha_response_field);
										
		echo $resp->is_valid;
		
		}elseif($capt=='playture'){								
		
		/////////////playtruecatpcah stuff
		//header('Content-type: application/json');
		//$jsonDat= file_get_contents('php://input');
		
		$jsonData = json_decode($jsonDat);
		 
		// Result: object(stdClass)#1 (2) { ["foo"]=> string(3) "bar" ["cool"]=> string(4) "attr" }
		var_dump($jsonData);

		$resp=$ayah->scoreResultWrapper($jsonData->session_secret);
		echo $resp;
		
		} elseif($capt='secureimage'){
		///////////////////secure image captcha
		//require_once('securimage.php');
		//header('Content-type: application/json');
		//$jsonDat= file_get_contents('php://input');
		
		$jsonData = json_decode($jsonDat);
		 
		// Result: object(stdClass)#1 (2) { ["foo"]=> string(3) "bar" ["cool"]=> string(4) "attr" }
		var_dump($jsonData);
		
		//echo $jsonData->ct_captcha;

		$captcha = $jsonData->ct_captcha;
		$securimage = new Securimage();

		$securimage->check($captcha); 
		
			if ($securimage->check($captcha) == false) {
				echo true;
			}else{
				echo false;
			}   
		
		}
	}

?>