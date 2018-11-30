<?php
if($action == 'login')
{
	if(check_guild_name($_REQUEST['guild']))
		$guild = $_REQUEST['guild'];
	if($_REQUEST['redirect'] == 'guild' || $_REQUEST['redirect'] == 'guilds')
		$redirect = $_REQUEST['redirect'];
	if(!$logged)
		$main_content .= 'Please enter your account number and your password.<br/><a href="?subtopic=createaccount" >Create an account</a> if you do not have one yet.<br/><br/><form action="?subtopic=guilds&action=login&guild='.$guild.'&redirect='.$redirect.'" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Login</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Account Number:</span></td><td style="width:100%;" ><input type="password" name="account_login" SIZE="10" maxlength="10" ></td></tr><tr><td class="LabelV" ><span >Password:</span></td><td><input type="password" name="password_login" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table width="100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=lostaccount" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Account lost?" alt="Account lost?" src="'.$layout_name.'/images/buttons/_sbutton_accountlost.gif" ></div></div></td></tr></form></table></td></tr></table>';
	else
	{
		$main_content .= '<center><h3>Now you are logged. Redirecting...</h3></center>';
		if($redirect == 'guilds')
			header("Location: ?subtopic=guilds");
		elseif($redirect == 'guild')
			header("Location: ?subtopic=guilds&action=show&guild=".$guild);
		else
			$main_content .= 'Wrong address to redirect!';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show list of guilds
if($action == '')
{
	$guilds_list = $db->query('SELECT `id`, `name`, `description`, `logo` FROM `guilds` WHERE `world_id` = '.(int)$world_id.' ORDER BY `name` ASC;')->fetchAll();
	$main_content .= '<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
	<tr bgcolor='.$config['site']['vdarkborder'].'><td COLSPAN=3 CLASS=white><B>Guilds on '.$world_name.'</B></td></tr>
	<tr bgcolor='.$config['site']['darkborder'].'><td width=64><B>Logo</B></td>
	<td width=100%><B>Description</B></td>
	<td width=56><B>&#160;</B></td></tr>';
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
				
			$main_content .= '<tr bgcolor="'.$bgcolor.'"><td><img src="./guilds/' . $guild['id'] . '.jpg" /></td>
			<td valign="top"><B>'.$guild['name'].'</B><BR/>'.$description.'';
			if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
				$main_content .= '<br /><a href="?subtopic=guilds&action=deletebyadmin&guild='.$guild['id'].'">Delete this guild (for ADMIN only!)</a>';
			$main_content .= '</td><td><TABLE border=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild['id'].'" METHOD=post><tr><td>
			<INPUT TYPE=image NAME="View" ALT="View" SRC="'.$layout_name.'/images/buttons/sbutton_view.gif" border=0 width=120 height=18>
			</td></tr></FORM></table>
			</td></tr>';
		}
	}
	else
		$main_content .= '<tr bgcolor='.$config['site']['lightborder'].'><td><img src="guilds/default.png" width=64 height=64></td>
		<td valign="top"><B>Create guild</B><BR/>Actually there is no guild on server. Create first! Press button "Create Guild".</td>
		<td><TABLE border=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=createguild" METHOD=post><tr><td>
		<INPUT TYPE=image NAME="Create Guild" ALT="Create Guild" SRC="'.$layout_name.'/images/buttons/sbutton_createguild.png" border=0 width=120 height=18>
		</td></tr></FORM></table></td></tr>';
	$main_content .= '</table><br /><br />';
	if($logged)
		$main_content .= '<TABLE border=0 width=100%><tr><td ALIGN=center><img src="'.$layout_name.'/images/general/blank.gif" width=80 height=1 border=0<br /></td><td ALIGN=center><TABLE border=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=createguild" METHOD=post><tr><td>
		<INPUT TYPE=image NAME="Create Guild" ALT="Create Guild" SRC="'.$layout_name.'/images/buttons/sbutton_createguild.png" border=0 width=120 height=18>
		</td></tr></FORM></table></td><td ALIGN=center><img src="'.$layout_name.'/images/general/blank.gif" width=80 height=1 border=0<br /></td></tr></table>
		<BR />If you have any problem with guilds try:
		<BR /><a href="?subtopic=guilds&action=cleanup_players">Cleanup players</a> - can\'t join guild/be invited? Can\'t create guild? Try cleanup players.
		<BR /><a href="?subtopic=guilds&action=cleanup_guilds">Cleanup guilds</a> - made guild, you are a leader, but you are not on players list? Cleanup guilds!';
	else
		$main_content .= 'Before you can create guild you must login.<br /><TABLE border=0 width=100%><tr><td ALIGN=center><img src="'.$layout_name.'/images/general/blank.gif" width=80 height=1 border=0<br /></td><td ALIGN=center><TABLE border=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=login&redirect=guilds" METHOD=post><tr><td>
		<INPUT TYPE=image NAME="Login" ALT="Login" SRC="'.$layout_name.'/images/buttons/sbutton_login.gif" border=0 width=120 height=18>
		</td></tr></FORM></table></td><td ALIGN=center><img src="'.$layout_name.'/images/general/blank.gif" width=80 height=1 border=0<br /></td></tr></table>';
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
################################################################################# 
##                            CONFIGURATION PAGE                               ## 
################################################################################# 
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                  # 
## ---------------------------------------------------------------------------- # 
## Script created by  Kavvson (http://otland.net/members/kavvson/)              # 
## Author & developer:  Kavvson                                                 # 
##                                                                              # 
## Helpers:             Stian       <http://www.otland.net>                     # 
##                      MiPo91      <http://www.otland.net>                     # 
##                      Gesior.pl   <http://www.otland.net>                     # 
################################################################################# 
## +--------------------------Show Guild Page-----------------------------------+ 
## | DONE: v.1.0.0 
## | - Show online | offline (total) members 
## | - Show the total level of members in guild 
## | - Show the average level of members in guild 
## | - Show the highest level in guild 
## | - Show the lowest level in guild 
## | - Skill ranking (all skills,mlvl experience) 
## | - Average level script fix .round(value) 
## | - Show number of invited members 
## | - Show vocations in guild 
## | - Show guild points | Formula [Sum of (Sum levels in guild) +  
## |   Members in guild + Average Level + Minimum Level + Maximum Level] 
## +----------------------------------------------------------------------------+ 
################################################################################# 
        $description = $guild->getCustomField('description'); 
        $newlines   = array("\r\n", "\n", "\r"); 
        $description_with_lines = str_replace($newlines, '<br />', $description, $count); 
        if($count < $config['site']['guild_description_lines_limit']) 
            $description = $description_with_lines; 
        $guild_owner = $guild->getOwner(); 
        if($guild_owner->isLoaded()) 
            $guild_owner = $guild_owner->getName(); 
        $main_content .= ' <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%> 
        <TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=3 CLASS=white><B>Guild Details</B></TD></TR> 
        <TR BGCOLOR='.$config['site']['darkborder'].'> 
        <TD WIDTH=64><IMG SRC="guilds/'.$guild->getId().'.jpg" WIDTH=64 HEIGHT=64></TD> 
        <TD ALIGN=center WIDTH=100%><H1>'.$guild->getName().'</H1></TD> 
         <TD WIDTH=64><IMG SRC="guilds/'.$guild->getId().'.jpg" WIDTH=64 HEIGHT=64></TD> 
        </tr></table> 
        <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%> 
        <TR BGCOLOR='.$config['site']['lightborder'].'> 
        <td width="50px"><small>Description</small></td><td width="80%"><p style="font-size:10px";>'.$description.'</p></td> 
        </tr> 
        <TR BGCOLOR='.$config['site']['darkborder'].'> 
        <td width="50px"><small>Leadership</small></td><td width="80%"><a href="?subtopic=characters&name='.urlencode($guild_owner).'"><b>'.$guild_owner.'</b></a> is guild leader of <b>'.$guild->getName().'</b></td> 
        </tr> 
        <TR BGCOLOR='.$config['site']['lightborder'].'> 
        <td width="50px"><small>Created</small></td><td width="80%">The guild was founded on '.$config['server']['serverName'].' on '.date("j F Y", $guild->getCreationData()).'</td> 
        </tr>         
        '; 
         if($guild_leader){ 
          $main_content .= ' 
          <TR BGCOLOR='.$config['site']['darkborder'].'> 
        <td width="50px"><small>Administration</small></td><td width="80%"><a href="?subtopic=guilds&action=manager&guild='.$guild_name.'"><IMG SRC="'.$layout_name.'/images/buttons/sbutton_manageguild.png" BORDER=0 WIDTH=120 HEIGHT=18 alt="Manage Guild"></a></td> 
        </tr>'; 
        } 
        $main_content .= '</table><BR><BR> 
        <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%> 
        <TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=3 CLASS=white><B>Guild Members</B></TD></TR> 
        <TR BGCOLOR='.$config['site']['darkborder'].'><TD WIDTH=30%><B>Rank</B></TD> 
        <TD WIDTH=50%><B>Name and Title</B></TD> 
         <TD WIDTH=20%><B>Vocation and Level</B></TD> 
        </TR>'; 
        $showed_players = 1; 
        foreach($rank_list as $rank) 
        { 
            $players_with_rank = $rank->getPlayersList(); 
            $players_with_rank->orderBy('name'); 
            $players_with_rank_number = count($players_with_rank); 
            if($players_with_rank_number > 0) 
            { 
                if(is_int($showed_players / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } $showed_players++; 
                $main_content .= '<TR BGCOLOR="'.$bgcolor.'"> 
                <TD valign="top">'.$rank->getName().'</TD> 
                <TD>'; 
                foreach($players_with_rank as $player) 
                { 
                    $main_content .= '<FORM ACTION="?subtopic=guilds&action=change_nick&name='.urlencode($player->getName()).'" METHOD=post><A HREF="?subtopic=characters&name='.urlencode($player->getName()).'">'.($player->isOnline() ? "<font color=\"green\">".$player->getName()."</font>" : "<font color=\"red\">".$player->getName()."</font>").'</A>'; 
                    $guild_nick = $player->getGuildNick(); 
                    if($logged) 
                        if(in_array($player->getId(), $players_from_account_ids)) 
                            $main_content .= ' <br>[<input type="text" size="20%" name="nick" value="'.htmlentities($player->getGuildNick()).'"> <input type="submit" value="Change">]'; 
                        else 
                        if(!empty($guild_nick)) 
                            $main_content .= ' ('.htmlentities($player->getGuildNick()).')'; 
                    else 
                        if(!empty($guild_nick)) 
                            $main_content .= ' ('.htmlentities($player->getGuildNick()).')'; 
                    if($level_in_guild > $rank->getLevel() || $guild_leader) 
                        if($guild_leader_char->getName() != $player->getName()) 
                            $main_content .= '&nbsp;<font size=1>{<a href="?subtopic=guilds&action=kickplayer&guild='.$guild->getId().'&name='.urlencode($player->getName()).'">KICK</a>}</font>'; 
                    $main_content .= '<td><small>Level: '.$player->getLevel().' '.$vocation_name[$player->getWorld()][$player->getPromotion()][$player->getVocation()].'</small></td> 
                    </FORM>'; 
                } 
                $main_content .= '</TD></TR>'; 
            } 
        } 
        $main_content .= '</TABLE><br><br>'; 
################################################################################# 
## +--------------------------------------------------------------------------- 
## | Database queries 
## +--------------------------------------------------------------------------- 
################################################################################# 
        $guild_id = (int)$_GET['guild']; 
        $guildMembers = $SQL->query( 'SELECT COUNT(`gr`.`id`) AS `total` FROM `players` AS `p` LEFT JOIN `guild_ranks` AS `gr` ON `gr`.`id` = `p`.`rank_id` WHERE `gr`.`guild_id` = '.$guild_id )->fetch( );        $allM = $SQL->query ('SELECT COUNT(1) as `people` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') AND online = 1')->fetch();  
        $sumav = $db->query ('SELECT SUM(`level`) as `level_sum`,AVG(`level`) as `level_avg` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.')  ')->fetch();  
        $allM3 = $db->query ('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ORDER BY `level` ASC LIMIT 1')->fetch();  
        $allM4 = $db->query ('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ORDER BY `level` DESC LIMIT 1')->fetch();  
        $invite = $db->query( 'SELECT COUNT(`guild_id`) FROM `guild_invites` WHERE `guild_id` = '.$guild_id.'')->fetch( );      
        $vocations = array(); 
            foreach($db->query('SELECT `vocation`, COUNT(`vocation`) AS `voc_count` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = ' . $guild_id . ') GROUP BY `vocation`')  as $voc) { 
        $vocations[$voc['vocation']] = $voc['voc_count'];       
            } 
        $point = $db->query(' 
        SELECT  
            `g`.`id` AS `id`, 
            `g`.`name` AS `name`, 
            SUM(`p`.`level`) AS `level`, 
            COUNT(`p`.`name`) AS `count`, 
            AVG(`p`.`level`) AS `average`, 
            MIN(`p`.`level`) AS `min`, 
            MAX(`p`.`level`) AS `max` 
        FROM `players` p 
            LEFT JOIN `guild_ranks` gr ON `p`.`rank_id` = `gr`.`id` 
            LEFT JOIN `guilds` g ON `gr`.`guild_id` = `g`.`id` 
        WHERE `guild_id` = '.$guild_id.' 
    ')->fetch(); 
############### 
## Variables ## 
############### 
$off = $guildMembers['total'] - $allM[0]; 
$skills = array(0 => "Fist Fighting", 1 => "Club Fighting", 2 => "Sword Fighting", 3 => "Axe Fighting", 4 => "Distance Fighting", 5 => "Shielding", 6 => "Fishing"); 
$Points = $point['level'] + $point['count'] + round($point['average']) + $point['min'] + $point['max'];      
################################################################################# 
$main_content .= ' 
<table width="100%" cellspacing="1" cellpadding="4" border="0"> 
    <tr bgcolor="#505050"><td class="white" colspan="3"><b>Guild Statistic</b></td></tr> 
    <tr bgcolor="#d4c0a1"><td width="30%"><b>Type</b></td><td width="50%"><b>Value</b></td></tr> 
    <tr bgcolor="#f1e0c6"><td valign="top">Number of Members in Guild</td> 
           <td><font color="green">'.$allM[0].'</font> online | <font color="red">'.$off.'</font> offline ('.$guildMembers['total'].')</td> 
    </tr>     
    <tr bgcolor="#d4c0a1"><td valign="top">Total Level in guild</td>        
        <td>'.$sumav['level_sum'].'</td> 
    </tr> 
    <tr bgcolor="#f1e0c6"><td valign="top">Avg Level in guild</td> 
        <td>'.round($sumav['level_avg']).'</td> 
    </tr> 
    <tr bgcolor="#d4c0a1"><td valign="top">Lowest Level in guild</td> 
           <td>'.$allM3[0].'</td> 
    </tr> 
    <tr bgcolor="#f1e0c6"><td valign="top">Highest Level in guild</td> 
        <td>'.$allM4[0].'</td> 
    </tr> 
    <tr bgcolor="#d4c0a1"><td valign="top">Number of Invited Members</td> 
     <td>'.$invite[0].' 
    </tr> 
        <tr><td valign="center" bgcolor="#f1e0c6">Vocations in guild</td> 
             <td bgcolor="#f1e0c6"> 
                 <table width="100%" cellspacing="1" cellpadding="4" border="0"> 
                    <tr bgcolor="#505050" align="center"><td width="30%" class="white"><b>Vocation</b></td><td width="50%" class="white"><b>Value</b></td></tr> 
                    <tr bgcolor="#f1e0c6"><td valign="top">Druid</td> 
                        <td>'.(int)$vocations[2].'</td> 
                    </tr> 
                    <tr bgcolor="#d4c0a1"><td valign="top">Knight</td> 
                        <td>'.(int)$vocations[4].'</td> 
                    </tr> 
                    <tr bgcolor="#f1e0c6"><td valign="top">Paladin</td> 
                        <td>'.(int)$vocations[3].'</td> 
                    </tr> 
                    <tr bgcolor="#d4c0a1"><td valign="top">Sorcerers</td> 
                        <td>'.(int)$vocations[1].'</td> 
                    </tr> 
                 </table> 
             </td> 
        </tr> 
     <tr bgcolor="#d4c0a1"><td valign="top">Guild points</td> 
       <td>'.$Points.'</td> 
    </tr> 
        <tr><td valign="center" bgcolor="#f1e0c6">Guild Achievements</td> 
             <td bgcolor="#f1e0c6"> 
                 <table width="100%" cellspacing="1" cellpadding="4" border="0"> 
                    <tr bgcolor="#505050" align="center"><td width="30%" class="white"><b>Skill</b></td><td width="50%" class="white"><b>Name (Value)</b></td></tr>'; 
    foreach ($skills as $key => $value) { 
    if(is_int($number / 2)) { $bgcolor = '#f1e0c6'; } else { $bgcolor = '#d4c0a1'; } 
    $number++; 
    $allM5 = $db->query(' 
        SELECT `p`.`name` AS `Name`, 
               `ps`.`value` AS `Sword`,  
               `p`.`maglevel`,  
               `p`.`experience` 
        FROM `players` AS `p` 
        JOIN `player_skills` AS `ps` 
        WHERE `ps`.`player_id` = `p`.`id` 
        AND `ps`.`skillid` = ' . $key . ' 
        AND `rank_id` 
        IN(SELECT `id` FROM `guild_ranks` WHERE `guild_id` = ' . $guild_id . ') ORDER BY `Sword` DESC Limit 1 ')->fetch(); 
         $main_content .= ' 
         <tr BGCOLOR='.$bgcolor.'> 
         <td valign="top"><img style="border:medium none;width:20px;" src="/images/skills/'.$key.'.png">  '.$value.'</td> 
         <td valign="top">   '.$allM5[0].'  ('.$allM5[1].')</td> 
        </tr>'; 
        } 
    $main_content .=' 
        <tr BGCOLOR="#d4c0a1"> 
         <td valign="top"><img style="border:medium none;width:20px;" src="/images/skills/7.png">  Experience</td> 
         <td valign="top">'.$allM5[0].' ('.$allM5[3].')</td> 
        </tr> 
        <tr BGCOLOR="#f1e0c6"> 
         <td valign="top"><img style="border:medium none;width:20px;" src="/images/skills/8.png">  Magic Level</td> 
         <td valign="top">'.$allM5[0].' ('.$allM5[2].')</td> 
        </tr> 
    </table> 
             </td> 
        </tr> 
    </tr>        
</table>'; 
///Don't delete this! Please respect my work! I am counting on reputation. 
$main_content .= '<div align="right"><small><b>Author of script: <a href="http://otland.net/members/kavvson/">Kavvson</a></b></small></div>'; 
///Don't delete this! Please respect my work! I am counting on reputation. 
        include('pot/InvitesDriver.php');  

//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//change rank of player in guild
if($action == 'changerank')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(!$logged)
		$guild_errors[] = 'You are not logged in. You can\'t change rank.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(!empty($guild_errors))
	{
		//show errors
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		//errors and back button
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
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
				$change_errors[] = 'Invalid player name format.';
			$rank = $ots->createObject('GuildRank');
			$rank->load($new_rank);
			if(!$rank->isLoaded())
				$change_errors[] = 'Rank with this ID doesn\'t exist.';
			if($level_in_guild <= $rank->getLevel() && !$guild_leader)
				$change_errors[] = 'You can\'t set ranks with equal or higher level than your.';
			if(empty($change_errors))
			{
				$player_to_change = $ots->createObject('Player');
				$player_to_change->find($player_name);
				if(!$player_to_change->isLoaded())
					$change_errors[] = 'Player with name '.$player_name.'</b> doesn\'t exist.';
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
				$change_errors[] = 'This player isn\'t in your guild.';
				if(!$rank_in_guild)
					$change_errors[] = 'This rank isn\'t in your guild.';
				if(!$player_has_lower_rank)
					$change_errors[] = 'This player has higher rank in guild than you. You can\'t change his/her rank.';
			}
			if(empty($change_errors))
			{
				$player_to_change->setRank($rank);
				$player_to_change->save();
				$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Rank of player <b>'.$player_to_change->getName().'</b> has been changed to <b>'.$rank->getName().'</b>.</td></tr>          </table>        </div>  </table></div></td></tr><br />';
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
				$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
				foreach($change_errors as $change_error)
					$main_content .= '<li>'.$change_error;
				$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
			}
		}
		$main_content .= '<FORM ACTION="?subtopic=guilds&action=changerank&guild='.$guild_name.'&todo=save" METHOD=post>
		<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%>
		<tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Change Rank</B></td></tr>
		<tr bgcolor='.$config['site']['darkborder'].'><td>Name: <SELECT NAME="name">';
		foreach($players_with_lower_rank as $player_to_list)
			$main_content .= '<OPTION value="'.$player_to_list['0'].'">'.$player_to_list['1'];
		$main_content .= '</SELECT>&nbsp;Rank:&nbsp;<SELECT NAME="rankid">';
		foreach($ranks as $rank)
			$main_content .= '<OPTION value="'.$rank['0'].'">'.$rank['1'];
		$main_content .= '</SELECT>&nbsp;&nbsp;&nbsp;<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18></td><tr>
		</table></FORM><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
	}
	else
		$main_content .= 'Error. You are not a leader or vice leader in guild '.$guild->getName().'.<FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></FORM>';
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
		$guild_errors[] = 'You are not logged in. You can\'t delete invitations.';
	if(!check_name($name))
		$guild_errors[] = 'Invalid name format.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
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
			$guild_errors[] = 'Player with name <b>'.$name.'</b> doesn\'t exist.';
	}
	if(!$guild_vice)
		$guild_errors[] = 'You are not a leader or vice leader of guild <b>'.$guild_name.'</b>.';
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
				$guild_errors[] = '<b>'.$player->getName().'</b> isn\'t invited to your guild.';
		}
		else
			$guild_errors[] = 'No one is invited to your guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
	}
	else
	{
		if($_REQUEST['todo'] == 'save')
		{
			$guild->deleteInvite($player);
			$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Delete player invitation</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Player with name <b>'.$player->getName().'</b> has been deleted from "invites list".</td></tr></table><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
		}
		else
			$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Delete player invitation</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Are you sure you want to delete player with name <b>'.$player->getName().'</b> from "invites list"?</td></tr></table><br/><center><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><tr><FORM ACTION="?subtopic=guilds&action=deleteinvite&guild='.$guild_name.'&name='.$player->getName().'&todo=save" METHOD=post><td align="right" width="50%"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18>&nbsp;&nbsp;</td></FORM><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><td>&nbsp;&nbsp;<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></td></tr></FORM></table></center>';
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
		$guild_errors[] = 'You are not logged in. You can\'t invite players.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
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
		$guild_errors[] = 'You are not a leader or vice leader of guild <b>'.$guild_name.'</b>.'.$level_in_guild;
	if($_REQUEST['todo'] == 'save')
	{
		if(!check_name($name))
			$guild_errors[] = 'Invalid name format.';
		if(empty($guild_errors))
		{
			$player = new OTS_Player();
			$player->find($name);
			if(!$player->isLoaded())
				$guild_errors[] = 'Player with name <b>'.$name.'</b> doesn\'t exist.';
			else
			{
				$rank_of_player = $player->getRank();
				if(!empty($rank_of_player))
					$guild_errors[] = 'Player with name <b>'.$name.'</b> is already in guild. He must leave guild before you can invite him.';
			}
		}
		if(empty($guild_errors) && $guild->getWorld() != $player->getWorld())
			$guild_errors[] = '<b>'.$player->getName().'</b> is from other world then your guild.';
		if(empty($guild_errors))
		{
			include('pot/InvitesDriver.php');
			new InvitesDriver($guild);
			$invited_list = $guild->listInvites();
			if(count($invited_list) > 0)
				foreach($invited_list as $invited)
					if($invited->getName() == $player->getName())
						$guild_errors[] = '<b>'.$player->getName().'</b> is already invited to your guild.';
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
	}
	else
		if($_REQUEST['todo'] == 'save')
		{
			$guild->invite($player);
			$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Invite player</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Player with name <b>'.$player->getName().'</b> has been invited to your guild.</td></tr></table><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
		}
		else
			$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Invite player</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%><FORM ACTION="?subtopic=guilds&action=invite&guild='.$guild_name.'&todo=save" METHOD=post>Invite player with name:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name">&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18></FORM></td></td></tr></tr></table><br/><center><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><tr><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><td><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></td></tr></FORM></table></center>';
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
	$guild_errors[] = 'You are not logged in. You can\'t accept invitations.';
if(empty($guild_errors))
{
	$guild = $ots->createObject('Guild');
	$guild->load($guild_name);
	if(!$guild->isLoaded())
		$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
}

if($_REQUEST['todo'] == 'save') {
if(!check_name($name))
	$guild_errors[] = 'Invalid name format.';
if(empty($guild_errors)) {
$player = new OTS_Player();
$player->find($name);
if(!$player->isLoaded()) {
$guild_errors[] = 'Player with name <b>'.$name.'</b> doesn\'t exist.';
}
else
{
$rank_of_player = $player->getRank();
if(!empty($rank_of_player)) {
$guild_errors[] = 'Character with name <b>'.$name.'</b> is already in guild. You must leave guild before you join other guild.';
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
$guild_errors[] = 'Character '.$player->getName.' isn\'t invited to guild <b>'.$guild->getName().'</b>.';
}
}
}
else
{
//co jesli nei save
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
$guild_errors[] = 'Any character from your account isn\'t invited to <b>'.$guild->getName().'</b>.';
}
}
if(!empty($guild_errors)) {
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
foreach($guild_errors as $guild_error) {
	$main_content .= '<li>'.$guild_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
}
else
{
if($_REQUEST['todo'] == 'save') {
$guild->acceptInvite($player);
$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Accept invitation</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Player with name <b>'.$player->getName().'</b> has been added to guild <b>'.$guild->getName().'</b>.</td></tr></table><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
}
else
{
$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Accept invitation</B></td></tr>';
$main_content .= '<tr bgcolor='.$config['site']['lightborder'].'><td width=100%>Select character to join guild:</td></tr>';
$main_content .= '<tr bgcolor='.$config['site']['darkborder'].'><td>
<form action="?subtopic=guilds&action=acceptinvite&guild='.$guild_name.'&todo=save" METHOD="post">';
sort($list_of_invited_players);
foreach($list_of_invited_players as $invited_player_from_list) {
$main_content .= '<input type="radio" name="name" value="'.$invited_player_from_list.'" />'.$invited_player_from_list.'<br />';
}
$main_content .= '<br /><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18></form></td></tr></table><br/><center><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><tr><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><td><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></td></tr></FORM></table></center>';
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
	$guild_errors[] = 'You are not logged in. You can\'t kick characters.';
if(!check_name($name))
	$guild_errors[] = 'Invalid name format.';
if(empty($guild_errors))
{
	$guild = $ots->createObject('Guild');
	$guild->load($guild_name);
	if(!$guild->isLoaded())
		$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
$guild_errors[] = 'You are not a leader of guild <b>'.$guild_name.'</b>. You can\'t kick players.';
}
}
if(empty($guild_errors)) {
$player = new OTS_Player();
$player->find($name);
if(!$player->isLoaded()) {
$guild_errors[] = 'Character <b>'.$name.'</b> doesn\'t exist.';
}
else
{
if($player->getRank()->getGuild()->getName() != $guild->getName()) {
$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t from your guild.';
}
}
}
if(empty($guild_errors)) {
if($player->getRank()->getLevel() >= $level_in_guild && !$guild_leader) {
$guild_errors[] = 'You can\'t kick character <b>'.$name.'</b>. Too high access level.';
}
}
if(empty($guild_errors)) {
if($guild->getOwner()->getName() == $player->getName()) {
$guild_errors[] = 'It\'s not possible to kick guild owner!';
}
}
if(!empty($guild_errors)) {
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
foreach($guild_errors as $guild_error) {
	$main_content .= '<li>'.$guild_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
}
else
	if($_REQUEST['todo'] == 'save')
	{
		$player->setRank();
		$player->save();
		$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Kick player</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Player with name <b>'.$player->getName().'</b> has been kicked from your guild.</td></tr></table><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
	}
	else
		$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Kick player</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Are you sure you want to kick player with name <b>'.$player->getName().'</b> from your guild?</td></tr></table><br/><center><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><tr><FORM ACTION="?subtopic=guilds&action=kickplayer&guild='.$guild_name.'&name='.$player->getName().'&todo=save" METHOD=post><td align="right" width="50%"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18>&nbsp;&nbsp;</td></FORM><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><td>&nbsp;&nbsp;<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></td></tr></FORM></table></center>';
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
		$guild_errors[] = 'You are not logged in. You can\'t leave guild.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}

	if(empty($guild_errors))
	{
		$guild_owner_id = $guild->getOwner()->getId();
		if($_REQUEST['todo'] == 'save')
		{
			if(!check_name($name))
				$guild_errors[] = 'Invalid name format.';
			if(empty($guild_errors))
			{
				$player = new OTS_Player();
				$player->find($name);
				if(!$player->isLoaded())
					$guild_errors[] = 'Character <b>'.$name.'</b> doesn\'t exist.';
				else
					if($player->getAccount()->getId() != $account_logged->getId())
						$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t from your account!';
			}
			if(empty($guild_errors))
			{
				$player_loaded_rank = $player->getRank();
				if(!empty($player_loaded_rank) && $player_loaded_rank->isLoaded())
				{
					if($player_loaded_rank->getGuild()->getId() != $guild->getId())
						$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t from guild <b>'.$guild->getName().'</b>.';
				}
				else
					$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t in any guild.';
			}
			if(empty($guild_errors))
				if($guild_owner_id == $player->getId())
					$guild_errors[] = 'You can\'t leave guild. You are an owner of guild.';
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
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
	}
	else
	{
		if($_REQUEST['todo'] == 'save')
		{
			$player->setRank();
			$player->save();
			$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Leave guild</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%>Player with name <b>'.$player->getName().'</b> leaved guild <b>'.$guild->getName().'</b>.</td></tr></table><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
		}
		else
		{
			$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Leave guild</B></td></tr>';
			if(count($array_of_player_ig) > 0)
			{
				$main_content .= '<tr bgcolor='.$config['site']['lightborder'].'><td width=100%>Select character to leave guild:</td></tr>';
				$main_content .= '<tr bgcolor='.$config['site']['darkborder'].'><td>
				<form action="?subtopic=guilds&action=leaveguild&guild='.$guild_name.'&todo=save" METHOD="post">';
				sort($array_of_player_ig);
				foreach($array_of_player_ig as $player_to_leave)
					$main_content .= '<input type="radio" name="name" value="'.$player_to_leave.'" />'.$player_to_leave.'<br />';
				$main_content .= '</td></tr><br /></table>';
			}
			else
				$main_content .= '<tr bgcolor='.$config['site']['lightborder'].'><td width=100%>Any of your characters can\'t leave guild.</td></tr>';
			$main_content .= '<TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><tr>';
			if(count($array_of_player_ig) > 0)
				$main_content .= '<td width="130" valign="top"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18></form></td>';
			$main_content .= '<td><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18></FORM></td></tr></table>';
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
		$guild_errors[] = 'You are not logged in. You can\'t create guild.';
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
		$guild_errors[] = 'On your account all characters are in guilds or have too low level to create new guild.';
	if($todo == 'save')
	{
		if(!check_guild_name($guild_name))
		{
			$guild_errors[] = 'Invalid guild name format.';
			$guild_name = '';
		}
		if(!check_name($name))
		{
			$guild_errors[] = 'Invalid character name format.';
			$name = '';
		}
		if(empty($guild_errors))
		{
			$player = $ots->createObject('Player');
			$player->find($name);
			if(!$player->isLoaded())
				$guild_errors[] = 'Character <b>'.$name.'</b> doesn\'t exist.';
		}
		if(empty($guild_errors))
		{
			$guild = $ots->createObject('Guild');
			$guild->find($guild_name);
			if($guild->isLoaded())
				$guild_errors[] = 'Guild <b>'.$guild_name.'</b> already exist. Select other name.';
		}
		if(empty($guild_errors))
		{
			$bad_char = TRUE;
			foreach($array_of_player_nig as $nick_from_list)
				if($nick_from_list == $player->getName())
					$bad_char = FALSE;
			if($bad_char)
				$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t on your account or is already in guild.';
		}
		if(empty($guild_errors))
		{
			if($player->getLevel() < $config['site']['guild_need_level'])
				$guild_errors[] = 'Character <b>'.$name.'</b> has too low level. To create guild you need character with level <b>'.$config['site']['guild_need_level'].'</b>.';
			if($config['site']['guild_need_pacc'] && !$account_logged->isPremium())
				$guild_errors[] = 'Character <b>'.$name.'</b> is on FREE account. To create guild you need PREMIUM account.';
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
		unset($todo);
	}

	if($todo == 'save')
	{
		$new_guild = new OTS_Guild();
		$new_guild->setCreationData($time);
		$new_guild->setName($guild_name);
		$new_guild->setOwner($player);
		$new_guild->save();
		$new_guild->setCustomField('description', 'New guild. Leader must edit this text :)');
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
		$main_content .= '<TABLE border=0 CELLSPACING=1 CELLPADDING=4 width=100%><tr bgcolor='.$config['site']['vdarkborder'].'><td CLASS=white><B>Create guild</B></td></tr><tr bgcolor='.$config['site']['darkborder'].'><td width=100%><b>Congratulations!</b><br/>You have created guild <b>'.$guild_name.'</b>. <b>'.$player->getName().'</b> is leader of this guild. Now you can invite players, change picture, description and motd of guild. Press submit to open guild manager.</td></tr></table><br/><TABLE border=0 CELLSPACING=0 CELLPADDING=0 width=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$new_guild->getId().'" METHOD=post><tr><td><center><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_Submit.gif" border=0 width=120 height=18></center></td></tr></FORM></table>';
	}
	else
	{
		$main_content .= 'To play on '.$config['server']['serverName'].' you need an account. 
		All you have to do to create your new account is to enter your email address, password to new account, verification code from picture and to agree to the terms presented below. 
		If you have done so, your account number, password and e-mail address will be shown on the following page and your account and password will be sent 
		to your email address along with further instructions.<br /><br />
		<FORM ACTION="?subtopic=guilds&action=createguild&todo=save" METHOD=post>
		<TABLE width=100% border=0 CELLSPACING=1 CELLPADDING=4>
		<tr><td bgcolor="'.$config['site']['vdarkborder'].'" CLASS=white><B>Create a '.$config['server']['serverName'].' Account</B></td></tr>
		<tr><td bgcolor="'.$config['site']['darkborder'].'"><TABLE border=0 CELLSPACING=8 CELLPADDING=0>
		  <tr><td>
		    <TABLE border=0 CELLSPACING=5 CELLPADDING=0>';
		$main_content .= '<tr><td width="150" valign="top"><B>Leader: </B></td><td><SELECT name=\'name\'>';
		if(count($array_of_player_nig) > 0)
		{
			sort($array_of_player_nig);
			foreach($array_of_player_nig as $nick)
				$main_content .= '<OPTION>'.$nick.'</OPTION>';
		}
		$main_content .= '</SELECT><br /><font size="1" face="verdana,arial,helvetica">(Name of leader of new guild.)</font></td></tr>
			<tr><td width="150" valign="top"><B>Guild name: </B></td><td><INPUT NAME="guild" VALUE="" SIZE=30 MAXLENGTH=50><br /><font size="1" face="verdana,arial,helvetica">(Here write name of your new guild.)</font></td></tr>
			</table>
		  </td></tr>
		</table></td></tr>
		</table>
		<br />
		<TABLE border=0 width=100%>
		  <tr><td ALIGN=center>
		    <img src="'.$layout_name.'/images/general/blank.gif" width=120 height=1 border=0><br />
		  </td><td ALIGN=center VALIGN=top>
		    <INPUT TYPE=image NAME="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" border=0 width=120 height=18>
		    </FORM>
		  </td><td ALIGN=center>
		    <FORM  ACTION="?subtopic=guilds" METHOD=post>
		    <INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" border=0 width=120 height=18>
		    </FORM>
		  </td><td ALIGN=center>
		    <img src="/images/general/blank.gif" width=120 height=1 border=0><br />
		  </td></tr>
		</table>
		</td>
		<td><img src="'.$layout_name.'/images/general/blank.gif" width=10 height=1 border=0></td>
		</tr>
		</table>';
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
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
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
				$main_content .= '<center><h2>Welcome to guild manager!</h2></center>Here you can change names of ranks, delete and add ranks, pass leadership to other guild member and delete guild.';
				$main_content .= '<br/><br/><table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'>
				<tr bgcolor='.$config['site']['darkborder'].'><td width="170"><font color="red"><b>Option</b></font></td><td><font color="red"><b>Description</b></font></td></tr>
				<tr bgcolor='.$config['site']['lightborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=passleadership">Pass Leadership</a></b></td><td><b>Pass leadership of guild to other guild member.</b></td></tr>
				<tr bgcolor='.$config['site']['darkborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=deleteguild">Delete Guild</a></b></td><td><b>Delete guild, kick all members.</b></td></tr>
				<tr bgcolor='.$config['site']['lightborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changedescription">Change Description</a></b></td><td><b>Change description of guild.</b></td></tr>
				<tr bgcolor='.$config['site']['darkborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changemotd">Change MOTD</a></b></td><td><b>Change MOTD of guild.</b></td></tr>
				<tr bgcolor='.$config['site']['lightborder'].'><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changelogo">Change guild logo</a></b></td><td><b>Upload new guild logo.</b></td></tr>
				</table>';
				$main_content .= '<br /><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Add new rank</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td width="120" valign="top">New rank name:</td><td> <form action="?subtopic=guilds&guild='.$guild_name.'&action=addrank" method="POST"><input type="text" name="rank_name" size="20"><input type="submit" value="Add"></form></td></tr>          </table>        </div>  </table></div></td></tr>';
				$main_content .= '<center><h3>Change rank names and levels</h3></center><form action="?subtopic=guilds&action=saveranks&guild='.$guild_name.'" method=POST><table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'><tr bgcolor='.$config['site']['vdarkborder'].'><td rowspan="2" width="120" align="center"><font color="white"><b>Delete Rank</b></font></td><td rowspan="2" width="300"><font color="white"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</b></font></td><td colspan="3" align="center"><font color="white"><b>Level of RANK in guild</b></font></td></tr><tr bgcolor='.$config['site']['vdarkborder'].'><td align="center" bgcolor="red"><font color="white"><b>Leader (3)</b></font></td><td align="center" bgcolor="yellow"><font color="black"><b>Vice (2)</b></font></td><td align="center" bgcolor="green"><font color="white"><b>Member (1)</b></font></td></tr>';
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
				$main_content .= '<h3>Ranks info:</h3><b>0. Owner of guild</b> - it\'s highest rank, only one player in guild may has this rank. Player with this rank can:
				<li>Invite/Cancel Invitation/Kick Player from guild
				<li>Change ranks of all players in guild
				<li>Delete guild or pass leadership to other guild member
				<li>Change names, levels(leader,vice,member), add and delete ranks
				<li>Change MOTD, logo and description of guild<hr>
				<b>3. Leader</b> - it\'s second rank in guild. Player with this rank can:
				<li>Invite/Cancel Invitation/Kick Player from guild (only with lower rank than his)
				<li>Change ranks of players with lower rank level ("vice leader", "member") in guild<hr>
				<b>2. Vice Leader</b> - it\'s third rank in guild. Player with this rank can:
				<li>Invite/Cancel Invitation
				<li>Change ranks of players with lower rank level ("member") in guild<hr>
				<b>1. Member</b> - it\'s lowest rank in guild. Player with this rank can:
				<li>Be a member of guild';
				$main_content .= '<br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
						$upload_errors[] = 'Uploaded image is too big. Size: <b>'.$file['size'].' bytes</b>, Max. size: <b>'.$max_image_size_b.' bytes</b>.';
							
					$type = strtolower($file['type']);
					if(!in_array($type, $allowed_ext))
						$upload_errors[] = 'Your file type isn\' allowed. Allowed: <b>gif, jpg, bmp, png</b>. Your file type: <b>'.$type.'</b> If it\'s image contact with admin.';
							
					if(!empty($upload_errors))
					{
						$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
						foreach($upload_errors as $guild_error)
							$main_content .= '<li>'.$guild_error;
						$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
					}
					else
						$db->query("UPDATE `guilds` SET `logo` = '" . addslashes(fread(fopen($file['tmp_name'], "rb"), $file['size'])) . "' WHERE `id` = " . $guild->getId() . ";");
				}
				$main_content .= '<center><h2>Change guild logo</h2></center>Here you can change logo of your guild.<br />Actuall logo: <img src="./guilds/' . $guild->getId() . '.jpg" /><br /><br />';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changelogo" method="POST">
				<input type="hidden" name="todo" value="save" />
				<input type="hidden" name="MAX_FILE_SIZE" value="'.$max_image_size_b.'" />
				    Select new logo: <input name="newlogo" type="file" />
				    <input type="submit" value="Send new logo" /></form>Only <b>jpg, gif, png, bmp</b> pictures. Max. size: <b>'.$config['site']['guild_image_size_kb'].' KB</b><br />';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
					$guild_errors2[] = 'Rank with ID '.$rank_to_delete.' doesn\'t exist.';
				else
				{
					if($rank->getGuild()->getId() != $guild->getId())
						$guild_errors2[] = 'Rank with ID '.$rank_to_delete.' isn\'t from your guild.';
					else
					{
						if(count($rank_list) < 2)
							$guild_errors2[] = 'You have only 1 rank in your guild. You can\'t delete this rank.';
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
									$new_rank->setName('New Rank level '.$rank->getLevel());
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
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Rank Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Rank <b>'.$rank->getName().'</b> has been deleted. Players with this rank has now other rank.</td></tr>          </table>        </div>  </table></div></td></tr>';
				else
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($guild_errors2 as $guild_error) 
						$main_content .= '<li>'.$guild_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
				}
				//back button
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Invalid rank name format.';
		if(!$logged)
			$guild_errors[] = 'You are not logged.';
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
				$main_content .= 'New rank added. Redirecting...';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		if(!empty($guild_errors))
		{
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
			foreach($guild_errors as $guild_error)
				$main_content .= '<li>'.$guild_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
			$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=show" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
	}
	else
		if(!empty($guild_errors))
		{
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
			foreach($guild_errors as $guild_error)
				$main_content .= '<li>'.$guild_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
				$main_content .= '<center><h2>Change guild description</h2></center>';
				if($saved)
					$main_content .= '<center><font color="red" size="3"><b>CHANGES HAS BEEN SAVED!</b></font></center><br />';
				$main_content .= 'Here you can change description of your guild.<br />';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changedescription" method="POST">
				<input type="hidden" name="todo" value="save" />
				    <textarea name="description" cols="60" rows="'.bcsub($config['site']['guild_description_lines_limit'],1).'">'.$guild->getCustomField('description').'</textarea><br />
				    (max. '.$config['site']['guild_description_lines_limit'].' lines, max. '.$config['site']['guild_description_chars_limit'].' chars) <input type="submit" value="Save description" /></form><br />';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
		$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($_POST['todo'] == 'save')
		{
			if(!check_name($pass_to))
				$guild_errors2[] = 'Invalid player name format.';
			if(empty($guild_errors2))
			{
				$to_player = new OTS_Player();
				$to_player->find($pass_to);
				if(!$to_player->isLoaded())
					$guild_errors2[] = 'Player with name <b>'.$pass_to.'</b> doesn\'t exist.';
				if(empty($guild_errors2))
				{
					$to_player_rank = $to_player->getRank();
					if(!empty($to_player_rank))
					{
						$to_player_guild = $to_player_rank->getGuild();
						if($to_player_guild->getId() != $guild->getId())
							$guild_errors2[] = 'Player with name <b>'.$to_player->getName().'</b> isn\'t from your guild.';
					}
					else
						$guild_errors2[] = 'Player with name <b>'.$to_player->getName().'</b> isn\'t from your guild.';
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
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td><b>'.$to_player->getName().'</b> is now a Leader of <b>'.$guild->getName().'</b>.</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=show" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Pass leadership to: </b><br />
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=passleadership" METHOD=post><input type="hidden" name="todo" value="save"><input type="text" size="40" name="player"><input type="submit" value="Save"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(empty($guild_errors) && !empty($guild_errors2))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors2 as $guild_error2)
			$main_content .= '<li>'.$guild_error2;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
		$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=passleadership" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		if(!empty($guild_errors2))
			foreach($guild_errors2 as $guild_error2)
				$main_content .= '<li>'.$guild_error2;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br /><br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
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
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
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
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Guild with name <b>'.$guild_name.'</b> has been deleted.</td></tr>          </table>        </div>  </table></div></td></tr>';
					$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
				{
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Are you sure you want delete guild <b>'.$guild_name.'</b>?<br />
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=deleteguild" METHOD=post><input type="hidden" name="todo" value="save"><input type="submit" value="Yes, delete"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr>';
					$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Guild with ID <b>'.$guild_name.'</b> has been deleted.</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionborderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionborderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Are you sure you want delete guild <b>'.$guild->getName().'</b>?<br />
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=deletebyadmin" METHOD=post><input type="hidden" name="todo" value="save"><input type="submit" value="Yes, delete"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not an admin!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t delete guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
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
				$main_content .= '<center><h2>Change guild MOTD</h2></center>';
				if($saved)
					$main_content .= '<center><font color="red" size="3"><b>CHANGES HAS BEEN SAVED!</b></font></center><br />';
				$main_content .= 'Here you can change MOTD (Message of the Day, showed in game!) of your guild.<br />';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changemotd" method="POST">
				<input type="hidden" name="todo" value="save" />
				    <textarea name="motd" cols="60" rows="3">'.$guild->getCustomField('motd').'</textarea><br />
				    (max. '.$config['site']['guild_motd_chars_limit'].' chars) <input type="submit" value="Save MOTD" /></form><br />';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
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
						$ranks_errors[] = 'Invalid rank name. Please use only a-Z, 0-9 and spaces. Rank ID <b>'.$rank_id.'</b>.';
					if($level > 0 && $level < 4)
						$rank->setLevel($level);
					else
						$ranks_errors[] = 'Invalid rank level. Contact with admin. Rank ID <b>'.$rank_id.'</b>.';
					$rank->save();
				}
				if(!empty($ranks_errors))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($ranks_errors as $guild_error)
						$main_content .= '<li>'.$guild_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
				}
				else
					header("Location: ?subtopic=guilds&action=manager&guild=".$guild_name);
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors)) {
	$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
	foreach($guild_errors as $guild_error) {
		$main_content .= '<li>'.$guild_error;
	}
	$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br />';
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
			$main_content .= "<b>Deleted ranks (this ranks guilds doesn't exist [bug fix]):</b>";
			if(!empty($deleted_ranks))
				foreach($deleted_ranks as $rank)
					$main_content .= "<li>".$rank;
			$main_content .= "<BR /><BR /><b>Changed ranks of players (rank or guild of rank doesn't exist [bug fix]):</b>";
			if(!empty($changed_ranks_of))
				foreach($changed_ranks_of as $name)
					$main_content .= "<li>".$name;
		}
		else
			$main_content .= "0 players found.";
	}
	else
		$main_content .= "You are not logged in.";
	$main_content .= "<center><h3><a href=\"?subtopic=guilds\">BACK</a></h3></center>";
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
            $main_content .= "<b>Deleted guilds (leaders of this guilds are not members of this guild [fix bugged guilds]):</b>";
            if(!empty($deleted_guilds))
                foreach($deleted_guilds as $guild)
                    $main_content .= "<li>".$guild;
        }
        else
            $main_content .= "0 guilds found.";
    }
    else
        $main_content .= "You are not logged in.";
    $main_content .= "<center><h3><a href=\"?subtopic=guilds\">BACK</a></h3></center>";
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
							$main_content .= 'Guild nick of player <b>'.$player->getName().'</b> changed to <b>'.htmlentities($new_nick).'</b>.';
							$addtolink = '&action=show&guild='.$player->getRank()->getGuild()->getId();
						}
						else
							$main_content .= 'This player is not from your account.';
					}
					else
						$main_content .= 'This player is not from your account.';
				}
				else
					$main_content .= 'Unknow error occured.';
			}
			else
				$main_content .= 'Too long guild nick. Max. 30 chars, your: '.strlen($new_nick);
		}
			else
				$main_content .= 'You are not logged.';
		$main_content .= '<center><h3><a href="?subtopic=guilds'.$addtolink.'">BACK</a></h3></center>';
	}
?>