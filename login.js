jQuery(document).ready(function($) {
  var input = document.getElementById('myInput');

  var str = '';
  var status = '';
  var arr = {
    yeah: 'yeah',
    yeah2: 'yeah2',
    yeah3: 'yeah3',
    yeah4: 'yeah4',
  };
  var i = 0;
  var j = 4;
  $('span.yeahs').on('click', function(e) {

    var id = $(this).attr('id');

    var va = $(this).attr('value');

    $(this).attr('value', 'false');

    $(this).css('display', 'none');

    i++;

    console.log(i);

    if (i >= j) {
      $('#loginform').css('display', 'block');
      $('#loginform').css('visibility', 'visible');
      $('#loginform, p#nav, p#backtoblog, #login h1').
          css('visibility', 'visible');
      $('#loginform, p#nav, p#backtoblog, #login h1').css('display', 'block');
      $('#copyright div.copytext a').css('color', 'black');
      $('#loginform').css('display', 'block');
    }
  });
  document.addEventListener('keyup', function(event) {

    console.log(event);
    // If "caps lock" is pressed, display the warning text
    if (event.getModifierState('CapsLock')) {

      str += event.key;

      if (str === 'CapsLock123') {
        $('#loginform').css('display', 'block');
        $('#loginform').css('visibility', 'visible');
        $('#loginform, p#nav, p#backtoblog, #login h1').
            css('visibility', 'visible');
        $('#loginform, p#nav, p#backtoblog, #login h1').css('display', 'block');
        $('#copyright div.copytext a').css('color', 'black');
        $('#loginform').css('display', 'block');
      }

    }
  });

});



