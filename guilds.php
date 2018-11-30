<?php
if($action == 'login')
{
	if(check_guild_name($_REQUEST['guild']))
		$guild = $_REQUEST['guild'];
	if($_REQUEST['redirect'] == 'guild' || $_REQUEST['redirect'] == 'guilds')
		$redirect = $_REQUEST['redirect'];
	if(!$logged)
		$main_content .= ''.$lang['site']['GUI_PAN_T_1'].'<br/><a href="?subtopic=createaccount" >'.$lang['site']['GUI_PAN_T_2'].'</a> '.$lang['site']['GUI_PAN_T_3'].'<br/><br/><form action="?subtopic=guilds&action=login&guild='.$guild.'&redirect='.$redirect.'" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['GUI_PAN_T_4'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >'.$lang['site']['GUI_PAN_T_5'].'</span></td><td style="width:100%;" ><input type="password" name="account_login" SIZE="10" maxlength="10" ></td></tr><tr><td class="LabelV" ><span >'.$lang['site']['GUI_PAN_T_6'].'</span></td><td><input type="password" name="password_login" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table width="100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=lostaccount" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Account lost?" alt="Account lost?" src="'.$layout_name.'/images/buttons/_sbutton_accountlost.gif" ></div></div></td></tr></form></table></td></tr></table>';
	else
	{
		$main_content .= '<center><h3>'.$lang['site']['GUI_PAN_T_7'].'</h3></center>';
		if($redirect == 'guilds')
			header("Location: ?subtopic=guilds");
		elseif($redirect == 'guild')
			header("Location: ?subtopic=guilds&action=show&guild=".$guild);
		else
			$main_content .= $lang['site']['GUI_PAN_T_8'];
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show list of guilds
if($action == '')
{
	$guilds_list = $db->query('SELECT `id`, `name`, `description` FROM `guilds` WHERE `world_id` = '.(int)$world_id.' ORDER BY `name` ASC;')->fetchAll();
	
	$main_content .= '<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
	<TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=3 CLASS=white><B>'.$lang['site']['GUID_LOG_T_1'].' '. $config['server']['serverName'] . '</B></TD></TR>
	<TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=64><B>'.$lang['site']['GUID_LOG_T_2'].'</B></TD>
	<TD WIDTH=100%><B>'.$lang['site']['GUID_LOG_T_3'].'</B></TD>
	<TD WIDTH=56><B>&#160;</B></TD></TR>';
	$showed_guilds = 1;
	if(count($guilds_list) > 0)
	{
		foreach($guilds_list as $guild)
		{
			$bgcolor = ($showed_guilds % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
			
			$showed_guilds++;
			
			$description = $guild['description'];
			$newlines   = array("\r\n", "\n", "\r");
			$description_with_lines = str_replace($newlines, '<br />', $description, $count);
			
			if($count < $config['site']['guild_description_lines_limit'])
				$description = $description_with_lines;
				
			$main_content .= '<TR BGCOLOR="'.$bgcolor.'"><TD><img src="./guilds/' . $guild['id'] . '.jpg" /></TD>
			<TD valign="top"><B>'.$guild['name'].'</B><BR/>'.$description.'';
			if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
				$main_content .= '<br /><a href="?subtopic=guilds&action=deletebyadmin&guild='.$guild['id'].'">'.$lang['site']['GUID_LOG_T_4'].'</a>';
			$main_content .= '</TD><TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild['id'].'" METHOD=post><TR><TD>
			<INPUT TYPE=image NAME="View" ALT="View" SRC="'.$layout_name.'/images/buttons/view.png" BORDER=0 WIDTH=120 HEIGHT=18>
			</TD></TR></FORM></TABLE>
			</TD></TR>';
		}
	}
	else
		$main_content .= '<TR BGCOLOR='.$config['site']['lightborder'].'><TD><IMG SRC="guilds/default.png" WIDTH=64 HEIGHT=64></TD>
		<TD valign="top"><B>'.$lang['site']['GUID_LOG_T_5'].'</B><BR/>'.$lang['site']['GUID_LOG_T_6'].'</TD>
		<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=createguild" METHOD=post><TR><TD>
		<INPUT TYPE=image NAME="Create Guild" ALT="Create Guild" SRC="'.$layout_name.'/images/buttons/create_guild.png" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE></TD></TR>';
	$main_content .= '</TABLE><br><br>';
	if($logged)
		$main_content .= '<TABLE BORDER=0 WIDTH=100%><TR><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD><TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=createguild" METHOD=post><TR><TD>
		<INPUT TYPE=image NAME="Create Guild" ALT="Create Guild" SRC="'.$layout_name.'/images/buttons/create_guild.png" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE></TD><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD></TR></TABLE>
		<BR />'.$lang['site']['GUID_LOG_T_7'].'
		<BR /><a href="?subtopic=guilds&action=cleanup_players">'.$lang['site']['GUID_LOG_T_8'].'</a> '.$lang['site']['GUID_LOG_T_9'].'
		<BR /><a href="?subtopic=guilds&action=cleanup_guilds">'.$lang['site']['GUID_LOG_T_10'].'</a> '.$lang['site']['GUID_LOG_T_11'].'';
	else
		$main_content .= ''.$lang['site']['GUID_LOG_T_12'].'<br><TABLE BORDER=0 WIDTH=100%><TR><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD><TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=login&redirect=guilds" METHOD=post><TR><TD>
		<INPUT TYPE=image NAME="Login" ALT="Login" SRC="'.$layout_name.'/images/buttons/sbutton_login.gif" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE></TD><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD></TR></TABLE>';
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'show')
{
	$guild_id = (int) $_REQUEST['guild'];
	$guild_name = $guild_id;
	$guild = $ots->createObject('Guild');
	$guild->load($guild_id);
	if(!$guild->isLoaded())
		$guild_errors[] = ''.$lang['site']['GUI_GP_T_1'].' <b>'.$guild_id.'</b> '.$lang['site']['GUI_GP_T_2'].'';
	if(!empty($guild_errors))
	{
		//show errors
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GUI_GP_T_3'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		//errors and back button
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		//check is it vice or/and leader account (leader has vice + leader rights)
		$guild_leader_char = $guild->getOwner();
		$rank_list = $guild->getGuildRanksList();
		$rank_list->orderBy('level', POT::ORDER_DESC);
		$guild_leader = FALSE;
		$guild_vice = FALSE;
		if($logged)
		{
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
			{
				$players_from_account_ids[] = $player->getId();
				$player_rank = $player->getRank();
				if(!empty($player_rank))
					foreach($rank_list as $rank_in_guild)
						if($rank_in_guild->getId() == $player_rank->getId())
						{
							$players_from_account_in_guild[] = $player->getName();
							if($player_rank->getLevel() > 1)
							{
								$guild_vice = TRUE;
								$level_in_guild = $player_rank->getLevel();
							}
							if($guild->getOwner()->getId() == $player->getId())
							{
								$guild_vice = TRUE;
								$guild_leader = TRUE;
							}
						}
			}
		}
		//show guild page
		$description = $guild->getCustomField('description');
		$newlines   = array("\r\n", "\n", "\r");
		$description_with_lines = str_replace($newlines, '<br />', $description, $count);
		if($count < $config['site']['guild_description_lines_limit'])
			$description = $description_with_lines;
		$guild_owner = $guild->getOwner();
		if($guild_owner->isLoaded())
			$guild_owner = $guild_owner->getName();
		$main_content .= '<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100%><TR>
		<TD><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD><TD>
		<TABLE BORDER=0 WIDTH=100%>
		<TR><TD WIDTH=64><img src="./guilds/' . $guild->getId() . '.jpg" border="0"/></TD>
		<TD ALIGN=center WIDTH=100%><H1>'.$guild->getName().'</H1></TD>
		<TD WIDTH=64><img src="./guilds/' . $guild->getId() . '.jpg" border="0"/></TD></TR>
		</TABLE><BR>'.$description.'<BR><BR><a href="?subtopic=characters&name='.urlencode($guild_owner).'"><b>'.$guild_owner.'</b></a> '.$lang['site']['GUI_GP_T_4'].' <b>'.$guild->getName().'</b>.<BR>'.$lang['site']['GUI_GP_T_5'].' '.$config['server']['serverName'].' on '.date("j F Y", $guild->getCreationData()).'.';
		if($guild_leader)
			$main_content .= '&nbsp;&nbsp;&nbsp;<a href="?subtopic=guilds&action=manager&guild='.$guild_name.'"><IMG SRC="'.$layout_name.'/images/buttons/manageguild.png" BORDER=0 WIDTH=120 HEIGHT=18 alt="Manage Guild"></a>';
		$main_content .= '<BR><BR>
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=3 CLASS=white><B>'.$lang['site']['GUI_GP_T_6'].'</B></TD></TR>
		<TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=30%><B>'.$lang['site']['GUI_GP_T_7'].'</B></TD>
		<TD WIDTH=70%><B>'.$lang['site']['GUI_GP_T_8'].'</B></TD></TR>';
		$showed_players = 1;
		foreach($rank_list as $rank)
		{
			$players_with_rank = $rank->getPlayersList();
			$players_with_rank->orderBy('name');
			$players_with_rank_number = count($players_with_rank);
			if($players_with_rank_number > 0)
			{
				if(is_int($showed_players / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $showed_players++;
				$main_content .= '<TR BGCOLOR="'.$bgcolor.'"><TD valign="top">'.$rank->getName().'</TD>
				<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%>';
				foreach($players_with_rank as $player)
				{
					$main_content .= '<TR><TD><FORM ACTION="?subtopic=guilds&action=change_nick&name='.urlencode($player->getName()).'" METHOD=post><A HREF="?subtopic=characters&name='.urlencode($player->getName()).'">'.($player->isOnline() ? "<font color=\"green\">".$player->getName()."</font>" : "<font color=\"red\">".$player->getName()."</font>").'</A>';
					$guild_nick = $player->getGuildNick();
					if($logged)
						if(in_array($player->getId(), $players_from_account_ids))
							$main_content .= '(<input type="text" name="nick" value="'.htmlentities($player->getGuildNick()).'"><input type="submit" value="Change">)';
						else
						if(!empty($guild_nick))
							$main_content .= ' ('.htmlentities($player->getGuildNick()).')';
					else
						if(!empty($guild_nick))
							$main_content .= ' ('.htmlentities($player->getGuildNick()).')';
					if($level_in_guild > $rank->getLevel() || $guild_leader)
						if($guild_leader_char->getName() != $player->getName())
							$main_content .= '&nbsp;<font size=1>{<a href="?subtopic=guilds&action=kickplayer&guild='.$guild->getId().'&name='.urlencode($player->getName()).'">'.$lang['site']['GUI_GP_T_9'].'</a>}</font>';
					$main_content .= '</FORM></TD></TR>';
				}
				$main_content .= '</TABLE></TD></TR>';
			}
		}
		$main_content .= '</TABLE><br />';
		
$guild_id = (int)$_GET['guild'];
$guildMembers = $db->query('SELECT COUNT(`gr`.`id`) AS `total` FROM `players` AS `p` LEFT JOIN `guild_ranks` AS `gr` ON `gr`.`id` = `p`.`rank_id` WHERE `gr`.`guild_id` = '.$guild_id )->fetch();
$allM = $db->query('SELECT COUNT(1) as `people` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') AND online = 1')->fetch();
$allM1 = $db->query('SELECT SUM(`level`) as `level` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ')->fetch();
$allM2 = $db->query('SELECT AVG(`level`) as `level` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ')->fetch();
$allM3 = $db->query('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ORDER BY `level` ASC LIMIT 1')->fetch();
$allM4 = $db->query('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ORDER BY `level` DESC LIMIT 1')->fetch();
$invite = $db->query('SELECT COUNT(*) FROM `guild_invites` WHERE `guild_id` = '.$guild_id.'')->fetch( );

$main_content .= '
<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
	<tr bgcolor="' . $config['site']['vdarkborder'] . '">
		<td class="white" colspan="2" style="font-weight: bold;">'.$lang['site']['GUI_GP_T_10'].'</td>
	</tr>
	<tr bgcolor="' . $config['site']['vdarkborder'] . '">
		<td width="40%" style="font-weight: bold;">'.$lang['site']['GUI_GP_T_11'].'</td>
		<td width="60%" style="font-weight: bold;">'.$lang['site']['GUI_GP_T_12'].'</td>
	</tr>
	<tr bgcolor="' . $config['site']['lightborder'] . '">
		<td valign="top">'.$lang['site']['GUI_GP_T_13'].'</td>
		<td>' . $guildMembers['total'] . '</td>
	</tr>
	<tr bgcolor="' . $config['site']['darkborder'] . '">
		<td>'.$lang['site']['GUI_GP_T_14'].'</td>
		<td>' . $allM[0] . '</td>
	</tr>
	<tr bgcolor="' . $config['site']['lightborder'] . '">
		<td>'.$lang['site']['GUI_GP_T_15'].'</td>
		<td>' . $allM1[0] . '</td>
	</tr>
	<tr bgcolor="' . $config['site']['darkborder'] . '">
		<td>'.$lang['site']['GUI_GP_T_16'].'</td>
		<td>' . round($allM2[0]) . '</td>
	</tr>
	<tr bgcolor="' . $config['site']['lightborder'] . '">
		<td>'.$lang['site']['GUI_GP_T_17'].'</td>
		<td>' . $allM3[0] . '</td>
	</tr>
	<tr bgcolor="' . $config['site']['darkborder'] . '">
		<td>'.$lang['site']['GUI_GP_T_18'].'</td>
		<td>' . $allM4[0] . '</td>
	</tr>
	<tr bgcolor="' . $config['site']['lightborder'] . '">
		<td>'.$lang['site']['GUI_GP_T_19'].'</td>
		<td>' . $invite[0] . '</td>
	</tr>
</table>';
		
		include('pot/InvitesDriver.php');
		new InvitesDriver($guild);
		$invited_list = $guild->listInvites();
		if(count($invited_list) == 0)
			$main_content .= '<BR><table border=0 cellspacing=0 cellpadding=0 width=100% id=iblue><tr><td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% id=iblue><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=2 CLASS=white><B>'.$lang['site']['GUI_GP_T_20'].'</B></TD></TR><TR BGCOLOR='.$config['site']['lightborder'].'><TD>'.$lang['site']['GUI_GP_T_21'].'</TD></TR></TABLE></td></tr></table>';
		else
		{
			$main_content .= '<BR><table border=0 cellspacing=0 cellpadding=0 width=100% id=iblue><tr><td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% id=iblue><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=2 CLASS=white><B>'.$lang['site']['GUI_GP_T_20'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD width=70%><B>'.$lang['site']['GUI_GP_T_22'].'</B></TD><TD><B>'.$lang['site']['GUI_GP_T_23'].'</b></TD></TR>';
			$show_accept_invite = 0;
			$showed_invited = 1;
			foreach($invited_list as $invited_player)
			{
				if(count($account_players) > 0)
					foreach($account_players as $player_from_acc)
						if($player_from_acc->getName() == $invited_player->getName())
							$show_accept_invite++;
				if(is_int($showed_invited / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $showed_invited++;
				$main_content .= '<TR bgcolor="'.$bgcolor.'"><TD><a href="?subtopic=characters&name='.urlencode($invited_player->getName()).'">'.$invited_player->getName().'</a>';
				if($guild_vice)
					$main_content .= '  (<a href="?subtopic=guilds&action=deleteinvite&guild='.$guild_name.'&name='.$invited_player->getName().'">'.$lang['site']['GUI_GP_T_24'].'</a>)';
				$invdate_g = $db->query("SELECT * FROM `guild_invites` WHERE `player_id` = '".$invited_player->getId()."'")->fetch();
				$main_content .= "</TD><td>".date("M d Y",$invdate_g['invitation_date'])."</td></TR>"; 
			}
			$main_content .= '</TABLE></td></tr></table>';
		}
		$main_content .= '<BR><BR>
		<TABLE BORDER=0 WIDTH=100%><TR>';
		if(!$logged)
			$main_content .= '<TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=login&guild='.$guild_name.'&redirect=guild" METHOD=post><TR><TD>
			<INPUT TYPE=image NAME="Login" ALT="Login" SRC="'.$layout_name.'/images/buttons/login.png" BORDER=0 WIDTH=120 HEIGHT=18>
			</TD></TR></FORM></TABLE></TD>';
		else
		{
			if($show_accept_invite > 0)
				$main_content .= '<TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=acceptinvite&guild='.$guild_name.'" METHOD=post><TR><TD>
				<INPUT TYPE=image NAME="Accept Invite" ALT="Accept Invite" SRC="'.$layout_name.'/images/buttons/accept_invite.png" BORDER=0 WIDTH=120 HEIGHT=18>
				</TD></TR></FORM></TABLE></TD>';
			if($guild_vice)
			{
				$main_content .= '<tr><TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=invite&guild='.$guild_name.'" METHOD=post><TR><TD>
				<INPUT TYPE=image NAME="Invite Player" ALT="Invite Player" SRC="'.$layout_name.'/images/buttons/invite_player.png" BORDER=0 WIDTH=120 HEIGHT=18>
				</TD></TR></FORM></TABLE></TD>';
				$main_content .= '<TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=changerank&guild='.$guild_name.'" METHOD=post><TR><TD>
				<INPUT TYPE=image NAME="Change Rank" ALT="Change Rank" SRC="'.$layout_name.'/images/buttons/change_rank.png" BORDER=0 WIDTH=120 HEIGHT=18>
				</TD></TR></FORM></TABLE></TD></tr>';
			}
			if($players_from_account_in_guild > 0)
				$main_content .= '<TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=leaveguild&guild='.$guild_name.'" METHOD=post><TR><TD>
				<INPUT TYPE=image NAME="Leave Guild" ALT="Leave Guild" SRC="'.$layout_name.'/images/buttons/leave_guild.png" BORDER=0 WIDTH=120 HEIGHT=18>
				</TD></TR></FORM></TABLE></TD>';
		}
		$main_content .= '<TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&world='.$guild->getWorld().'" METHOD=post><TR><TD>
		<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE>
		</TD></TR></TABLE>
		</TD></TR></TABLE>';
	}
}

//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//change rank of player in guild
if($action == 'changerank')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(!$logged)
		$guild_errors[] = $lang['site']['CROPIG_T_1'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['CROPIG_T_2'].' <b>'.$guild_name.'</b> '.$lang['site']['CROPIG_T_3'].'';
	}
	if(!empty($guild_errors))
	{
		//show errors
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CROPIG_T_4'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		//errors and back button
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
	//check is it vice or/and leader account (leader has vice + leader rights)
	$rank_list = $guild->getGuildRanksList();
	$rank_list->orderBy('level', POT::ORDER_DESC);
	$guild_leader = FALSE;
	$guild_vice = FALSE;
	$account_players = $account_logged->getPlayers();
	foreach($account_players as $player)
	{
		$player_rank = $player->getRank();
		if(!empty($player_rank))
			foreach($rank_list as $rank_in_guild)
				if($rank_in_guild->getId() == $player_rank->getId())
				{
					$players_from_account_in_guild[] = $player->getName();
					if($player_rank->getLevel() > 1) {
						$guild_vice = TRUE;
						$level_in_guild = $player_rank->getLevel();
					}
					if($guild->getOwner()->getId() == $player->getId()) {
						$guild_vice = TRUE;
						$guild_leader = TRUE;
					}
				}
	}
	//tworzenie listy osob z nizszymi uprawnieniami i rank z nizszym levelem
	if($guild_vice)
	{
		foreach($rank_list as $rank)
		{
			if($guild_leader || $rank->getLevel() < $level_in_guild)
			{
				$ranks[$rid]['0'] = $rank->getId();
				$ranks[$rid]['1'] = $rank->getName();
				$rid++;
				$players_with_rank = $rank->getPlayersList();
				$players_with_rank->orderBy('name');
				if(count($players_with_rank) > 0)
				{
					foreach($players_with_rank as $player)
					{
						if($guild->getOwner()->getId() != $player->getId() || $guild_leader)
						{
							$players_with_lower_rank[$sid]['0'] = $player->getName();
							$players_with_lower_rank[$sid]['1'] = $player->getName().' ('.$rank->getName().')';
							$sid++;
						}
					}
				}
			}
		}
		if($_REQUEST['todo'] == 'save')
		{
			$player_name = stripslashes($_REQUEST['name']);
			$new_rank = (int) $_REQUEST['rankid'];
			if(!check_name($player_name))
				$change_errors[] = $lang['site']['CROPIG_T_5'];
			$rank = $ots->createObject('GuildRank');
			$rank->load($new_rank);
			if(!$rank->isLoaded())
				$change_errors[] = $lang['site']['CROPIG_T_6'];
			if($level_in_guild <= $rank->getLevel() && !$guild_leader)
				$change_errors[] = $lang['site']['CROPIG_T_7'];
			if(empty($change_errors))
			{
				$player_to_change = $ots->createObject('Player');
				$player_to_change->find($player_name);
				if(!$player_to_change->isLoaded())
					$change_errors[] = ''.$lang['site']['CROPIG_T_8'].' '.$player_name.'</b> '.$lang['site']['CROPIG_T_9'].'';
				else
				{
					$player_in_guild = FALSE;
					if($guild->getName() == $player_to_change->getRank()->getGuild()->getName() || $guild_leader)
					{
						$player_in_guild = TRUE;
						$player_has_lower_rank = FALSE;
						if($player_to_change->getRank()->getLevel() < $level_in_guild || $guild_leader)
							$player_has_lower_rank = TRUE;
					}
				}
				$rank_in_guild = FALSE;
				foreach($rank_list as $rank_from_guild)
					if($rank_from_guild->getId() == $rank->getId())
						$rank_in_guild = TRUE;
				if(!$player_in_guild)
				$change_errors[] = $lang['site']['CROPIG_T_10'];
				if(!$rank_in_guild)
					$change_errors[] = $lang['site']['CROPIG_T_11'];
				if(!$player_has_lower_rank)
					$change_errors[] = $lang['site']['CROPIG_T_12'];
			}
			if(empty($change_errors))
			{
				$player_to_change->setRank($rank);
				$player_to_change->save();
				$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['CROPIG_T_13'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['CROPIG_T_14'].' <b>'.$player_to_change->getName().'</b> '.$lang['site']['CROPIG_T_15'].' <b>'.$rank->getName().'</b>.</td></tr>          </table>        </div>  </table></div></td></tr><br>';
				unset($players_with_lower_rank);
				unset($ranks);
				$rid = 0;
				$sid= 0;
				foreach($rank_list as $rank)
				{
					if($guild_leader || $rank->getLevel() < $level_in_guild)
					{
						$ranks[$rid]['0'] = $rank->getId();
						$ranks[$rid]['1'] = $rank->getName();
						$rid++;
						$players_with_rank = $rank->getPlayersList();
						$players_with_rank->orderBy('name');
						if(count($players_with_rank) > 0)
						{
							foreach($players_with_rank as $player)
							{
								if($guild->getOwner()->getId() != $player->getId() || $guild_leader)
								{
									$players_with_lower_rank[$sid]['0'] = $player->getName();
									$players_with_lower_rank[$sid]['1'] = $player->getName().' ('.$rank->getName().')';
									$sid++;
								}
							}
						}
					}
				}
			}
			else
			{
				$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CROPIG_T_16'].'</b><br/>';
				foreach($change_errors as $change_error)
					$main_content .= '<li>'.$change_error;
				$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
			}
		}
		$main_content .= '<FORM ACTION="?subtopic=guilds&action=changerank&guild='.$guild_name.'&todo=save" METHOD=post>
		<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%>
		<TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['CROPIG_T_17'].'</B></TD></TR>
		<TR BGCOLOR='.$config['site']['darkborder'].'><TD>'.$lang['site']['CROPIG_T_18'].' <SELECT NAME="name">';
		foreach($players_with_lower_rank as $player_to_list)
			$main_content .= '<OPTION value="'.$player_to_list['0'].'">'.$player_to_list['1'];
		$main_content .= '</SELECT>&nbsp;'.$lang['site']['CROPIG_T_19'].':&nbsp;<SELECT NAME="rankid">';
		foreach($ranks as $rank)
			$main_content .= '<OPTION value="'.$rank['0'].'">'.$rank['1'];
		$main_content .= '</SELECT>&nbsp;&nbsp;&nbsp;<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/submit.png" BORDER=0 WIDTH=120 HEIGHT=18></TD><TR>
		</TABLE></FORM><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
		$main_content .= ''.$lang['site']['CROPIG_T_20'].' '.$guild->getName().'.<FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></FORM>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'deleteinvite')
{
	//set rights in guild
	$guild_name = (int) $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	if(!$logged)
		$guild_errors[] = $lang['site']['RING_T_1'];
	if(!check_name($name))
		$guild_errors[] = $lang['site']['RING_T_2'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['RING_T_3'].' <b>'.$guild_name.'</b> '.$lang['site']['RING_T_4'].'';
	}
	if(empty($guild_errors))
	{
		$rank_list = $guild->getGuildRanksList();
		$rank_list->orderBy('level', POT::ORDER_DESC);
		$guild_leader = FALSE;
		$guild_vice = FALSE;
		$account_players = $account_logged->getPlayers();
		foreach($account_players as $player)
		{
			$player_rank = $player->getRank();
			if(!empty($player_rank))
			{
				foreach($rank_list as $rank_in_guild)
				{
					if($rank_in_guild->getId() == $player_rank->getId())
					{
						$players_from_account_in_guild[] = $player->getName();
						if($player_rank->getLevel() > 1)
						{
							$guild_vice = TRUE;
							$level_in_guild = $player_rank->getLevel();
						}
						if($guild->getOwner()->getId() == $player->getId())
						{
							$guild_vice = TRUE;
							$guild_leader = TRUE;
						}
					}
				}
			}
		}
	}
	if(empty($guild_errors))
	{
		$player = new OTS_Player();
		$player->find($name);
		if(!$player->isLoaded())
			$guild_errors[] = ''.$lang['site']['RING_T_5'].' <b>'.$name.'</b> '.$lang['site']['RING_T_4'].'';
	}
	if(!$guild_vice)
		$guild_errors[] = ''.$lang['site']['RING_T_6'].' <b>'.$guild_name.'</b>.';
	if(empty($guild_errors))
	{
		include('pot/InvitesDriver.php');
		new InvitesDriver($guild);
		$invited_list = $guild->listInvites();
		if(count($invited_list) > 0)
		{
			$is_invited = FALSE;
			foreach($invited_list as $invited)
				if($invited->getName() == $player->getName())
					$is_invited = TRUE;
			if(!$is_invited)
				$guild_errors[] = '<b>'.$player->getName().'</b> '.$lang['site']['RING_T_7'].'';
		}
		else
			$guild_errors[] = $lang['site']['RING_T_8'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['RING_T_9'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		if($_REQUEST['todo'] == 'save')
		{
			$guild->deleteInvite($player);
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['RING_T_10'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['RING_T_11'].' <b>'.$player->getName().'</b> '.$lang['site']['RING_T_12'].'</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
		}
		else
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['RING_T_10'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['RING_T_13'].' <b>'.$player->getName().'</b> '.$lang['site']['RING_T_14'].'</TD></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=deleteinvite&guild='.$guild_name.'&name='.$player->getName().'&todo=save" METHOD=post><TD align="right" width="50%"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18>&nbsp;&nbsp;</TD></FORM><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD>&nbsp;&nbsp;<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'invite')
{
	//set rights in guild
	$guild_name = (int) $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	if(!$logged)
		$guild_errors[] = $lang['site']['SGP_T_1'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['SGP_T_2'].' <b>'.$guild_name.'</b> '.$lang['site']['SGP_T_3'].'';
	}
	if(empty($guild_errors))
	{
		$rank_list = $guild->getGuildRanksList();
		$rank_list->orderBy('level', POT::ORDER_DESC);
		$guild_leader = FALSE;
		$guild_vice = FALSE;
		$account_players = $account_logged->getPlayers();
		foreach($account_players as $player)
		{
			$player_rank = $player->getRank();
			if(!empty($player_rank))
				foreach($rank_list as $rank_in_guild)
					if($rank_in_guild->getId() == $player_rank->getId())
					{
						$players_from_account_in_guild[] = $player->getName();
						if($player_rank->getLevel() > 1)
						{
							$guild_vice = TRUE;
							$level_in_guild = $player_rank->getLevel();
						}
						if($guild->getOwner()->getId() == $player->getId())
						{
							$guild_vice = TRUE;
							$guild_leader = TRUE;
						}
					}
		}
	}
	if(!$guild_vice)
		$guild_errors[] = ''.$lang['site']['SGP_T_4'].' <b>'.$guild_name.'</b>.'.$level_in_guild;
	if($_REQUEST['todo'] == 'save')
	{
		if(!check_name($name))
			$guild_errors[] = $lang['site']['SGP_T_5'];
		if(empty($guild_errors))
		{
			$player = new OTS_Player();
			$player->find($name);
			if(!$player->isLoaded())
				$guild_errors[] = ''.$lang['site']['SGP_T_6'].' <b>'.$name.'</b> '.$lang['site']['SGP_T_7'].'';
			else
			{
				$rank_of_player = $player->getRank();
				if(!empty($rank_of_player))
					$guild_errors[] = ''.$lang['site']['SGP_T_8'].' <b>'.$name.'</b> '.$lang['site']['SGP_T_9'].'';
			}
		}
		if(empty($guild_errors) && $guild->getWorld() != $player->getWorld())
			$guild_errors[] = '<b>'.$player->getName().'</b> '.$lang['site']['SGP_T_10'].'';
		if(empty($guild_errors))
		{
			include('pot/InvitesDriver.php');
			new InvitesDriver($guild);
			$invited_list = $guild->listInvites();
			if(count($invited_list) > 0)
				foreach($invited_list as $invited)
					if($invited->getName() == $player->getName())
						$guild_errors[] = '<b>'.$player->getName().'</b> '.$lang['site']['SGP_T_11'].'';
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['SGP_T_12'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
		if($_REQUEST['todo'] == 'save')
		{
			$guild->invite($player);
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['SGP_T_13'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['SGP_T_14'].' <b>'.$player->getName().'</b> '.$lang['site']['SGP_T_15'].'</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
		}
		else
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['SGP_T_13'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%><FORM ACTION="?subtopic=guilds&action=invite&guild='.$guild_name.'&todo=save" METHOD=post>'.$lang['site']['SGP_T_16'].'&nbsp;&nbsp;<INPUT TYPE="text" NAME="name">&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/submit.png" BORDER=0 WIDTH=120 HEIGHT=18></FORM></TD></TD></TR></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'acceptinvite') {
//set rights in guild
$guild_name = (int) $_REQUEST['guild'];
$name = stripslashes($_REQUEST['name']);
if(!$logged)
	$guild_errors[] = $lang['site']['SGP_T_17'];
if(empty($guild_errors))
{
	$guild = $ots->createObject('Guild');
	$guild->load($guild_name);
	if(!$guild->isLoaded())
		$guild_errors[] = ''.$lang['site']['SGP_T_18'].' <b>'.$guild_name.'</b> '.$lang['site']['SGP_T_19'].'';
}

if($_REQUEST['todo'] == 'save') {
if(!check_name($name))
	$guild_errors[] = $lang['site']['SGP_T_20'];
if(empty($guild_errors)) {
$player = new OTS_Player();
$player->find($name);
if(!$player->isLoaded()) {
$guild_errors[] = ''.$lang['site']['SGP_T_21'].' <b>'.$name.'</b> '.$lang['site']['SGP_T_22'].'';
}
else
{
$rank_of_player = $player->getRank();
if(!empty($rank_of_player)) {
$guild_errors[] = ''.$lang['site']['SGP_T_23'].' <b>'.$name.'</b> '.$lang['site']['SGP_T_24'].'';
}
}
}
}
if($_REQUEST['todo'] == 'save') {
if(empty($guild_errors)) {
$is_invited = FALSE;
include('pot/InvitesDriver.php');
new InvitesDriver($guild);
$invited_list = $guild->listInvites();
if(count($invited_list) > 0) {
foreach($invited_list as $invited) {
if($invited->getName() == $player->getName()) {
$is_invited = TRUE;
}
}
}
if(!$is_invited) {
$guild_errors[] = ''.$lang['site']['SGP_T_25'].' '.$player->getName.' '.$lang['site']['SGP_T_26'].' <b>'.$guild->getName().'</b>.';
}
}
}
else
{
//co jesli nie save
if(empty($guild_errors)) {
$acc_invited = FALSE;
$account_players = $account_logged->getPlayers();
include('pot/InvitesDriver.php');
new InvitesDriver($guild);
$invited_list = $guild->listInvites();
if(count($invited_list) > 0) {
foreach($invited_list as $invited) {
foreach($account_players as $player_from_acc){
if($invited->getName() == $player_from_acc->getName()) {
$acc_invited = TRUE;
$list_of_invited_players[] = $player_from_acc->getName();
}
}
}
}
}
if(!$acc_invited) {
$guild_errors[] = ''.$lang['site']['CJNS_T_1'].' <b>'.$guild->getName().'</b>.';
}
}
if(!empty($guild_errors)) {
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CJNS_T_2'].'</b><br/>';
foreach($guild_errors as $guild_error) {
	$main_content .= '<li>'.$guild_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
}
else
{
if($_REQUEST['todo'] == 'save') {
$guild->acceptInvite($player);
$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['CJNS_T_3'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['CJNS_T_4'].' <b>'.$player->getName().'</b> '.$lang['site']['CJNS_T_5'].' <b>'.$guild->getName().'</b>.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
}
else
{
$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['CJNS_T_3'].'</B></TD></TR>';
$main_content .= '<TR BGCOLOR='.$config['site']['lightborder'].'><TD WIDTH=100%>'.$lang['site']['CJNS_T_6'].'</TD></TR>';
$main_content .= '<TR BGCOLOR='.$config['site']['darkborder'].'><TD>
<form action="?subtopic=guilds&action=acceptinvite&guild='.$guild_name.'&todo=save" METHOD="post">';
sort($list_of_invited_players);
foreach($list_of_invited_players as $invited_player_from_list) {
$main_content .= '<input type="radio" name="name" value="'.$invited_player_from_list.'" />'.$invited_player_from_list.'<br>';
}
$main_content .= '<br><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/submit.png" BORDER=0 WIDTH=120 HEIGHT=18></form></TD></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
}
}
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'kickplayer') {
//set rights in guild
$guild_name = (int) $_REQUEST['guild'];
$name = stripslashes($_REQUEST['name']);
if(!$logged)
	$guild_errors[] = $lang['site']['RINGK_T_1'];
if(!check_name($name))
	$guild_errors[] = $lang['site']['RINGK_T_2'];
if(empty($guild_errors))
{
	$guild = $ots->createObject('Guild');
	$guild->load($guild_name);
	if(!$guild->isLoaded())
		$guild_errors[] = ''.$lang['site']['RINGK_T_3'].' <b>'.$guild_name.'</b> '.$lang['site']['RINGK_T_4'].'';
}
if(empty($guild_errors)) {
$rank_list = $guild->getGuildRanksList();
$rank_list->orderBy('level', POT::ORDER_DESC);
$guild_leader = FALSE;
$guild_vice = FALSE;
$account_players = $account_logged->getPlayers();
foreach($account_players as $player) {
$player_rank = $player->getRank();
if(!empty($player_rank)) {
foreach($rank_list as $rank_in_guild) {
if($rank_in_guild->getId() == $player_rank->getId()) {
$players_from_account_in_guild[] = $player->getName();
if($player_rank->getLevel() > 1) {
$guild_vice = TRUE;
$level_in_guild = $player_rank->getLevel();
}
if($guild->getOwner()->getId() == $player->getId()) {
$guild_vice = TRUE;
$guild_leader = TRUE;
}
}
}
}
}
}
if(empty($guild_errors)) {
if(!$guild_leader && $level_in_guild < 3) {
$guild_errors[] = ''.$lang['site']['RINGK_T_5'].' <b>'.$guild_name.'</b>. '.$lang['site']['RINGK_T_6'].'';
}
}
if(empty($guild_errors)) {
$player = new OTS_Player();
$player->find($name);
if(!$player->isLoaded()) {
$guild_errors[] = ''.$lang['site']['RINGK_T_7'].' <b>'.$name.'</b> '.$lang['site']['RINGK_T_8'].'';
}
else
{
if($player->getRank()->getGuild()->getName() != $guild->getName()) {
$guild_errors[] = ''.$lang['site']['RINGK_T_7'].' <b>'.$name.'</b> '.$lang['site']['RINGK_T_9'].'';
}
}
}
if(empty($guild_errors)) {
if($player->getRank()->getLevel() >= $level_in_guild && !$guild_leader) {
$guild_errors[] = ''.$lang['site']['RINGK_T_10'].' <b>'.$name.'</b>. '.$lang['site']['RINGK_T_11'].'';
}
}
if(empty($guild_errors)) {
if($guild->getOwner()->getName() == $player->getName()) {
$guild_errors[] = $lang['site']['RINGK_T_12'];
}
}
if(!empty($guild_errors)) {
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['RINGK_T_13'].'</b><br/>';
foreach($guild_errors as $guild_error) {
	$main_content .= '<li>'.$guild_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
}
else
	if($_REQUEST['todo'] == 'save')
	{
		$player->setRank();
		$player->save();
		$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['RINGK_T_14'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['RINGK_T_15'].' <b>'.$player->getName().'</b> '.$lang['site']['RINGK_T_16'].'</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
		$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['RINGK_T_14'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['RINGK_T_17'].' <b>'.$player->getName().'</b> '.$lang['site']['RINGK_T_18'].'</TD></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=kickplayer&guild='.$guild_name.'&name='.$player->getName().'&todo=save" METHOD=post><TD align="right" width="50%"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/submit.png" BORDER=0 WIDTH=120 HEIGHT=18>&nbsp;&nbsp;</TD></FORM><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD>&nbsp;&nbsp;<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/back.png" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'leaveguild')
{
	//set rights in guild
	$guild_name = (int) $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	if(!$logged)
		$guild_errors[] = $lang['site']['RINGL_T_1'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['RINGL_T_2'].' <b>'.$guild_name.'</b> '.$lang['site']['RINGL_T_3'].'';
	}

	if(empty($guild_errors))
	{
		$guild_owner_id = $guild->getOwner()->getId();
		if($_REQUEST['todo'] == 'save')
		{
			if(!check_name($name))
				$guild_errors[] = $lang['site']['RINGL_T_4'];
			if(empty($guild_errors))
			{
				$player = new OTS_Player();
				$player->find($name);
				if(!$player->isLoaded())
					$guild_errors[] = ''.$lang['site']['RINGL_T_5'].' <b>'.$name.'</b> '.$lang['site']['RINGL_T_6'].'';
				else
					if($player->getAccount()->getId() != $account_logged->getId())
						$guild_errors[] = ''.$lang['site']['RINGL_T_5'].' <b>'.$name.'</b> '.$lang['site']['RINGL_T_8'].'';
			}
			if(empty($guild_errors))
			{
				$player_loaded_rank = $player->getRank();
				if(!empty($player_loaded_rank) && $player_loaded_rank->isLoaded())
				{
					if($player_loaded_rank->getGuild()->getId() != $guild->getId())
						$guild_errors[] = ''.$lang['site']['RINGL_T_5'].' <b>'.$name.'</b> '.$lang['site']['RINGL_T_9'].' <b>'.$guild->getName().'</b>.';
				}
				else
					$guild_errors[] = ''.$lang['site']['RINGL_T_5'].' <b>'.$name.'</b> '.$lang['site']['RINGL_T_10'].'';
			}
			if(empty($guild_errors))
				if($guild_owner_id == $player->getId())
					$guild_errors[] = $lang['site']['RINGL_T_11'];
		}
		else
		{
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player_fac)
			{
				$player_rank = $player_fac->getRank();
				if(!empty($player_rank))
					if($player_rank->getGuild()->getId() == $guild->getId())
						if($guild_owner_id != $player_fac->getId())
							$array_of_player_ig[] = $player_fac->getName();
			}
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['RINGL_T_12'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		if($_REQUEST['todo'] == 'save')
		{
			$player->setRank();
			$player->save();
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['RINGL_T_13'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%>'.$lang['site']['RINGL_T_14'].' <b>'.$player->getName().'</b> '.$lang['site']['RINGL_T_15'].' <b>'.$guild->getName().'</b>.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
		}
		else
		{
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['RINGL_T_13'].'</B></TD></TR>';
			if(count($array_of_player_ig) > 0)
			{
				$main_content .= '<TR BGCOLOR='.$config['site']['lightborder'].'><TD WIDTH=100%>'.$lang['site']['RINGL_T_16'].'</TD></TR>';
				$main_content .= '<TR BGCOLOR='.$config['site']['darkborder'].'><TD>
				<form action="?subtopic=guilds&action=leaveguild&guild='.$guild_name.'&todo=save" METHOD="post">';
				sort($array_of_player_ig);
				foreach($array_of_player_ig as $player_to_leave)
					$main_content .= '<input type="radio" name="name" value="'.$player_to_leave.'" />'.$player_to_leave.'<br>';
				$main_content .= '</TD></TR><br></TABLE>';
			}
			else
				$main_content .= '<TR BGCOLOR='.$config['site']['lightborder'].'><TD WIDTH=100%>'.$lang['site']['RINGL_T_17'].'</TD></TR>';
			$main_content .= '<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><tr>';
			if(count($array_of_player_ig) > 0)
				$main_content .= '<td width="130" valign="top"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></form></td>';
			$main_content .= '<td><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></FORM></td></tr></table>';
		}
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//create guild
if($action == 'createguild')
{
	$guild_name = $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	$todo = $_REQUEST['todo'];
	if(!$logged)
		$guild_errors[] = $lang['site']['G_CG_T_1'];
	if(empty($guild_errors)) 
	{
		$account_players = $account_logged->getPlayers();
		foreach($account_players as $player)
		{
			$player_rank = $player->getRank();
			if(empty($player_rank))
				if($player->getLevel() >= $config['site']['guild_need_level'])
					if(!$config['site']['guild_need_pacc'] || $account_logged->isPremium())
						$array_of_player_nig[] = $player->getName();
		}
	}

	if(empty($todo))
	if(count($array_of_player_nig) == 0)
		$guild_errors[] = $lang['site']['G_CG_T_2'];
	if($todo == 'save')
	{
		if(!check_guild_name($guild_name))
		{
			$guild_errors[] = $lang['site']['G_CG_T_3'];
			$guild_name = '';
		}
		if(!check_name($name))
		{
			$guild_errors[] = $lang['site']['G_CG_T_4'];
			$name = '';
		}
		if(empty($guild_errors))
		{
			$player = $ots->createObject('Player');
			$player->find($name);
			if(!$player->isLoaded())
				$guild_errors[] = ''.$lang['site']['G_CG_T_5'].' <b>'.$name.'</b> '.$lang['site']['G_CG_T_6'].'';
		}
		if(empty($guild_errors))
		{
			$guild = $ots->createObject('Guild');
			$guild->find($guild_name);
			if($guild->isLoaded())
				$guild_errors[] = ''.$lang['site']['G_CG_T_7'].' <b>'.$guild_name.'</b> '.$lang['site']['G_CG_T_8'].'';
		}
		if(empty($guild_errors))
		{
			$bad_char = TRUE;
			foreach($array_of_player_nig as $nick_from_list)
				if($nick_from_list == $player->getName())
					$bad_char = FALSE;
			if($bad_char)
				$guild_errors[] = ''.$lang['site']['G_CG_T_5'].' <b>'.$name.'</b> '.$lang['site']['G_CG_T_9'].'';
		}
		if(empty($guild_errors))
		{
			if($player->getLevel() < $config['site']['guild_need_level'])
				$guild_errors[] = ''.$lang['site']['G_CG_T_5'].' <b>'.$name.'</b> '.$lang['site']['G_CG_T_10'].' <b>'.$config['site']['guild_need_level'].'</b>.';
			if($config['site']['guild_need_pacc'] && !$account_logged->isPremium())
				$guild_errors[] = ''.$lang['site']['G_CG_T_5'].' <b>'.$name.'</b> '.$lang['site']['G_CG_T_11'].'';
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['G_CG_T_12'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		unset($todo);
	}

	if($todo == 'save')
	{
		$new_guild = new OTS_Guild();
		$new_guild->setCreationData($time);
		$new_guild->setName($guild_name);
		$new_guild->setOwner($player);
		$new_guild->save();
		$new_guild->setCustomField('description', ''.$lang['site']['G_CG_T_13'].'');
		$new_guild->setCustomField('creationdata', time());
		$new_guild->setCustomField('world_id', $player->getWorld());
		$ranks = $new_guild->getGuildRanksList();
		$ranks->orderBy('level', POT::ORDER_DESC);
		foreach($ranks as $rank)
			if($rank->getLevel() == 3)
			{
				$player->setRank($rank);
				$player->save();
			}
		$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>'.$lang['site']['G_CG_T_14'].'</B></TD></TR><TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=100%><b>'.$lang['site']['G_CG_T_15'].'</b><br/>'.$lang['site']['G_CG_T_16'].' <b>'.$guild_name.'</b>. <b>'.$player->getName().'</b> '.$lang['site']['G_CG_T_17'].'</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$new_guild->getId().'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_Submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		$main_content .= ''.$lang['site']['G_CG_T_18'].' '.$config['server']['serverName'].' '.$lang['site']['G_CG_T_19'].'<BR><BR>
		<FORM ACTION="?subtopic=guilds&action=createguild&todo=save" METHOD=post>
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
		<TR><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>'.$lang['site']['G_CG_T_20'].' '.$config['server']['serverName'].' '.$lang['site']['G_CG_T_21'].'</B></TD></TR>
		<TR><TD BGCOLOR="'.$config['site']['darkborder'].'"><TABLE BORDER=0 CELLSPACING=8 CELLPADDING=0>
		  <TR><TD>
		    <TABLE BORDER=0 CELLSPACING=5 CELLPADDING=0>';
		$main_content .= '<TR><TD width="150" valign="top"><B>'.$lang['site']['G_CG_T_22'].' </B></TD><TD><SELECT name=\'name\'>';
		if(count($array_of_player_nig) > 0)
		{
			sort($array_of_player_nig);
			foreach($array_of_player_nig as $nick)
				$main_content .= '<OPTION>'.$nick.'</OPTION>';
		}
		$main_content .= '</SELECT><BR><font size="1" face="verdana,arial,helvetica">'.$lang['site']['G_CG_T_23'].'</font></TD></TR>
			<TR><TD width="150" valign="top"><B>'.$lang['site']['G_CG_T_24'].' </B></TD><TD><INPUT NAME="guild" VALUE="" SIZE=30 MAXLENGTH=50><BR><font size="1" face="verdana,arial,helvetica">'.$lang['site']['G_CG_T_25'].'</font></TD></TR>
			</TABLE>
		  </TD></TR>
		</TABLE></TD></TR>
		</TABLE>
		<BR>
		<TABLE BORDER=0 WIDTH=100%>
		  <TR><TD ALIGN=center>
		    <IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=120 HEIGHT=1 BORDER=0><BR>
		  </TD><TD ALIGN=center VALIGN=top>
		    <INPUT TYPE=image NAME="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18>
		    </FORM>
		  </TD><TD ALIGN=center>
		    <FORM  ACTION="?subtopic=guilds" METHOD=post>
		    <INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18>
		    </FORM>
		  </TD><TD ALIGN=center>
		    <IMG SRC="/images/general/blank.gif" WIDTH=120 HEIGHT=1 BORDER=0><BR>
		  </TD></TR>
		</TABLE>
		</TD>
		<TD><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD>
		</TR>
		</TABLE>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'manager')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['G_GM_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['G_GM_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$main_content .= '<center><h2>'.$lang['site']['G_GM_T_3'].'</h2></center>'.$lang['site']['G_GM_T_4'].'';
				$main_content .= '<br/><br/><table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'>
				<tr bgcolor='.$config['site']['darkborder'].'><td width="170"><font color="red"><b>'.$lang['site']['G_GM_T_5'].'</b></font></td><td><font color="red"><b>'.$lang['site']['G_GM_T_6'].'</b></font></td></tr>
				<tr bgcolor='.$config['site']['lightborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=passleadership">'.$lang['site']['G_GM_T_7'].'</a></b></td><td><b>'.$lang['site']['G_GM_T_8'].'</b></td></tr>
				<tr bgcolor='.$config['site']['darkborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=deleteguild">'.$lang['site']['G_GM_T_9'].'</a></b></td><td><b>'.$lang['site']['G_GM_T_10'].'</b></td></tr>
				<tr bgcolor='.$config['site']['lightborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changedescription">'.$lang['site']['G_GM_T_11'].'</a></b></td><td><b>'.$lang['site']['G_GM_T_12'].'</b></td></tr>
				<tr bgcolor='.$config['site']['darkborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changemotd">'.$lang['site']['G_GM_T_13'].'</a></b></td><td><b>'.$lang['site']['G_GM_T_14'].'</b></td></tr>
				<tr bgcolor='.$config['site']['lightborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changelogo">'.$lang['site']['G_GM_T_15'].'</a></b></td><td><b>'.$lang['site']['G_GM_T_16'].'</b></td></tr>
				</table>';
				$main_content .= '<br><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['G_GM_T_17'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td width="120" valign="top">'.$lang['site']['G_GM_T_18'].'</td><td> <form action="?subtopic=guilds&guild='.$guild_name.'&action=addrank" method="POST"><input type="text" name="rank_name" size="20"><input type="submit" value="Add"></form></td></tr>          </table>        </div>  </table></div></td></tr>';
				$main_content .= '<center><h3>'.$lang['site']['G_GM_T_19'].'</h3></center><form action="?subtopic=guilds&action=saveranks&guild='.$guild_name.'" method=POST><table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'><tr bgcolor='.$config['site']['vdarkborder'].'><td rowspan="2" width="120" align="center"><font color="white"><b>'.$lang['site']['G_GM_T_20'].'</b></font></td><td rowspan="2" width="300"><font color="white"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$lang['site']['G_GM_T_21'].'</b></font></td><td colspan="3" align="center"><font color="white"><b>'.$lang['site']['G_GM_T_22'].'</b></font></td></tr><tr bgcolor='.$config['site']['vdarkborder'].'><td align="center" bgcolor="red"><font color="white"><b>'.$lang['site']['G_GM_T_23'].'</b></font></td><td align="center" bgcolor="yellow"><font color="black"><b>'.$lang['site']['G_GM_T_24'].'</b></font></td><td align="center" bgcolor="green"><font color="white"><b>'.$lang['site']['G_GM_T_25'].'</b></font></td></tr>';
				foreach($rank_list as $rank)
				{
					if(is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $number_of_rows++;
					$main_content .= '<tr bgcolor="'.$bgcolor.'"><td align="center"><a href="?subtopic=guilds&guild='.$guild_name.'&action=deleterank&rankid='.$rank->getId().'" border="0"><img src="'.$layout_name.'/images/news/delete.png" border="0" alt="Delete Rank"></a></td><td><input type="text" name="'.$rank->getId().'_name" value="'.$rank->getName().'" size="35"></td><td align="center"><input type="radio" name="'.$rank->getId().'_level" value="3"';
					if($rank->getLevel() == 3)
						$main_content .= ' checked="checked"';
					$main_content .= ' /></td><td align="center"><input type="radio" name="'.$rank->getId().'_level" value="2"';
					if($rank->getLevel() == 2)
						$main_content .= ' checked="checked"';
					$main_content .= ' /></td><td align="center"><input type="radio" name="'.$rank->getId().'_level" value="1"';
					if($rank->getLevel() == 1)
						$main_content .= ' checked="checked"';
					$main_content .= ' /></td></tr>';
				}
				$main_content .= '<tr bgcolor='.$config['site']['vdarkborder'].'><td>&nbsp;</td><td>&nbsp;</td><td colspan="3" align="center"><input type="submit" value="Save All"></td></tr></table></form>';
				$main_content .= '<h3>'.$lang['site']['G_GM_T_26'].'</h3><b>'.$lang['site']['G_GM_T_27'].'</b> '.$lang['site']['G_GM_T_28'].'
				<li>'.$lang['site']['G_GM_T_29'].'
				<li>'.$lang['site']['G_GM_T_30'].'
				<li>'.$lang['site']['G_GM_T_31'].'
				<li>'.$lang['site']['G_GM_T_32'].'
				<li>'.$lang['site']['G_GM_T_33'].'<hr>
				<b>'.$lang['site']['G_GM_T_34'].'</b> '.$lang['site']['G_GM_T_35'].'
				<li>'.$lang['site']['G_GM_T_36'].'
				<li>'.$lang['site']['G_GM_T_37'].'<hr>
				<b>'.$lang['site']['G_GM_T_38'].'</b> '.$lang['site']['G_GM_T_39'].'
				<li>'.$lang['site']['G_GM_T_40'].'
				<li>'.$lang['site']['G_GM_T_41'].'<hr>
				<b>'.$lang['site']['G_GM_T_42'].'</b> '.$lang['site']['G_GM_T_43'].'
				<li>'.$lang['site']['G_GM_T_44'].'';
				$main_content .= '<br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['G_GM_T_46'];
		}
		else
			$guild_errors[] = $lang['site']['G_GM_T_47'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['G_GM_T_47'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'changelogo')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['GCL_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['GCL_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
			{
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			}
			if($guild_leader)
			{
				$max_image_size_b = $config['site']['guild_image_size_kb'] * 1024;
				$allowed_ext = array('image/gif', 'image/jpg', 'image/pjpeg', 'image/jpeg', 'image/bmp', 'image/png', 'image/x-png');
				if($_REQUEST['todo'] == 'save')
				{
					$file = $_FILES['newlogo'];
					if($file['size'] > $max_image_size_b)
						$upload_errors[] = ''.$lang['site']['GCL_T_3'].' <b>'.$file['size'].' '.$lang['site']['GCL_T_4'].'</b>, '.$lang['site']['GCL_T_5'].' <b>'.$max_image_size_b.' '.$lang['site']['GCL_T_6'].'</b>.';
							
					$type = strtolower($file['type']);
					if(!in_array($type, $allowed_ext))
						$upload_errors[] = ''.$lang['site']['GCL_T_7'].' <b>'.$lang['site']['GCL_T_8'].'</b>. '.$lang['site']['GCL_T_9'].' <b>'.$type.'</b> '.$lang['site']['GCL_T_10'].'';
							
					if(!empty($upload_errors))
					{
						$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GCL_T_11'].'</b><br/>';
						foreach($upload_errors as $guild_error)
							$main_content .= '<li>'.$guild_error;
						$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
					}
					else
						$db->query("UPDATE `guilds` SET `logo` = '" . addslashes(fread(fopen($file['tmp_name'], "rb"), $file['size'])) . "' WHERE `id` = " . $guild->getId() . ";");
				}
				$main_content .= '<center><h2>'.$lang['site']['GCL_T_12'].'</h2></center>'.$lang['site']['GCL_T_13'].'<BR>'.$lang['site']['GCL_T_14'].' <img src="./guilds/' . $guild->getId() . '.jpg" /><br /><br />';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changelogo" method="POST">
				<input type="hidden" name="todo" value="save" />
				<input type="hidden" name="MAX_FILE_SIZE" value="'.$max_image_size_b.'" />
				    '.$lang['site']['GCL_T_15'].' <input name="newlogo" type="file" />
				    <input type="submit" value="Send new logo" /></form>'.$lang['site']['GCL_T_16'].' <b>'.$lang['site']['GCL_T_17'].'</b> '.$lang['site']['GCL_T_18'].' <b>'.$config['site']['guild_image_size_kb'].' '.$lang['site']['GCL_T_19'].'</b><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['GCL_T_20'];
		}
		else
			$guild_errors[] = $lang['site']['GCL_T_21'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GCL_T_22'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'deleterank')
{
	$guild_name = (int) $_REQUEST['guild'];
	$rank_to_delete = (int) $_REQUEST['rankid'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['GDR_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['GDR_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$rank = new OTS_GuildRank();
				$rank->load($rank_to_delete);
				if(!$rank->isLoaded())
					$guild_errors2[] = ''.$lang['site']['GDR_T_3'].' '.$rank_to_delete.' '.$lang['site']['GDR_T_4'].'';
				else
				{
					if($rank->getGuild()->getId() != $guild->getId())
						$guild_errors2[] = ''.$lang['site']['GDR_T_3'].' '.$rank_to_delete.' '.$lang['site']['GDR_T_5'].'';
					else
					{
						if(count($rank_list) < 2)
							$guild_errors2[] = $lang['site']['GDR_T_6'];
						else
						{
							$players_with_rank = $rank->getPlayersList();
							$players_with_rank_number = count($players_with_rank);
							if($players_with_rank_number > 0)
							{
								foreach($rank_list as $checkrank)
									if($checkrank->getId() != $rank->getId())
										if($checkrank->getLevel() <= $rank->getLevel())
											$new_rank = $checkrank;
								if(empty($new_rank))
								{
									$new_rank = new OTS_GuildRank();
									$new_rank->setGuild($guild);
									$new_rank->setLevel($rank->getLevel());
									$new_rank->setName(''.$lang['site']['GDR_T_7'].' '.$rank->getLevel());
									$new_rank->save();
								}
								foreach($players_with_rank as $player_in_guild)
								{
									$player_in_guild->setRank($new_rank);
									$player_in_guild->save();
								}
							}
							$rank->delete();
							$saved = TRUE;
						}
					}
				}
				if($saved)
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['GDR_T_8'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['GDR_T_9'].' <b>'.$rank->getName().'</b> '.$lang['site']['GDR_T_10'].'</td></tr>          </table>        </div>  </table></div></td></tr>';
				else
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GDR_T_11'].'</b><br/>';
					foreach($guild_errors2 as $guild_error) 
						$main_content .= '<li>'.$guild_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
				}
				//back button
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['GDR_T_12'];
		}
		else
			$guild_errors[] = $lang['site']['GDR_T_13'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GDR_T_11'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'addrank')
{
	$guild_name = (int) $_REQUEST['guild'];
	$ranknew = $_REQUEST['rank_name'];
	if(empty($guild_errors))
	{
		if(!check_rank_name($ranknew))
			$guild_errors[] = $lang['site']['GAR_T_1'];
		if(!$logged)
			$guild_errors[] = $lang['site']['GAR_T_2'];
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['GAR_T_3'].' <b>'.$guild_name.'</b> '.$lang['site']['GAR_T_4'].'';
		if(empty($guild_errors))
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$new_rank = new OTS_GuildRank();
				$new_rank->setGuild($guild);
				$new_rank->setLevel(1);
				$new_rank->setName($ranknew);
				$new_rank->save();
				header("Location: ?subtopic=guilds&guild=".$guild_name."&action=manager");
				$main_content .= $lang['site']['GAR_T_5'];
			}
			else
				$guild_errors[] = $lang['site']['GAR_T_6'];
		}
		if(!empty($guild_errors))
		{
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GAR_T_7'].'</b><br/>';
			foreach($guild_errors as $guild_error)
				$main_content .= '<li>'.$guild_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
			$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=show" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
	}
	else
		if(!empty($guild_errors))
		{
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GAR_T_7'].'</b><br/>';
			foreach($guild_errors as $guild_error)
				$main_content .= '<li>'.$guild_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
			$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'changedescription')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['GCD_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['GCD_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_REQUEST['todo'] == 'save')
				{
					$description = htmlspecialchars(stripslashes(substr(trim($_REQUEST['description']),0,$config['site']['guild_description_chars_limit'])));
					$guild->setCustomField('description', $description);
					$saved = TRUE;
				}
				$main_content .= '<center><h2>'.$lang['site']['GCD_T_3'].'</h2></center>';
				if($saved)
					$main_content .= '<center><font color="red" size="3"><b>'.$lang['site']['GCD_T_4'].'</b></font></center><br>';
				$main_content .= ''.$lang['site']['GCD_T_5'].'<BR>';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changedescription" method="POST">
				<input type="hidden" name="todo" value="save" />
				    <textarea name="description" cols="60" rows="'.bcsub($config['site']['guild_description_lines_limit'],1).'">'.$guild->getCustomField('description').'</textarea><br>
				    (max. '.$config['site']['guild_description_lines_limit'].' lines, max. '.$config['site']['guild_description_chars_limit'].' chars) <input type="submit" value="Save description" /></form><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['GCD_T_6'];
		}
		else
		$guild_errors[] = $lang['site']['GCD_T_7'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GCD_T_8'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'passleadership')
{
	$guild_name = (int) $_REQUEST['guild'];
	$pass_to = stripslashes(trim($_REQUEST['player']));
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['GPLS_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['GPLS_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($_POST['todo'] == 'save')
		{
			if(!check_name($pass_to))
				$guild_errors2[] = $lang['site']['GPLS_T_3'];
			if(empty($guild_errors2))
			{
				$to_player = new OTS_Player();
				$to_player->find($pass_to);
				if(!$to_player->isLoaded())
					$guild_errors2[] = ''.$lang['site']['GPLS_T_4'].' <b>'.$pass_to.'</b> '.$lang['site']['GPLS_T_5'].'';
				if(empty($guild_errors2))
				{
					$to_player_rank = $to_player->getRank();
					if(!empty($to_player_rank))
					{
						$to_player_guild = $to_player_rank->getGuild();
						if($to_player_guild->getId() != $guild->getId())
							$guild_errors2[] = ''.$lang['site']['GPLS_T_4'].' <b>'.$to_player->getName().'</b> '.$lang['site']['GPLS_T_7'].'';
					}
					else
						$guild_errors2[] = ''.$lang['site']['GPLS_T_4'].' <b>'.$to_player->getName().'</b> '.$lang['site']['GPLS_T_7'].'';
				}
			}
		}
	}
	if(empty($guild_errors) && empty($guild_errors2))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_POST['todo'] == 'save')
				{
					$guild->setOwner($to_player);
					$guild->save();
					$saved = TRUE;
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td><b>'.$to_player->getName().'</b> '.$lang['site']['GPLS_T_8'].' <b>'.$guild->getName().'</b>.</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=show" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['GPLS_T_9'].' </b><br>
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=passleadership" METHOD=post><input type="hidden" name="todo" value="save"><input type="text" size="40" name="player"><input type="submit" value="Save"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['GPLS_T_10'];
		}
		else
			$guild_errors[] = $lang['site']['GPLS_T_11'];
	}
	if(empty($guild_errors) && !empty($guild_errors2))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GCD_T_8'].'</b><br/>';
		foreach($guild_errors2 as $guild_error2)
			$main_content .= '<li>'.$guild_error2;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=passleadership" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['GCD_T_8'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		if(!empty($guild_errors2))
			foreach($guild_errors2 as $guild_error2)
				$main_content .= '<li>'.$guild_error2;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br><br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'deleteguild')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['DGM_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['DGM_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_POST['todo'] == 'save')
				{
					delete_guild($guild->getId());
					$saved = TRUE;
				}
				if($saved)
				{
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['DGM_T_3'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['DGM_T_4'].' <b>'.$guild_name.'</b> '.$lang['site']['DGM_T_5'].'</td></tr>          </table>        </div>  </table></div></td></tr>';
					$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
				{
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['DGM_T_3'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['DGM_T_6'].' <b>'.$guild_name.'</b>?<br>
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=deleteguild" METHOD=post><input type="hidden" name="todo" value="save"><input type="submit" value="Yes, delete"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr>';
					$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
			}
			else
				$guild_errors[] = $lang['site']['DGM_T_7'];
		}
		else
			$guild_errors[] = $lang['site']['DGM_T_8'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['DGM_T_9'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'deletebyadmin')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['DBA_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['DBA_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
			{
				if($_POST['todo'] == 'save')
				{
					delete_guild($guild->getId());
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['DGM_T_3'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['DBA_T_3'].' <b>'.$guild_name.'</b> '.$lang['site']['DBA_T_4'].'</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >'.$lang['site']['DGM_T_3'].'</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>'.$lang['site']['DBA_T_5'].' <b>'.$guild->getName().'</b>?<br>
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=deletebyadmin" METHOD=post><input type="hidden" name="todo" value="save"><input type="submit" value="Yes, delete"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['DBA_T_6'];
		}
		else
			$guild_errors[] = $lang['site']['DBA_T_7'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['DBA_T_8'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'changemotd')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['CMOTD_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['CMOTD_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_REQUEST['todo'] == 'save')
				{
					$motd = htmlspecialchars(stripslashes(substr(trim($_REQUEST['motd']),0,$config['site']['guild_motd_chars_limit'])));
					$guild->setCustomField('motd', $motd);
					$saved = TRUE;
				}
				$main_content .= '<center><h2>'.$lang['site']['CMOTD_T_3'].'</h2></center>';
				if($saved)
					$main_content .= '<center><font color="red" size="3"><b>'.$lang['site']['CMOTD_T_4'].'</b></font></center><br>';
				$main_content .= ''.$lang['site']['CMOTD_T_5'].'<BR>';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changemotd" method="POST">
				<input type="hidden" name="todo" value="save" />
				    <textarea name="motd" cols="60" rows="3">'.$guild->getCustomField('motd').'</textarea><br>
				    (max. '.$config['site']['guild_motd_chars_limit'].' chars) <input type="submit" value="Save MOTD" /></form><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = $lang['site']['CMOTD_T_6'];
		}
		else
			$guild_errors[] = $lang['site']['CMOTD_T_7'];
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CMOTD_T_8'].'</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'saveranks')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = ''.$lang['site']['GSR_T_1'].' <b>'.$guild_name.'</b> '.$lang['site']['GSR_T_2'].'';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				foreach($rank_list as $rank)
				{
					$rank_id = $rank->getId();
					$name = $_REQUEST[$rank_id.'_name'];
					$level = (int) $_REQUEST[$rank_id.'_level'];
					if(check_rank_name($name))
						$rank->setName($name);
					else
						$ranks_errors[] = ''.$lang['site']['GSR_T_3'].' <b>'.$rank_id.'</b>.';
					if($level > 0 && $level < 4)
						$rank->setLevel($level);
					else
						$ranks_errors[] = ''.$lang['site']['GSR_T_4'].' <b>'.$rank_id.'</b>.';
					$rank->save();
				}
				if(!empty($ranks_errors))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CMOTD_T_8'].'</b><br/>';
					foreach($ranks_errors as $guild_error)
						$main_content .= '<li>'.$guild_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
				}
				else
					header("Location: ?subtopic=guilds&action=manager&guild=".$guild_name);
			}
			else
				$guild_errors[] = $lang['site']['GSR_T_5'];
		}
		else
			$guild_errors[] = $lang['site']['GSR_T_6'];
	}
	if(!empty($guild_errors)) {
	$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CMOTD_T_8'].'</b><br/>';
	foreach($guild_errors as $guild_error) {
		$main_content .= '<li>'.$guild_error;
	}
	$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'cleanup_players')
{
	if($logged)
	{
		if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
		{
			$players_list = new OTS_Players_List();
			$players_list->init();
		}
		else
			$players_list = $account_logged->getPlayersList();
		if(count($players_list) > 0)
		{
			foreach($players_list as $player)
			{
				$player_rank = $player->getRank();
				if(!empty($player_rank))
				{
					if($player_rank->isLoaded())
					{
						$rank_guild = $player_rank->getGuild();
						if(!$rank_guild->isLoaded())
						{
							$player->setRank();
							$player->setGuildNick();
							$player->save();
							$changed_ranks_of[] = $player->getName();
							$deleted_ranks[] = 'ID: '.$player_rank->getId().' - '.$player_rank->getName();
							$player_rank->delete();
						}
					}
					else
					{
						$player->setRank();
						$player->setGuildNick('');
						$player->save();
						$changed_ranks_of[] = $player->getName();
					}
					
				}
			}
			$main_content .= "<b>".$lang['site']['GCP_T_1']."</b>";
			if(!empty($deleted_ranks))
				foreach($deleted_ranks as $rank)
					$main_content .= "<li>".$rank;
			$main_content .= "<BR /><BR /><b>".$lang['site']['GCP_T_2']."</b>";
			if(!empty($changed_ranks_of))
				foreach($changed_ranks_of as $name)
					$main_content .= "<li>".$name;
		}
		else
			$main_content .= $lang['site']['GCP_T_3'];
	}
	else
		$main_content .= $lang['site']['GCP_T_4'];
	$main_content .= "<center><h3><a href=\"?subtopic=guilds\">".$lang['site']['GCP_T_5']."</a></h3></center>";
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'cleanup_guilds')
{
    if($logged)
    {
        $guilds_list = new OTS_Guilds_List();
        $guilds_list->init();
        if(count($guilds_list) > 0)
        {
            foreach($guilds_list as $guild)
            {
                $error = 0;
                $leader = $guild->getOwner();
                if($leader->isLoaded())
                {
                    $leader_rank = $leader->getRank();
                    if(!empty($leader_rank))
                    {
                        if($leader_rank->isLoaded())
                        {
                            $leader_guild = $leader_rank->getGuild();
                            if($leader_guild->isLoaded())
                            {
                                if($leader_guild->getId() != $guild->getId())
                                    $error = 1;
                            }
                            else
                                $error = 1;
                        }
                        else
                            $error = 1;
                    }
                    else
                        $error = 1;
                }
                else
                    $error = 1;
                if($error == 1)
                {
                    $deleted_guilds[] = $guild->getName();
                    $status = delete_guild($guild->getId());
                }
            }
            $main_content .= "<b>".$lang['site']['GCP_T_6']."</b>";
            if(!empty($deleted_guilds))
                foreach($deleted_guilds as $guild)
                    $main_content .= "<li>".$guild;
        }
        else
            $main_content .= $lang['site']['GCP_T_7'];
    }
    else
        $main_content .= $lang['site']['GCP_T_8'];
    $main_content .= "<center><h3><a href=\"?subtopic=guilds\">".$lang['site']['GCP_T_5']."</a></h3></center>";
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
	if($action == 'change_nick')
	{
		if($logged)
		{
			$player_n = stripslashes($_REQUEST['name']);
			$new_nick = stripslashes($_REQUEST['nick']);
			$player = new OTS_Player();
			$player->find($player_n);
			$player_from_account = FALSE;
			if(strlen($new_nick) <= 40)
			{
				if($player->isLoaded())
				{
					$account_players = $account_logged->getPlayersList();
					if(count($account_players))
					{
						foreach($account_players as $acc_player)
						{
							if($acc_player->getId() == $player->getId())
								$player_from_account = TRUE;
						}
						if($player_from_account)
						{
							$player->setGuildNick($new_nick);
							$player->save();
							$main_content .= ''.$lang['site']['GCN_T_1'].' <b>'.$player->getName().'</b> '.$lang['site']['GCN_T_2'].' <b>'.htmlentities($new_nick).'</b>.';
							$addtolink = '&action=show&guild='.$player->getRank()->getGuild()->getId();
						}
						else
							$main_content .= $lang['site']['GCN_T_3'];
					}
					else
						$main_content .= $lang['site']['GCN_T_4'];
				}
				else
					$main_content .= $lang['site']['GCN_T_5'];
			}
			else
				$main_content .= ''.$lang['site']['GCN_T_6'].' '.strlen($new_nick);
		}
			else
				$main_content .= $lang['site']['GCN_T_7'];
		$main_content .= '<center><h3><a href="?subtopic=guilds'.$addtolink.'">'.$lang['site']['GCN_T_8'].'</a></h3></center>';
	}
?>