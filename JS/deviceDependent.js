/**
 * Created by Nemina on 7/13/2015.
 */



function setCookie(cookieName, cookieValue) {

    if (navigator.cookieEnabled) {
        var date = new Date();

        date.setTime(date.getTime() + (1000));

        var expiers = "; expiers=" + date.toUTCString();

        document.cookie = cookieName + "=" + cookieValue + expiers + ";path=/";
    }
}

function getCookie() {

    var cookie = document.cookie.split(';');

    return cookie.length;
}

$(document).ready(function () {

    var screenWidth = screen.width;
    var screenHeight = screen.height;
    var pixelDepth = screen.pixelDepth;
    var isTouch = Modernizr.touch;

    setCookie("screen-width", screenWidth);
    setCookie("screen-height", screenHeight);
    setCookie("pixelDepth", pixelDepth);
    setCookie("isTouch", isTouch);

    if (getCookie() < 4) {

        location.reload(true);
    }
});
/*

 function ClickMe(){
 $("#recaptcha_area").find("#recaptcha_table").find("#recaptcha_response_field").keypress(function(){
 setCookie("KeyPressed","true");
 })
 }
 */
