<?php 
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
//include_once("analyticstracking.php");
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

  ?>
<!DOCTYPE html>
<html>
<head>
<meta name="description" content="Online Affiliate Tool">
<meta name="keywords" content="Affiliate, Advertisement, Lock, Banner, Share">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
<?php
require_once 'db.php';


// Nuskaitome užrakintos nuorods prefeksą
$prefix = $_GET["prefix"];

// Paiimamas užrakintos nuorodos kodas, kuris yra unikalus kiekvienai nuorodai
$code = substr($prefix, 2);
// Paiimamas užrakintos nuorodos prefekas, nustatyti koks nuorodos tipas: s - social, b - banner, p - password
$type = substr($prefix, 0, 2);
switch ($type)
{
    case 'ss':

    $JM = mysql_fetch_assoc(mysql_query("SELECT * FROM links_social WHERE code = '".$code."'"));

    break;

}
?>

<meta property="og:url"            content="http://lockframe.net/" />
<meta property="og:type"           content="website" />
<meta property="og:author"         content="LockFrame" />
<meta property="og:title"          content="<?php echo $JM['title']; ?>" />
<meta property="og:description"    content="<?php echo $JM['description']; ?>"/>
<meta property="og:image"          content="http://lockframe.net/img/header.png" />
<meta property="article:publisher" content="LockFrame" />
<meta property="article:author"    content="LockFrame" />

<meta itemprop="name" content="<?php echo $JM['title']; ?>">
<meta itemprop="description" content="<?php echo $JM['description']; ?>">
<meta itemprop="image" content="http://lockframe.net/img/header.png"/>

<meta name="twitter:dnt" content="off">
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@Lockframe.net" />
<meta name="twitter:title" content="<?php echo $JM['title']; ?>" />
<meta name="twitter:description" content="<?php echo $JM['description']; ?>" />
<meta name="twitter:image" content="http://lockframe.net/img/header.png" />

<style>
.visible {
	display: inline !important;
}

</style>

<link rel="stylesheet" type="text/css" href="locked_style.css">



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="//connect.facebook.net/en_US/sdk.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script type="text/javascript" src="js/widget.js"></script>
<title>LockFrame - Online Affiliate Tool</title>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</head>
<?php

// Tik atsidarius užrakintai nuorodai nuskaitome vartojo IP adresą
$visitor_ip = $_SERVER['REMOTE_ADDR'];


$link = "";
// Loginiai kintamieji 
$b_fb = 0; // Facebook
$b_tw = 0; // Twitter
$b_g = 0;  // Google
$count = 0;
// Atitinkamai nuo užrakintos nuorodos tipo vykdoma jam būdinga logika
switch ($type)
{
///////////////////////////
// Banner tipas
///////////////////////////
case "bb":
	// Iš duomenų bazės išrenkame informaciją apie užrakintą nuorodą
	$lockresult = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS unlocked FROM banner_links_unlock WHERE code = '".$code."' AND ip = '".$visitor_ip."'"),MYSQL_ASSOC);
	$result = mysql_fetch_array(mysql_query("SELECT * FROM links_banner WHERE code = '".$code."'"),MYSQL_ASSOC);
	// Suskaičiuojame kiek yra rezultatų


break;
///////////////////////////
// Password tipas
///////////////////////////
case "pp":
	// Iš duomenų bazės išrenkame informaciją apie užrakintą nuorodą
	$result = mysql_query("SELECT * FROM links_password WHERE code = '".$code."'");
	// Suskaičiuojame kiek yra rezultatų

	$count = mysql_num_rows($result);
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$link = $row['link'];      // Užrakinta nuoroda
	}
	$aaa = mysql_fetch_array($result);

	if($count == 0){
	?>
		<script>location.href = "index.php";</script>
	<?php
	}
	
	$result = mysql_query("SELECT * FROM password_links_unlock WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
	$count = mysql_num_rows($result);
   
	if($count == 1){
	?>
		<script>location.href = '<?php echo $link;?>';</script>
	<?php
        die();
	}


break;
/////////////////////////
// Social tipas
/////////////////////////
case "ss":

	// Iš duomenų bazės išrenkame informaciją apie užrakintą nuorodą
	$result = mysql_query("SELECT * FROM links_social WHERE code = '".$code."'");
	// Suskaičiuojame kiek yra rezultatų
	$count = mysql_num_rows($result);


    $JM = mysql_fetch_assoc(mysql_query("SELECT * FROM links_social WHERE code = '".$code."'"));


	if($count == 0){
	?>
		<script>location.href = "index.php";</script>
	<?php
    die();
	}
	
	// Priskiriame parametrus
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$link = $row['link'];      // Užrakinta nuoroda
		$b_fb = $row['facebook'];  // Facebook loginis kintamasis
		$b_tw = $row['twitter'];   // Twitter loginis kintamasis
		$b_g =  $row['google'];    // Google loginis kintamasis

	}

	// Išrenakame informaciją apie nuorodą esamo lankytojo atžvilgiu
	$result = mysql_query("SELECT * FROM social_links_unlock WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
	// Suskaičiuojame kiek yra rezultatų
	$count = mysql_num_rows($result);
   
	// Jai rezultatų duomenų bazėje vis dar nėra reiškia lankytojas apsilankė pirmą kartą, todėl įrašome informaciją i duomenų bazę
	if($count == 0){
		mysql_query("INSERT INTO social_links_unlock  VALUES ('".$code."','".$visitor_ip."', 0, 0, 0)");
	} else {
    // Priešingu atveju lankytojas šią nuorodą atidaro jau ne pirmą kartą todėl išrenkame informaciją iš lentelės ir priskiriame kintamiesiems
       $result = mysql_query("SELECT * FROM social_links_unlock WHERE ip = '".$visitor_ip."' AND code = '".$code."'");
       $lol = '';
       // Priskiriame parametrus
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    	$lol = $row;
            if($row['facebook'] == 1)
			   $b_fb = 0;
		    else
			   $b_fb = $b_fb;
		   
            if($row['twitter'] == 1)
			   $b_tw = 0;
		    else
			   $b_tw = $b_tw;
		   
            if($row['google'] == 1)
			   $b_g = 0;
			else
			   $b_g = $b_g;
        }           
	}
	/**/

	if($b_fb == 0 && $b_tw == 0 && $b_g == 0){	
	?>
		<script>window.location.href = '<?php echo $link; ?>';</script>
	<?php
	}
	
	break;
default:
	?>
	<script>window.location.href = "/index.php";</script>
	<?php
}
?>
<body>
<div id="fb-root"></div>
<script type="text/javascript">

    $(document).ready(function () {


		FB.Event.subscribe('edge.create', function(href, widget) {
			$.ajax({
                type: "POST",
                url: "ajax/social_ajax.php",
                data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>", fb: 1 },
                success: function (data) {
                    $(".fb-like").hide();
                }
            });
		});
		FB.Event.subscribe('edge.remove', function(href, widget) {
			$.ajax({
                type: "POST",
                url: "ajax/social_ajax.php",
                data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>", fb: 0 },
                success: function (data) {
                    $(".fb-like").show();
                }
            });
		});
		
		$("#password_unlock").submit(function (e) {
			e.preventDefault();

			dataString = $('#password_unlock').serialize();

			$.ajax({
				type: "POST",
				url: "ajax/pass_ajax.php",
				data: dataString,
				dataType: "json",
				success: function (data) {	
					if (data.error == 1) {
						$("#password_unlock_error").html("Password is incorrect, try again!");
					} else {
						var url =  "<?php echo $link; ?>";						
						window.location.href = url;
					}


				}
			});
		});






});
</script>
<?php
function getLockedURL($type, $code) 
{
	$lockedLink = "";
    if($type == "bb")
	{
		$result = mysql_fetch_assoc(mysql_query("SELECT * FROM links_banner WHERE code = '".$code."'"));
		$lockedLink = $result["redirect_link"];
		
	}
	else if($type == "ss")
	{	
		$result = mysql_fetch_assoc(mysql_query("SELECT * FROM links_social WHERE code = '".$code."'"));
		$lockedLink = $result["link"];	
	}
	
	return $lockedLink;
}
?>
<script>
	function myCallback(jsonParam)
	{
		$.ajax({
            type: "POST",
            url: "ajax/social_ajax.php",
            data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>", g: 1 },
            success: function (data) {
                $("#plusone").hide();
            }
        });
	}

	function unlockBanner(code) {
		$.ajax({
            type: "POST",
            url: "ajax/banner_ajax.php",
            data: { code: code, ip: "<?php echo $visitor_ip;?>" },
            success: function (data) {
                location.href = "<?php echo getLockedURL($type,$code);?>";
            }
        });
	}




	function sharered() {
		// comment bellow to make it work
		//return false;
		 $.ajax({
	        type: "POST",
	        url: "ajax/social_ajax.php",
	        // tw change to 1
	        data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>", tw: 1 },
	        success: function (data) {
	            $(".tw-share").hide();
	        }
	    });
	}




	function gplus() {
		 $.ajax({
	        type: "POST",
	        url: "ajax/social_ajax.php",
	        data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>", g: 1 },
	        success: function (data) {
	            $(".g-plus").hide();
	        }
	    });
	}


	window.twttr = (function (d, s, id) {
  var t, js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src= "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
  return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
}(document, "script", "twitter-wjs"));

function popupTweetLogin() {
	var myWindow = popupCenter('https://twitter.com/intent/tweet?url=http%3A%2F%2Flockframe.net%2Fssf3xv5wz&original_referer=http%3A%2F%2Flockframe.net%2Fssf3xv5wz&text="<?php echo $JM['description']; ?>"','myPop1',600,600);
	var timer = setInterval(function() {   
	    if(myWindow.closed) {  
	        clearInterval(timer);  
	        sharered();
	    }  
	}, 1000); 
}


function popupTweetLogin2() {
    var myWindow = popupCenter('http://lockframe.net/ajax/login.php','myPop1',600,600);
    myWindow.onhashchange = function() { 
        console.log(myWindow.location.hash, 'location');
    }


    var timer = setInterval(function() {
        console.log(myWindow.location.href);   
        if(myWindow.closed) {  
            clearInterval(timer);  
           //sharered();
        }  
    }, 3000); 
}



//'http://google.lt', 'myPop1',450,450
function popupCenter(url, title, w, h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 


</script>
  <div class="content_lock_bg">
 </div>
    <span class="twitter-wjs" style="display: none;"></span>
    <div id="fb-root"></div>
	<?php if($type == 'ss'){ 
		?>
        <script>
                setInterval(function() {
                    $.ajax({
                        url: '/ajax/soc.php',
                        type: 'GET',
                        dataType: 'json',
                        data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>"},
                    })
                    .always(function(out) {
                        if(out.err == 'ok') {
                            location.href = out.link;
                        }
                        
                    });
                    
                }, 5000);

        </script>
    <div class="unlock_panel">

        <?php  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $codukas = $_SERVER['REQUEST_URI'];
        if(($b_fb+$b_tw+$b_g)>1)
        {
        ?><p>&nbsp;If you want unlock content you must to do these actions:</p><?php
        }else{
        ?><p>&nbsp;If you want unlock content you must to do this action:</p><?php
        }?>

        <div class="unlock_buttons">
            
            <?php if ($b_fb == 1){?>
             
              

                <div class="share_fb" style="cursor: pointer; cursor: hand;"><img src="http://lockframe.net/img/images.png" style="width: 75px;  "></div>
                  <script>
                    $(".share_fb").click(function(event) {
                        $.ajaxSetup({ cache: true });
                        $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
                            FB.init({
                              appId: '565855746949887',
                              version: 'v2.3' // or v2.0, v2.1, v2.0
                            });
                            FB.ui({
                                method: 'share',
                                title: "<?php echo $JM['title']; ?>",
                                description: "<?php echo $JM['description']; ?>",
                                href: "<?php echo $actual_link; ?>",
                              },
                              function(response) {
                                if (response && !response.error_code) {
                                   $.ajax({
                                        type: "POST",
                                        url: "ajax/social_ajax.php",
                                        data: { code: "<?php echo $code; ?>", ip: "<?php echo $visitor_ip;?>", fb: 1 },
                                        success: function (data) {
                                            $(".fb-like").hide();
                                        }
                                    });
                                } else {
                                  
                                }
                            });
                        });
                    });
                </script>
				<!-- <div class="fb-share-button" data-href="http://lockframe.net" data-layout="button_count" data-text="test"></div><br/> -->
			<?php }?>
			
			<?php if ($b_tw == 1){
				?>
                    <script src="js/oauth.js"></script>

					<script type="text/javascript">
					function tryLogIn() {
						//popupTweetLogin2();
                        OAuth.initialize('qy8WvS8VlP3fKTX0P-zpH6uozt0');
                        OAuth.popup('twitter', function(error, success){
                            // See the result below
                            if(error == null) {
                                oauth_token = success.oauth_token;
                                oauth_token_secret = success.oauth_token_secret;

                                var myWindow = popupCenter("https://twitter.com/intent/tweet?url=<?php echo $actual_link; ?>&original_referer=<?php echo $actual_link; ?>&text=<?php echo $JM['description']; ?>",'myPop1',600,600);
                                var timer = setInterval(function() {   
                                    if(myWindow.closed) {  
                                        clearInterval(timer);  
                                        setTimeout(function() {
                                            success.get('/1.1/statuses/user_timeline.json').done(function(data) {
                                                console.log(data);
                                              
                                                for(var i in data[0].entities.urls) {
                                                    var url = data[0].entities.urls[i];
                                                    var displayed = url.expanded_url;
                                                    if(displayed == "<?php echo $actual_link; ?>") {
                                                        console.log('shared');
                                                        sharered();
                                                    }
                                                }

                                                
                                            });
                                        }, 1000);
                                        
                                    }  
                                }, 1000); 



                            }
                        });


                        
					}
					</script>

                    
					<a href="" class="tw-share" onclick="tryLogIn(); return false;"><img src="http://lockframe.net/img/tweet.png"/></a>


				<?php

		 }?>
				
			<?php if ($b_g == 1){ ?>  

				<div style="width:40px !important; position: relative !important; " data-action="share" class="g-plus" id="share-googleplus"></div>

				<script src="js/gplus.js"></script>
			<script>
				 gapi.plus.render('share-googleplus', {
			            action: "share",
			            href: "<?php echo $actual_link; ?>",
			        });
			        
	            window.onmessage = function (mes)
			    {
			        var s = mes.data.replace("!_", "");
			        s = $.parseJSON(s);
			        if (s.s.indexOf("_g_restyleMe") != -1 && Object.keys(s.a[0]).length == 1 && s.a[0].hasOwnProperty("height")) {
			           gplus();
			        }
			    }

			</script>

	

				
			<?php }
		
				?>
		</div> 
     
        <div class="locked_by"><span>Content locked by</span> <a href="index.php"><img src="img/small_head.png" alt="LockFrame"></a></div>
    </div>
	<
	<div id="ads" style="margin: 5px auto; height: 95px; width: 728px; z-index: 2000000000; position: relative;">
			<iframe data-aa='401669' src='//ad.a-ads.com/401669?size=728x90' scrolling='no' style='width:728px; height:90px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
	</div>

	<?php }else if($type == 'pp'){ ?>
		<div class="unlock_panel" style="height: 200px;">
			<p>&nbsp;Input password as unlock content</p>
			<div id="password_unlock_error" style="margin-left: 7px; color: #FF5E5E; font-weight: bolder;"></div>
			<form id="password_unlock">
				<input type="hidden" id="code" name="code" value="<?php echo $code;?>">
				<input type="password" id="password" name="password" style="margin-left: 7px; width: 300px;"><br>
				<input type="submit" value="Unlock" style="margin-top: 10px; width: 100px; margin-left: 35%;">
			</form>
			<div class="locked_by" style="margin-top: 20px;"><span>Content locked by</span> <a href="index.php"><img src="img/small_head.png" alt="LockFrame"></a></div>
		</div>
		
		<div id="ads" style="margin: 5px auto; height: 95px; width: 728px; z-index: 2000000000; position: relative;">
			<iframe data-aa='401669' src='//ad.a-ads.com/401669?size=728x90' scrolling='no' style='width:728px; height:90px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
		</div>
	<?php } else if($type == 'bb' ) {
		if($lockresult['unlocked'] >= 1) {
			?>
			<script>
			location.href= "<?php echo $result['redirect_link']; ?>";
			

			</script>
			<?php
			die();
		}
		echo ' <div class="unlock_panel" style="    width: 50%;
    text-align: center;
    height: 40%;">

       	 <p>&nbsp;If you want unlock content you must click on banner:</p><?php
     

        <div class="unlock_buttons">';
		echo '
			<a href="'.$result['link'].'" target="_blank" onclick="unlockBanner(\''.$result['code'].'\');" ><img  src="http://lockframe.net/uploads/'.$result['banner'].'" style="width: 200px;"/></a>

			<div class="locked_by" style="margin-top: 20px;"><span>Content locked by</span> <a href="index.php"><img src="img/small_head.png" alt="LockFrame"></a></div>
		</div>';
		 }

?>

</body>
</html>