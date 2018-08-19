  $(document).ready(function() {
        
		
		//the min chars for username
		var min_chars = 3;
		
		var username        = $('#username').val();
		var password        = $('#password').val();
		var password_repeat = $('#password_repeat').val();
		var email           = $('#email').val();
		var email_repeat    = $('#email_repeat').val();
		
		//result texts
		var characters_error = 'Minimum amount of chars is 3';
		var checking_html = '<img src="images/loading.gif" /> Checking...';
		
		//when button is clicked
		$('register_submit').click(function(){
		    $.post("register_approved.php", { username: username, password: password, password_repeat: password_repeat, email: email, email_repeat: email_repeat },
			    function(data){
				$('#username_error').html(data.a);

                  }, "json");
	

				}
		    });
		});
		
		
});
  

