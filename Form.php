<?php
/**
 * Created by PhpStorm.
 * User: Nemina
 * Date: 7/13/2015
 * Time: 9:52 AM
 */

require_once "deviceDependentAPI.php"
?>


<!DOCTYPE HTML>
<html>
<head>
    <title>Device Dependent</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css"/>

    <script type="text/javascript" src="JS/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="JS/formFill.js"
    <script type="text/javascript" src="JS/modernizr.custom.00923.js"></script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="page-header">
                <h1 style="font-weight: bold ">Registration Form<br>
                    <small style="font-size:medium;font-text-align:left;"> Honeypot and Timestamp Integration</small>
                </h1>
            </div>

            <?php
            if ($_POST && isset($_POST['ValidateCaptchaButton'])) {

                $api = new deviceDependentAPI();
                $data = $_POST;
                $isValid = $api->HoneyPotValidation($data);

                if ($isValid == "true") {
                    echo '<div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span> Success! Form Validated.</strong>
                </div>';
                } else {
                    echo '<div class="alert alert-danger">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Bot Detected.</strong>
                </div>';
                }
            }

            if (!$_POST) {
                ?>

                <form role="form" method="post">
                    <div class="form-group">
                        <label for="InputName">Enter Name</label>

                        <div class="input-group">
                            <input type="text" class="form-control" name="InputName" id="InputName"
                                   placeholder="Enter Name">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Enter Email</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="InputEmailFirst" name="InputEmail"
                                   placeholder="Enter Email">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputMessage">Enter Message</label>

                        <div class="input-group">
                            <textarea name="InputMessage" id="InputMessage" class="form-control" rows="3"></textarea>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>

                    <?php
                    $api = new deviceDependentAPI();
                    echo $api->getHoneyPot();
                    setcookie("sTime", time(), null, "/");
                    ?>

                    <div class="input-group">
                        <input type="submit" name="ValidateCaptchaButton" id="ValidateCaptchaButton" value="Submit"
                               class="btn btn-group pull-right"
                               style="width: 100px;border-radius: 4px !important;border-bottom-right-radius: 0px !important;border-top-right-radius: 0px!important;background-color: #eee !important;border-color: #ccc">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-ok-circle"></span></span>
                    </div>
                </form>

                <div class="input-group" style="padding-top: 20px">
                    <input type="button" id="bot" onclick="fillForm();return false;" value="Bot Attack"
                           class="btn btn-group pull-right"
                           style="width: 100px;background-color: #ff835e !important;border-radius: 4px !important;border-bottom-right-radius: 0px !important;border-top-right-radius: 0px!important;border-color: #ccc">
                    <span class="input-group-addon warnin" style="background-color: #ff835e !important;"><span
                            class="glyphicon glyphicon-warning-sign"></span></span>
                </div>

                <div class="input-group" style="padding-top: 20px">
                    <input type="button" id="bot" onclick="timeCheck();return false;" value="Time Attack"
                           class="btn btn-group pull-right"
                           style="background-color: #5cb85c !important;border-radius: 4px !important;border-bottom-right-radius: 0px !important;border-top-right-radius: 0px!important;border-color: #ccc">
                    <span class="input-group-addon warnin" style="background-color: #5cb85c !important;"><span
                            class="glyphicon glyphicon-warning-sign"></span></span>
                </div>

                <?php
            }
            ?>
        </div>
    </div>
</body>

</html>
