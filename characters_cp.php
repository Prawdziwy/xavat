<?php
$main_content .= '
<script type="text/javascript">
	$(function(){$("#tabs").tabs();});
</script>';
?>

<?php
$main_content .= '
<script type="text/javascript">
	$(function() {
		$( "input:submit, button", "#tabs" ).button();
	});
</script>';
?>

<?php
	$name = stripslashes(ucwords(strtolower(trim($_REQUEST['name']))));
	$info = array
	(
		0 => 'The level of a character is perhaps the single most important  characteristic. As a rule, characters grow in power whenever their  level increases, so the level is a good indicator of a character\'s  overall strength. To advance in level characters must collect experience  points. Whenever they have amassed enough points they will advance to  the next level automatically.',
		1 => 'The magic level is similar to regular weapon skills in that  it directly influences the power of a character\'s spells. Thus, a druid  with a high magic level will restore more hit points when casting a  healing spell than a druid of comparable experience who has a lower  magic level. This way it is even possible for a low-level spellcaster to  cast spells that are more powerful than those of some high-level  characters.',
		2 => 'This skill determines your character\'s ability to fight with  bare hands. Needless to say, characters do not cause much damage when  fighting unarmed, even if they have a considerable fist fighting  skill.',
		3 => 'This is a weapon skill. It covers blunt weapons such as clubs, maces, staffs and hammers.',
		4 => 'Another weapon skill. This skill is needed to use any kind of  edged weapons, from puny knives to mighty giant swords.',
		5 => 'Similar to other weapon skills, your character will need the  corresponding skill to successfully wield any kinds of axe, from  hatchets to the legendary Stonecutter Axe. Also, this skill covers pole  weapons such as halberds and lances.',
		6 => 'This weapon skill covers all distance weapons. This includes  thrown weapons such as stones and spears as well as bows and  crossbows.',
		7 => 'Shielding is the ability to successfully block enemy attacks  with a shield. Of course, characters need to hold shields in their hands  in order to use this skill. Note that it is not possible to block more  than 2 opponents at a time.',
		8 => 'Fishing differs from other skills in that you must actively  use it every single time you try to catch a fish. To use this skill  characters need a fishing rod and some worms in their inventory. Worms  can be found in some monsters or can be bought at shops that also sell  fishing rods. Equipped with the fishing gear, you will have to find a  place close to a river or some other body of water that contains fish.  Once you have found a suitable place all you need to do is to use  the  fishing rod on the water. Do not worry if you do not catch a fish  immediately - your chance to catch one will increase with your fishing  skill.'
	);

	if(empty($name))
	{
		$main_content .= 'Here you can get detailed information about a certain player on '.$config['server']['serverName'].'.<BR>  <FORM ACTION="?subtopic=characters" METHOD=post><table border="0" cellpadding="4" cellspacing="1" width="100%"><tr><TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>Search Character</B></td></tr><tr><TD BGCOLOR="'.$config['site']['darkborder'].'"><TABLE BORDER=0 CELLPADDING=1><tr><td>Name:</td><td><INPUT NAME="name" VALUE=""SIZE=29 MAXLENGTH=29></td><td><INPUT TYPE=image NAME="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></td></tr></TABLE></td></tr></TABLE></FORM>';
	}
	else
	{
		if(check_name($name))
		{
			$main_content .= '
			<div id="tabs">
				<ul>
					<li><a href="#characters">Main</a></li>
					<li><a href="#statistics">Statistics</a></li>
				</ul>
				<div id="characters">';
					$player = new OTS_Player();
					$player->find($name);
					if($player->isLoaded())
					{
						$account = $player->getAccount();
						$cc = strtolower(geoip_country_code_by_name(revertIp(long2ip($player->getLastIP()))));
						if(empty($cc))
							$cc = "unknown";
								
						$main_content .= '
						<table border="0" cellpadding="4" cellspacing="1" width="100%" style="border:1px dotted #B5B5B5;">
							<tr>
								<td width="30%" style="border:1px dotted #B5B5B5;">Name</td>
								<td style="color: ' . ($player->isOnline() ? "green" : "red") . ';font-weight: bold; border:1px dotted #B5B5B5;"><img src="./images/flags/' . $cc . '.gif" border="0" /> ' . $player->getName() . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">Sex</td>
								<td style="border:1px dotted #B5B5B5;">' . ($player->getSex() == 0 ? "female" : "male") . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">Profession</td>
								<td style="border:1px dotted #B5B5B5;">' . $vocation_name[$player->getWorld()][$player->getPromotion()][$player->getVocation()] . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">Level</td>
								<td style="border:1px dotted #B5B5B5;">' . $player->getLevel() . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">World</td>
								<td style="border:1px dotted #B5B5B5;">' . $config['site']['worlds'][$player->getWorld()] . '</td>
							</tr>';
							
							if(!empty($towns_list[ $player->getWorld() ][ $player->getTownId() ]))
							{
								$main_content .= '
								<tr>
									<td style="border:1px dotted #B5B5B5;">Residence</td>
									<td style="border:1px dotted #B5B5B5;">' . $towns_list[$player->getWorld()][$player->getTownId()] . '</td>
								</tr>';
							}
							
							$rank_of_player = $player->getRank();
							if(!empty($rank_of_player))
							{
								$guildId = $rank_of_player->getGuild()->getId();
								$guildName = $rank_of_player->getGuild()->getName();
								
								$main_content .= '
								<tr>
									<td style="border:1px dotted #B5B5B5;">Guild membership</td>
									<td style="border:1px dotted #B5B5B5;">' . $rank_of_player->getName() . ' of the <a href="?subtopic=guilds&action=show&guild=' . (int)$guildId . '">' . urlencode($guildName) . '</a></td>
								</tr>';
							}
							
							$lastLogin = $player->getLastLogin();
							$main_content .= '
							<tr>
								<td style="border:1px dotted #B5B5B5;">Last login</td>
								<td style="border:1px dotted #B5B5B5;">' . (empty($lastLogin) ? "Never logged in." : date("j F Y, g:i a", $lastLogin)) . '</td>
							</tr>';
							
							if($config['site']['show_creationdate'] && $player->getCreated())
							{
								$main_content .= '
								<tr>
									<td style="border:1px dotted #B5B5B5;">Created</td>
									<td style="border:1px dotted #B5B5B5;">' . date("j F Y, g:i a", $player->getCreated()) . '</td>
								</tr>';
							}
							
							$comment = $player->getComment();
							$comment_with_lines = str_replace(array("\r\n", "\n", "\r"), '<br />', $comment, $count);
							if($count < 50)
								$comment = $comment_with_lines;
							
							if(!empty($comment))
							{
								$main_content .= '
								<tr>
									<td valign="top" style="border:1px dotted #B5B5B5;">Comment</td>
									<td style="border:1px dotted #B5B5B5;">' . $comment . '</td>
								</tr>';
							}
							
							$main_content .= '
						</table>
						<br />
						<table border="0" cellpadding="4" cellspacing="1" width="100%" style="border:1px dotted #B5B5B5;">
							<tr>
								<td colspan="5"  style="font-weight: bold; border:1px dotted #B5B5B5;">Characters</td>
							</tr>
							<tr>
								<td style="font-weight: bold; border:1px dotted #B5B5B5;">Name</td>
								<td style="font-weight: bold; border:1px dotted #B5B5B5;">World</td>
								<td style="font-weight: bold; border:1px dotted #B5B5B5;">Level</td>
								<td style="font-weight: bold; border:1px dotted #B5B5B5;">Status</td>
								<td style="font-weight: bold; border:1px dotted #B5B5B5;"></td>
							</tr>';
							
							$account_players = $account->getPlayersList();
							$account_players->orderBy('name');
							foreach($account_players as $player_list)
							{
								if(!$player_list->getHideChar())
								{
									if(!$player_list->isOnline())
										$player_list_status = '<font color="red">Offline</font>';
									else
										$player_list_status = '<font color="green">Online</font>';
										
									$main_content .= '
									<tr>
										<td width="40%" style="border:1px dotted #B5B5B5;">' . $player_list->getName() . ' ' . ($player_list->isDeleted() ? '<font color="red">[DELETED]</font>' : '') . '</td>
										<td width="15%" style="border:1px dotted #B5B5B5;">' . $config['site']['worlds'][$player_list->getWorld()] . '</td>
										<td width="25%" style="border:1px dotted #B5B5B5;">' . $player_list->getLevel() . ' ' . $vocation_name[$player_list->getWorld()][$player_list->getPromotion()][$player_list->getVocation()] . '</td>
										<td width="10%" style="border:1px dotted #B5B5B5;">' . $player_list_status . '</td>
										<td style="border:1px dotted #B5B5B5;"><button onClick=\'document.location = "?subtopic=characters&name=' . $player_list->getName() . '"; return false;\'>View</button></td>
									</tr>';
								}
							}
							$main_content .= '
						</table>
					</div>
					<div id="statistics">';
						$time = time();
						$today = $player->getExperience() - $player->getCustomField('exphist_lastexp');
						$yesterday = $player->getCustomField('exphist1');
						$twodays = $player->getCustomField('exphist2');
						$threedays = $player->getCustomField('exphist3');
						$fourdays = $player->getCustomField('exphist4');
						$fivedays = $player->getCustomField('exphist5');
						$sixdays = $player->getCustomField('exphist6');
						
						$main_content .= '
						<table border="0" cellpadding="4" cellspacing="1" width="100%" style="border:1px dotted #B5B5B5;">
							<tr>
								<td style="border:1px dotted #B5B5B5;">#</td> 
								<td style="border:1px dotted #B5B5B5;">Day</td> 
								<td style="border:1px dotted #B5B5B5;">Exp Change</td> 
								<td style="border:1px dotted #B5B5B5;">Exp per Hour</td>
							</tr>			
							<tr>
								<td style="border:1px dotted #B5B5B5;">1. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($today) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($today / (date("H") + 1)) . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">2. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time - 1 * 24 * 60 * 60) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($yesterday) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($yesterday / 24) . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">3. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time - 2 * 24 * 60 * 60) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($twodays) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($twodays / 24) . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">4. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time - 3 * 24 * 60 * 60) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($threedays) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($threedays / 24) . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">5. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time - 4 * 24 * 60 * 60) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($fourdays) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($fourdays / 24) . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">6. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time - 5 * 24 * 60 * 60) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($fivedays) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($fivedays / 24) . '</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">7. </td>
								<td style="border:1px dotted #B5B5B5;">' . date("d.m.Y", $time - 6 * 24 * 60 * 60) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($sixdays) . '</td>
								<td style="border:1px dotted #B5B5B5;">' . coloured_value($sixdays / 24) . '</td>
							</tr>
						</table>
						<br />
						<table border="0" cellpadding="4" cellspacing="1" width="100%" style="border:1px dotted #B5B5B5;">
							<tr>
								<td colspan="9" style="border:1px dotted #B5B5B5;">Skills</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/level.gif" title="'.$info[0].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/ml.gif" title="'.$info[1].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/fist.gif" title="'.$info[2].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/club.gif" title="'.$info[3].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/sword.gif" title="'.$info[4].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/axe.gif" title="'.$info[5].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/dist.gif" title="'.$info[6].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<img src="./images/skills/def.gif" title="'.$info[7].'" style="border: solid 1px #000;" width="70%" height="70%"/>
								</td>
							</tr>	
							<tr>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Level</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Magic</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Fist</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Club</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Sword</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Axe</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Dist</span>
								</td>
								<td style="border:1px dotted #B5B5B5;" align="center">
									<span class="black">Shield</span>
								</td>
							</tr>
							<tr>
								<td style="border:1px dotted #B5B5B5;">
									<div class="skill-progress">
										<div style="width:'.getExperiencePercent($player->getLevel(),  $player->getExperience()).'%; background-color: #FFD700;">
											<span class="glow" align="center">'.$player->getLevel().' </span>
										</div>
									</div>
								</td>
								<td style="border:1px dotted #B5B5B5;">
									<div class="skill-progress">
										<div style="width:'.getManaSpentPercentage($player->getMagLevel(),$player->getManaSpent(),$player->getVocation()).'%;background-color: #1E90FF;">
											<span class="glow" align="center">'.$player->getMagLevel().'</span>
										</div>
									</div>            
								</td>
								<td style="border:1px dotted #B5B5B5;">
									<div class="skill-progress">
										<div style="width:'.getSkillTriesPercentage(0,$player->getSkill(0),getTries($player->getId(),0),$player->getVocation()).'%;background-color: #DEB887;">
											<span class="glow" align="center">'.$player->getSkill(0).'</span>
										</div>
									</div>            
								</td>
								<td style="border:1px dotted #B5B5B5;">
									<div class="skill-progress">
										<div style="width:'.getSkillTriesPercentage(1,$player->getSkill(1),  getTries($player->getId(),1),$player->getVocation()).'%;background-color: #ADFF2F;">
											<span class="glow" align="center">'.$player->getSkill(1).'</span>
										</div>
									</div>            
								</td>
								<td style="border:1px dotted #B5B5B5;">
									<div class="skill-progress">
										<div style="width:'.getSkillTriesPercentage(2,$player->getSkill(2),  getTries($player->getId(),2),$player->getVocation()).'%;background-color: #E9967A;">
											<span class="glow" align="center">'.$player->getSkill(2).'</span>
										</div>
									</div>            
								</td>
								<td>
									<div class="skill-progress">
										<div style="width:'.getSkillTriesPercentage(3,$player->getSkill(3),  getTries($player->getId(),3),$player->getVocation()).'%; background-color: #D8BFD8;">
											<span class="glow" align="center">'.$player->getSkill(3).'</span>
										</div>
									</div>            
								</td>
								<td>
									<div class="skill-progress">
										<div style="width:'.getSkillTriesPercentage(4,$player->getSkill(4),  getTries($player->getId(),4),$player->getVocation()).'%; background-color: #00FF7F;">
											<span class="glow" align="center">'.$player->getSkill(4).'</span>
										</div>
									</div>            
								</td>
								<td>
									<div class="skill-progress">
										<div style="width:'.getSkillTriesPercentage(5,$player->getSkill(5),  getTries($player->getId(),5),$player->getVocation()).'%; background-color: #40E0D0;">
											<span class="glow" align="center">'.$player->getSkill(5).'</span>
										</div>
									</div>            
								</td>
							</tr>
							
						</table>';
					}
					$main_content .= '
				</div>
			</div>';
		}
	}
?>
