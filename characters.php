	<?php
	$name = stripslashes(ucwords(strtolower(trim($_REQUEST['name']))));
	if(empty($name))
	{
		$main_content .= '
		'.$lang['site']['CHAR_TEXT_1'].' ' . $config['server']['serverName'] . '. <br /><br />
		<form action="?subtopic=characters" method="POST">
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td>
						<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
							<tr>
								<td bgcolor="' . $config['site']['vdarkborder'] . '" class="white" style="font-weight: bold;">'.$lang['site']['CHAR_TEXT_2'].'</td>
							</tr>
							<tr>
								<td bgcolor="' . $config['site']['darkborder'] . '">
									<table border="0" cellpadding="1">
										<tr>
											<td>Name:</td>
											<td><input name="name" value="" size="26" maxlength="29"></td>
											<td><input type="image" name="Submit" src="' . $layout_name . '/images/buttons/submit.png" border="0" width="120" height="18"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';
	}
	else
	{
	if(check_name($name))
	{
		$player = $ots->createObject('Player');
		$player->find($name);
		if($player->isLoaded())
		{
			$cc = strtolower(geoip_country_code_by_name(revertIp(long2ip($player->getLastIP()))));
			if(empty($cc))
				$cc = "unknown";

			$account = $player->getAccount();
						$bgcolor = ($number_of_rows % 2) ? $config['site']['lightborder'] : $config['site']['darkborder'];
						$number_of_rows++;
						
						$main_content .= '
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<td>
									<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
										<tr bgcolor="' . $config['site']['vdarkborder'] . '">
											<td colspan="3" class="white" style="font-weight: bold;">&raquo; '.$lang['site']['CHAR_TEXT_3'].'</td>
										</tr>
										<tr bgcolor="' . $bgcolor . '">
											<td width="20%">'.$lang['site']['CHAR_TEXT_NAME'].'</td>
											<td>
												<image src="images/flags/' . $cc . '.gif"/> <span style="color: ' . ($player->isOnline() ? 'green' : 'red') . '; font-weight: bold;">' . $player->getName() . '</span>';
												if($player->isDeleted())
													$main_content .= '<span style="color: red;"> '.$lang['site']['CHAR_TEXT_4'].'</span>';
												
												if($player->isNameLocked())
													$main_content .= '<span style="color: red;"> '.$lang['site']['CHAR_TEXT_5'].'</span>';

												if(!empty($towns_list[$player->getWorld()][$player->getTownId()]))	
													$main_content .= '
													</td>
													<td rowspan="8" width="110" valign="top">';
												else
													$main_content .= '
													</td>
													<td rowspan="7" width="110" valign="top">';

														require_once('equipshower/eqshower-config.php');
														
														$id = $player->getId();
														$items = $db->query("SELECT `itemtype`, `pid` FROM `player_items` WHERE `player_id`= " . $id . " AND `pid` <= 10;")->fetchAll();
														foreach($items as $result)
														{
															$item[$result['pid']]['img'] = "<img src=\"images/items/" . $result['itemtype'] . ".gif\" alt=" . $result['itemtype'] . " />";
															$item[$result['pid']]['id'] = $result['itemtype'];
															$class[$result['pid']] = "a0-" . $result['pid'];
														}

														$EQShower = new EQShower();
														$items = items();

														for($i = 1; $i <= 10; $i++)
														{
															$num_attr = 0;
															unset($val);
															
															$val = array();
															$val[0] = str_replace("'", "\'", $items[$item[$i]['id']]['name']);
															$val[1] = $items[$item[$i]['id']]['description'];
															$val[2] = $items[$item[$i]['id']]['armor'];
															$val[3] = $items[$item[$i]['id']]['weight'];
															$val[4] = $items[$item[$i]['id']]['containerSize'];
															$val[5] = $items[$item[$i]['id']]['attack'];
															$val[6] = $items[$item[$i]['id']]['speed'];
															$val[7] = $items[$item[$i]['id']]['defense'];
															$val[8] = $items[$item[$i]['id']]['elementFire'];
															$val[9] = $items[$item[$i]['id']]['elementIce'];
															$val[10] = $items[$item[$i]['id']]['elementEarth'];
															$val[11] = $items[$item[$i]['id']]['elementEnergy'];
															$val[12] = $items[$item[$i]['id']]['range'];
															$val[13] = $items[$item[$i]['id']]['extradef'];
															$val[14] = $items[$item[$i]['id']]['skillShield'];
															$val[15] = $items[$item[$i]['id']]['magiclevelpoints'];
															$val[16] = $items[$item[$i]['id']]['absorbPercentAll'];
															$val[17] = $items[$item[$i]['id']]['charges'];
															$val[18] = $items[$item[$i]['id']]['skillDist'];
															$val[19] = $items[$item[$i]['id']]['absorbPercentFire'];
															$val[20] = $items[$item[$i]['id']]['absorbPercentEarth'];
															$val[21] = $items[$item[$i]['id']]['absorbPercentIce'];
															$val[22] = $items[$item[$i]['id']]['absorbPercentEnergy'];
															$val[23] = $items[$item[$i]['id']]['absorbPercentDeath'];
															$val[24] = $items[$item[$i]['id']]['absorbPercentHoly'];
															$val[25] = $items[$item[$i]['id']]['absorbPercentPhysical'];
															$val[26] = $items[$item[$i]['id']]['skillAxe'];
															$val[27] = $items[$item[$i]['id']]['skillClub'];
															$val[28] = $items[$item[$i]['id']]['skillSword'];
															$val[29] = $items[$item[$i]['id']]['duration'];
															$val[30] = $items[$item[$i]['id']]['skillFist'];
															$val[31] = $items[$item[$i]['id']]['absorbPercentManaDrain'];
															$val[32] = $items[$item[$i]['id']]['absorbPercentLifeDrain'];
															$val[33] = $items[$item[$i]['id']]['preventDrop'];
															$val[34] = $items[$item[$i]['id']]['hitChance'];
															$val[35] = $items[$item[$i]['id']]['shootType'];

															foreach($val as $attribute)
															{
																if(!empty($attribute))
																	$num_attr++;
															}

															$tooltip[$i] = $EQShower->item_info($val, $num_attr);

															if(empty($item[$i]))
															{
																$class[$i] = "a" . $i;
																$tooltip[$i] = "<font class=\'attr\'>".$lang['site']['CHAR_TEXT_6']."</font>";
															}
														}

														$main_content .= '
															<table with="100%" cellspacing="1">
																<tr class="darkBorder">
																	<div id="bg">
																		<div class="col1">
																			<div class="' . $class['2'] . '" onmouseover="showTooltip(event, \'' . $tooltip[2] . '\'); return false" onmouseout="hideTooltip()">
																				' . $item['2']['img'] . '
																			</div>
																			<div class="' . $class['6'] . '" onmouseover="showTooltip(event, \'' . $tooltip[6] . '\'); return false" onmouseout="hideTooltip()"">
																				' . $item['6']['img'] . '
																			</div>
																			<div class="' . $class['9'] . '" onmouseover="showTooltip(event, \'' . $tooltip[9] . '\'); return false" onmouseout="hideTooltip()">
																				' . $item['9']['img'] . '
																			</div>
																			<div class="soul">
																				<div class="txts" onmouseover="showTooltip(event, \'<center>'.$lang['site']['CHAR_TEXT_7'].' ' . $player->getSoul() . '</center>\'); return false" onmouseout="hideTooltip()">
																					<p style="padding-bottom:6px">' . $player->getSoul() . '</p>
																				</div>
																			</div>
																		</div>
																		<div class="col2">
																			<div class="' . $class['1'] . '" onmouseover="showTooltip(event, \'' . $tooltip[1] . '\'); return false" onmouseout="hideTooltip()">
																			' . $item['1']['img'] . '
																			</div>
																			<div class="' . $class['4'] . '" onmouseover="showTooltip(event, \'' . $tooltip[4] . '\'); return false" onmouseout="hideTooltip()"">
																			' . $item['4']['img'] . '
																			</div>
																			<div class="' . $class['7'] . '" onmouseover="showTooltip(event, \'' . $tooltip[7] . '\'); return false" onmouseout="hideTooltip()">
																			' . $item['7']['img'] . '
																			</div>
																			<div class="' . $class['8'] . '" onmouseover="showTooltip(event, \'' . $tooltip[8] . '\'); return false" onmouseout="hideTooltip()">
																			' . $item['8']['img'] . '
																			</div>
																		</div>
																		<div class="col3">
																			<div class="' . $class['3'] . '" onmouseover="showTooltip(event, \'' . $tooltip[3] . '\'); return false" onmouseout="hideTooltip()">
																			' . $item['3']['img'] . '
																			</div>
																			<div class="' . $class['5'] . '" onmouseover="showTooltip(event, \'' . $tooltip[5] . '\'); return false" onmouseout="hideTooltip()"">
																			' . $item['5']['img'] . '
																			</div>
																			<div class="' . $class['10'] . '" onmouseover="showTooltip(event, \'' . $tooltip[10] . '\'); return false" onmouseout="hideTooltip()">
																			' . $item['10']['img'] . '
																			</div>
																			<div class="cap">
																				<div class="txtc" onmouseover="showTooltip(event, \'<center>'.$lang['site']['CHAR_TEXT_8'].' ' . $player->getCap() . '</center>\'); return false" onmouseout="hideTooltip()">
																					<p style="padding-bottom:6px">' . $player->getCap() . '</p>
																				</div>
																			</div>
																		</div>
																	</div>
																</tr>
															</table>';
														$main_content .= '
													</td>
												</tr>
											</td>
										</tr>';
										
										$array_groups = array(2 => 'Tutor', 3 => 'Senior Tutor', 4 => 'Game Master', 5 => 'Community Manager', 6 => 'Administrator', 7 => 'Tester');
										$group = $array_groups[$player->getGroup()];
										if($group > 1)
										{
											$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
											$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_11'].'</td><td>'.$group_name.'</td></tr>';
										}
										
										$formerNames = $db->query("SELECT `name` FROM `player_namelocks` WHERE `player_id` = " . $player->getId() . " ORDER BY `date` DESC LIMIT 1;")->fetch();
										if(!empty($formerNames))
										{
											$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
											$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>Former Names:</td><td>' . $formerNames['name'] . '</td></tr>';
										}

										$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
										$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_12'].'</td><td>' . (($player->getSex() == 0) ? ''.$lang['site']['CHAR_TEXT_13'].'' : ''.$lang['site']['CHAR_TEXT_14'].'') . '</td></tr>';
										
										if($config['site']['show_marriage_info'])
										{
											$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
											$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_15'].'</td><td>';
											$marriage = new OTS_Player();
											$marriage->load($player->getMarriage());
											if($marriage->isLoaded())
												$main_content .= ''.$lang['site']['CHAR_TEXT_16'].' <a href="?subtopic=characters&name=' . urlencode($marriage->getName()) . '"><b>' . $marriage->getName() . '</b></a></td></tr>';
											else
												$main_content .= ''.$lang['site']['CHAR_TEXT_17'].'</td></tr>';
										}
										
										$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
										$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_18'].'</td><td>' . $vocation_name[$player->getWorld()][$player->getPromotion()][$player->getVocation()] . '</td></tr>';
										
										$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
										$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_19'].'</td><td>' . $player->getLevel() . '</td></tr>';
			
										$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
										$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_20'].'</td><td>' . $config['site']['worlds'][$player->getWorld()] . '</td></tr>';
										
										if(!empty($towns_list[$player->getWorld()][$player->getTownId()]))
										{
											$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
											$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_21'].'</td><td>' . $towns_list[$player->getWorld()][$player->getTownId()] . '</td></tr>';
										}

										$rank_of_player = $player->getRank();
										if(!empty($rank_of_player))
										{
											$guild_id = $rank_of_player->getGuild()->getId();
											$guild_name = $rank_of_player->getGuild()->getName();
										}

										$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
										$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_22'].'</td>';
										if($group != 1)
										{
										$main_content .= '<td colspan=2>';
										$rank_of_player = $player->getRank();
										if(!empty($rank_of_player))
										{
										$main_content .= ''.$rank_of_player->getName().'';
										$main_content .= $lang['site']['CHAR_TEXT_23'];
										}
										$main_content .= '<a href="?subtopic=guilds&action=show&guild='.$guild_id.'">'.$guild_name.'</a>';
										if ($rank_of_player == 0)
										{
										$main_content .= $lang['site']['CHAR_TEXT_24'];
										}
										$main_content .='</td></tr>';
										}
										else
										{
										$main_content .= '<td>';

										$rank_of_player = $player->getRank();
										if(!empty($rank_of_player))
										{
										$main_content .= ''.$rank_of_player->getName().'';
										$main_content .= $lang['site']['CHAR_TEXT_23'];
										}
										$main_content .= '<a href="?subtopic=guilds&action=show&guild='.$guild_id.'">'.$guild_name.'</a>';
										if ($rank_of_player == 0)
										{
										$main_content .= $lang['site']['CHAR_TEXT_24'];
										}
										$main_content .='</td></tr>';
										}


			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$lastlogin = $player->getLastLogin();
			if(empty($lastlogin))
			{
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_25'].'</td>';
			$main_content .= '<td colspan=2>'.$lang['site']['CHAR_TEXT_26'].'</td></tr>';
			}
			else
			{
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td>'.$lang['site']['CHAR_TEXT_25'].'</td>';
			$main_content .= '<td colspan=2>'.date("M d Y, H:i:s T", $lastlogin).'</td></tr>';
			}
			$house = $db->query( 'SELECT `houses`.`name`, `houses`.`town` FROM `houses` WHERE `houses`.`world_id` = '.$player->getWorld().' AND `houses`.`owner` = '.$player->getId().';' )->fetchAll();
			$comment = $player->getComment();
			$newlines   = array("\r\n", "\n", "\r");
			$comment_with_lines = str_replace($newlines, '<br />', $comment, $count);
			if($count < 50)
			$comment = $comment_with_lines;
			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td width=20%>'.$lang['site']['CHAR_TEXT_27'].'</td><td colspan=2>';
			if ( count( $house ) != 0 )
			{
			$main_content .= ''.$house[0]['name'].' ('.$towns_list[$player->getWorld()][$house[0]['town']].')';
			}
			else
			{
			$main_content .= $lang['site']['CHAR_TEXT_28'];
			}
			$main_content .= '</td></tr>';

			if(!empty($comment))
			{
			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$main_content .= '';
			$main_content .='<tr bgcolor="' . $bgcolor . '"><td width=20% VALIGN=top>'.$lang['site']['CHAR_TEXT_29'].'</td><td colspan=2>'.$comment.'</td></tr>';

			}

			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td width=20%>'.$lang['site']['CHAR_TEXT_30'].'</td><td colspan=2>';
			$main_content .= ($account->isPremium()) ? ''.$lang['site']['CHAR_TEXT_31'].'' : ''.$lang['site']['CHAR_TEXT_32'].'';
			$main_content .= '</td></tr></table></td></tr></table><br>';
			//MAIN STATS END

			$main_content .= '
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['vdarkborder'].'">
			<td style="cursor: pointer;" class="white"><b>&raquo; '.$lang['site']['CHAR_QL_T_1'].'</b></td>
			<td width="15"><div id="stats_click1" style="background: url(images/plus.png); width:16px; height: 16px; cursor: pointer;"></div></td>
			</tr>
			</table>
			<table id="statistics1" cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['darkborder'].'">
			<td align="center" width="1%">';
			$id = $player->getId();
			$quests = array (
			'Annihilator' => 7000,
			'Demon Helmet' => 1001,
			'Yalahari' => 58272,
			'Demon Oak' => 50090,
			'Pits of Inferno' => 5955,
			'Inquisition' => 8560,
			'Warlord Arena' => 42381,
			'Scrapper Arena' => 42371,
			'Greenshore Arena' => 42361,
			'Begin Quest' => 5952,
			'Begin Quest 30lvl' => 5951,
			'Begin Quest 60lvl' => 5925,
			'Monay Quest 50lvl' => 1741,
			'Monay Quest 100lvl' => 1742,
			'Monay Quest 150lvl' => 1743,
			'Monay Quest 200lvl' => 1744,
			'Terra Set' => 5937,
			'Magma Set' => 5929,
			'Lightning Set' => 5930,
			'Glacier Set' => 5941,
			'Necro Quest' => 7500,
			'Dwarf Quest' => 7510,
			'Eternal Flames Quest' => 15202,
			'Morgaroth Cave' => 5912,
			);

			$questlistcontent .= '<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">';
			foreach($quests as $storage => $name)
			{
			if(is_int($number_of_rows / 2))
			$bgcolor = $config['site']['darkborder'];
			else
			$bgcolor = $config['site']['lightborder'];

			$number_of_rows++;
			$quest = $db->query("SELECT * FROM `player_storage` WHERE `player_id` = " . $id . " AND `key` = " . $quests[$storage] . ";")->fetch();
			if($quest == false)
			$questlistcontent .= '<TR BGCOLOR="' . $bgcolor . '"><td WIDTH=95%>'.$storage.'</td><td><img src="images/false.png"/></td></tr>';
			else
			$questlistcontent .= '<TR BGCOLOR="' . $bgcolor . '"><td WIDTH=95%>'.$storage.'</td><td><img src="images/true.png"/></td></tr>';
			}
			$questlistcontent .= '</table>';

			$main_content .= $questlistcontent;
			$main_content .= '
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table><br />';
			// QUEST LOG END
			
			$main_content .= '
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['vdarkborder'].'">
			<td style="cursor: pointer;" class="white"><b>&raquo; Show Achievements</b></td>
			<td width="15"><div id="stats_click8" style="background: url(images/plus.png); width:16px; height: 16px; cursor: pointer;"></div></td>
			</tr>
			</table>
			<table id="statistics8" cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['darkborder'].'">
			<td align="center" width="1%">';
			
			$z = 1;
			$ach = $db->query("SELECT * FROM `player_achievements` WHERE `player_id` = " . $player->getId() . ";")->fetchAll();
			foreach($ach as $a)
			{
				$main_content .= '<img src="images/achievements/' . $a['id'] . '.png" onmouseover="showTooltip(event, \'' . $a['name'] . '<br /><br />Achievement zdobyty dnia ' . date("M d Y, H:i:s T", $a['date']) . '.\'); return false" onmouseout="hideTooltip()"/>';
				if($z % 5 == 0)
					$main_content .= '<br />';
					
				$z++;
			}
			
			$main_content .= '
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table><br />';

			$time = time();
			$today = $player->getExperience() - $player->getCustomField('exphist_lastexp');
			$yesterday = $player->getCustomField('exphist1');
			$twodays = $player->getCustomField('exphist2');
			$threedays = $player->getCustomField('exphist3');
			$fourdays = $player->getCustomField('exphist4');
			$fivedays = $player->getCustomField('exphist5');
			$sixdays = $player->getCustomField('exphist6');

			$main_content .= '
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['vdarkborder'].'">
			<td style="cursor: pointer;" class="white"><b>&raquo; '.$lang['site']['CHAR_C_T_1'].'</b></td>
			<td width="15"><div id="stats_click2" style="background: url(images/plus.png); width:16px; height: 16px; cursor: pointer;"></div></td>
			</tr>
			</table>
			<table id="statistics2" cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['darkborder'].'">
			<td align="center" width="1%">
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white">'.$lang['site']['CHAR_C_T_2'].'</td>
			<td class="white">'.$lang['site']['CHAR_C_T_3'].'</td>
			<td class="white">'.$lang['site']['CHAR_C_T_4'].'</td>
			<td class="white">'.$lang['site']['CHAR_C_T_5'].'</td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>1. </td>
			<td>' . date("d.m.Y", $time) . '</td>
			<td>' . coloured_value($today) . '</td>
			<td>' . coloured_value($today / (date("H") + 1)) . '</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>2. </td>
			<td>' . date("d.m.Y", $time - 1 * 24 * 60 * 60) . '</td>
			<td>' . coloured_value($yesterday) . '</td>
			<td>' . coloured_value($yesterday / 24) . '</td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>3. </td>
			<td>' . date("d.m.Y", $time - 2 * 24 * 60 * 60) . '</td>
			<td>' . coloured_value($twodays) . '</td>
			<td>' . coloured_value($twodays / 24) . '</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>4. </td>
			<td>' . date("d.m.Y", $time - 3 * 24 * 60 * 60) . '</td>
			<td>' . coloured_value($threedays) . '</td>
			<td>' . coloured_value($threedays / 24) . '</td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>5. </td>
			<td>' . date("d.m.Y", $time - 4 * 24 * 60 * 60) . '</td>
			<td>' . coloured_value($fourdays) . '</td>
			<td>' . coloured_value($fourdays / 24) . '</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>6. </td>
			<td>' . date("d.m.Y", $time - 5 * 24 * 60 * 60) . '</td>
			<td>' . coloured_value($fivedays) . '</td>
			<td>' . coloured_value($fivedays / 24) . '</td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>7. </td>
			<td>' . date("d.m.Y", $time - 6 * 24 * 60 * 60) . '</td>
			<td>' . coloured_value($sixdays) . '</td>
			<td>' . coloured_value($sixdays / 24) . '</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table><br />';
			// CHARTS END

			$hp = round($player->getHealth() / $player->getHealthMax() * 100);
			$mana = round($player->getMana() / $player->getManaMax() * 100);
			$exp = getExperiencePercent($player->getLevel(), $player->getExperience());
			$magic = getManaSpentPercentage($player->getMagLevel(), $player->getManaSpent(), $player->getVocation());
			$stamina = round($player->getCustomField("stamina") / 151200000 * 100);
			$fist = getSkillTriesPercentage(0, $player->getSkill(0), $player->getSkillTries(0), $player->getVocation());
			$club = getSkillTriesPercentage(1, $player->getSkill(1), $player->getSkillTries(1), $player->getVocation());
			$sword = getSkillTriesPercentage(2, $player->getSkill(2), $player->getSkillTries(2), $player->getVocation());
			$axe = getSkillTriesPercentage(3, $player->getSkill(3), $player->getSkillTries(3), $player->getVocation());
			$distance = getSkillTriesPercentage(4, $player->getSkill(4), $player->getSkillTries(4), $player->getVocation());
			$shielding = getSkillTriesPercentage(5, $player->getSkill(5), $player->getSkillTries(5), $player->getVocation());
			$fishing = getSkillTriesPercentage(6, $player->getSkill(6), $player->getSkillTries(6), $player->getVocation());
			$main_content .= '
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['vdarkborder'].'">
			<td style="cursor: pointer;" class="white"><b>&raquo; '.$lang['site']['CHAR_S_T_1'].'</b></td>
			<td width="15"><div id="stats_click5" style="background: url(images/plus.png); width:16px; height: 16px; cursor: pointer;"></div></td>
			</tr>
			</table>
			<table id="statistics5" cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['darkborder'].'">
			<td align="center" width="1%">
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td width="40%" height="30px">'.$lang['site']['CHAR_S_T_2'].'</td>
			<td>' . $player->getHealth() . '/' . $player->getHealthMax() . ' (' . $hp . '% of 100%)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: red; width: ' . $hp . '%; height: 3px;"></td>
			<td rowspan="2" width="60px" height="60px" valign="top">
			<img src="outfiter.php?id=' . $player->getLookType() . '&addons=' . $player->getLookAddons() . '&head=' . $player->getLookHead() . '&body=' . $player->getLookBody() . '&legs=' . $player->getLookLegs() . '&feet=' . $player->getLookFeet() . '" border="0" />
			</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="40%" height="30px">'.$lang['site']['CHAR_S_T_3'].'</td>
			<td>' . $player->getMana() . '/' . $player->getManaMax() . ' (' . $mana . '% of 100%)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: blue; width: ' . $mana . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_4'].'</td>
			<td colspan="2">' . $player->getExperience() . ' (<span onmouseover="showTooltip(event, \'' . (getExperienceForLevel($player->getLevel() + 1) - $player->getExperience()) . ' experience to next level\'); return false" onmouseout="hideTooltip()">' . (100 - $exp) . '% to next level</span>)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: red; width: ' . $exp . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_5'].'</td>
			<td colspan="2">' . $player->getMagLevel() . ' (' . (100 - $magic) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: red; width: ' . $magic . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_6'].'</td>
			<td colspan="2">' . $stamina . '% of 100%<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $stamina . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_7'].'</td>
			<td colspan="2">' . $player->getSkill(0) . ' (' . (100 - $fist) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $fist . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_8'].'</td>
			<td colspan="2">' . $player->getSkill(1) . ' (' . (100 - $club) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $club . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_9'].'</td>
			<td colspan="2">' . $player->getSkill(2) . ' (' . (100 - $sword) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $sword . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_10'].'</td>
			<td colspan="2">' . $player->getSkill(3) . ' (' . (100 - $axe) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $axe . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_11'].'</td>
			<td colspan="2">' . $player->getSkill(4) . ' (' . (100 - $distance) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $distance . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_12'].'</td>
			<td colspan="2">' . $player->getSkill(5) . ' (' . (100 - $shielding) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $shielding . '%; height: 3px;"></td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="40%">'.$lang['site']['CHAR_S_T_13'].'</td>
			<td colspan="2">' . $player->getSkill(6) . ' (' . (100 - $fishing) . '% to next level)<br /><div style="width: 100%; height: 3px; border: 1px solid #000;"><div style="background: green; width: ' . $fishing . '%; height: 3px;"></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table><br />';
			// CHARTS END

			$main_content .= '
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['vdarkborder'].'">
			<td style="cursor: pointer;" class="white"><b>&raquo; '.$lang['site']['CHAR_DL_T_1'].'</b></td>
			<td width="15"><div id="stats_click3" style="background: url(images/minus.png); width:16px; height: 16px; cursor: pointer;"></div></td>
			</tr>
			</table>
			<table id="statistics3" cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['darkborder'].'">
			<td align="center" width="1%">';

			$player_deaths = $db->query('SELECT `id`, `date`, `level` FROM `player_deaths` WHERE `player_id` = '.$player->getId().' ORDER BY `date` DESC LIMIT 0,10;');
			foreach($player_deaths as $death)
			{
			if(is_int($number_of_rows / 2))
			$bgcolor = $config['site']['darkborder']; else $bgcolor = $config['site']['lightborder'];

			$number_of_rows++; $deads++;
			$dead_add_content .= "<tr bgcolor=\"".$bgcolor."\">
			<td width=\"28%\" >".date("M d Y, H:i:s T", $death['date'])."</td>
			<td>";
			$killers = $db->query("SELECT environment_killers.name AS monster_name, players.name AS player_name, players.deleted AS player_exists FROM killers LEFT JOIN environment_killers ON killers.id = environment_killers.kill_id
			LEFT JOIN player_killers ON killers.id = player_killers.kill_id LEFT JOIN players ON players.id = player_killers.player_id
			WHERE killers.death_id = ".$db->quote($death['id'])." ORDER BY killers.final_hit DESC, killers.id ASC")->fetchAll();

			$i = 0;
			$count = count($killers);
			foreach($killers as $killer)
			{
			$i++;
			if(in_array($i, array(1, $count)))
			$killer['monster_name'] = str_replace(array("an ", "a "), array("", ""), $killer['monster_name']);

			if($killer['player_name'] != "")
			{
			if($i == 1)
			$dead_add_content .= "".$lang['site']['CHAR_DL_T_2']." <b>".$death['level']."</b> ".$lang['site']['CHAR_DL_T_6']." ";
			else if($i == $count)
			$dead_add_content .= $lang['site']['CHAR_DL_T_3'];
			else
			$dead_add_content .= ", ";

			if($killer['monster_name'] != "")
			$dead_add_content .= $killer['monster_name']. $lang['site']['CHAR_DL_T_4'];

			if($killer['player_exists'] == 0)
			$dead_add_content .= "<a href=\"?subtopic=characters&name=".urlencode($killer['player_name'])."\">";

			$dead_add_content .= $killer['player_name'];
			if($killer['player_exists'] == 0)
			$dead_add_content .= "</a>";
			}
			else
			{
			if($i == 1)
			$dead_add_content .= "".$lang['site']['CHAR_DL_T_5']." <b>".$death['level']."</b> ".$lang['site']['CHAR_DL_T_6']." ";
			else if($i == $count)
			$dead_add_content .= $lang['site']['CHAR_DL_T_3'];
			else
			$dead_add_content .= ", ";

			$dead_add_content .= $killer['monster_name'];
			}

			if($i == $count)
			$dead_add_content .= ".";
			}

			$dead_add_content .= "</td></tr>";
			}

			if($deads > 0) {
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% id=iblue>' . $dead_add_content . '</table>
			';
			} else {
			$main_content .= $lang['site']['CHAR_DL_T_7'];
			}
			$main_content .= '</td></tr></table></td></tr></table><br>';
			// DEATH LIST END

			$main_content .= '
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['vdarkborder'].'">
			<td style="cursor: pointer;" class="white"><b>&raquo; '.$lang['site']['CHAR_FL_T_1'].'</b></td>
			<td width="15"><div id="stats_click4" style="background: url(images/plus.png); width:16px; height: 16px; cursor: pointer;"></div></td>
			</tr>
			</table>
			<table id="statistics4" cellpadding="4" cellspacing="1" border="0" width="100%" id="iblue">
			<tr style="background: '.$config['site']['darkborder'].'">
			<td align="center" width="1%">';


			$frags_limit = 10; // frags limit to show? // default: 10
			$player_frags = $db->query('SELECT `player_deaths`.*, `players`.`name`, `killers`.`unjustified`, `killers`.`war` FROM `player_deaths` LEFT JOIN `killers` ON `killers`.`death_id` = `player_deaths`.`id` LEFT JOIN `player_killers` ON `player_killers`.`kill_id` = `killers`.`id` LEFT JOIN `players` ON `players`.`id` = `player_deaths`.`player_id` WHERE `player_killers`.`player_id` = '.$player->getId().' ORDER BY `date` DESC LIMIT 0,'.$frags_limit.';');
			if(count($player_frags))
			{
			$frags = 0;
			$frag_add_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% id=iblue>';
			foreach($player_frags as $frag)
			{
			$frags++;
			if(is_int($number_of_rows / 2)) $bgcolor = $config['site']['darkborder']; else $bgcolor = $config['site']['lightborder'];
			$number_of_rows++;
			$frag_add_content .= "<tr bgcolor=\"".$bgcolor."\">
			<td width=\"28%\">".date("M d Y, H:i:s T", $frag['date'])."</td>
			<td>".$lang['site']['CHAR_FL_T_2']." <a href='?subtopic=characters&name=".urlencode($frag['name'])."'>".$frag[name]."</a> ".$lang['site']['CHAR_FL_T_3']." ".$frag[level]."";

			$frag_add_content .= " ".(($frag[unjustified] == 0) ? "<font size=\"2\" color=\"green\"><b>".$lang['site']['CHAR_FL_T_4']."</b></font>" : "<font size=\"2\" color=\"red\"><b>".$lang['site']['CHAR_FL_T_5']."</b></font>")."</td></tr>";
			}
			if($frags >= 1) {
			$main_content .= $frag_add_content . '</table>';
			} else {
			$main_content .= $lang['site']['CHAR_FL_T_6'];
			}
			}

			$main_content .= '</td></tr></table>
			</td></tr></table><br>';
			// FRAG LIST END

			//Account information
			if(!$player->getHideChar())
			{
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% id=iblue><TR BGCOLOR='.$config['site']['vdarkborder'].'><td COLSPAN=2 CLASS=white><B>'.$lang['site']['CHAR_AI_T_1'].'</B></td></tr>';
			if($account->getRLName())
			{
			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td WIDTH=20%>'.$lang['site']['CHAR_AI_T_2'].'</td><td>'.$account->getRLName().'</td></tr>';
			}
			if($account->getLocation())
			{
			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td WIDTH=20%>'.$lang['site']['CHAR_AI_T_3'].'</td><td>'.$account->getLocation().'</td></tr>';
			}
			if($account->getCreated())
			{
			$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder']; $i++;
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td WIDTH=20%>'.$lang['site']['CHAR_AI_T_4'].'</td><td>'.date("M d Y, H:i:s T", $account->getCreated()).'';
			}
			if($account->isBanned())
			if($account->getBanTime() > 0)
			$main_content .= '<font color="red"> ['.$lang['site']['CHAR_AI_T_5'].' '.date("j F Y, G:i", $account->getBanTime()).']</font>';
			else
			$main_content .= '<font color="red"> ['.$lang['site']['CHAR_AI_T_6'].']</font>';
			$main_content .= '</td></tr></table><br>';
			}
			//ACCOUNT INFORMATION END

			//CHARACTER LIST START

			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% id=iblue><TR BGCOLOR='.$config['site']['vdarkborder'].'><td COLSPAN=5 CLASS=white><B>'.$lang['site']['CHAR_CL_T_1'].'</B></td></tr>
			<TR BGCOLOR='.$config['site']['darkborder'].'><td><B>'.$lang['site']['CHAR_CL_T_2'].'</B></td><td><B>'.$lang['site']['CHAR_CL_T_3'].'</B></td><td><b>'.$lang['site']['CHAR_CL_T_4'].'</b></td><td><B>&#160;</B></td></tr>';
			$account_players = $account->getPlayersList();
			$account_players->orderBy('name');
			$player_number = 0;
			foreach($account_players as $player_list)
			{
			if(!$player_list->getHideChar())
			{
			$player_number++;
			if(is_int($player_number / 2))
			$bgcolor = $config['site']['darkborder'];
			else
			$bgcolor = $config['site']['lightborder'];
			if(!$player_list->isOnline())
			$player_list_status = '<span style="color: red; font-weight: bold;">offline</span>';
			else
			$player_list_status = '<span style="color: green; font-weight: bold;">'.$lang['site']['CHAR_CL_T_5'].'</span>';
			$main_content .= '<tr bgcolor="' . $bgcolor . '"><td WIDTH=25%><NOBR>'.$player_number.'.&#160;'.$player_list->getName();
			$main_content .= ($player_list->isDeleted()) ? '<font color="red"> ['.$lang['site']['CHAR_CL_T_6'].']</font>' : '';
			$main_content .= '</NOBR></td><td WIDTH=10%>'.$config['site']['worlds'][$player_list->getWorld()].'</td><td WIDTH="50%"><b>'.$player_list_status.'</b></td><td><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=characters" METHOD=post><tr><td><INPUT TYPE=hidden NAME=name VALUE="'.$player_list->getName().'"><INPUT TYPE=image NAME="View '.$player_list->getName().'" ALT="View '.$player_list->getName().'" SRC="'.$layout_name.'/images/buttons/view.png" BORDER=0 WIDTH=120 HEIGHT=18></td></tr></FORM></table></td></tr>';
			}
			}
			$main_content .= '</table><br>';
			//CHARACTER LIST END

			// SEARCHER START
			$main_content .= '<FORM ACTION="?subtopic=characters" METHOD=post>
			<TABLE WIDTH=100% align=center BORDER=0 CELLSPACING=1 CELLPADDING=4 id=iblue><tr><td bgcolor="'.$config['site']['vdarkborder'].'" CLASS=white><B>'.$lang['site']['CHAR_SEARCH_T_1'].'</B></td></tr><tr><td bgcolor="'.$config['site']['darkborder'].'"><TABLE BORDER=0 CELLPADDING=1><tr><td>'.$lang['site']['CHAR_SEARCH_T_1'].'</td><td><INPUT NAME="name" VALUE="" SIZE=26 MAXLENGTH=29></td><td><INPUT TYPE=image NAME="Submit" SRC="'.$layout_name.'/images/buttons/submit.png" BORDER=0 WIDTH=120 HEIGHT=18></td></tr></table></td></tr></table></FORM>';
			// SEARCHER STOP

		}
		else
		$search_errors[] = ''.$lang['site']['CHAR_SEARCH_T_3'].' <b>'.$name.'</b> '.$lang['site']['CHAR_SEARCH_T_4'].'';
	}
	else
	$search_errors[] = $lang['site']['CHAR_SEARCH_T_5'];
	// SEARCH ERROR START
	if(!empty($search_errors))
	{
	$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>'.$lang['site']['CHAR_SEARCH_T_6'].'</b><br/>';
	foreach($search_errors as $search_error)
	$main_content .= '<li>'.$search_error;
	$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
	$main_content .= '<BR><FORM ACTION="?subtopic=characters" METHOD=post><table cellspacing=0 cellpadding=0 border=0 width=100% id=iblue><tr><td><TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4><tr><td bgcolor="'.$config['site']['vdarkborder'].'" CLASS=white><B>'.$lang['site']['CHAR_SEARCH_T_1'].'</B></td></tr><tr><td bgcolor="'.$config['site']['darkborder'].'"><TABLE BORDER=0 CELLPADDING=1><tr><td>'.$lang['site']['CHAR_SEARCH_T_2'].'</td><td><INPUT NAME="name" VALUE="" SIZE=26 MAXLENGTH=29></td><td><INPUT TYPE=image NAME="Submit" SRC="'.$layout_name.'/images/buttons/submit.png" BORDER=0 WIDTH=120 HEIGHT=18></td></tr></table></td></tr></table></td></tr></table></FORM>';
	}
	// SEARCH ERROR END
	}

	?>
