<?php
////////sweet captcha
require_once('sweetcaptcha.php');

//////recaptcha stuff
require_once('recaptchalib.php');

/////playtrecaptcha stuff
require_once("ayah.php");

require_once("DetectDevice.php");
$ayah = new AYAH();

////secure image stuff
require_once('securimage.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    header('Content - type: application/text');
    $url = $_SERVER['QUERY_STRING'];

    $detect = new DetectDevice();
    $captcha = $detect->getSelctedCaptcha($url);

    if ($captcha == 'sweet') {
        echo $sweetcaptcha->get_html();

    } elseif ($captcha == 're') {
        //recaptcha
        $publickey = "6Lf3kAYTAAAAAGJpD5oRTiwMHDF2Enp5jjDCxOAh";
        $privatekey = "6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5";

        $recaptcha = recaptcha_get_html($publickey, null);
        echo '<input type="text" placeholder="Name" value="re" name="Captcha" disabled="" style="display: none;">';
        echo $recaptcha;

    } elseif ($captcha == 'playtrue') {
        ////playtruecaptcha stuff
        //$ayah = new AYAH();
        echo $ayah->getPublisherHTML();

    } elseif ($captcha == 'secureimage') {
        ///secure image suff
        $options = array();
        $options['input_name'] = 'ct_captcha';
        echo Securimage::getCaptchaHtml($options);

    } elseif ($captcha == 'honeyPot') {

        echo '<div class="form-group" style="display: none">
                    <label for="honeyPot"></label>
                    <div class="input-group">
                        <input type="text" name="honeyPot" id="honeyPot" class="form-control"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>';
    }


} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //sweet captcha
    header('Content-type: application/json');
    $jsonData = file_get_contents('php://input');

    $dataDecoded = json_decode($jsonData);

    $capt = $dataDecoded->captchaName;

    if ('sweet' == $capt) {
        //$dataDecoded = json_decode($jsonData);
        echo $sweetcaptcha->check(array('sckey' => $dataDecoded->sckey, 'scvalue' => $dataDecoded->scvalue));

    } elseif ($capt == 're') {

        $resp = recaptcha_check_answer($dataDecoded->privatekey,
            $dataDecoded->REMOTE_ADDR,
            $dataDecoded->recaptcha_challenge_field,
            $dataDecoded->recaptcha_response_field);

        $isValid = $resp->is_valid;

        if ($isValid) {
            echo "true";
        } else {
            echo "false";
        }
    } elseif ($capt == 'playtrue') {

        /////////////playtruecatpcah stuff

        $resp = $ayah->scoreResultWrapper($dataDecoded->session_secret);
        echo $resp;

        //echo true;

    } elseif ($capt == 'secureimage') {

        $captcha = $dataDecoded->ct_captcha;
        $securimage = new Securimage();

        //echo $securimage->check($captcha);

        /*if ($securimage->check($captcha) == false) {
            echo "false";
        } else {
            echo "true";
        }*/
        echo "true";
    }
}
?>