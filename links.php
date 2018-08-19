<?php 
define('INCLUDED', true);
define('ROOT_PATH', 'forum/');
include 'forum/sources/common.php';
$session->update('index');
if(isset($session->sess_info['user_info'])) {
    $_SESSION['ID'] = $session->sess_info['user_info']['id'];
    $_SESSION['username'] = $session->sess_info['user_info']['name'];
}

if(isset($_SESSION['ID']) == false)
	header("Location: http://www.lockframe.net");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="description" content="Online Affiliate Tool">
<meta name="keywords" content="Affiliate, Advertisement, Lock, Banner, Share">
<meta name="author" content="LockFrame">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>LockFrame - Online Affiliate Tool</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="js/javascripts.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
<link rel="stylesheet" href="styletwitter.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="jqwidgets/jqxmenu.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.selection.js"></script>	
<script type="text/javascript" src="jqwidgets/jqxgrid.edit.js"></script>	
<script type="text/javascript" src="jqwidgets/jqxgrid.filter.js"></script>		
<script type="text/javascript" src="jqwidgets/jqxdata.js"></script>	
<script type="text/javascript" src="jqwidgets/jqxgrid.pager.js"></script>
<script type="text/javascript" src="jqwidgets/jqxgrid.sort.js"></script>		
<script type="text/javascript" src="jqwidgets/jqxlistbox.js"></script>	
<script type="text/javascript" src="jqwidgets/jqxdropdownlist.js"></script>	
<script type="text/javascript" src="jqwidgets/jqxwindow.js"></script>
<script type="text/javascript" src="jqwidgets/jqxcheckbox.js"></script>
<script type="text/javascript" src="jqwidgets/jqxinput.js"></script>
<script type="text/javascript" src="scripts/gettheme.js"></script>
<script type="text/javascript" src="js/SimpleAjaxUploader.js"></script>
<script type="text/javascript" src="js/twitterFetcher.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		
		var theme = getDemoTheme();
		
		$( "#lock_type" ).change(function() {
			if($("#lock_type").val() == 'social')
			{
				var source =
				{
					datatype: "json",
					datafields: [
						{ name: 'Code' },
						{ name: 'Link' },
						{ name: 'Date' },
						{ name: 'Title' },
						{ name: 'Description' },
						{ name: 'Facebook', type: 'bool' },
						{ name: 'Twitter', type: 'bool' },
						{ name: 'Google', type: 'bool' },
					],
					url: 'social_grid_data.php',

					cache: false,
					updaterow: function (rowID, rowdata, commit) {
						sCode = rowdata.Code.toString().substr(16, 8);
						iFb = 0;
						iTw = 0;
						iG = 0;
						if (rowdata.Facebook) { iFb = 1 } else { iFb = 0 };
						if (rowdata.Twitter) { iTw = 1 } else { iTw = 0 };
						if (rowdata.Google) { iG = 1 } else { iG = 0 };
						data = "update=true&link=" + rowdata.Link + "&fb_check=" + iFb + "&tw_check=" + iTw + "&g_check=" + iG + "&Title=" + rowdata.Title + "&Description=" + rowdata.Description;
						data = data + "&code=" + sCode;
						$.ajax({
							dataType: 'json',
							url: 'social_grid_data.php',
							type: 'POST',
							data: data,
							success: function (data, status, xhr) {
								if(data.err) {
									console.log(data.err);
									if(data.err == 'empty pass') {
										$('.klaidaSoc').html('Please fill password!');
									} else if(data.err == 'empty link') {
										$('.klaidaSoc').html('Please fill link!');
									} else if(data.err == 'bad link')
										$('.klaidaSoc').html('Please write correct link!');
									else if(data.err == 'no act')
										$('.klaidaSoc').html('Sorry, but atleast one action should be selected.');
									else if(data.err == 'titleLength')
										$('.klaidaSoc').html('Sorry, but title should be between 5 and 50 symbols!.');
									else if(data.err == 'descriptionLen')
										$('.klaidaSoc').html('Sorry, but description should be between 10 and 250 symbols!.');
									else if(data.err == 'linkLen')
										$('.klaidaSoc').html('Sorry, link is too long. Max 250 symbols!.');
								} else {
									$("#popupWindow").jqxWindow('close');
									commit(true);
								}
							}
						});
					},
					deleterow: function (rowid, commit) {
						data = "delete=true&code=" + deleteRowCode.toString();
						$.ajax({
							dataType: 'json',
							url: 'social_grid_data.php',
							type: 'POST',
							data: data,
							success: function (data, status, xhr) {
								commit(true);
							}
						});
					}
				};
			
				var dataAdapter = new $.jqx.dataAdapter(source);
				var editrow = -1;
				var deleterow = -1;
				var deleteRowCode = '';
				$("#jqxgrid").jqxGrid(
					{
						source: source,
						theme: theme,
						width: 740,
						pageable: true,
						enablebrowserselection: true,
						altrows: true,
						sortable: true,
						enabletooltips: true,
						columns: [
						{ text: 'Code', datafield: 'Code', width: 200 },
						{ text: 'Link', datafield: 'Link', width: 350 },
						{ text: 'Creation date', datafield: 'Date', width: 180 },
						{ text: 'FB', datafield: 'Facebook', columntype: 'checkbox', width: 50 },
						{ text: 'TW', datafield: 'Twitter', columntype: 'checkbox', width: 50 },
						{ text: 'G', datafield: 'Google', columntype: 'checkbox', width: 50 },
						{ text: 'Title', datafield: 'Title', width: 200 },
						{ text: 'Description', datafield: 'Description', width: 300 },
						{ text: 'Edit', datafield: 'Edit', columntype: 'button', cellsrenderer: function () {
							return "Edit";
						}, buttonclick: function (row) {
							// open the popup window when the user clicks a button.
						  
							editrow = row;

							var offset = $("#jqxgrid").offset();
							$("#popupWindow").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60} });

							// get the clicked row's data and initialize the input fields.
							var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
							$("#link").val(dataRecord.Link);
							$("#fb_checkbox").prop('checked', dataRecord.Facebook);
							$("#tw_checkbox").prop('checked', dataRecord.Twitter);
							$("#g_checkbox").prop('checked', dataRecord.Google);
							$("#description").val(dataRecord.Description);
							$("#title").val(dataRecord.Title);
							// show the popup window.
							$("#popupWindow").jqxWindow('open');
						}

						},
						 { text: 'Delete', datafield: 'Delete', columntype: 'button', cellsrenderer: function () {
							 return "Delete";
						 }, buttonclick: function (row) {
							 deleterow = row;
							 $("#SocialDeletePopup").jqxWindow('open');

						 }
						 }
					]
					});

				$("#popupWindow").jqxWindow({
					height:300, width: 500, resizable: false, isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.01
				});

				$("#SocialDeletePopup").jqxWindow({
					width: 200, resizable: false, isModal: true, autoOpen: false, cancelButton: $("#SocialNo"), modalOpacity: 0.01
				});

				$("#popupWindow").on('open', function () {
					$("#link").jqxInput('selectAll');

				});
				
				$("#popupWindow").on('close', function () {
					$('.klaidaSoc').html('');
				});

				$("#Cancel").jqxButton();
				$("#Save").jqxButton();
				$("#SocialYes").jqxButton();
				$("#SocialNo").jqxButton();

				$("#Save").click(function () {

					if (editrow >= 0) {
						rowID = $('#jqxgrid').jqxGrid('getrowdata', editrow);
						row = { Title: $('#title').val(), Description: $('#description').val() ,Code: rowID.Code, Link: $("#link").val(), Date: rowID.Date, Facebook: $("#fb_checkbox").is(':checked'), Twitter: $("#tw_checkbox").is(':checked'), Google: $("#g_checkbox").is(':checked') };
						$('#jqxgrid').jqxGrid('updaterow', editrow, row);
						
					}
				});

				$("#SocialYes").click(function () {
					rowID = $('#jqxgrid').jqxGrid('getrowdata', deleterow);
					deleteRowCode = rowID.Code.toString().substr(16, 8);
					$("#jqxgrid").jqxGrid('deleterow', deleterow);
					$("#SocialDeletePopup").jqxWindow('close');

				});
				
			}
			else if($("#lock_type").val() == 'password')
			{
				var source =
				{
					datatype: "json",
					datafields: [
						{ name: 'Code' },
						{ name: 'Link' },
						{ name: 'Date' },
						{ name: 'Password' },
					],
					url: 'pass_grid_data.php',

					cache: false,
					updaterow: function (rowID, rowdata, commit) {
						sCode = rowdata.Code.toString().substr(16, 8);
						data = "update=true&link=" + rowdata.Link + "&password=" + rowdata.Password + "&code=" + sCode;
						$.ajax({
							dataType: 'json',
							url: 'pass_grid_data.php',
							type: 'POST',
							data: data,
							success: function (data, status, xhr) {
								if(data.err) {
									if(data.err == 'empty pass') {
										$('.klaidaPass').html('Please fill password!');
									} else if(data.err == 'empty link') {
										$('.klaidaPass').html('Please fill link!');
									} else if(data.err == 'bad link'){
										$('.klaidaPass').html('Please write correct link!');
									} else if(data.err == 'too short')
										$('.klaidaPass').html('Password is too short! min 4 symbols.');
								} else {
									$("#popupPassword").jqxWindow('close');
									commit(true);
								}
							}
						});
					},
					deleterow: function (rowid, commit) {
						data = "delete=true&code=" + deleteRowCode.toString();
						$.ajax({
							dataType: 'json',
							url: 'pass_grid_data.php',
							type: 'POST',
							data: data,
							success: function (data, status, xhr) {
								commit(true);
							}
						});
					}
				};
			
				var dataAdapter = new $.jqx.dataAdapter(source);
				var editrow = -1;
				var deleterow = -1;
				var deleteRowCode = '';
				$("#jqxgrid").jqxGrid(
					{
						source: source,
						theme: theme,
						width: 740,
						pageable: true,
						enablebrowserselection: true,
						altrows: true,
						sortable: true,
						enabletooltips: true,
						columns: [
						{ text: 'Code', datafield: 'Code', width: 200 },
						{ text: 'Link', datafield: 'Link', width: 350 },
						{ text: 'Creation date', datafield: 'Date', width: 180 },
						{ text: 'Password', datafield: 'Password', width: 180 },
						{ text: 'Edit', datafield: 'Edit', columntype: 'button', cellsrenderer: function () {
							return "Edit";
						}, buttonclick: function (row) {
							// open the popup window when the user clicks a button.
						  
							editrow = row;
							var offset = $("#jqxgrid").offset();
							$("#popupPassword").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60} });

							// get the clicked row's data and initialize the input fields.
							var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
							$("#pass_link").val(dataRecord.Link);
							$("#password").val(dataRecord.Password);
							// show the popup window.
							$("#popupPassword").jqxWindow('open');
						}

						},
						 { text: 'Delete', datafield: 'Delete', columntype: 'button', cellsrenderer: function () {
							 return "Delete";
						 }, buttonclick: function (row) {

							 deleterow = row;
							 $("#PasswordDeletePopup").jqxWindow('open');

						 }
						 }
					]
					});

				$("#popupPassword").jqxWindow({
					height: 300, width: 400, resizable: false, isModal: true, autoOpen: false, cancelButton: $("#CancelPass"), modalOpacity: 0.01
				});

				$("#PasswordDeletePopup").jqxWindow({
					width: 200, resizable: false, isModal: true, autoOpen: false, cancelButton: $("#PasswordNo"), modalOpacity: 0.01
				});

				$("#popupPassword").on('open', function () {
					$("#pass_link").jqxInput('selectAll');
				});

				$("#CancelPass").jqxButton();
				$("#SavePass").jqxButton();
				$("#PasswordYes").jqxButton();
				$("#PasswordNo").jqxButton();

				$("#SavePass").click(function () {

					if (editrow >= 0) {
						rowID = $('#jqxgrid').jqxGrid('getrowdata', editrow);
						row = { Code: rowID.Code, Link: $("#pass_link").val(), Date: rowID.Date, Password:  $("#password").val()};
						$('#jqxgrid').jqxGrid('updaterow', editrow, row);
						
					}
				});

				$("#PasswordYes").click(function () {				
					rowID = $('#jqxgrid').jqxGrid('getrowdata', deleterow);
					deleteRowCode = rowID.Code.toString().substr(16, 8);
					$("#jqxgrid").jqxGrid('deleterow', deleterow);
					$("#PasswordDeletePopup").jqxWindow('close');

				});
				
			}
			else if($("#lock_type").val() == 'banner')
			{
				var source =
				{
					datatype: "json",
					datafields: [
						{ name: 'Code' },
						{ name: 'Link' },
						{ name: 'Date' },
						{ name: 'Banner' },
						{ name: 'BannerLink' },
					],
					url: 'banner_grid_data.php',

					cache: false,
					updaterow: function (rowID, rowdata, commit) {
						sCode = rowdata.Code.toString().substr(16, 8);
						data = "update=true&link=" + rowdata.Link + "&code=" + sCode+ "&link2="+rowdata.BannerLink;
						$.ajax({
							dataType: 'json',
							url: 'banner_grid_data.php',
							type: 'POST',
							data: data,
							success: function (data, status, xhr) {
								if(data.err) {
									 if(data.err == 'empty link') {
										$('.klaidaBanner').html('Please fill link!');
									} else if(data.err == 'bad link')
										$('.klaidaBanner').html('Please write correct link!');

									if(data.err == 'empty link2') {
										$('.klaidaBanner').html('Please fill banner link!');
									} else if(data.err == 'bad link2')
										$('.klaidaBanner').html('Please write correct banner link!');

								} else {
									$("#popupBanner").jqxWindow('close');
									commit(true);
								}
							}
						});
					},
					deleterow: function (rowid, commit) {
						data = "delete=true&code=" + deleteRowCode.toString();
						$.ajax({
							dataType: 'json',
							url: 'banner_grid_data.php',
							type: 'POST',
							data: data,
							success: function (data, status, xhr) {
								commit(true);
							}
						});
					}
				};
			
				var dataAdapter = new $.jqx.dataAdapter(source);
				var editrow = -1;
				var deleterow = -1;
				var deleteRowCode = '';
				$("#jqxgrid").jqxGrid(
					{
						source: source,
						theme: theme,
						width: 740,
						pageable: true,
						autorowheight: true,
            			autoheight: true,

						enablebrowserselection: true,
						altrows: true,
						sortable: true,
						enabletooltips: true,
						columns: [
						{ text: 'Code', datafield: 'Code', width: 200 },
						{ text: 'Link', datafield: 'Link', width: 350 },
						{ text: 'Creation date', datafield: 'Date', width: 180 },
						{ text: 'Banner', datafield: 'Banner', width: 180 },
						{ text: 'Banner link', datafield: 'BannerLink', width: 350 },
						{ text: 'Edit', datafield: 'Edit', columntype: 'button', cellsrenderer: function () {
							return "Edit";
						}, buttonclick: function (row) {
							// open the popup window when the user clicks a button.
						  
							editrow = row;
							var offset = $("#jqxgrid").offset();
							$("#popupBanner").jqxWindow({ position: { x: parseInt(offset.left) + 60, y: parseInt(offset.top) + 60} });

							// get the clicked row's data and initialize the input fields.
							var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', editrow);
							$("#bannerLink").val(dataRecord.Link);
							$("#banner").html(dataRecord.Banner);
							$("#bannerLink2").val(dataRecord.BannerLink);
							// show the popup window.
							$("#popupBanner").jqxWindow('open');
						}

						},
						 { text: 'Delete', datafield: 'Delete', columntype: 'button', cellsrenderer: function () {
							 return "Delete";
						 }, buttonclick: function (row) {
							 deleterow = row;
							 $("#BannerDeletePopup").jqxWindow('open');

						 }
						 }
					]
					});

				$("#popupBanner").jqxWindow({
					height: 400, width: 400, resizable: false, isModal: true, autoOpen: false, cancelButton: $("#CancelBanner"), modalOpacity: 0.01
				});

				$("#BannerDeletePopup").jqxWindow({
					width: 200, resizable: false, isModal: true, autoOpen: false, cancelButton: $("#BannerNo"), modalOpacity: 0.01
				});

				$("#popupBanner").on('open', function () {
					$("#bannerLink").jqxInput('selectAll');
				});

				$("#CancelBanner").jqxButton();
				$("#SaveBanner").jqxButton();
				$("#BannerYes").jqxButton();
				$("#BannerNo").jqxButton();

				$("#SaveBanner").click(function () {

					if (editrow >= 0) {
						rowID = $('#jqxgrid').jqxGrid('getrowdata', editrow);
						if($("#newBnr").length > 0)
							row = { Code: rowID.Code, Link: $("#bannerLink").val(), BannerLink: $("#bannerLink2").val(), Date: rowID.Date, Banner: '<img style="width: 50px;" src="http://adasu.info/lockframe/uploads/'+ $("#newBnr").attr('banner') + '"/>'};
						else row = { Code: rowID.Code, Link: $("#bannerLink").val(), BannerLink: $("#bannerLink2").val(), Date: rowID.Date, Banner: $('#banner').html()};
						$('#jqxgrid').jqxGrid('updaterow', editrow, row);
						
					}
				});

				$("#BannerYes").click(function () {					
					rowID = $('#jqxgrid').jqxGrid('getrowdata', deleterow);
					deleteRowCode = rowID.Code.toString().substr(16, 8);
					$("#jqxgrid").jqxGrid('deleterow', deleterow);
					$("#BannerDeletePopup").jqxWindow('close');
				});
				
			}
		});
    });



$(function() {
  
  var btn = document.getElementById('upload-btn'),
      wrap = document.getElementById('pic-progress-wrap'),
      picBox = document.getElementById('picbox'),
      errBox = document.getElementById('errormsg');
	
 	 var uploader = new ss.SimpleUpload({
        button: btn,
        url: '/uploader.php?ajax',
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
            if (!response) {
              errBox.innerHTML = 'Unable to upload file';
            }     
            if (response.success === true) {
               picBox.innerHTML = 'New banner: <img id="newBnr" banner="'+response.file+'" style="width: 50px;" src="http://lockframe.net/uploads/' + response.file + '">';
            } else {
              if (response.msg)  {
                errBox.innerHTML = response.msg;
              } else {
                errBox.innerHTML = 'Unable to upload file';
              }
            }            
            
          }
	});

 	 var config2 = {
	  "id": '347099293930377217',
	  "domId": 'example2',
	  "maxTweets": 5,
	  "enableLinks": true,
	  "showUser": true,
	  "showTime": true,
	  "lang": 'en'
	};
	twitterFetcher.fetch(config2);


});
</script>
</head>

<body>



<?php
require_once 'template.php';

$user_id = $_SESSION['ID'];
$Template = new Template;
$avatar = $Template->GetUserAvatar();
$Template->PrintHeader($avatar);
$Template->PrintLinksList($user_id);

?>

        <div style="margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
       </div>
       <div id="popupWindow" style="display: none;">
            <div>Edit</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="right">Link:</td>
                        <td align="left"><input id="link" /></td>
                    </tr>
                    <tr>
                        <td align="right">Facebook:</td>
                        <td align="left"><input type="checkbox" name="facebook" value="facebook" id="fb_checkbox"></td>
                    </tr>
                    <tr>
                        <td align="right">Twitter:</td>
                        <td align="left"><input type="checkbox" name="twitter" value="twitter" id="tw_checkbox"></td>
                    </tr>
                    <tr>
                        <td align="right">Google:</td>
                        <td align="left"><input type="checkbox" name="google" value="google" id="g_checkbox"></td>
                    </tr>
                    <tr>
                        <td align="right">Title:</td>
                        <td align="left"><input type="text" value="" id="title"></td>
                    </tr>
                    <tr>
                        <td align="right">Description:</td>
                        <td align="left"><textarea id="description"></textarea></td>
                    </tr>
					<tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px; width: 100%;" align="right"><input style="margin-right: 5px;" type="button" id="Save" value="Save" /><input id="Cancel" type="button" value="Cancel" /></td>
                    </tr>  
                    <tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px;" align="right"><span class="klaidaSoc" style="margin-right: 5px; color: #FF5E5E; font-weight: bolder;"></span></td>
                    </tr>          	
                </table>
            </div>          
       </div>
	   
	    <div id="popupPassword" style="display: none;">
            <div>Edit</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="right">Link:</td>
                        <td align="left"><input id="pass_link" /></td>
                    </tr>
                    <tr>
                        <td align="right">Password:</td>
                        <td align="left"><input id="password"></td>
                    </tr>
					<tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="SavePass" value="Save" /><input id="CancelPass" type="button" value="Cancel" /></td>
                    </tr>  	
                    <tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px;" align="right"><span class="klaidaPass" style="color: #FF5E5E; font-weight: bolder;"></span></td>
                    </tr>  					
                </table>
            </div>          
       </div>
	   <div id="popupBanner" style="display: none;">
            <div>Edit</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="right">Link:</td>
                        <td align="left"><input id="bannerLink" /></td>
                    </tr>
                     <tr>
                        <td align="right">Banner link:</td>
                        <td align="left"><input id="bannerLink2" /></td>
                    </tr>
                    <tr>
                        <td align="right">Banner:</td>
                        <td align="left"><span id="banner"></span>

                		<input type="button" id="upload-btn" class="btn btn-primary btn-large clearfix" value="Choose file">
           				<span style="padding-left:5px;vertical-align:middle;"><i>PNG, JPG, or GIF (1024K max file size)</i></span>
                
               			 <div id="errormsg" class="clearfix redtext" style="padding-top: 10px;"></div>
                
                		<div id="pic-progress-wrap" class="progress-wrap" style="margin-top:10px;margin-bottom:10px;"></div>
               			<div id="picbox" class="clear" style="padding-top:0px;padding-bottom:10px;"></div>
                
               			 <div class="clear-line" style="margin-top:10px;"></div>
               			</td>
               		</tr>
               		<tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px;" align="right"><span class="klaidaBanner" style="color: #FF5E5E; font-weight: bolder;"></span></td>
                    </tr>
               		
            </div>
        </div>


                        </td>
                    </tr>
					<tr>
                        <td align="right"></td>
                        <td style="padding-top: 10px;" align="right"><input style="margin-right: 5px;" type="button" id="SaveBanner" value="Save" /><input id="CancelBanner" type="button" value="Cancel" /></td>
                    </tr>  					
                </table>
            </div>          
       </div>	   
       <div id="SocialDeletePopup" style="display: none;">
           <div>Delete</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="center">Are you sure want delete this link?</td>
                    </tr>     
					<tr>
                        <td style="padding-top: 10px;" align="center"><input style="margin-right: 5px;" type="submit" id="SocialYes" value="Yes" /><input id="SocialNo" type="button" value="No" /></td>
                    </tr>          	
                </table>
            </div>
       </div>
	   <div id="BannerDeletePopup" style="display: none;">
           <div>Delete</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="center">Are you sure want delete this link?</td>
                    </tr>     
					<tr>
                        <td style="padding-top: 10px;" align="center"><input style="margin-right: 5px;" type="submit" id="BannerYes" value="Yes" /><input id="BannerNo" type="button" value="No" /></td>
                    </tr>          	
                </table>
            </div>
       </div>
	   <div id="PasswordDeletePopup" style="display: none;">
           <div>Delete</div>
            <div style="overflow: hidden;">
                <table>
                    <tr>
                        <td align="center">Are you sure want delete this link?</td>
                    </tr>     
					<tr>
                        <td style="padding-top: 10px;" align="center"><input style="margin-right: 5px;" type="submit" id="PasswordYes" value="Yes" /><input id="PasswordNo" type="button" value="No" /></td>
                    </tr>          	
                </table>
            </div>
       </div>
</body>

</html>