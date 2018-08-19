<?php 
//require_once 'db.php';
class Template {

    function GetUserAvatar(){
        if (isset($_SESSION['ID'])){
            $avatar_result = mysql_query('SELECT avatar FROM users WHERE ID = "'.$_SESSION['ID'].'"');
            $row = mysql_fetch_array($avatar_result);
            return $row['avatar'];
        }
    }
        
    function PrintHeader($avatar){
		include_once("analyticstracking.php");
        if (!isset($_SESSION['username']))
        {
            echo
            '<header>
                <form id="login_form">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" id="username_login" name="username_login" maxlength = "20" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" id="password_login" name="password_login" maxlength = "25" autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td><button id="login_submit" type="submit">Login</button></td>
                            <td><div id="login_error"></div></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href="register">Register</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href="forgot_password">Forgot Password</a></td>
                        </tr>
                    </table>
                </form>

                <nav>
                    <a href="home" id="navhome">Home</a> |
                    <a href="faq" id="navfaq">FAQ</a> |
                    <a href="forum" id="navforum">Forum</a> |
                    <a href="contact" id="navcontact">Contacts</a>
                </nav>
            </header>';            
        }
        else
        {
            echo 
            '<header>
                <table id="logged">
                    <tr>
                        <td colspan="2" id="logged_as">Hi '.$_SESSION['username'].'</td>
                    </tr>
                    <tr>
                        <td id="avatar" rowspan="4"><img src="avatars/'.$avatar.'" alt="User avatar"></td>
                        <td><img src="img/profile.png">&nbsp<a href="profile.php?err='.NULL.'&success='.NULL.'&action='.NULL.'">Profile</a></td>
                    </tr>
                    <tr>
                        <td><img src="img/hyperlink.png">&nbsp<a href="links">Links</a></td>
                    </tr>
                    <tr>
                        <td><img src="img/logout.png">&nbsp<a href="logout.php">Logout</a></td>
                    </tr>';
                    if($_SESSION['ID'] == 1){
                    echo '<tr>
                        <td><a href="admin.php">Admin</a></td>
                    </tr>';
                    }
                    echo
                    '
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>

                <nav>
                    <a href="home" id="navhome">Home</a> |
                    <a href="faq" id="navfaq">FAQ</a> |
                    <a href="forum" id="navforum">Forum</a> |
                    <a href="contact" id="navcontact">Contacts</a>
                </nav>
            </header>';            
            
        }
    }

    function PrintCountriesSelect($country){
              $country_list = array(
        "Afghanistan",
        "Albania",
        "Algeria",
        "Andorra",
        "Angola",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bhutan",
        "Bolivia",
        "Bosnia and Herzegovina",
        "Botswana",
        "Brazil",
        "Brunei",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Central African Republic",
        "Chad",
        "Chile",
        "China",
        "Colombi",
        "Comoros",
        "Congo (Brazzaville)",
        "Congo",
        "Costa Rica",
        "Cote d'Ivoire",
        "Croatia",
        "Cuba",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "Dominican Republic",
        "East Timor (Timor Timur)",
        "Ecuador",
        "Egypt",
        "El Salvador",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Fiji",
        "Finland",
        "France",
        "Gabon",
        "Gambia, The",
        "Georgia",
        "Germany",
        "Ghana",
        "Greece",
        "Grenada",
        "Guatemala",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Haiti",
        "Honduras",
        "Hungary",
        "Iceland",
        "India",
        "Indonesia",
        "Iran",
        "Iraq",
        "Ireland",
        "Israel",
        "Italy",
        "Jamaica",
        "Japan",
        "Jordan",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Korea, North",
        "Korea, South",
        "Kuwait",
        "Kyrgyzstan",
        "Laos",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macedonia",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Marshall Islands",
        "Mauritania",
        "Mauritius",
        "Mexico",
        "Micronesia",
        "Moldova",
        "Monaco",
        "Mongolia",
        "Morocco",
        "Mozambique",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepal",
        "Netherlands",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "Nigeria",
        "Norway",
        "Oman",
        "Pakistan",
        "Palau",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Peru",
        "Philippines",
        "Poland",
        "Portugal",
        "Qatar",
        "Romania",
        "Russia",
        "Rwanda",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Vincent",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Senegal",
        "Serbia and Montenegro",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "Spain",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syria",
        "Taiwan",
        "Tajikistan",
        "Tanzania",
        "Thailand",
        "Togo",
        "Tonga",
        "Trinidad and Tobago",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "United Kingdom",
        "United States",
        "Uruguay",
        "Uzbekistan",
        "Vanuatu",
        "Vatican City",
        "Venezuela",
        "Vietnam",
        "Yemen",
        "Zambia",
        "Zimbabwe"
    );
            echo ' <select  name="country">
                   <option value="Not set">Select country</option>
                   ';

            for($i = 1; $i < count($country_list); $i++){
                if($country == $country_list[$i]){
                    echo  '<option value="'.$country_list[$i].'" selected>'.$country_list[$i].'</option>';
                }else{
                    echo  '<option value="'.$country_list[$i].'">'.$country_list[$i].'</option>';
                }
            }
           echo '</select>';
             
    }

    function PrintGenderSelect($gender)
    {
        echo 
        '<select name="gender">';
          if ($gender == "Not set" || $gender == ""){
              echo '<option value="Not set" selected>Select gender</option>';
          }else{
              echo '<option value="Not set">Select gender</option>';
          }

          if ($gender == "Male"){
              echo '<option value="Male" selected>Male</option>';
          }else{
              echo '<option value="Male">Male</option>';
          }

          if ($gender == "Female"){
              echo '<option value="Female" selected>Female</option>';
          }else{
              echo '<option value="Female">Female</option>';
          }
       echo '</select>';
    }

    function PrintDaySelect($day)
    {
        echo 
        '<select name="day">';
        for($i = 1; $i < 32; $i++){
            if($day == $i){
                echo '<option value="'.$i.'" selected>'.$i.'</option>';
            }else{
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
        }
       echo '</select>';
    }

    function PrintMonthSelect($month)
    {
        $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
        echo 
        '<select name="month">';
        for($i = 0; $i < count($months); $i++){
            if($month == ($i+1)){
                echo '<option value="'.($i+1).'" selected>'.$months[$i].'</option>';
            }else{
                echo '<option value="'.($i+1).'">'.$months[$i].'</option>';
            }
        }
       echo '</select>';
    }

    function PrintRegisterform()
    {
        echo 
        '<form id="register_form">
            <table>
                <tr>
                    <td colspan="2"><h2>New User Registration</h2></td>
                </tr>
                <tr>
                    <td>Username *</td>
                    <td><input type="text" id="username" name="username" maxlength = "20"></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="username_error"></div></td>
                </tr>
                <tr>
                    <td>Password *</td>
                    <td><input type="password" id="password" name="password" maxlength = "25"></td>
                </tr>
                <tr>
                    <td>Password repeat *</td>
                    <td><input type="password" id="password_repeat" name="password_repeat" maxlength = "25"></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="password_error"></div></td>
                </tr>
                <tr>
                    <td>E-Mail *</td>
                    <td><input type="text" id="email" name="email" maxlength = "35"></td>
                </tr>
                <tr>
                    <td>E-Mail repeat *</td>
                    <td><input type="text" id="email_repeat" name="email_repeat" maxlength = "35"></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="email_error"></div></td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><img src="captcha.php?rand='.rand().'" id="captchaimg"><br></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="code_error"></div></td>
                </tr>
                <tr>
                    <td>Enter the code above here :</td>
                    <td><input id="6_letters_code" name="6_letters_code" type="text"><br><small>Can\'t read the image? click <a href=\'javascript: refreshCaptcha();\'>here</a> to refresh</small></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td>';
                    $this->PrintGenderSelect("");
                    echo'</td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>';
                    $this->PrintCountriesSelect("");
                    echo '</td>
                </tr>
                <tr>
                    <td>Birthdate</td>
                    <td>';
                    $this->PrintDaySelect("");
                    $this->PrintMonthSelect("");
                     echo'            
                    <input id="years" name="years" type="text" size="4" maxlength="4"/>
                    ex. 1978
                    </td>
                </tr>
                <tr>
                    <td><button id="register_submit" type="submit">Register</button></td>
                    <td>All fields with * must be filled.</td>
                </tr>
            </table>
        </form>';
    }
    
    function PrintProfile($ID, $username, $email, $avatar, $gender, $country, $birthdate, $error, $success){
     echo
            '<table id="profile">
                <tr>
                    <td colspan="2"><h2>My Profile</h2></td>
                </tr>
                <tr>
                    <td id="avatar"><img src="avatars/'.$avatar.'" alt="User avatar"></td>
                    <td id="avatar_notice">
                        <div id="success_upload">'.$success.'</div>
                        <div id="unsuccess_upload">'.$error.'</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form id="avatar_upload" action="avatar_upload.php" method="post" enctype="multipart/form-data">
                            <label for="file">Avatar:</label>
                            <input type="file" name="file" id="file">
                            <button type="submit">Upload</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><h3>Account details</h3></td>
                </tr>
                <tr>
                    <td>User ID:</td>
                    <td>'.$ID.'</td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>'.$username.'</td>
                </tr>
                <tr>
                    <td>E-Mail:</td>
                    <td>'.$email.'</td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>'.$gender.'</td>
                </tr>
                <tr>
                    <td>Country:</td>
                    <td>'.$country.'</td>
                </tr>
                <tr>
                    <td>Birthdate:</td>
                    <td>'.$birthdate.'</td>
                </tr>
                <tr>
                    <td><button id="edit_profile" type="submit" ONCLICK="window.location.href=\'profile.php?err='.NULL.'&success='.NULL.'&action=edit\'">Edi Profile</button></td>
                    <td></td>
                </tr>
            </table>';            
        }

     function PrintProfileEdit($ID, $username, $email, $avatar, $gender, $country, $birthdate, $error, $success){
        $birthdate_values = explode("-", $birthdate);
     echo
            '<table id="profile">
                <tr>
                    <td colspan="2"><h2>My Profile</h2></td>
                </tr>
                <tr>
                    <td id="avatar"><img src="avatars/'.$avatar.'" alt="User avatar"></td>
                    <td id="avatar_notice">
                        <div id="success_upload">'.$success.'</div>
                        <div id="unsuccess_upload">'.$error.'</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form id="avatar_upload" action="avatar_upload.php" method="post" enctype="multipart/form-data">
                            <label for="file">Avatar:</label>
                            <input type="file" name="file" id="file">
                            <button type="submit">Upload</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><h3>Account details</h3></td>
                </tr>
                <tr>
                    <td>User ID:</td>
                    <td>'.$ID.'</td>
                </tr>
                <form id="profile_edit" action="profile_edit.php" method="post">
                <tr>
                    <td>Username:</td>
                    <td>'.$username.'</td>
                </tr>
                <tr>
                    <td>E-Mail:</td>
                    <td><input type="text" name="email" value="'.$email.'"></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>';
                       $this->PrintGenderSelect($gender);     
                    echo '</td>
                </tr>
                <tr>
                    <td>Country:</td>
                    <td>';
                    $this->PrintCountriesSelect($country);
                    echo'</td>
                </tr>
                <tr>
                    <td>Birthdate:</td>
                    <td>';
                    $this->PrintDaySelect($birthdate_values[2]);
                    $this->PrintMonthSelect($birthdate_values[1]);
                    echo '
                    <input id="years" name="years" type="text" size="4" maxlength="4" value = "'.$birthdate_values[0].'"/>
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="pass" ></td>
                </tr>
                <tr>
                    <td>Repeat password:</td>
                    <td><input type="password" name="pass2" ></td>
                </tr>
                <tr>
                    <td><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;">
                    <button id="save" type="submit">Save</button>
                    </td>
                    <td></td>
                </tr>
                </form>
            </table>';            
        }
        
        function PrintForgotPassword(){
            global $DB;
            $err = '';
            if(isset($_GET['username']) || isset($_GET['email']) ) {

                if( !empty($_GET['username'])) {
                    $_GET['username'] = preg_replace("/[^a-zA-Z0-9]/", "", $_GET['username']);
                    $user = $DB->prepare("SELECT * FROM users WHERE username=:username LIMIT 1");
                    $user->bindParam(':username', $_GET['username'], PDO::PARAM_STR, 20);
                    $user->execute();
                    $user = $user->fetch();
                    if(!empty($user)) {

                        $newPass =  generateRandomString(7);
                        $err = 'We have sent your password to given email.';
                        $to      = $user->email;
                        $subject = 'Forgotten password';
                        $message = 'Hello '.$user->username.",\r\n Your new password is: ".$newPass;
                        $headers = 'From: info@'.$_SERVER['SERVER_NAME'].'' . "\r\n" .
                            'Reply-To: info@'.$_SERVER['SERVER_NAME'].'' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();


                        mail($to, $subject, $message, $headers);
                        $DB->query("UPDATE users SET password='".md5($newPass)."' WHERE username='".$user->username."' LIMIT 1");
						$DB->query("UPDATE usebb_members SET passwd = '".md5($newPass)."' WHERE name='".$user->username."'");
                    } else $err = 'Sorry, we were unable to find any match.';
                    
                } else if( !empty($_GET['email']) ) {
                    if(filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
                        $user = $DB->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
                        $user->bindParam(':email', $_GET['email'], PDO::PARAM_STR, 100);
                        $user->execute();
                        $user = $user->fetch();
                        if(!empty($user)) {

                        $newPass =  generateRandomString(7);
                        $err = 'We have sent your password to given email.';
                        $to      = $user->email;
                        $subject = 'Forgotten password';
                        $message = 'Hello '.$user->username.",\r\n Your new password is: ".$newPass;
                        $headers = 'From: info@'.$_SERVER['SERVER_NAME'].'' . "\r\n" .
                            'Reply-To: info@'.$_SERVER['SERVER_NAME'].'' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();


                        mail($to, $subject, $message, $headers);
                        $DB->query("UPDATE users SET password='".md5($newPass)."' WHERE username='".$user->username."' LIMIT 1");
						$DB->query("UPDATE usebb_members SET passwd = '".md5($newPass)."' WHERE name='".$user->username."'");
                        } else {
                            $err = 'Sorry, we were unable to find any match.';
                        }

                    } else $err = 'Sorry, invalid email address.';
                    
                    
                } else $err = 'Please fill form above.';
            } 
                echo
                '<form id="forgot_password" action="" methdo="POST">
                <table>
                    <tr>
                        <td colspan="2"><h2>Remind My Password</h2></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h4>Input your username</h4></td>
                    </tr>
                    <tr>
                        <td>Username: </td>
                        <td><input type="text" id="username" name="username" maxlength = "20"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h4>Or e-mail address</h4></td>
                    </tr>
                    <tr>
                        <td>E-Mail: </td>
                        <td><input type="text" id="email" name="email" maxlength = "50"></td>
                    </tr>
                    <tr>
                        <td><button id="remind_password" type="submit">Remind</button></td>
                        <td><div id="remind_error">'.(!empty($err) ? $err : '').'</div></td>
                    </tr>
                </table>
                </form>';
        

        
        }
        
        function PrintForum(){
        echo
            '';
        }
        
        function PrintSocialLock($URL){
            echo
            '<div id="social_lock">
            <h2>Social Lock</h2>
            <p><b>Your link:</b>&nbsp;<div class="locking_link">'.$URL.'</div></p>
            <form id="social_lock">
            <p>Check options which user must to do as unlock your link:</p>
            <p><input type="text" name="title" placeholder="Title"></p>
            <p><textarea name="description" placeholder="Description"></textarea></p>
            
            <div id="lock_error"></div>
                <p><input type="checkbox" name="facebook" value="fb">&nbsp;<img src="img/like.png">&nbsp;Facebook Like</p>
                <p><input type="checkbox" name="twitter" value="tw">&nbsp;<img src="img/tweet.png">&nbsp;Twitter tweet</p>
                <p><input type="checkbox" name="google" value="g">&nbsp;<img src="img/google_plus.png">&nbsp;Google G+</p>

                <button id="lock_submit" type="submit">Lock</button>
            </form>
            </div>';
             
        }
        
        function PrintPasswordLock($URL){
            echo
            '<div id="password_locker">
            <h2>Password Lock</h2>
            <p><b>Your link:</b>&nbsp;<div class="locking_link">'.$URL.'</div></p>
            <form id="password_lock">
                <p>Input password which user must to use as unlock your link:</p>
                <div id="lock_error"></div>
                <p><input type="text" id="password" name="password" placeholder="password"></p>
                <button type="submit">Lock</button>
            </form>
            </div>';
             
        }

         function PrintBannerLock($URL, $err){
             $ur = base64_encode($URL);



            echo
                        '<div id="bannerlock">
                        <h2>Banner Lock</h2>
                        <p><b>Your link:</b>&nbsp;<div class="locking_link">'.$URL.'</div></p>
                        <p>Choose banner from your computer and upload it:</p>
                        
                <span style="display: none;" class="ur">'.$ur.'</span>

                <input type="button" id="upload-btn" class="btn btn-primary btn-large clearfix" value="Choose file">
                <span style="padding-left:5px;vertical-align:middle;"><i>PNG, JPG, or GIF (1024K max file size)</i></span>
        
                <div id="errormsg" class="clearfix redtext" style="padding-top: 10px;"></div>
        
                <div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;"></div>
                <div id="picbox" class="clear" style="padding-top:0px;padding-bottom:10px;"></div>
        




            </div>';   

                         ?>
             <script>
                  var btn = document.getElementById('upload-btn'),
              wrap = document.getElementById('pic-progress-wrap'),
              picBox = document.getElementById('picbox'),
              errBox = document.getElementById('errormsg');
                $ur = $('.ur').html();
     var uploader = new ss.SimpleUpload({
        button: btn,
        url: '/uploader.php?url='+$ur,
        sessionProgressUrl: '/uploader/sessionProgress.php',
        name: 'imgfile',
        multiple: true,
        multipart: true,
        maxUploads: 2,
        maxSize: 1024,
        queue: false,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        accept: 'image/*',
        debug: true,
        hoverClass: 'btn-hover',
        focusClass: 'active',
        disabledClass: 'disabled',
        responseType: 'json',
        onSubmit: function(filename, ext) {            
           var prog = document.createElement('div'),
               outer = document.createElement('div'),
               bar = document.createElement('div'),
               size = document.createElement('div'),
               self = this;     
    
            prog.className = 'prog';
            size.className = 'size';
            outer.className = 'progress progress-striped';
            bar.className = 'progress-bar progress-bar-success';
            
            outer.appendChild(bar);
            prog.appendChild(size);
            prog.appendChild(outer);
            wrap.appendChild(prog); // 'wrap' is an element on the page
            
            self.setProgressBar(bar);
            self.setProgressContainer(prog);
            self.setFileSizeBox(size);                
            
            errBox.innerHTML = '';
            btn.value = 'Choose another file';
          },        
          onSizeError: function() {
                errBox.innerHTML = 'Files may not exceed 1024K.';
          },
          onExtError: function() {
              errBox.innerHTML = 'Invalid file type. Please select a PNG, JPG, GIF image.';
          },
        onComplete: function(file, response, btn) {  
            console.log(response);
            if (response.err == 1) {
              //location
              document.location= "http://lockframe.net/lock_banner.php?pg=bannerlock&url="+ $ur+"&file="+response.file;
            }  else {
                errBox.innerHTML = response.err;
            }   
                
            
          }
    });

             </script>


             <?php         
        }
        
          function PrintLinksList($user_id){
              echo 
              '<div id="locked_links_list">
              <h2>Your Locked Links</h2>
               Lock type:
               <select id="lock_type">
                    <option value="null">---</option>
                    <option value="banner">Banner</option>
                    <option value="social">Social</option>
                    <option value="password">Password</option>
              </select>
              <div id="jqxgrid"></div>
              </div>';
            
        }
        function PrintAdminPanel(){
              echo 
              '<div id="locked_links_list">
              <h2>Administrator Panel</h2>
              </div>';
            
        }
		
		function PrintFAQ(){
              echo 
              '<div id="faq">
				<h3>1. What is lockframe.net?</h3>
				<p>Lockframe.net is a service which helps lock any link by banner ads, social network sharing or password. Visitor must to do locked link actions as he can see locked content.</p>
				<h3>2. Lockframe.net service is free?</h3>
				<p>Yes, it is absolutely free.</p>
				<h3>3. How many locked links can I have?</h3>
				<p>At this moment locked links amount is unlimited.</p>
				<h3>4. Can I lock adult content?</h3>
				<p>Yes you can, we do not assume responsibility of user locked content, however observation any forbidden content link is removed and user get permanently banned.</p>
				<h3>5. How can I monetize my content with lockframe.net?</h3>
				<p>It is only your fantasy and ideas how can you have done it. You can find ideas and share with other your experience in our forum. Suggestions also are welcome.</p>
              </div>';
            
        }
        
        

   
}
?>