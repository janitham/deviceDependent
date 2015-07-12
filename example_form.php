<?php
session_start(); // this MUST be called prior to any output including whitespaces and line breaks!
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<fieldset>

<?php
process_si_contact_form(); 
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']) ?>" id="contact_form">
  <input type="hidden" name="do" value="contact" />

    <p>
    <?php
      // show captcha HTML using Securimage::getCaptchaHtml()
      require_once 'securimage.php';
      $options = array();
      $options['input_name'] = 'ct_captcha'; // change name of input element for form post

      if (!empty($_SESSION['ctform']['captcha_error'])) {
        // error html to show in captcha output
        $options['error_html'] = $_SESSION['ctform']['captcha_error'];
      }

      echo Securimage::getCaptchaHtml($options);
    ?>
  </p>

  <p>
    <br />
    <input type="submit" value="Submit Message" />
  </p>

</form>
</fieldset>

</body>
</html>

<?php

// The form processor PHP code
function process_si_contact_form()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['do'] == 'contact') {
  	// if the form has been submitted

    /*foreach($_POST as $key => $value) {
      if (!is_array($key)) {
      	// sanitize the input data
        if ($key != 'ct_message') $value = strip_tags($value);
        $_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
      }
    }*/

    $captcha = @$_POST['ct_captcha']; // the user's entry for the captcha code
    //$name    = substr($name, 0, 64);  // limit name to 64 characters

    // Only try to validate the captcha if the form has no errors
    // This is especially important for ajax calls
      require_once dirname(__FILE__) . '/securimage.php';
      $securimage = new Securimage();

      if ($securimage->check($captcha) == false) {
        echo 'denaied123';
      }else{
		echo 'success123';
	  }    
  } // POST
}
