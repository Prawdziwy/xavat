<?php
	if(!$logged)
	{
		if($action == "logout")
			$main_content .= '
			<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
				<tr>
					<th>Logout Succesful</th>
				</tr>
				<tr class="first">
					<td>You have logged out of your '.$config['server']['serverName'].' account. In order to view your account you need to <a href="?subtopic=accountmanagement" >log in</a> again.</td>
				</tr>
			</table>';
		else
		{
			$main_content .= '
			' . $lang['site']['AM_CREATE_TEXT'] . '
			<form action="?subtopic=accountmanagement" method="POST">
			<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<th colspan="2">Account Login</th>
				</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td align="center" width="30%" style="font-weight: bold;">' . $lang['site']['AM_AL_TABLE_ACC_NUM'] . '</td>
					<td><input type="password" name="account_login" size="20" maxlength="12" ></td>
				</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
					<td align="center" width="30%" style="font-weight: bold;">' . $lang['site']['AM_AL_TABLE_PW'] . '</td>
					<td><input type="password" name="password_login" size="20" maxlength="29" ></td>
				</tr>
			</table><br />
			<table border="0" width="100%" align="center">
				<tr>
					<td align="center" valign="top">
						<input type="image" name="Submit" src="' . $layout_name . '/images/buttons/submit.png" border="0" /></form>
					</td>
					<td align="center">
						<form action="?subtopic=lostaccount" method="POST">
							<input type="image" name="Cancel" src="' . $layout_name . '/images/buttons/cancel.png" border="0" />
						</form>
					</td>
				</tr>
			</table>';
		}
	}
	else
	{
		if($action == "")
		{
			$check = $db->query("SELECT `country` FROM `players` WHERE `account_id` = " . $account_logged->getId() . ";")->fetch();
			if($check['country'] == "unknown")
			{
				$db->query("UPDATE `players` SET `country` = '" . strtolower(geoip_country_code_by_name(getIP())) . "', `lastip` = " . ip2long(revertIp(getIP())) . " WHERE `account_id` = " . $account_logged->getId() . ";");
			}
			
			$account_reckey = $account_logged->getCustomField("key");
			if(!$account_logged->isPremium())
				$account_status = '<b><font color="red">'.$lang['site']['AM_ON_ACCFREE'].'</font></b>';
			else
				$account_status = '<b><font color="green">'.$lang['site']['AM_ON_ACCPREM'].', ' . $account_logged->getPremDays() . ' ' . $lang['site']['AM_ON_DAYS'] . '</font></b>';
				
			if(empty($account_reckey))
				$account_registred = '<b><font color="red">'.$lang['site']['AM_AREG_N'].'</font></b>';
			else
				if($config['site']['generate_new_reckey'] && $config['site']['send_emails'])
					$account_registred = '<b><font color="green">'.$lang['site']['AM_AREG_Y'].' ( <a href="?subtopic=accountmanagement&action=newreckey"> '.$lang['site']['AM_AREG_BUY'].' </a> )</font></b>';
				else
					$account_registred = '<b><font color="green">'.$lang['site']['AM_AREG_Y'].'</font></b>';
					
			$account_created = $account_logged->getCustomField("created");
			$account_email = $account_logged->getEMail();
			$account_email_new_time = $account_logged->getCustomField("email_new_time");
			if($account_email_new_time > 1)
				$account_email_new = $account_logged->getCustomField("email_new");
				
			$account_rlname = $account_logged->getRLName();
			$account_location = $account_logged->getLocation();
			$account_flag = "";
			$account_gg = "";
			if($account_logged->isBanned())
				if($account_logged->getBanTime() > 0)
					$welcome_msg = '<font color="red">'.$lang['site']['AM_ON_BAN1'].' '.date("j F Y, G:i:s", $account_logged->getBanTime()).'!</font>';
				else
					$welcome_msg = '<font color="red">'.$lang['site']['AM_ON_BAN2'].'</font>';
			else
				$welcome_msg = $lang['site']['AM_ON_WELCOME'];
				
			$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<th colspan="2">Hint</th>
					</tr>
					<tr bgcolor="' . $config['site']['darkborder'] . '">
						<td width="100%" align="center">
							<nobr>[<a href="#General+Information" >' . $lang['site']['AM_ON_GENERAL'] . '</a>]</nobr>
							<nobr>[<a href="#Public+Information" >'.$lang['site']['AM_ON_PUBLIC'].'</a>]</nobr>
							<nobr>[<a href="#Characters" >'.$lang['site']['AM_ON_CHARACTERS'].'</a>]</nobr>
						</td>
						<td>
							<table border="0" cellspacing="0" cellpadding="0">
								<form action="?subtopic=accountmanagement&action=logout" method="post">
									<tr>
										<td style="border:0px; margin-right: 30px;">
											<div style="margin-right: 30px;">
												<input type="image" name="Logout" alt="Logout" src="' . $layout_name . '/images/buttons/logout.png" />
											</div>
										</td>
									</tr>
								</form>
							</table>
						</td>
					</tr>
				</table><br />';
				
			//if account dont have recovery key show hint
			if(empty($account_reckey))
			{
				$main_content .= '
					<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
						<tr bgcolor="' . $config['site']['vdarkborder'] . '">
							<td align="center">' . $lang['site']['AM_ON_HINT'] . '</td>
						</tr>
						<tr bgcolor="' . $config['site']['darkborder'] . '">
							<td align="center">
								<form action="?subtopic=accountmanagement&action=registeraccount" method="post">
									<input type="image" name="Register Account" alt="Register Account" src="'.$layout_name.'/images/buttons/register_account.png" />
								</form>
							</td>
						</tr>
					</table><br />'; 
			}
					
			if($account_email_new_time > 1)
			{
				if($account_email_new_time < time())
					$account_email_change = $lang['site']['AM_ON_MAIL_CH'] . '' . $account_email_new . '' . $lang['site']['AM_ON_MAIL_CH1'];
				else
				{
					$account_email_change = ' '.$lang['site']['AM_ON_MAIL_CH2'].' '.date("j F Y", $account_email_new_time).".</b>";
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="Message" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div><table><tr><td class="LabelV" >Note:</td><td style="width:100%;" >'.$lang['site']['AM_ON_MAIL_CH3'].''.$account_email_new.''.$lang['site']['AM_ON_MAIL_CH4'].''.date("j F Y, G:i:s", $account_email_new_time).''.$lang['site']['AM_ON_MAIL_CH5'].'</td></tr></table><div align="center" ><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement&action=changeemail" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Edit" alt="Edit" src="'.$layout_name.'/images//images/buttons/_sbutton_edit.gif" ></div></div></td></tr></form></table></div>    </div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><br/>';
				}
			}
			
			$main_content .= '
			<a name="General+Information"></a>
			<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<th colspan="2">' . $lang['site']['AM_ON_GEN_INF'] . '</th>
				</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td width="20%">' . $lang['site']['AM_ON_GEN_INF_EMAIL'] . '</td>
					<td>' . $account_email . ' ' . $account_email_change . '</td>
				</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
					<td>' . $lang['site']['AM_ON_GEN_INF_CREATED'] . '</td>
					<td>' . date("j F Y, G:i:s", $account_created) . '</td>
				</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td>' . $lang['site']['AM_ON_GEN_INF_LAST'] . '</td>
					<td>' . date("j F Y, G:i:s", time()) . '</td>
				</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
					<td>' . $lang['site']['AM_ON_GEN_INF_STATUS'] . '</td>
					<td>' . $account_status . '</td>
				</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td>' . $lang['site']['AM_ON_GEN_INF_REG'] . '</td>
					<td>' . $account_registred . '</td>
				</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
					<td>Premium Points: </td>
					<td><span style="color: ' . ($account_logged->getCustomField("premium_points") > 0 ? "lime" : "red") . '">' . $account_logged->getCustomField("premium_points") . '</span></td>
				</tr>
			</table><br />
			<div style="margin-left: 5px;">
				<a href="?subtopic=accountmanagement&action=changepassword">
					<img src="' . $layout_name . '/images/buttons/change_password.png" />
				</a> 
				<a href="?subtopic=accountmanagement&action=changeemail">
					<img src="' . $layout_name . '/images/buttons/change_email.png" />
				</a>
			</div><br />';
			
			$main_content .='
			<a name="Public+Information"></a>
			<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<th colspan="2">' . $lang['site']['AM_ON_PI_CATEGORY_INFORMATION'] . '</th>
				</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td width="20%">' . $lang['site']['AM_ON_PI_REAL_NAME'] . '</td>
					<td>' . (!empty($account_rlname) ? $account_rlname : "Unknown") . '</td>
				</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
					<td>' . $lang['site']['AM_ON_PI_LOCATION'] . '</td>
					<td>' . (!empty($account_location) ? $account_location : "Unknown") . '</td>
				</tr>
			</table><br />
			<div style="margin-left: 5px;">
				<a href="?subtopic=accountmanagement&action=changeinfo">
					<img src="' . $layout_name . '/images/buttons/edit_informations.png" />
				</a>
			</div><br />';
			
			$main_content .= '
			<a name="Characters"></a>
			<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<th colspan="4">' . $lang['site']['AM_ON_C_CATEGORY_CHARACTERS'] . '</th>
				</tr>
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<td>' . $lang['site']['AM_ON_C_NAME'] . '</td>
					<td>' . $lang['site']['AM_ON_C_LEVEL'] . '</td>
					<td>' . $lang['site']['AM_ON_C_STATUS'] . '</td>
					<td style="width:5%">&#160;</td>
				</tr>';
				
				$account_players = $account_logged->getPlayersList();
				$account_players->orderBy('name');
				foreach($account_players as $account_player)
				{
					$player_number_counter++;
					$bgcolor = ($player_number_counter % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
					
					$main_content .= '
					<tr bgcolor="' . $bgcolor . '">
						<td width="28%">' . $player_number_counter . '.&#160;' . $account_player->getName();
							if($account_player->isDeleted())
								$main_content .= '<font color="red"><b> [ DELETED ] </b> <a href="?subtopic=accountmanagement&action=undelete&name='.urlencode($account_player->getName()).'">>> UNDELETE <<</a></font>';
							if($account_player->isNameLocked())
								if($account_player->getOldName())
									$main_content .= '<font color="red"><b> [ NAMELOCK:</b> Wait for GM, new name: <b>'.$account_player->getOldName().' ]</b></font>';
								else
									$main_content .= '<font color="red"><b> [ NAMELOCK: <form action="" method="GET"><input name="subtopic" type="hidden" value="accountmanagement" /><input name="action" type="hidden" value="newnick" /><input name="name" type="hidden" value="'.$account_player->getName().'" /><input name="name_new" type="text" value="Enter here new nick" size="16" /><input type="submit" value="Set new nick" /></form> ]</b></font>';
								
								$main_content .= '
						</td>
						<td width="28%">' . $account_player->getLevel() . ' ' . $vocation_name[$account_player->getWorld()][$account_player->getPromotion()][$account_player->getVocation()] . '</td>';
							if(!$account_player->isOnline())
								$main_content .= '<td width="28%"><font color="red"><b>Offline</b></font></td>';
							else
								$main_content .= '<td><font color="green"><b>Online</b></font></td>';
							
							$main_content .= '
						<td>
							[<a href="?subtopic=accountmanagement&action=changecomment&name=' . urlencode($account_player->getName()) . '" >' . $lang['site']['AM_ON_C_EDIT'] . '</a>]
						</td>
					</tr>';
				}
				$main_content .= '
			</table><br />
			<table width="100%">
				<tr>
					<td align="left">
						<div style="margin-left: 5px;">
							<a href="?subtopic=accountmanagement&action=createcharacter">
								<img src="' . $layout_name . '/images/buttons/create_character.png" />
							</a>
						</div>
					</td>
					<td align="right">
						<div style="margin-left: 5px;">
							<a href="?subtopic=accountmanagement&action=deletecharacter">
								<img src="' . $layout_name . '/images/buttons/delete_character.png" />
							</a>
						</div>
					</td>
				</tr>
			</table><br />';
		}
		if($action == "changepassword")
		{
			$new_password = trim($_POST['newpassword']);
			$new_password2 = trim($_POST['newpassword2']);
			$old_password = trim($_POST['oldpassword']);
			if(empty($new_password) && empty($new_password2) && empty($old_password))
			{
				$main_content .= $lang['site']['AM_ON_CW_TEXT'] . '<br /><br />			
				
				<form action="?subtopic=accountmanagement&action=changepassword" method="post">
				<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
					<tr>
						<th colspan="2">' . $lang['site']['AM_ON_CAT_CW'] . '</th>
					</tr>
					<tr class="first">
						<td width="25%">' . $lang['site']['AM_ON_NPW'] . '</td>
						<td><input type="password" name="newpassword" size="30" maxlength="29"></td>
					</tr>
					<tr class="second">
						<td width="25%">' . $lang['site']['AM_ON_NPWA'] . '</td>
						<td><input type="password" name="newpassword2" size="30" maxlength="29"></td>
					</tr>
					<tr class="first">
						<td width="25%">' . $lang['site']['AM_ON_CPW'] . '</td>
						<td><input type="password" name="oldpassword" size="30" maxlength="29"></td>
					</tr>
				</table><br />
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr align="center">
						<td width="50%"><input type="image" name="Submit" alt="Submit" src="' . $layout_name . '/images/buttons/submit.png" /></form></td>
						<td width="50%">
							<form action="?subtopic=accountmanagement" method="post">
								<input type="image" name="Back" alt="Back" src="' . $layout_name . '/images/buttons/back.png" />
							</form>
						</td>
					</tr>
				</table>';
			}
			else
			{
				if(empty($new_password) || empty($new_password2) || empty($old_password))
					$show_msgs[] = $lang['site']['AM_ON_SHOW_MSGS1'];
					
				if($new_password != $new_password2)
					$show_msgs[] = $lang['site']['AM_ON_SHOW_MSGS2'];
					
				if(empty($show_msgs))
				{
					if(!check_password($new_password))
						$show_msgs[] = $lang['site']['AM_ON_SHOW_MSGS3'];
					
					$old_password = password_ency($old_password);
					if($old_password != $account_logged->getPassword())
						$show_msgs[] = $lang['site']['AM_ON_SHOW_MSGS4'];
				}
				
				if(!empty($show_msgs))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['AM_ON_ERROR'].'</b><br/>';
					foreach($show_msgs as $show_msg)
					{
						$main_content .= '<li>'.$show_msg;
					}
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
					//show form
					$main_content .= ''.$lang['site']['AM_ON_FORM'].'<br/><br/><form action="?subtopic=accountmanagement&action=changepassword" method="post" ><div class="TableContainer" ><table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" ><div class="CaptionInnerContainer" ><span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span><span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span><span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span><span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span><div class="Text" >Change Password</div><span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span><span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span><span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span><span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span></div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >New Password:</span></td><td style="width:90%;" ><input type="password" name="newpassword" size="30" maxlength="29" ></td></tr><tr><td class="LabelV" ><span >New Password Again:</span></td><td><input type="password" name="newpassword2" size="30" maxlength="29" ></td></tr><tr><td class="LabelV" ><span >Current Password:</span></td><td><input type="password" name="oldpassword" size="30" maxlength="29" ></td></tr></table>        </div>  </table></div></td></tr><br/><table style="width:100%;" ><tr align="center"><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
				}
				else
				{
					$org_pass = $new_password;
					$new_password = password_ency($new_password);
					$account_logged->setPassword($new_password);
					$account_logged->save();
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_PWCHANGER_TEXT'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['AM_ON_PWCHANGER_TEXT1'].'';
					if($config['site']['send_emails'] && $config['site']['send_mail_when_change_password'])
					{
						$mailBody = '
						<html>
							<body>
								<h3>' . $lang['site']['AM_ON_NEWPW1'] . '</h3>
								<p>' . $lang['site']['AM_ON_NEWPW2'] . ' <a href="' . $config['server']['url'] . '"><b>' . $config['server']['serverName'] . '</b></a>.</p>
								<p>' . $lang['site']['AM_ON_NEWPW3'] . ' <b>' . $org_pass . '</b></p>
							</body>
						</html>';
						
						require_once("phpmailer/class.phpmailer.php");
						$mail = new PHPMailer();
						if($config['site']['smtp_enabled'] == "yes")
						{
							$mail->IsSMTP();
							$mail->Host = $config['site']['smtp_host'];
							$mail->Port = (int)$config['site']['smtp_port'];
							$mail->SMTPAuth = ($config['site']['smtp_auth'] ? true : false);
							$mail->Username = $config['site']['smtp_user'];
							$mail->Password = $config['site']['smtp_pass'];
						}
						else
						{
							$mail->IsMail();
							$mail->IsHTML(true);
							$mail->From = $config['site']['mail_address'];
							$mail->AddAddress($account_logged->getEMail());
							$mail->Subject = $config['server']['serverName']." - Changed password";
							$mail->Body = $mailBody;
						}
						
						if($mail->Send())
							$main_content .= '<br /><small>'.$lang['site']['AM_ON_FORM_MC1'].' <b>'.$account_logged->getEMail().'</b>.</small>';
						else
							$main_content .= '<br /><small>'.$lang['site']['AM_ON_FORM_MC2'].'</small>';
					}
					
					$main_content .= '</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
					$_SESSION['password'] = $new_password;
				}
			}
		}
		if($action == "changeemail")
		{
			$account_email_new_time = $account_logged->getCustomField("email_new_time");
			if($account_email_new_time > 10)
				$account_email_new = $account_logged->getCustomField("email_new");
				
			if($account_email_new_time < 10)
			{
				if($_POST['changeemailsave'] == 1)
				{
					$account_email_new = trim($_POST['new_email']);
					$post_password = trim($_POST['password']);
					if(empty($account_email_new))
						$change_email_errors[] = $lang['site']['AM_ON_CM_TEXT1'];
					else
					{
						if(!check_mail($account_email_new))
							$change_email_errors[] = $lang['site']['AM_ON_CM_TEXT2'];
					}
					
					if(empty($post_password))
						$change_email_errors[] = $lang['site']['AM_ON_CM_TEXT3'];
					else
					{
						$post_password = password_ency($post_password);
						if($post_password != $account_logged->getPassword())
							$change_email_errors[] = $lang['site']['AM_ON_CM_TEXT4'];
					}
					
					if(empty($change_email_errors))
					{
						$account_email_new_time = time() + $config['site']['email_days_to_change'] * 24 * 3600;
						$account_logged->setCustomField("email_new", $account_email_new);
						$account_logged->setCustomField("email_new_time", $account_email_new_time);
						$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT5'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['AM_ON_CM_TEXT6'].' <b>'.$account_email_new.'</b>'.$lang['site']['AM_ON_CM_TEXT7'].' <b>'.date("j F Y, G:i:s", $account_email_new_time).'</b>'.$lang['site']['AM_ON_CM_TEXT8'].'</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
					}
					else
					{
						//show errors
						$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['AM_ON_CM_TEXT9'].'</b><br/>';
						foreach($change_email_errors as $change_email_error) {
						$main_content .= '<li>'.$change_email_error;
						}
						$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
						//show form
						$main_content .= ''.$lang['site']['AM_ON_CM_TEXT10'].' '.$config['site']['email_days_to_change'].' '.$lang['site']['AM_ON_CM_TEXT11'].'.</b><br/><br/><form action="?subtopic=accountmanagement&action=changeemail" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT12'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ></tr><td class="LabelV" ><span >'.$lang['site']['AM_ON_CM_TEXT13'].'</span></td>  <td style="width:90%;" ><input name="new_email" value="'.$_POST['new_email'].'" size="30" maxlength="50" ></td><tr></tr><td class="LabelV" ><span >'.$lang['site']['AM_ON_CM_TEXT14'].'</span></td>  <td><input type="password" name="password" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table style="width:100%;" ><tr align="center"><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><input type="hidden" name=changeemailsave value=1 ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
					}
				}
				else
				{
					$main_content .= ''.$lang['site']['AM_ON_CM_TEXT10'].' '.$config['site']['email_days_to_change'].' '.$lang['site']['AM_ON_CM_TEXT11'].'.</b><br/><br/><form action="?subtopic=accountmanagement&action=changeemail" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT12'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ></tr><td class="LabelV" ><span >'.$lang['site']['AM_ON_CM_TEXT13'].'</span></td>  <td style="width:90%;" ><input name="new_email" value="'.$_POST['new_email'].'" size="30" maxlength="50" ></td><tr></tr><td class="LabelV" ><span >'.$lang['site']['AM_ON_CM_TEXT14'].'</span></td>  <td><input type="password" name="password" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table style="width:100%;" ><tr align="center"><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><input type="hidden" name=changeemailsave value=1 ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
				}
			}
			else
			{
				if($account_email_new_time < time())
				{
					if($_POST['changeemailsave'] == 1)
					{
						$account_logged->setCustomField("email_new", "");
						$account_logged->setCustomField("email_new_time", 0);
						$account_logged->setEmail($account_email_new);
						$account_logged->save();
						$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT15'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['AM_ON_CM_TEXT18'].' <b>'.$account_logged->getEmail().'</b> '.$lang['site']['AM_ON_CM_TEXT19'].'.</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
					}
					else
					{
						$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT15'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['AM_ON_CM_TEXT20'].' <b>'.$account_email_new.'</b> '.$lang['site']['AM_ON_CM_TEXT21'].'</td></tr>          </table>        </div>  </table></div></td></tr><br /><table width="100%"><tr><td width="30">&nbsp;</td><td align=left><form action="?subtopic=accountmanagement&action=changeemail" method="post"><input type="hidden" name="changeemailsave" value=1 ><INPUT type="image" NAME="I Agree" SRC="'.$layout_name.'/images//images/buttons/sbutton_iagree.gif" BORDER=0 WIDTH=120 HEIGHT=17></FORM></td><td align=left><form action="?subtopic=accountmanagement&action=changeemail" method="post"><input type="hidden" name="emailchangecancel" value=1 ><input type="image" name="Cancel" src="'.$layout_name.'/images//images/buttons/sbutton_cancel.gif" BORDER=0 WIDTH=120 HEIGHT=17></form></td><td align=right><form action="?subtopic=accountmanagement" method="post" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></form></td><td width="30">&nbsp;</td></tr></table>';
					}
				}
				else
				{
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT16'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['AM_ON_CM_TEXT22'].' <b>'.$account_email_new.'</b>.<br/>'.$lang['site']['AM_ON_CM_TEXT23'].' <b>'.date("j F Y, G:i:s", $account_email_new_time).'</b>.<br>'.$lang['site']['AM_ON_CM_TEXT24'].'.</td></tr>          </table>        </div>  </table></div></td></tr><br/><table style="width:100%;" ><tr align="center"><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement&action=changeemail" method="post" ><tr><td style="border:0px;" ><input type="hidden" name="emailchangecancel" value=1 ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Cancel" alt="Cancel" src="'.$layout_name.'/images//images/buttons/_sbutton_cancel.gif" ></div></div></td></tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
				}
			}
			
			if($_POST['emailchangecancel'] == 1)
			{
				$account_logged->setCustomField("email_new", "");
				$account_logged->setCustomField("email_new_time", 0);
				$main_content = '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['AM_ON_CM_TEXT17'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['AM_ON_CM_TEXT25'].'</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
			}
		}
		if($action == "changeinfo")
		{
			$new_rlname = htmlspecialchars(stripslashes(trim($_POST['info_rlname'])));
			$new_location = htmlspecialchars(stripslashes(trim($_POST['info_location'])));
			if($_POST['changeinfosave'] == 1)
			{
				$account_logged->setCustomField("rlname", $new_rlname);
				$account_logged->setCustomField("location", $new_location);
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
					<tr>
						<th>Public Information Changed</th>
					</tr>
					<tr class="first">
						<td>Your public information has been changed.</td>
					</tr>
				</table><br />
				
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr align="center">
						<td>
							<form action="?subtopic=accountmanagement" method="post">
								<input type="image" name="Back" alt="Back" src="' . $layout_name . '/images/buttons/back.png" />
							</form>
						</td>
					</tr>
				</table>';
			}
			else
			{
				$account_rlname = $account_logged->getCustomField("rlname");
				$account_location = $account_logged->getCustomField("location");
				$main_content .= '
				Here you can tell other players about yourself. This information will be displayed alongside the data of your characters. If you do not want to fill in a certain field, just leave it blank.<br /><br />
				<form action="?subtopic=accountmanagement&action=changeinfo" method="POST">
				<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
					<tr>
						<th colspan="2">' . $lang['site']['AM_ON_PI_CATEGORY_INFORMATION'] . '</th>
					</tr>
					<tr class="first">
						<td width="25%">' . $lang['site']['AM_ON_PI_REAL_NAME'] . '</td>
						<td><input name="info_rlname" value="' . $account_rlname . '" size="30" maxlength="50"></td>
					</tr>
					<tr class="second">
						<td>' . $lang['site']['AM_ON_PI_LOCATION'] . '</td>
						<td><input name="info_location" value="' . $account_location . '" size="30" maxlength="50"></td>
					</tr>
				</table><br />
				
				<input type="hidden" name="changeinfosave" value="1">
				
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr align="center">
						<td width="50%"><input type="image" name="Submit" alt="Submit" src="' . $layout_name . '/images/buttons/submit.png" /></form></td>
						<td width="50%">
							<form action="?subtopic=accountmanagement" method="post">
								<input type="image" name="Back" alt="Back" src="' . $layout_name . '/images/buttons/back.png" />
							</form>
						</td>
					</tr>
				</table>';
			}
		}
		if($action == "registeraccount")
		{
			$reg_password = password_ency(trim($_POST['reg_password']));
			$old_key = $account_logged->getCustomField("key");
			if($_POST['registeraccountsave'] == "1")
			{
				if($reg_password == $account_logged->getPassword())
				{
					if(empty($old_key))
					{
						$dontshowtableagain = 1;
						$acceptedChars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
						$max = strlen($acceptedChars) - 1;
						$new_rec_key = NULL;
						for($i = 0; $i < 10; $i++)
						{
							$cnum[$i] = $acceptedChars{mt_rand(0, $max)};
							$new_rec_key .= $cnum[$i];
						}
						
						$account_logged->setCustomField("key", $new_rec_key);
						
						$main_content .= '
						<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
							<tr>
								<th>Account Registered</th>
							</tr>
							<tr class="first">
								<td>
									Thank you for registering your account! You can now recover your account if you have lost access to the assigned email address by using the following
									<br /><br />
									<font size="5">&nbsp;&nbsp;&nbsp;<b>Recovery Key: ' . $new_rec_key . '</b></font>
									<br /><br /><br />
									<b>Important:</b>
									Write down this recovery key carefully.<br />Store it at a safe place!';
							
									if($config['site']['send_emails'] && $config['site']['send_mail_when_generate_reckey'])
									{
										$mailBody = '
										<html>
											<body>
												<h3>New recovery key!</h3>
												<p>You or someone else generated recovery key to your account on server <a href="' . $config['server']['url'] . '"><b>' . $config['server']['serverName'] . '</b></a>.</p>
												<p>Recovery key: <b>' . $new_rec_key . '</b></p>
											</body>
										</html>';
										
										require_once("phpmailer/class.phpmailer.php");
										$mail = new PHPMailer();
										if($config['site']['smtp_enabled'] == "yes")
										{
											$mail->IsSMTP();
											$mail->Host = $config['site']['smtp_host'];
											$mail->Port = (int)$config['site']['smtp_port'];
											$mail->SMTPAuth = ($config['site']['smtp_auth'] ? true : false);
											$mail->Username = $config['site']['smtp_user'];
											$mail->Password = $config['site']['smtp_pass'];
										}
										else
										{
											$mail->IsMail();
											$mail->IsHTML(true);
											$mail->From = $config['site']['mail_address'];
											$mail->AddAddress($account_logged->getEMail());
											$mail->Subject = $config['server']['serverName']." - recovery key";
											$mail->Body = $mailBody;
										}
										
										if($mail->Send())
											$main_content .= '<br /><small>Your recovery key were send on email address <b>' . $account_logged->getEMail() . '</b>.</small>';
										else
											$main_content .= '<br /><small>An error occorred while sending email with recovery key! You will not receive e-mail with this key.</small>';
									}
									$main_content .= '
								</td>
							</tr>
						</table><br />
						
						<table border="0" width="100%" align="center">
							<tr>
								<td align="center">
									<form action="?subtopic=accountmanagement" method="POST">
										<input type="image" name="Back" src="' . $layout_name . '/images/buttons/back.png" border="0" />
									</form>
								</td>
							</tr>
						</table>';
					}
					else
						$reg_errors[] = 'Your account is already registred.';
				}
				else
					$reg_errors[] = 'Wrong password to account.';
			}
			if($dontshowtableagain != 1)
			{
				if(!empty($reg_errors))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($reg_errors as $reg_error)
						$main_content .= '<li>'.$reg_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
				}
				
				$main_content .= '
				To generate recovery key for your account please enter your password.<br /><br />
				<form action="?subtopic=accountmanagement&action=registeraccount" method="POST">
				<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
					<tr>
						<th colspan="2">Generate Recovery Key</th>
					</tr>
					<tr class="first">
						<td align="center" width="30%" style="font-weight: bold;">' . $lang['site']['AM_AL_TABLE_PW'] . '</td>
						<td><input type="password" name="reg_password" size="30" maxlength="29" ></td>
					</tr>
				</table><br />
				
				<input type="hidden" name="registeraccountsave" value="1">
				
				<table border="0" width="100%" align="center">
					<tr>
						<td align="center" valign="top">
							<input type="image" name="Submit" src="' . $layout_name . '/images/buttons/submit.png" border="0" /></form>
						</td>
						<td align="center">
							<form action="?subtopic=lostaccount" method="POST">
								<input type="image" name="Cancel" src="' . $layout_name . '/images/buttons/cancel.png" border="0" />
							</form>
						</td>
					</tr>
				</table>';
			}
		}

//############## GENERATE NEW RECOVERY KEY ###########
	if($action == "newreckey")
	{
		$reg_password = password_ency(trim($_POST['reg_password']));
		$reckey = $account_logged->getCustomField("key");
		if((!$config['site']['generate_new_reckey'] || !$config['site']['send_emails']) || empty($reckey))
			$main_content .= 'You cant get new rec key';
		else
		{
			$points = $account_logged->getCustomField('premium_points');
			if($_POST['registeraccountsave'] == "1")
			{
				if($reg_password == $account_logged->getPassword())
				{
					if($points >= $config['site']['generate_new_reckey_price'])
					{
							$dontshowtableagain = 1;
							$acceptedChars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
							$max = strlen($acceptedChars)-1;
							$new_rec_key = NULL;
							// 10 = number of chars in generated key
							for($i=0; $i < 10; $i++) {
								$cnum[$i] = $acceptedChars{mt_rand(0, $max)};
								$new_rec_key .= $cnum[$i];
							}
							$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Registered</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><ul>';
								$mailBody = '<html>
								<body>
								<h3>New recovery key!</h3>
								<p>You or someone else generated recovery key to your account on server <a href="'.$config['server']['url'].'"><b>'.$config['server']['serverName'].'</b></a>.</p>
								<p>Recovery key: <b>'.$new_rec_key.'</b></p>
								</body>
								</html>';
								require("phpmailer/class.phpmailer.php");
								$mail = new PHPMailer();
								if ($config['site']['smtp_enabled'] == "yes")
								{
									$mail->IsSMTP();
									$mail->Host = $config['site']['smtp_host'];
									$mail->Port = (int)$config['site']['smtp_port'];
									$mail->SMTPAuth = ($config['site']['smtp_auth'] ? true : false);
									$mail->Username = $config['site']['smtp_user'];
									$mail->Password = $config['site']['smtp_pass'];
								}
								else
									$mail->IsMail();
								$mail->IsHTML(true);
								$mail->From = $config['site']['mail_address'];
								$mail->AddAddress($account_logged->getEMail());
								$mail->Subject = $config['server']['serverName']." - new recovery key";
								$mail->Body = $mailBody;
								if($mail->Send())
								{
									$account_logged->setCustomField("key", $new_rec_key);
									$account_logged->setCustomField("premium_points", $account_logged->getCustomField("premium_points")-$config['site']['generate_new_reckey_price']);
									$main_content .= '<br />Your recovery key were send on email address <b>'.$account_logged->getEMail().'</b> for '.$config['site']['generate_new_reckey_price'].' premium points.';
								}
								else
									$main_content .= '<br />An error occorred while sending email ( <b>'.$account_logged->getEMail().'</b> ) with recovery key! Recovery key not changed. Try again.';
							$main_content .= '</ul>          </table>        </div>  </table></div></td></tr><br/><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
					}
					else
						$reg_errors[] = 'You need '.$config['site']['generate_new_reckey_price'].' premium points to generate new recovery key. You have <b>'.$points.'<b> premium points.';
				}
				else
					$reg_errors[] = 'Wrong password to account.';
			}
			if($dontshowtableagain != 1)
			{
				//show errors if not empty
				if(!empty($reg_errors))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($reg_errors as $reg_error)
						$main_content .= '<li>'.$reg_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
				}
				//show form
				$main_content .= 'To generate NEW recovery key for your account please enter your password.<br/><font color="red"><b>New recovery key cost '.$config['site']['generate_new_reckey_price'].' Premium Points.</font> You have '.$points.' premium points. You will receive e-mail with this recovery key.</b><br/><form action="?subtopic=accountmanagement&action=newreckey" method="post" ><input type="hidden" name="registeraccountsave" value="1"><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Generate recovery key</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Password:</td><td><input type="password" name="reg_password" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table style="width:100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
			}
		}
	}

	
	
//###### CHANGE CHARACTER COMMENT ######
	if($action == "changecomment") {
		$player_name = stripslashes($_REQUEST['name']);
		$new_comment = htmlspecialchars(stripslashes(substr(trim($_POST['comment']),0,2000)));
		$new_hideacc = (int) $_POST['accountvisible'];
		if(check_name($player_name)) {
			$player = $ots->createObject('Player');
			$player->find($player_name);
			if($player->isLoaded()) {
				$player_account = $player->getAccount();
				if($account_logged->getId() == $player_account->getId()) {
					if($_POST['changecommentsave'] == 1) {
						$player->setCustomField("hide_char", $new_hideacc);
						$player->setCustomField("comment", $new_comment);
						$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Character Information Changed</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>The character information has been changed.</td></tr>          </table>        </div>  </table></div></td></tr><br><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
					}
					else
					{
						$main_content .= 'Here you can see and edit the information about your character.<br/>If you do not want to specify a certain field, just leave it blank.<br/><br/><form action="?subtopic=accountmanagement&action=changecomment" method="post" ><div class="TableContainer" >  <table class="Table5" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Edit Character Information</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td><div class="TableShadowContainerRightTop" >  <div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);" ></div></div><div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);" >  <div class="TableContentContainer" >    <table class="TableContent" width="100%" ><tr><td class="LabelV" >Name:</td><td style="width:80%;" >'.$player_name.'</td></tr><tr><td class="LabelV" >Hide Account:</td><td>';
						if($player->getCustomField("hide_char") == 1) {
							$main_content .= '<input type="checkbox" name="accountvisible"  value="1" checked="checked">';
						}
						else
						{
							$main_content .= '<input type="checkbox" name="accountvisible"  value="1" >';
						}
						$main_content .= ' check to hide your account information</td></tr>    </table>  </div></div><div class="TableShadowContainer" >  <div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bm.gif);" >    <div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bl.gif);" ></div>    <div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-br.gif);" ></div>  </div></div></td></tr><tr><td><div class="TableShadowContainerRightTop" >  <div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);" ></div></div><div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);" >  <div class="TableContentContainer" >    <table class="TableContent" width="100%" ><tr><td class="LabelV" ><span >Comment:</span></td><td style="width:80%;" ><textarea name="comment" rows="10" cols="50" wrap="virtual" >'.$player->getCustomField("comment").'</textarea><br>[max. length: 2000 chars, 50 lines (ENTERs)]</td></tr>    </table>  </div></div><div class="TableShadowContainer" >  <div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bm.gif);" ><div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bl.gif);" ></div><div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-br.gif);" ></div></div></div></td></tr></td></tr>          </table>        </div>  </table></div></td></tr><br/><table style="width:100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><input type="hidden" name="name" value="'.$player->getName().'"><input type="hidden" name="changecommentsave" value="1"><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
					}
				}
				else
				{
					$main_content .= "Error. Character <b>".$player_name."</b> is not on your account.";
				}
			}
			else
			{
				$main_content .= "Error. Character with this name doesn't exist.";
			}
		}
		else
		{
			$main_content .= "Error. Name contain illegal characters.";
		}
	}

//### NEW NICK - set new nick proposition ###
	if($action == "newnick")
	{
		$name = $_GET['name'];
		$name_new = stripslashes(ucwords(strtolower(trim($_GET['name_new']))));
		if(!empty($name) && !empty($name_new))
		{
			if(check_name_new_char($name_new))
			{
				$player = $ots->createObject('Player');
				$player->find($name);
				if($player->isLoaded() && $player->isNameLocked())
				{
					$player_account = $player->getAccount();
					if($account_logged->getId() == $player_account->getId())
					{
						if(!$player->getOldName())
							if(!$player->isOnline())
							{
								$player->setCustomField('old_name', $name_new);
								$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >New nick proposition</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>The character <b>'.$name.'</b> new nick proposition <b>'.$name_new.'</b> has been set. Now you must wait for acceptation from GM.</td></tr>          </table>        </div>  </table></div></td></tr>';
							}
							else
								$main_content .= 'This character is online.';
						else
							$main_content .= 'You already set new name for this character ( <b>'.$player->getOldName().'</b> ). You must wait until GM accept/reject your proposition.';
					}
					else
						$main_content .= 'Character <b>'.$player_name.'</b> is not on your account.';
				}
				else
					$main_content .= 'Character with this name doesn\'t exist or isn\'t name locked.';
			}
			else
				$main_content .= 'Name contain illegal characters. Invalid format or lenght.';
		}
		else
			$main_content .= 'Please enter new char name.';
		$main_content .= '<br><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
	}

//### DELETE character from account ###
	if($action == "deletecharacter") {
		$player_name = stripslashes(trim($_POST['delete_name']));
		$password_verify = trim($_POST['delete_password']);
		$password_verify = password_ency($password_verify);
		if($_POST['deletecharactersave'] == 1) {
			if(!empty($player_name) && !empty($password_verify)) {
				if(check_name($player_name)) {
					$player = $ots->createObject('Player');
					$player->find($player_name);
					if($player->isLoaded()) {
						$player_account = $player->getAccount();
						if($account_logged->getId() == $player_account->getId()) {
							if($password_verify == $account_logged->getPassword()) {
								if(!$player->isOnline())
								{
								//dont show table "delete character" again
								$dontshowtableagain = 1;
								//delete player
								$player->setCustomField('deleted', 1);
								$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Character Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>The character <b>'.$player_name.'</b> has been deleted.</td></tr>          </table>        </div>  </table></div></td></tr><br><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
								}
								else
									$delete_errors[] = 'This character is online.';
							}
							else
							{
								$delete_errors[] = 'Wrong password to account.';
							}
						}
						else
						{
							$delete_errors[] = 'Character <b>'.$player_name.'</b> is not on your account.';
						}
					}
					else
					{
						$delete_errors[] = 'Character with this name doesn\'t exist.';
					}
				}
				else
				{
					$delete_errors[] = 'Name contain illegal characters.';
				}
			}
			else
			{
			$delete_errors[] = 'Character name or/and password is empty. Please fill in form.';
			}
		}
		if($dontshowtableagain != 1) {
			if(!empty($delete_errors)) {
				$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
				foreach($delete_errors as $delete_error) {
						$main_content .= '<li>'.$delete_error;
				}
				$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
			}
			$main_content .= 'To delete a character enter the name of the character and your password.<br/><br/><form action="?subtopic=accountmanagement&action=deletecharacter" method="post" ><input type="hidden" name="deletecharactersave" value="1"><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Delete Character</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Character Name:</td><td style="width:90%;" ><input name="delete_name" value="" size="30" maxlength="29" ></td></tr><tr><td class="LabelV" ><span >Password:</td><td><input type="password" name="delete_password" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table style="width:100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
		}
	}

	
//### UNDELETE character from account ###
	if($action == "undelete")
	{
		$player_name = stripslashes(trim($_GET['name']));
		if(!empty($player_name))
		{
			if(check_name($player_name))
			{
				$player = $ots->createObject('Player');
				$player->find($player_name);
				if($player->isLoaded())
				{
					$player_account = $player->getAccount();
					if($account_logged->getId() == $player_account->getId())
					{
						if(!$player->isOnline())
						{
						$player->setCustomField('deleted', 0);
						$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Character Undeleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>The character <b>'.$player_name.'</b> has been undeleted.</td></tr>          </table>        </div>  </table></div></td></tr><br><center><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></center>';
						}
						else
							$delete_errors[] = 'This character is online.';
					}
					else
						$delete_errors[] = 'Character <b>'.$player_name.'</b> is not on your account.';
				}
				else
					$delete_errors[] = 'Character with this name doesn\'t exist.';
			}
			else
				$delete_errors[] = 'Name contain illegal characters.';
		}
	}	
	if($action == "createcharacter")
	{
		if(count($config['site']['worlds']) > 1)
		{
			if(isset($_REQUEST['world']))
				$world_id = (int) $_REQUEST['world'];
		}
		else
			$world_id = 0;
			
		if(!isset($world_id))
		{
			$main_content .= 'Before you can create character you must select world: ';
			foreach($config['site']['worlds'] as $id => $world_n)
				$main_content .= '<br /><a href="?subtopic=accountmanagement&action=createcharacter&world='.$id.'">- '.$world_n.'</a>';
			$main_content .= '<br /><h3><a href="?subtopic=accountmanagement">BACK</a></h3>';
		}
		else
		{
			$main_content .= '
			<script type="text/javascript">
			var nameHttp;

			function checkName()
			{
				if(document.getElementById("newcharname").value=="")
				{
					document.getElementById("name_check").innerHTML = \'<b><font color="red">Please enter new character name.</font></b>\';
					return;
				}
				
				nameHttp=GetXmlHttpObject();
				
				if(nameHttp == null)
					return;
					
				var newcharname = document.getElementById("newcharname").value;
				var url="ajax/check_name.php?name=" + newcharname + "&uid=" + Math.random();
				nameHttp.onreadystatechange = NameStateChanged;
				nameHttp.open("GET", url, true);
				nameHttp.send(null);
			} 

			function NameStateChanged() 
			{ 
				if(nameHttp.readyState == 4)
					document.getElementById("name_check").innerHTML=nameHttp.responseText;
			}
			</script>';
			
			$newchar_name = stripslashes(ucwords(strtolower(trim($_POST['newcharname']))));
			$newchar_sex = $_POST['newcharsex'];
			$newchar_vocation = $_POST['newcharvocation'];
			$newchar_town = 1;
			if($_POST['savecharacter'] != 1)
			{
				$main_content .= 'Please choose a name';
				if(count($config['site']['newchar_vocations'][$world_id]) > 1)
					$main_content .= ', vocation';
					
				$str = "";	
				if($account_logged->getPlayersList()->count() == 0)
					$str = " <u>first</u>";
					
				$main_content .= ' and sex for your' . $str . ' character. <br />In any case the name must not violate the naming conventions stated in the <a href="?subtopic=tibiarules" target="_blank" >' . $config['server']['serverName'] . ' Rules</a>, or your character might get deleted or name locked.';
				
				if($account_logged->getPlayersList()->count() >= $config['site']['max_players_per_account'])
					$main_content .= '<b><font color="red"> You have maximum number of characters per account on your account. Delete one before you make new.</font></b>';
					
				$main_content .= '<br /><br />
				<form action="?subtopic=accountmanagement&action=createcharacter" method="post">
				<table border="0" cellspacing="1" cellpadding="4" width="100%" class="old">
					<tr>
						<th colspan="2">Create Character</th>
					</tr>
					<tr class="first">
						<td width="30%" style="font-weight: bold;">Name</td>
						<td>
							<input id="newcharname" name="newcharname" onkeyup="checkName();" value="'.$newchar_name.'" size="30" maxlength="29"><br />
							<font size="1" face="verdana,arial,helvetica"><div id="name_check">Please enter your character name.</div></font>
						</td>
					</tr>
					<tr class="second">
						<td width="30%" style="font-weight: bold;">Sex</td>
						<td>
							<input type="radio" name="newcharsex" value="1" checked="checked"/> - Male<br />
							<input type="radio" name="newcharsex" value="0" /> - Female<br />
						</td>
					</tr>';
					
					if(count($config['site']['newchar_vocations'][$world_id]) > 1)
					{
						$main_content .= '
						<tr class="first">
							<td width="30%" style="font-weight: bold;">Vocation</td>
							<td>
								<select name="newcharvocation">';
									foreach($config['site']['newchar_vocations'][$world_id] as $char_vocation_key => $sample_char)			
										$main_content .= '<option value="' . $char_vocation_key . '">' . $vocation_name[$world_id][0][$char_vocation_key] . '</option>';
									
									$main_content .= '
								</select>
							</td>
						</tr>';
					}
					
					$main_content .= '
				</table><br />
				
				<input type="hidden" name=savecharacter value="1">
				
				<table border="0" width="100%" align="center">
					<tr>
						<td align="center" valign="top">
							<input type="image" name="Create Character" src="' . $layout_name . '/images/buttons/create_character.png" border="0" /></form>
						</td>
						<td align="center">
							<form action="?subtopic=accountmanagement" method="POST">
								<input type="image" name="Back" src="' . $layout_name . '/images/buttons/back.png" border="0" />
							</form>
						</td>
					</tr>
				</table>';
			}
			else
			{	
				if(empty($newchar_name))
					$newchar_errors[] = 'Please enter a name for your character!';
					
				if(empty($newchar_sex) && $newchar_sex != "0")
					$newchar_errors[] = 'Please select the sex for your character!';
					
				if(count($config['site']['newchar_vocations'][$world_id]) > 1)
				{
					if(empty($newchar_vocation))
						$newchar_errors[] = 'Please select a vocation for your character.';
				}
				else
					$newchar_vocation = $config['site']['newchar_vocations'][$world_id][0];
					
				if(count($config['site']['newchar_towns'][$world_id]) > 1)
				{
					if(empty($newchar_town))
						$newchar_errors[] = 'Please select a town for your character.';
				}
				else
					$newchar_town = $config['site']['newchar_towns'][$world_id][0];
					
				if(empty($newchar_errors))
				{
					if(!check_name_new_char($newchar_name))
						$newchar_errors[] = 'This name contains invalid letters, words or format. Please use only a-Z, - , \' and space.';
						
					if($newchar_sex != 1 && $newchar_sex != "0")
						$newchar_errors[] = 'Sex must be equal <b>0 (female)</b> or <b>1 (male)</b>.';
						
					if(!in_array($newchar_town, $config['site']['newchar_towns'][$world_id]))
						$newchar_errors[] = 'Please select valid town.';
						
					if(count($config['site']['newchar_vocations'][$world_id]) > 1)
					{
						$newchar_vocation_check = FALSE;
						foreach($config['site']['newchar_vocations'][$world_id] as $char_vocation_key => $sample_char)
							if($newchar_vocation == $char_vocation_key)
								$newchar_vocation_check = TRUE;
						if(!$newchar_vocation_check)
							$newchar_errors[] = 'Unknown vocation. Please fill in form again.';
					}
					else
						$newchar_vocation = 0;
				}
				
				if(empty($newchar_errors))
				{
					$check_name_in_database = $ots->createObject('Player');
					$check_name_in_database->find($newchar_name);
					if($check_name_in_database->isLoaded())
						$newchar_errors[] .= 'This name is already used. Please choose another name!';
						
					$number_of_players_on_account = $account_logged->getPlayersList()->count();
					if($number_of_players_on_account >= $config['site']['max_players_per_account'])
						$newchar_errors[] .= 'You have too many characters on your account <b>('.$number_of_players_on_account.'/'.$config['site']['max_players_per_account'].')</b>!';
				}
				
				if(empty($newchar_errors))
				{
					$char_to_copy_name = $config['site']['newchar_vocations'][$world_id][$newchar_vocation];
					$char_to_copy = new OTS_Player();
					$char_to_copy->find($char_to_copy_name);
					if(!$char_to_copy->isLoaded())
						$newchar_errors[] .= 'Wrong characters configuration. Try again or contact with admin. ADMIN: Edit file config/config.php and set valid characters to copy names. Character to copy'.$char_to_copy_name.'</b> doesn\'t exist.';
				}
				
				if(empty($newchar_errors))
				{
					if($newchar_sex == 0)
						$char_to_copy->setLookType(136);
						
					$player = new OTS_Player();
				    $player->setName($newchar_name);
				    $player->setAccount($account_logged);
				    $player->setGroup($char_to_copy->getGroup());
				    $player->setSex($newchar_sex);
				    $player->setVocation($char_to_copy->getVocation());
				    $player->setConditions($char_to_copy->getConditions());
				    $player->setRank($char_to_copy->getRank());
				    $player->setLookAddons($char_to_copy->getLookAddons());
				    $player->setExperience($char_to_copy->getExperience());
				    $player->setLevel($char_to_copy->getLevel());
				    $player->setMagLevel($char_to_copy->getMagLevel());
				    $player->setHealth($char_to_copy->getHealth());
				    $player->setHealthMax($char_to_copy->getHealthMax());
				    $player->setMana($char_to_copy->getMana());
				    $player->setManaMax($char_to_copy->getManaMax());
				    $player->setManaSpent($char_to_copy->getManaSpent());
				    $player->setSoul($char_to_copy->getSoul());
				    $player->setDirection($char_to_copy->getDirection());
				    $player->setLookBody($char_to_copy->getLookBody());
				    $player->setLookFeet($char_to_copy->getLookFeet());
				    $player->setLookHead($char_to_copy->getLookHead());
				    $player->setLookLegs($char_to_copy->getLookLegs());
				    $player->setLookType($char_to_copy->getLookType());
				    $player->setCap($char_to_copy->getCap());
					$player->setTownId($char_to_copy->getTownId());
					$player->setPosX(0);
					$player->setPosY(0);
					$player->setPosZ(0);
				    $player->setLossExperience($char_to_copy->getLossExperience());
				    $player->setLossMana($char_to_copy->getLossMana());
				    $player->setLossSkills($char_to_copy->getLossSkills());
					$player->setLossItems($char_to_copy->getLossItems());
					$player->setLastIP(ip2long(revertIp(getIP())));
					$player->save();
					unset($player);
					
					$player = new OTS_Player();
					$player->find($newchar_name);
					if($player->isLoaded())
					{
						$player->setCustomField("country", strtolower(geoip_country_code_by_name(getIP())));
						$player->setCustomField('world_id', (int) $world_id);
						$player->setSkill(0, $char_to_copy->getSkill(0));
						$player->setSkill(1, $char_to_copy->getSkill(1));
						$player->setSkill(2, $char_to_copy->getSkill(2));
						$player->setSkill(3, $char_to_copy->getSkill(3));
						$player->setSkill(4, $char_to_copy->getSkill(4));
						$player->setSkill(5, $char_to_copy->getSkill(5));
						$player->setSkill(6, $char_to_copy->getSkill(6));
						$player->save();
						
						$loaded_items_to_copy = $db->query("SELECT * FROM `player_items` WHERE `player_id` = " . $char_to_copy->getId())->fetchAll();
						foreach($loaded_items_to_copy as $save_item)
						{
							$db->query("INSERT INTO `player_items` (`player_id`, `pid`, `sid`, `itemtype`, `count`, `attributes`) VALUES (" . $player->getId() . ", " . $save_item['pid'] . ", " . $save_item['sid'] . ", " . $save_item['itemtype'] . ", " . $save_item['count'] . ", '" . $save_item['attributes'] . "');");
						}
						
						$main_content .= '
						<div class="TableContainer" >
							<table class="Table1" cellpadding="0" cellspacing="0" >
								<div class="CaptionContainer" >
									<div class="CaptionInnerContainer" >
										<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>
										<span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>
										<span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>
										<div class="Text" >Character Created</div>
										<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>
										<span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>
										<span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>
										<span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>
									</div>
								</div>
								<tr><td>
									<div class="InnerTableContainer">
										<table style="width:100%;">
											<tr><td>
												The character <b>' . $newchar_name . '</b> has been created.<br/>
												Please select the outfit when you log in for the first time.<br/><br/>
												<b>See you on '.$config['server']['serverName'].'!</b>
											</td></tr>
										</table>
									</div>
								</td></tr>
							</table>
						</div><br />
						<center>
							<table border="0" cellspacing="0" cellpadding="0" >
								<form action="?subtopic=accountmanagement" method="POST">
									<input type="image" name="Back" src="' . $layout_name . '/images/buttons/back.png" border="0" />
								</form>
							</table>
						</center>';
					}
					else
					{
						echo "Error. Can\'t create character. Probably problem with database. Try again or contact with the administrator.";
						exit;
					}
				}
				else
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($newchar_errors as $newchar_error)
						$main_content .= '<li>'.$newchar_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
					$main_content .= 'Please choose a name';
					if(count($config['site']['newchar_vocations'][$world_id]) > 1)
						$main_content .= ', vocation';
					$main_content .= ' and sex for your character. <br/>In any case the name must not violate the naming conventions stated in the <a href="?subtopic=tibiarules" target="_blank" >'.$config['server']['serverName'].' Rules</a>, or your character might get deleted or name locked.<br/><br/><form action="?subtopic=accountmanagement&action=createcharacter" method="post" ><input type="hidden" name="world" value="'.$world_id.'" ><input type="hidden" name=savecharacter value="1" ><div class="TableContainer" >  <table class="Table3" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" ><span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span><span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span><span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span><span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span><div class="Text" >Create Character</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span><span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span><span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span><span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span></div>    </div><tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td><div class="TableShadowContainerRightTop" >  <div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);" ></div></div><div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);" >  <div class="TableContentContainer" ><table class="TableContent" width="100%" ><tr class="LabelH" ><td style="width:50%;" ><span >Name</td><td><span >Sex</td></tr><tr class="Odd" ><td><input id="newcharname" name="newcharname" onkeyup="checkName();" value="'.$newchar_name.'" size="30" maxlength="29" ><BR><font size="1" face="verdana,arial,helvetica"><div id="name_check">Please enter your character name.</div></font></td><td>';
					$main_content .= '<input type="radio" name="newcharsex" value="1" ';
					if($newchar_sex == 1)
						$main_content .= 'checked="checked" ';
					$main_content .= '>male<br/>';
					$main_content .= '<input type="radio" name="newcharsex" value="0" ';
					if($newchar_sex == "0")
						$main_content .= 'checked="checked" ';
					$main_content .= '>female<br/></td></tr></table></div></div></table></div>';
					if(count($config['site']['newchar_towns'][$world_id]) > 1 || count($config['site']['newchar_vocations'][$world_id]) > 1)
						$main_content .= '<div class="InnerTableContainer" >          <table style="width:100%;" ><tr>';
					if(count($config['site']['newchar_vocations'][$world_id]) > 1)
					{
						$main_content .= '<td><table class="TableContent" width="100%" ><tr class="Odd" valign="top"><td width="160"><br /><b>Select your vocation:</b></td><td><table class="TableContent" width="100%" >';
						foreach($config['site']['newchar_vocations'][$world_id] as $char_vocation_key => $sample_char)
						{
							$main_content .= '<tr><td><input type="radio" name="newcharvocation" value="'.$char_vocation_key.'" ';
							if($newchar_vocation == $char_vocation_key)
								$main_content .= 'checked="checked" ';
							$main_content .= '>'.$vocation_name[$world_id][0][$char_vocation_key].'</td></tr>';
						}
						$main_content .= '</table></table></td>';
					}
					if(count($config['site']['newchar_towns'][$world_id]) > 1)
					{
						$main_content .= '<td><table class="TableContent" width="100%" ><tr class="Odd" valign="top"><td width="160"><br /><b>Select your city:</b></td><td><table class="TableContent" width="100%" >';
						foreach($config['site']['newchar_towns'][$world_id] as $town_id)
						{
							$main_content .= '<tr><td><input type="radio" name="newchartown" value="'.$town_id.'" ';
							if($newchar_town == $town_id)
								$main_content .= 'checked="checked" ';
							$main_content .= '>'.$towns_list[$world_id][$town_id].'</td></tr>';
						}
						$main_content .= '</table></table></td>';
					}
					if(count($config['site']['newchar_towns'][$world_id]) > 1 || count($config['site']['newchar_vocations'][$world_id]) > 1)
						$main_content .= '</tr></table></div>';
					$main_content .= '</table></div></td></tr><br/><table style="width:100%;" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images//images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=accountmanagement" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images//images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images//images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table>';
				}
			}
		}
	}
}
?>