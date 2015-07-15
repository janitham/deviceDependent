<?php

/**
 *  Created by PhpStorm.
 * User: Nemina
 * Date: 7/13/2015
 * Time: 11:13 AM
 */
class deviceDependentAPI
{

    const URL = "http://localhost:9090/devicedependent/status.php";

    public function getCAPTCHA()
    {

        foreach (getallheaders() as $name => $value) {
            if ($name == "User-Agent") {
                $useragent = $value;
            }
        }

        if (isset($_COOKIE['screen-width'])) {

            $width = $_COOKIE['screen-width'];
        } else {

            $width = '1020';
        }

        if (isset($_COOKIE['screen-height'])) {

            $height = $_COOKIE['screen-height'];
        } else {

            $height = '720';
        }

        if (isset($_COOKIE['isTouch'])) {

            $isTouch = $_COOKIE['isTouch'];
        } else {

            $isTouch = 'false';
        }

        $getUrl = Self::URL . '?' . urlencode('userAgent=' . $useragent . '&screen-width=' . $width . '&screen-height=' . $height . '&isTouch=' . $isTouch);

        // 1. initialize

        $ch = curl_init();
        // 2. set the options, including the url

        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 3. execute and fetch the resulting HTML output

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public function getHoneyPot()
    {

        $getUrl = Self::URL . '?' . urlencode('isHoneyPot=true');

        // 1. initialize

        $ch = curl_init();
        // 2. set the options, including the url

        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 3. execute and fetch the resulting HTML output

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    function Validate($params)
    {
        $postData = Self::PostCaptcha($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, Self::URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    function PostCaptcha($params)
    {

        //reCaptcha
        if (isset($params["recaptcha_response_field"])) {

            $params['captchaName'] = 're';
            $params['privatekey'] = '6Lf3kAYTAAAAAEMVCybX4IDJtl_uEpJKuQsPc8Q5';
            $params['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
        }


        ///sweet catpcha
        if (isset($params['sckey']) and isset($params['scvalue'])) {
            $params['captchaName'] = 'sweet';
        }

        ////playtruecaptcha stuff

        if (array_key_exists("session_secret", $_REQUEST)) {
            $params['captchaName'] = 'playtrue';
            /*$data = array(
            "session_secret" => '$_REQUEST["session_secret"]'
            );*/
            $params['session_secret'] = $_REQUEST["session_secret"];


        }

        //secureimage stuff
        if (isset($params["ct_captcha"])) {

            $params['captchaName'] = 'secureimage';
            //$params['ct_captcha'] = $_POST['ct_captcha'];
            ///secure image captcha stuff
            /*$data = array(
            "ct_captcha" => @$_POST['ct_captcha']
            );*/
        }

        if (isset($params["honeyPot"])) {
            $params['captchaName'] = 'honeyPot';
        }

        return json_encode($params);
    }

    function HoneyPotValidation($params)
    {

        $time = time() - $_COOKIE["sTime"];

        if (empty($params["honeyPot"]) && $time > 10) {
            return "true";
        } elseif (!empty($params["honeyPot"])) {
            echo '<div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-warning-sign"></span> Detected By HoneyPot</strong>
                  </div>';
            return "false";
        } else {

            echo '<div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-warning-sign"></span> Detected By Time</strong>
                  </div>';
            return "false";
        }
    }
}