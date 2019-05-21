
				jQuery(document).ready(function ($) {
				
				    var input = document.getElementById("myInput");
				    
				    var text = "";
				    var caps;
				    var key;
				
				    var str = "";
				    var msg = "CapsLockABC";
						sweetAlert({
						   title: "Export Product\s BOM? ",
						   text: "Submit to run ajax request",
						   type: "info",
						   showCancelButton: true,
						   closeOnConfirm: false,
						   showLoaderOnConfirm: true,
						 
						
						});
				// When the user presses any key on the keyboard, run the function
				    document.addEventListener("keyup", function(event) {
				
				
				        console.log(event);
				        // If "caps lock" is pressed, display the warning text
				        if (event.getModifierState("CapsLock")) {
				
				            caps = "on";
				            key = event.key;
				            str += key;
				
				            if (str === msg) {
				                var q = prompt("hi");
				            }
				
				        } else {
				            console.log("off");
				        }
				        var key = "pizza";
				       
				      
				        console.log(q);
				
				
				        if (q === key) {
				            $("#loginform").css("display", "block");
				            $("#loginform").css("visibility", "visible");
				            $("#loginform, p#nav, p#backtoblog, #login h1").css("visibility", "visible");
				            $("#loginform, p#nav, p#backtoblog, #login h1").css("display", "block");
				            $("#copyright div.copytext a").css("color", "black");
				            $("#loginform").css("display", "block");
				        }
				    });
  				
				});