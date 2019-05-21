
jQuery(document).ready(function ($) {
    console.log("weerfgwef");

//    $('*').on('click', function(e) {
//        console.log(this);
//
//        prompt('hey');
//        console.log(e);
//    });
// Get the input field
    var input = document.getElementById("myInput");

// Get the warning text
    var text = '';
    var caps;
    var key;

    var str = '';
    var msg = 'CapsLockABC';

// When the user presses any key on the keyboard, run the function
    document.addEventListener("keyup", function(event) {


        //console.log(event);
        // If "caps lock" is pressed, display the warning text
        if (event.getModifierState("CapsLock")) {

            caps = 'on';

            key = event.key;

            str += key;


            console.log(str);

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
