$(document).ready(function () {

    $("#register_form").submit(function (e) {

        e.preventDefault();

        dataString = $("#register_form").serialize();
        $.ajax({
            type: "POST",
            url: "approved.php",
            data: dataString,
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data.userlength == 1) {
                    $("#username_error").html("Username minimum amount of symbols is 4");
                } else if (data.userexist == 1) {
                    $("#username_error").html("This username already taken !");
				} else if (data.noone == 1) {
                    $("#username_error").html("Username must contain one word!");
                } else {
                    $("#username_error").html("");
                }


                if (data.passwordlength == 1) {
                    $("#password_error").html("Password minimum amount of symbols is 6");
                } else if (data.passwordmatch == 1) {
                    $("#password_error").html("Passwords do no match !");
                } else {
                    $("#password_error").html("");
                }

                if (data.emailsyntax == 1) {
                    $("#email_error").html("Wrong email format !");
                } else if (data.emailexist == 1) {
                    $("#email_error").html("This E-Mail is already used !");
                } else if (data.emailmatch == 1) {
                    $("#email_error").html("E-Mails do no match !");
                } else {
                    $("#email_error").html("");
                }

                if(data.letters_code == 1) {
                    $('#code_error').html('Invalid code from image!');
                }			

                if (data.success == 1) {
                    $("#register_form").html("<div id=\"registration_success\">Registration is successful, now you can login with your username and password, if you have questions ask in our forum or contact with support!</div>");
                    //  var url = "http://localhost:8080/lockframe/index.php";
                    //  $(location).attr('href',url);
                }

            }
        });
    });

    $("#login_form").submit(function (e) {
        e.preventDefault();

        dataString = $("#login_form").serialize();
        $.ajax({
            type: "POST",
            url: "login.php",
            data: dataString,
            dataType: "json",
            success: function (data) {
                console.log(data);
                
                if (data.loginerror == 1) {
                    $("#login_error").html("Check your login data !");
                } else {
                    var url = "home";
                    $(location).attr('href', url);
                }
            }
        });
    });

    $("#lock_form").submit(function (e) {
        e.preventDefault();

        dataString = $("#lock_form").serialize();

        $.ajax({
            type: "POST",
            url: "lock_form_valid.php",
            data: dataString,
            dataType: "json",
            success: function (data) {
                if (data.logged == 1) {
                    $("#lock_error").html("Links can be locked only by registered users! Please register.");
                } else if (data.input == 1) {
                    $("#lock_error").html("Please insert link which you want to lock!");
                } else if (data.syntax == 1) {
                    $("#lock_error").html("Your link syntax is incorrect, please check and try again!");
                } else {
                    var url = "lock.php?type=" + data.type + "";
                    $(location).attr('href', url);

                }


            }
        });
    });

	$("#password_lock").submit(function (e) {
        e.preventDefault();

        dataString = $('#password_lock').serialize();

        $.ajax({
            type: "POST",
            url: "password_lock_valid.php",
            data: dataString,
            dataType: "json",
            success: function (data) {
                if (data.error == 1) {
                    $("#lock_error").html("Password must be minimum of 4 symbols.");
				}
	            else if (data.error == 2) {
                    $("#lock_error").html("Password is too long. Maximum can be 20 symbols.");	
                } else {
                    var url = "links.php?password=1";
                    $(location).attr('href', url);
                }


            }
        });
    });
	
    $("#social_lock").submit(function (e) {
        e.preventDefault();

        dataString = $('#social_lock input:checkbox:checked, #social_lock input:text, #social_lock textarea').serialize();

        $.ajax({
            type: "POST",
            url: "social_lock_valid.php",
            data: dataString,
            dataType: "json",
            success: function (data) {

                if (data.fb == 0 && data.tw == 0 && data.g == 0) {
                    $("#lock_error").html("You must select at least one lock type!");
                } else if(data.title.length < 5 || data.title.length > 100) {
                    $("#lock_error").html("Your title must be between 5 and 100 symbols!");
                } else if(data.description.length < 10 || data.description.length > 250){
                    $("#lock_error").html("Your description must be between 10 and 250 symbols!");
                } else {
                    var url = "social_lock_completed.php?fb=" + data.fb + "&tw=" + data.tw + "&g=" + data.g  + "&title=" + data.title + "&description=" + data.description + "";
                    $(location).attr('href', url);
                }


            }
        });
    });

    $("#banner_lock").click(function (e) {

        e.preventDefault();

        if ($('#redirect_link').val() == "") {
            $('#lock_error').html("You have not inserted banner link");
            return false;
        }

        if ($('#locked_link_code').val() == "") {
            $('#lock_error').html("You have not uploaded banner");
            return false;
        }
        dataString = $('#banner_lock').serialize();

    
    });


});


