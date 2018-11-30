<?PHP
	$lang['monsters']['nameDesc'] = 'Name DESC';
	$lang['monsters']['name'] = 'Name';
	$lang['monsters']['healthDesc'] = 'Health DESC';
	$lang['monsters']['health'] = 'Health';
	$lang['monsters']['expDesc'] = 'Experience DESC';
	$lang['monsters']['exp'] = 'Experience';
	$lang['monsters']['sumonableDesc'] = 'Summonable Mana DESC';
	$lang['monsters']['sumonable'] = 'S~able Mana';
	$lang['monsters']['convinceableDesc'] = 'Convinceable Mana DESC';
	$lang['monsters']['convinceable'] = 'C~ble Mana';
	$lang['monsters']['raceDesc'] = 'Race DESC';
	$lang['monsters']['race'] = 'Race';
	
	$lang['monsters']['health'] = 'Health:';
	$lang['monsters']['giveexp'] = 'Experience:';
	$lang['monsters']['speedlike'] = 'Speed Like:';
	$lang['monsters']['speedlvl'] = 'level';
	$lang['monsters']['speedcanhaste'] = 'Can use haste';
	$lang['monsters']['summon'] = 'Summon:';
	$lang['monsters']['impossible'] = 'Impossible';
	$lang['monsters']['convince'] = 'Convince:';
	$lang['monsters']['immunities'] = 'Immunities:';
	$lang['monsters']['voices'] = 'Voices:';
	$lang['monsters']['image'] = 'Image';
	$lang['monsters']['maxcount'] = 'Max Count';
	$lang['monsters']['itemname'] = 'Name';
	$lang['monsters']['droprate'] = 'Drop Rate';
	$lang['monsters']['hideinside'] = 'Hide items inside...';
	$lang['monsters']['showinside'] = 'Show items inside...';
	
	$lang['monsters']['ratenote'][1] = 'Drop rate is counted by Real Tibia drop rate and multipled by our server drop rate!';
	$lang['monsters']['ratenote'][2] = 'Drop rate is a rate of drop one item not maximum count of items, for example: Drop rate of gold coins will be relate to chance of one coin drop.';
	$lang['monsters']['error'][1][1] = 'Monster with name';
	$lang['monsters']['error'][1][2] = 'doesn\'t exist.';

if( empty($_REQUEST['creature']) ) 
{
	$main_content .= '
	<table cellspacing="0" cellpadding="0" border="0" width="100%"  id="iblue">
		<tr>
			<td>';
			
	//SHOW MONSTERS LIST
	$allowed_order_by = array('name', 'exp', 'health', 'summonable', 'convinceable', 'race');
	$order = $_REQUEST['order'];
	
	//generate sql query
	if( $_REQUEST['desc'] == 1 ) 
	{
		$desc = " DESC";
	}
	
	if( $order == 'name' ) 
	{
		$whereandorder = ' ORDER BY name'.$desc;
	}
	elseif( $order == 'exp' ) 
	{
		$whereandorder = ' ORDER BY exp'.$desc.', name';
	}
	elseif( $order == 'health' ) 
	{
		$whereandorder = ' ORDER BY health'.$desc.', name';
	}
	elseif( $order == 'summonable' ) 
	{
		$whereandorder = ' AND summonable = 1 ORDER BY mana'.$desc;
	}
	elseif( $order == 'convinceable' ) 
	{
		$whereandorder = ' AND convinceable = 1 ORDER BY mana'.$desc;
	}
	elseif( $order == 'race' ) 
	{
		$whereandorder = ' ORDER BY race'.$desc.', name';
	}
	else
	{
		$whereandorder = ' ORDER BY name';
	}
	
	//send query to database
	$monsters = $db->query('SELECT * FROM '.$db->tableName('z_monsters').' WHERE hide_creature != 1'.$whereandorder);
	
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr style="background: '.$config['site']['vdarkborder'].'" align="center">';
	
				if( $order == 'name' && !isset($_REQUEST['desc']) ) 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=name&desc=1" class="white">'.$lang['monsters']['nameDesc'].'</a></td>';
				} 
				else 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=name" class="white">'.$lang['monsters']['name'].'</a></td>';
				}
				
				if( $order == 'health' && !isset($_REQUEST['desc']) ) 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=health&desc=1" class="white">'.$lang['monsters']['healthDesc'].'</a></td>';
				} 
				else 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=health" class="white">'.$lang['monsters']['health'].'</a></td>';
				}
				
				if( $order == 'exp' && !isset($_REQUEST['desc']) ) 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=exp&desc=1" class="white">'.$lang['monsters']['expDesc'].'</a></td>';
				} 
				else 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=exp" class="white">'.$lang['monsters']['exp'].'</a></td>';
				}
				
				if( $order == 'summonable' && !isset($_REQUEST['desc']) ) 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=summonable&desc=1" class="white">'.$lang['monsters']['sumonableDesc'].'</a></td>';
				} 
				else 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=summonable" class="white">'.$lang['monsters']['sumonable'].'</a></td>';
				}
				
				if( $order == 'convinceable' && !isset($_REQUEST['desc']) ) 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=convinceable&desc=1" class="white">'.$lang['monsters']['convinceableDesc'].'</a></td>';
				} 
				else 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=convinceable" class="white">'.$lang['monsters']['convinceable'].'</a></td>';
				}
			
				if( $order == 'race' && !isset($_REQUEST['desc']) ) 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=race&desc=1" class="white">'.$lang['monsters']['raceDesc'].'</a></td></tr>';
				} 
				else 
				{
					$main_content .= '
					<td class="white"><a href="?subtopic=creatures&order=race" class="white">'.$lang['monsters']['race'].'</a></td></tr>';
				}
	
				foreach( $monsters as $monster ) 
				{
					if( is_int($number_of_rows / 2) ) 
					{ 
						$bgcolor = $config['site']['lightborder']; 
					} 
					else 
					{ 
						$bgcolor = $config['site']['darkborder']; 
					} 
					
					$number_of_rows++;
					
					$main_content .= '
					<tr style="background: '.$bgcolor.'">
						<td><a href="?subtopic=creatures&creature='.urlencode($monster['name']).'">'.$monster['name'].'</a></td>
						<td>'.$monster['health'].'</td>
						<td>'.$monster['exp'].'</td>';
			
						if( $monster['summonable'] )
						{
							$main_content .= '<td>'.$monster['mana'].'</td>';
						}
						else
						{
							$main_content .= '<td>---</td>';
						}
						
						if( $monster['convinceable'] ) 
						{
							$main_content .= '<td>'.$monster['mana'].'</td>';
						}
						else
						{
							$main_content .= '<td>---</td>';
						}
					
						$main_content .= '
						<td>'.ucwords($monster['race']).'</td></tr>';
				}

				$main_content .= '
				</table>
			</td>
		</tr>
	</table>';
}
else
//SHOW INFORMATION ABOUT MONSTER
{
	$monster_name = stripslashes(trim(ucwords($_REQUEST['creature'])));
	$monster = $db->query('SELECT * FROM '.$db->tableName('z_monsters').' WHERE '.$db->fieldName('hide_creature').' != 1 AND '.$db->fieldName('name').' = '.$db->quote($monster_name).';')->fetch();
				
				if( isset($monster['name']) ) 
				{
					$main_content .= '
					<center><h2>'.$monster['name'].'</h2></center>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr><td width="50%">
							<table border="0" cellspacing="0" cellpadding="0" width="100%" id="iblue">
								<tr ><td>
									<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">';
						
									if( is_int($number_of_rows / 2) ) 
									{ 
										$bgcolor = $config['site']['darkborder']; 
									} 
									else 
									{ 
										$bgcolor = $config['site']['lightborder']; 
									} 
						
									$number_of_rows++;
						
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['health'].'</b></td>
											<td>'.$monster['health'].'</td>
										</tr>';
			
									if( is_int($number_of_rows / 2) ) 
									{ 
										$bgcolor = $config['site']['darkborder']; 
									} 
									else 
									{ 
										$bgcolor = $config['site']['lightborder']; 
									} 
						
									$number_of_rows++;
						
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['giveexp'].'</b></td>
											<td>'.$monster['exp'].'</td>
										</tr>';
			
									if( is_int($number_of_rows / 2) ) 
									{ 
										$bgcolor = $config['site']['darkborder']; 
									} 
									else 
									{ 
										$bgcolor = $config['site']['lightborder']; 
									} 
									
									$number_of_rows++;
						
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['speedlike'].'</b></td>
											<td>'.$monster['speed_lvl'].' '.$lang['monsters']['speedlvl'].'';
											
											if( $monster['use_haste'] ) 
											{
												$main_content .= '<br />('.$lang['monsters']['speedcanhaste'].')';
											}
											
											$main_content .= '
											</td>
										</tr>';
						
									if( $monster['summonable'] == 1 ) 
									{
										if( is_int($number_of_rows / 2) ) 
										{ 
											$bgcolor = $config['site']['darkborder']; 
										}
										else 
										{ 
											$bgcolor = $config['site']['lightborder']; 
										} 
										
										$number_of_rows++;
										
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['summon'].'</b></td>
											<td>'.$monster['mana'].' mana</td>
										</tr>';
									}
									else
									{
										if( is_int($number_of_rows / 2) ) 
										{ 
											$bgcolor = $config['site']['darkborder']; 
										} 
										else 
										{ 
											$bgcolor = $config['site']['lightborder']; 
										} 
										
										$number_of_rows++;
										
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['summon'].'</b></td>
											<td>'.$lang['monsters']['impossible'].'</td>
										</tr>';
									}
			
									if( $monster['convinceable'] == 1 ) 
									{
										if( is_int($number_of_rows / 2) ) 
										{ 
											$bgcolor = $config['site']['darkborder']; 
										} 
										else 
										{ 
											$bgcolor = $config['site']['lightborder']; 
										} 
										
										$number_of_rows++;
										
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['convince'].'</b></td>
											<td>'.$monster['mana'].' mana</td>
										</tr>';
									}
									else
									{
										if( is_int($number_of_rows / 2) ) 
										{ 
											$bgcolor = $config['site']['darkborder']; 
										} 
										else 
										{ 
											$bgcolor = $config['site']['lightborder']; 
										} 
										
										$number_of_rows++;
										
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['convince'].'</b></td>
											<td>'.$lang['monsters']['impossible'].'</td>
										</tr>';
									}
						
									$main_content .= '
									</table>
								</td></tr>
							</table><br>
						</td>
						<td align="center" width="50%">
							<table border="0" cellspacing="1" cellpadding="4" width="100%">
								<tr>
									<td align="center">';
						
									if(file_exists('monsters/'.$monster['gfx_name']) ) 
									{
										$main_content .= '
										<!--<div style="width: 134px; height: 92px; background: url('.$layout_name.'/images/false.png) no-repeat; padding-top: 25px;">-->
											<img src="monsters/'.$monster['gfx_name'].'" height="64" width="64" alt="Monster" />
										<!--</div>-->';
									} 
									else 
									{
										$main_content .= '
										<!--<div style="width: 134px; height: 92px; background: url('.$layout_name.'/images/avatar_bg.png) no-repeat; padding-top: 25px;">-->
											<img src="images/false.png" height="64" width="64" alt="No Photo" />
										<!--</div>-->';
									}
						
									$main_content .= '
									</td>
								</tr>
							</table>
						</td></tr>
						<tr><td colspan="2">
							<table border="0" cellspacing="0" cellpadding="0" width="100%" id="iblue">
								<tr><td>
									<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">';
						
									if( !empty($monster['immunities']) ) 
									{
										if( is_int($number_of_rows / 2) ) 
										{ 
											$bgcolor = $config['site']['darkborder']; 
										} 
										else 
										{ 
											$bgcolor = $config['site']['lightborder']; 
										} 
										
										$number_of_rows++;
										
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['immunities'].'</b></td>
											<td width="100%">'.$monster['immunities'].'</td>
										</tr>';
									}
						
									if( !empty($monster['voices']) ) 
									{
										if( is_int($number_of_rows / 2) ) 
										{ 
											$bgcolor = $config['site']['darkborder']; 
										} 
										else 
										{ 
											$bgcolor = $config['site']['lightborder']; 
										} 
										
										$number_of_rows++;
										
										$main_content .= '
										<tr style="background: '.$bgcolor.'">
											<td width="100"><b>'.$lang['monsters']['voices'].'</b></td>
											<td width="100%">'.$monster['voices'].'</td>
										</tr>';
									}
						
									$main_content .= '
									</table>
								</td></tr>
							</table><br>
						</td></tr>
						<tr><td colspan="2">
							<table border="0" cellspacing="0" cellpadding="0" width="100%" id="iblue">
								<tr><td>
									<table width="100%" cellpadding="4" cellspacing="1" id="iblue">
										<tr style="background: '.$config['site']['vdarkborder'].'">
											<td><b>'.$lang['monsters']['image'].'</b></td>
											<td><b>'.$lang['monsters']['maxcount'].'</b></td>
											<td><b>'.$lang['monsters']['itemname'].'</b></td>
											<td><b>'.$lang['monsters']['droprate'].'</b></td>
										</tr>
										<style type="text/css">';
											for( $n = 1; $n < 100; $n++ )
											{
												$main_content .= '#inside_'.$n.' { display: none; }';
											}
										$main_content .= '
										</style>
										<script type="text/javascript">
										var items = \'off\';
										
										function insideItems()
										{
											if( items == \'off\' )
											{
												for( i = 1; i < 100; i++ )
												{
													if( document.getElementById("inside_" + i) )
													{
														document.getElementById("inside_" + i).style.display = \'table-row\';
														document.getElementById("insideShow").innerHTML = \''.$lang['monsters']['hideinside'].'\';
													}
												}
												
												items = \'on\';
											}
											else
											{
												for( i = 1; i < 100; i++ )
												{
													if( document.getElementById("inside_" + i) )
													{
														document.getElementById("inside_" + i).style.display = \'none\';
														document.getElementById("insideShow").innerHTML = \''.$lang['monsters']['showinside'].'\';
													}
												}
												items = \'off\';
											}
										}
										</script>';
					
										// Monster Loot
										$items = simplexml_load_file($config['site']['server_path'].'data/items/items.xml') or die('<b>Could not load items!</b>'); 
										foreach( $items->item as $v ) 
										{
											$itemList[(int)$v['id']] = $v['name'];
										}
										
										$loadFile = simplexml_load_file($config['site']['server_path'].'data/monster/monsters.xml');
										foreach( $loadFile->monster as $monsters )
										{
											if( $monsters['name'] == $monster['name'] )
											{
												$loadMonFile = simplexml_load_file($config['site']['server_path'].'data/monster/'.$monsters['file'].'');
												
												foreach( $loadMonFile->loot as $monsterLoot )
												{
													foreach( $monsterLoot->item as $item )
													{
														if( isset($item['countmax']) ) 
														{ 
															$countmax = $item['countmax']; 
														} 
														else 
														{ 
															$countmax = '1'; 
														}
														
														// Count Drop Rate
														if( isset($item['chance']) )
														{
															$dropRate = ($item['chance'] / 1000) * $config['server']['rateLoot'];
															$dropRate = round($dropRate, 2);
														}
														else if( isset($item['chance1']) )
														{
															$dropRate = ($item['chance1'] / 1000) * $config['server']['rateLoot'];
															$dropRate = round($dropRate, 2);
														}
														
														// Jeœli drop rate wiêksze ni¿ 100 zniweluj wynik do 100
														$dropRate = ($dropRate > 100) ? '100' : $dropRate;
														
														$main_content .= '
														<tr style="background: '.$config['site']['darkborder'].'">
															<td width="32" height="32"><img src="images/items/'.$item['id'].'.gif" alt="IMG" /></td>
															<td align="center">'.$countmax.'</td>
															<td>&raquo; <span style="font-weight: bold;">'.ucwords($itemList[(int)$item['id']]).'</span></td>
															<td>'.$dropRate.'%</td>
														</tr>';
															
														foreach( $item->inside as $inside )
														{
															$main_content .= '
															<tr style="background: '.$config['site']['lightborder'].'">
																<td></td>
																<td align="center">&raquo;&raquo;</td>
																<td><span style="font-weight: bold; cursor: pointer;" id="insideShow" onclick="insideItems();">'.$lang['monsters']['showinside'].'</span></td>
																<td></td>
															</tr>';
																	
															foreach( $inside->item as $insideItem )
															{
																
																// Count Drop Rate
																if( isset($insideItem['chance']) )
																{
																	$dropRate = ($insideItem['chance'] / 1000) * $config['server']['rateLoot'];
																	$dropRate = round($dropRate, 2);
																}
																else if( isset($insideItem['chance1']) )
																{
																	$dropRate = ($insideItem['chance1'] / 1000) * $config['server']['rateLoot'];
																	$dropRate = round($dropRate, 2);
																}
																
																
																// Jeœli drop rate wiêksze ni¿ 100
																$dropRate = ($dropRate > 100) ? '100' : $dropRate;
																
																if( isset($insideItem['countmax']) ) 
																{ 
																	$countmax = $insideItem['countmax']; 
																} 
																else 
																{ 
																	$countmax = '1'; 
																}
																
																$i++;
																
																$main_content .= '
																<tr id="inside_'.$i.'" style="background: '.$config['site']['lightborder'].'">
																	<td width="32" height="32"><img src="images/items/'.$insideItem['id'].'.gif" alt="IMG" /></td>
																	<td align="center">'.$countmax.'</td>
																	<td>&raquo;&raquo; <span style="font-weight: bold;">'.ucwords($itemList[(int)$insideItem['id']]).'</span></td>
																	<td>'.$dropRate.'%</td>
																</tr>';
															}
														}
													}
												}
											}
										}
										
									$main_content .= '
									</table>
								</td></tr>
							</table>
						</td></tr>
						<tr><td colspan="2"><br><br>
							<span class="note">'.$lang['monsters']['ratenote'][1].'</span>
							<span class="note">'.$lang['monsters']['ratenote'][2].'</span>

						</td></tr>
					</table>';
				}
				else
				{
					$main_content .= '<span class="alert">'.$lang['monsters']['error'][1][1].' <b>'.$monster_name.'</b> '.$lang['monsters']['error'][1][2].'</span>';
				}
	
				//back button
				$main_content .= '
				<br/></br>
				<center>
					<form action="?subtopic=creatures" method="post">
						<input type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/sbutton_back.gif" />
					</form>
				</center>';
}
?>
