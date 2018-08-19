<?php

/*
	Copyright (C) 2003-2012 UseBB Team
	http://www.usebb.net
	
	$Id$
	
	This file is part of UseBB.
	
	UseBB is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	UseBB is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with UseBB; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Panel login
 *
 * Gives an interface to login into user accounts.
 *
 * @author	UseBB Team
 * @link	http://www.usebb.net
 * @license	GPL-2
 * @version	$Revision$
 * @copyright	Copyright (C) 2003-2012 UseBB Team
 * @package	UseBB
 * @subpackage	Panel
 */

//
// Die when called directly in browser
//
if ( !defined('INCLUDED') )
	exit();

//
// User wants to login
//
$session->update('login');

//
// Include the page header
//
require(ROOT_PATH.'sources/page_head.php');

$template->add_breadcrumb($lang['LogIn']);

$_POST['user'] = ( !empty($_POST['user']) ) ? preg_replace('#\s+#', ' ', $_POST['user']) : '';

if ( !empty($_POST['user']) && !empty($_POST['passwd']) && preg_match(USER_PREG, $_POST['user']) && $functions->validate_password(stripslashes($_POST['passwd'])) ) {
		
	//
	// The user already passed a username and password
	//
	
	$result = $db->query("SELECT id, passwd, active, active_key, banned, banned_reason, level, last_pageview FROM ".TABLE_PREFIX."members WHERE name = '".$_POST['user']."'");
	$userdata = $db->fetch_result($result);

	//
	// If this user/password does not exist...
	//
	if ( !$userdata['id'] || md5(stripslashes($_POST['passwd'])) != $userdata['passwd'] ) {
		
		//
		// ...show a warning
		//
		$template->parse('msgbox', 'global', array(
			'box_title' => $lang['Error'],
			'content' => sprintf($lang['WrongUsernamePassword'], '<em>'.unhtml(stripslashes($_POST['user'])).'</em>')
		));
		
	} elseif ( $userdata['banned'] ) {
		
		//
		// User is banned
		//

		$banned_reason = ( !empty($userdata['banned_reason']) ) ? '<br /><br />'.$userdata['banned_reason'] : ' <em>'.$lang['Unknown'].'</em>';

		$template->parse('msgbox', 'global', array(
			'box_title' => $lang['BannedUser'],
			'content' => sprintf($lang['BannedUserExplain'], '<em>'.unhtml(stripslashes($_POST['user'])).'</em>').$banned_reason
		));
		
	} elseif ( !$userdata['active'] ) {
		
		//
		// Account hasn't been activated yet
		//

		$msg_string = ( !empty($userdata['active_key']) ) ? $lang['NotActivated'] : $lang['NotActivatedByAdmin'];

		$template->parse('msgbox', 'global', array(
			'box_title' => $lang['Error'],
			'content' => sprintf($msg_string, '<em>'.unhtml(stripslashes($_POST['user'])).'</em>')
		));
		
	} elseif ( $functions->get_config('board_closed') && $userdata['level'] != LEVEL_ADMIN ) {
		
		//
		// Only admins can log in when the forum is closed.
		//
		$template->parse('msgbox', 'global', array(
			'box_title' => $lang['Error'],
			'content' => $lang['BoardClosedOnlyAdmins']
		));
		
	} else {
		
		//
		// The password is correct,
		// we will now log in the user
		//
		$session->update(NULL, $userdata['id']);
		
		//
		// Set a remember cookie if the user chose to
		//
		if ( !empty($_POST['remember']) )
			$functions->set_al($userdata['id'], $userdata['passwd']);
		
		$_SESSION['previous_visit'] = $userdata['last_pageview'];
		
		//
		// Get us back to the previous page
		//
		$refere_to = ( !empty($_SESSION['refere_to']) ) ? $functions->attach_sid($_SESSION['refere_to']) : $functions->get_config('board_url').$functions->make_url('index.php', array(), false);
		unset($_SESSION['refere_to']);

		$functions->raw_redirect($refere_to);
		
	}

} else {
	
	//
	// Show the login form, if the user is not logged in
	//
	if ( !$session->sess_info['user_id'] ) {
		
		$_SERVER['HTTP_REFERER'] = ( !empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $functions->get_config('board_url')) === 0 && !preg_match('#(?:login|logout|register|activate|sendpwd|install)#', $_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : '';
		$_SESSION['refere_to'] = ( !empty($_SESSION['referer']) ) ? $_SESSION['referer'] : $_SERVER['HTTP_REFERER'];
		unset($_SESSION['referer']);
		
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			
			$errors = array();
			if ( empty($_POST['user']) || !preg_match(USER_PREG, $_POST['user']) )
				$errors[] = $lang['Username'];
			if ( empty($_POST['passwd']) || !$functions->validate_password(stripslashes($_POST['passwd'])) )
				$errors[] = $lang['Password'];
			
			if ( count($errors) ) {
				
				$template->parse('msgbox', 'global', array(
					'box_title' => $lang['Error'],
					'content' => sprintf($lang['MissingFields'], join(', ', $errors))
				));
				
			}
			
		}
		
		$_POST['user'] = ( !empty($_POST['user']) && preg_match(USER_PREG, $_POST['user']) ) ? $_POST['user'] : '';
		if ( count($_COOKIE) < 1 ) {
			
			$remember_input = $lang['FeatureDisabledBecauseCookiesDisabled'];
			
		} else {
			
			$remember_input = '<label><input type="checkbox" name="remember" value="1" tabindex="3" /> '.$lang['Yes'].'</label>';
			
		}
		
		$template->parse('login_form', 'various', array(
			'form_begin'     => '<form action="'.$functions->make_url('panel.php', array('act' => 'login')).'" method="post">',
			'user_input'     => '<input type="text" name="user" id="user" size="25" maxlength="255" value="'.unhtml(stripslashes($_POST['user'])).'" tabindex="1" />',
			'password_input' => '<input type="password" name="passwd" size="25" maxlength="255" tabindex="2" />',
			'remember_input' => $remember_input,
			'submit_button'  => '<input type="submit" value="'.$lang['LogIn'].'" tabindex="4" />',
			'link_reg'       => '<a href="../register">'.$lang['RegisterNewAccount'].'</a>',
			'link_sendpwd'   => '<a href="../forgot_password">'.$lang['SendPassword'].'</a>',
			'form_end'       => '</form>'
		));
		$template->set_js_onload("set_focus('user')");
		
	} else {
		
		//
		// If he/she is logged in, return to index
		//
		$functions->redirect('index.php');
		
	}
	
}

//
// Include the page footer
//
require(ROOT_PATH.'sources/page_foot.php');

?>
