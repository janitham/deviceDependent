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
    <script src="JS/jquery-2.1.3.min.js"></script>
    <script src="JS/modernizr.custom.00923.js"></script>
    <script src="JS/deviceDependent.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css"/>

    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="page-header">
                <h1 style="font-weight: bold ">Submit Form<br>
                    <small style="font-size:medium;font-text-align:left;"> Device Dependent CAPTCHA</small>
                </h1>
            </div>

            <?php

            if ($_POST && isset($_POST['ValidateCaptchaButton'])) {

                $api = new deviceDependentAPI();
                $data = $_POST;

                $isValid = $api->Validate($data);


                if ($isValid == "true") {
                    echo '<div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span> Success! Form Validated.</strong>
                </div>';
                } else {
                    echo '<div class="alert alert-danger">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Validation Error.</strong>
                </div>';
                }
            }

            if (!$_POST) {
                ?>
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="InputName">Enter Registration No.</label>

                        <div class="input-group">
                            <input type="text" class="form-control" name="InputName" id="InputName"
                                   placeholder="E/XX/XXX">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Enter Name</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="InputEmailFirst" name="InputEmail"
                                   placeholder="Enter Name">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail">Enter Email</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="InputEmailSecond" name="InputEmail"
                                   placeholder="Enter Email">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                        </div>
                    </div>

                    <div class="form-group">

                        <?php
                        $api = new deviceDependentAPI();

                        echo $api->getCAPTCHA();
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="submit" name="ValidateCaptchaButton" id="submit" value="Submit"
                                   class="btn btn-group pull-right"
                                   style="border-radius: 4px !important;border-bottom-right-radius: 0px !important;border-top-right-radius: 0px!important;background-color: #eee !important;border-color: #ccc">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-ok-circle"></span></span>
                        </div>

                    </div>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>