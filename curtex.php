<?php
include_once('webClient.php');

	class test extends webClient{

	//public $url="http://localhost:81/resttest/rest/test/deviceDependent/status.php";
	
	function getCaptcha($capacha){
		$url="http://localhost:81/resttest/rest/test/deviceDependent/status.php";
		$this->httpGet($url);
	}
	
	function wrapContent(){
	
	}
	
	function validateCaptcha(){
	
	}
		
	}

	$api=new test();
	//$api->processApi();
	//echo $api->httpGet("http://localhost:81/resttest/rest/test/deviceDependent/status.php");

?>

<?php

// require sweetcaptcha php sdk, don't forget to set up your credentials first
//require_once('sweetcaptcha.php');

if (empty($_POST)) {
  // print sweetcaptcha in your form
?>

  <form method="post">
    <p>You can set up it normally as you like <input type="text" name="name" value="" placeholder="Name" /></p>
    <!-- implement sweetcaptcha -->
    <?php echo $api->httpGet("http://localhost:81/resttest/rest/test/deviceDependent/status.php"); 
			//echo $api->getCaptcha(null);
	?>
    <!-- continue with your form -->
    <input type="submit" />
  </form>

<?php

} else { 

	$data = $_POST;
	$url="http://localhost:81/resttest/rest/test/deviceDependent/status.php";
	
	//$captcha =""
	
	///sweet catpcha
	if (isset($_POST['sckey']) and isset($_POST['scvalue'])) {
		$data['captchaName'] = 'sweet';
	}
   
	/////////// recaptcha stuff
	
	if (isset($_POST["recaptcha_response_field"])) {
		$data['captchaName'] = 're';
		$data['privatekey'] = '6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5';
		$data['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
					
	}
	
	
	////playtruecaptcha stuff
	
    if(array_key_exists("session_secret", $_REQUEST)) {
		$data['captchaName'] = 'playtrue';
		/*$data = array(
		"session_secret" => '$_REQUEST["session_secret"]'
		);*/
		$data['session_secret'] = $_REQUEST["session_secret"];
		
		//echo "playtrue";
        
	}
	
	//secureimage stuff
	if (isset($_POST["ct_captcha"]) ){
	
		$data['captchaName'] = 'secureimage';
		$data['ct_captcha'] = $_POST['ct_captcha'];
		///secure image captcha stuff
		/*$data = array(
		"ct_captcha" => @$_POST['ct_captcha']
		);*/
	}
	
		$jsonString= $api->httpPost($url,$data);
		echo $jsonString;
}

?>
  
  