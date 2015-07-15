<?php

/**
 * Created by PhpStorm.
 * User: Nemina
 * Date: 7/13/2015
 * Time: 12:52 PM
 */
class DetectDevice
{


    public function getSelctedCaptcha($urlQuery)
    {

        $urlDecoded = urldecode($urlQuery);

        parse_str($urlDecoded, $output);

        $length = count($output);

        if ($length > 1) {

            $userAgent = strtolower($output['userAgent']);
            $height = $output['screen-height'];
            $width = $output['screen-width'];
            $isTouch = $output['isTouch'];
            $isHoneyPot = null;
        } else {
            $isHoneyPot = $output['isHoneyPot'];
        }

        if ($isHoneyPot != null && $isHoneyPot == "true") {

            return "honeyPot";

        } else {

            $agent = str_replace(", ", "", $userAgent);
            $agent = str_replace("(", "", $agent);
            $agent = str_replace(")", "", $agent);
            $agent = str_replace(";", "", $agent);

            if (strpos($agent, "mobile") || strpos($agent, "iphone") || strpos($agent, "phone")) {
                return "sweet";
            }

            if (strpos($agent, "android") || strpos($agent, "ipad") || strpos($agent, "tablet")) {
                return "playtrue";
            }

            /*if ($isTouch == "true") {
                return "playtrue";
            }*/

            return "re";
        }
    }
}