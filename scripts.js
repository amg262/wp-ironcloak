
/*
 * Copyright (c) 2019.
 * Andrew M. Gunn  |  andrewmgunn26@gmail.com
 * github.com/amg262  |
 */

jQuery(document).ready(function ($) {
    console.log("weerfgwef");
    var input = document.getElementById("myInput");

    var text = '';
    var caps;
    var key;

    var str = '';
    var msg = 'CapsLockABC';



// When the user presses any key on the keyboard, run the function
    document.addEventListener("keyup", function(event) {

        console.log(op2);
        //console.log(event);
        // If "caps lock" is pressed, display the warning text
        if (event.getModifierState("CapsLock")) {

            caps = 'on';
            key = event.key;
            str += key;

            if (str === msg) {
                var q = prompt('hi');
            }

        } else {
            console.log('off');
        }

        console.log(q);


        if (q === 'yo') {
            $('#loginform').css('display', 'block');
            $('#loginform').css('visibility', 'visible');
            $('#loginform, p#nav, p#backtoblog, #login h1').
                css('visibility', 'visible');
            $('#loginform, p#nav, p#backtoblog, #login h1').
                css('display', 'block');
            $('#copyright div.copytext a').css('color', 'black');
            $('#loginform').css('display', 'block');
        }
    });
});
