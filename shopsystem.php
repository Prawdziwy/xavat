<?php
	if($config['site']['shop_system'] == 1)
	{
		if($logged)
			$user_premium_points = $account_logged->getCustomField('premium_points');
		else
			$user_premium_points = '<i>login first</i>';
	
	
		function getItemByID($id)
		{
			$id = (int)$id;
			global $db;
			$data = $db->query("SELECT * FROM `z_shop_offer` WHERE `id` = " . $db->quote($id) . ";")->fetch();
			if($data['offer_type'] == 'pacc')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['days'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'donator')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'magicans')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'knights')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'paladins')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'all')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'others')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			elseif($data['offer_type'] == 'container')
			{
				$offer['id'] = $data['id'];
				$offer['type'] = $data['offer_type'];
				$offer['container_id'] = $data['itemid2'];
				$offer['container_count'] = $data['count2'];
				$offer['item_id'] = $data['itemid1'];
				$offer['item_count'] = $data['count1'];
				$offer['points'] = $data['points'];
				$offer['description'] = $data['offer_description'];
				$offer['name'] = $data['offer_name'];
			}
			
			return $offer;
		}

		function getOfferArray()
		{
			global $db;
			$offer_list = $db->query("SELECT * FROM `z_shop_offer` WHERE `hidden` = 0 ORDER BY `sort` ASC;")->fetchAll();
			$i_pacc = 0;
			$i_donator = 0;
			$i_magicans = 0;
			$i_knights = 0;
			$i_paladins = 0;
			$i_all = 0;
			$i_others = 0;
			$i_container = 0;
			
			foreach($offer_list as $data)
			{
				if ($data['offer_type'] == 'pacc')
				{
					$offer_array['pacc'][$i_pacc]['id'] = $data['id'];
					$offer_array['pacc'][$i_pacc]['days'] = $data['count1'];
					$offer_array['pacc'][$i_pacc]['points'] = $data['points'];
					$offer_array['pacc'][$i_pacc]['description'] = $data['offer_description'];
					$offer_array['pacc'][$i_pacc]['name'] = $data['offer_name'];
					$i_pacc++;
				}
				elseif ($data['offer_type'] == 'donator')
				{
					$offer_array['donator'][$i_donator]['id'] = $data['id'];
					$offer_array['donator'][$i_donator]['item_id'] = $data['itemid1'];
					$offer_array['donator'][$i_donator]['item_count'] = $data['count1'];
					$offer_array['donator'][$i_donator]['points'] = $data['points'];
					$offer_array['donator'][$i_donator]['description'] = $data['offer_description'];
					$offer_array['donator'][$i_donator]['name'] = $data['offer_name'];
					$i_donator++;
				}
				elseif ($data['offer_type'] == 'magicans')
				{
					$offer_array['magicans'][$i_magicans]['id'] = $data['id'];
					$offer_array['magicans'][$i_magicans]['item_id'] = $data['itemid1'];
					$offer_array['magicans'][$i_magicans]['item_count'] = $data['count1'];
					$offer_array['magicans'][$i_magicans]['points'] = $data['points'];
					$offer_array['magicans'][$i_magicans]['description'] = $data['offer_description'];
					$offer_array['magicans'][$i_magicans]['name'] = $data['offer_name'];
					$i_magicans++;
				}
				elseif ($data['offer_type'] == 'knights')
				{
					$offer_array['knights'][$i_knights]['id'] = $data['id'];
					$offer_array['knights'][$i_knights]['item_id'] = $data['itemid1'];
					$offer_array['knights'][$i_knights]['item_count'] = $data['count1'];
					$offer_array['knights'][$i_knights]['points'] = $data['points'];
					$offer_array['knights'][$i_knights]['description'] = $data['offer_description'];
					$offer_array['knights'][$i_knights]['name'] = $data['offer_name'];
					$i_knights++;
				}
				elseif ($data['offer_type'] == 'paladins')
				{
					$offer_array['paladins'][$i_paladins]['id'] = $data['id'];
					$offer_array['paladins'][$i_paladins]['item_id'] = $data['itemid1'];
					$offer_array['paladins'][$i_paladins]['item_count'] = $data['count1'];
					$offer_array['paladins'][$i_paladins]['points'] = $data['points'];
					$offer_array['paladins'][$i_paladins]['description'] = $data['offer_description'];
					$offer_array['paladins'][$i_paladins]['name'] = $data['offer_name'];
					$i_paladins++;
				}
				elseif ($data['offer_type'] == 'all')
				{
					$offer_array['all'][$i_all]['id'] = $data['id'];
					$offer_array['all'][$i_all]['item_id'] = $data['itemid1'];
					$offer_array['all'][$i_all]['item_count'] = $data['count1'];
					$offer_array['all'][$i_all]['points'] = $data['points'];
					$offer_array['all'][$i_all]['description'] = $data['offer_description'];
					$offer_array['all'][$i_all]['name'] = $data['offer_name'];
					$i_all++;
				}
				elseif ($data['offer_type'] == 'others')
				{
					$offer_array['others'][$i_others]['id'] = $data['id'];
					$offer_array['others'][$i_others]['item_id'] = $data['itemid1'];
					$offer_array['others'][$i_others]['item_count'] = $data['count1'];
					$offer_array['others'][$i_others]['points'] = $data['points'];
					$offer_array['others'][$i_others]['description'] = $data['offer_description'];
					$offer_array['others'][$i_others]['name'] = $data['offer_name'];
					$i_others++;
				}
				elseif ($data['offer_type'] == 'container')
				{
					$offer_array['container'][$i_container]['id'] = $data['id'];
					$offer_array['container'][$i_container]['container_id'] = $data['itemid2'];
					$offer_array['container'][$i_container]['container_count'] = $data['count2'];
					$offer_array['container'][$i_container]['item_id'] = $data['itemid1'];
					$offer_array['container'][$i_container]['item_count'] = $data['count1'];
					$offer_array['container'][$i_container]['points'] = $data['points'];
					$offer_array['container'][$i_container]['description'] = $data['offer_description'];
					$offer_array['container'][$i_container]['name'] = $data['offer_name'];
					$i_container++;
				}
			}
			
			return $offer_array;
		}
	
		if(empty($action))
		{
			unset($_SESSION['viewed_confirmation_page']);
			$main_content .= '<h2><center>Welcome to ' . $config['server']['serverName'] . ' Shop.</center></h2>';
			
			$query = $db->query("SELECT * FROM `z_shop_offer`WHERE `offer_type` NOT LIKE 'container' AND `offer_type` NOT LIKE 'changename' ORDER BY `bought` DESC LIMIT 3"); 
			foreach($query as $rows)
			{      
				if(is_int($number_of_rows / 2)) { $bgcolor = $config['site']['darkborder']; } else { $bgcolor = $config['site']['lightborder']; } 
				$number_of_rows++; 
				$result .= ' 
				<td bgcolor='.$bgcolor.'> 
					<center> 
						<img src="images/items/'.$rows['itemid1'].'.gif"> <br /><br /> 
						<b>'.$rows['offer_name'].'</b><br /> 
						Points: <b>'.$rows['points'].'</b><br /><br />';
						
						if(!$logged)
							$result .= 'Login to Buy';
						else
							$result .= '
							<form action="index.php?subtopic=shopsystem&action=select_player" method=POST> 
								<input type="hidden" name="buy_id" value="'.$rows['id'].'">
								<input type="image" src="' . $layout_name . '/images/buttons/buy.png" value="Buy">
							</form>';
							
							$result .= '
					</center> 
				</td>'; 
			} 

			$main_content .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\" id=\"iblue\"><tr bgcolor=".$config['site']['vdarkborder']."><td class=\"white\" colspan=\"3\"><center><strong>The most popular items in SMS Shop!</strong></center></td></tr><tr bgcolor=".$config['site']['vdarkborder']."><td class=\"white\" width=\"33%\"><b><center>#1</center></b></td><td class=\"white\" width=\"33%\"><b><center>#2</center></b></td><td class=\"white\" widht=\"33%\"><b><center>#3</center></b></td></tr>".$result."</table> <br />";  
			
			$offer_list = getOfferArray();
		
			$z = 0;
			if(count($offer_list['donator']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">Donator Items</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['donator'] as $item)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $item['item_id'] . '.gif"></td>
							<td><strong>' . $item['name'] . '</strong> (' . $item['points'] . ' points)<br /><i>' . $item['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$item['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$item['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table>';
			}
			
			$z = 0;
			if(count($offer_list['magicans']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">Sorcerer and Druid Items</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['magicans'] as $item)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $item['item_id'] . '.gif"></td>
							<td><strong>' . $item['name'] . '</strong> (' . $item['points'] . ' points)<br /><i>' . $item['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$item['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$item['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table>';
			}
			
			$z = 0;
			if(count($offer_list['paladins']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">Paladin Items</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['paladins'] as $item)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $item['item_id'] . '.gif"></td>
							<td><strong>' . $item['name'] . '</strong> (' . $item['points'] . ' points)<br /><i>' . $item['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$item['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$item['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table>';
			}
			
			$z = 0;
			if(count($offer_list['knights']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">Knight Items</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['knights'] as $item)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $item['item_id'] . '.gif"></td>
							<td><strong>' . $item['name'] . '</strong> (' . $item['points'] . ' points)<br /><i>' . $item['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$item['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$item['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table>';
			}
			
			$z = 0;
			if(count($offer_list['all']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">All Profession Items</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['all'] as $item)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $item['item_id'] . '.gif"></td>
							<td><strong>' . $item['name'] . '</strong> (' . $item['points'] . ' points)<br /><i>' . $item['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$item['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$item['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table>';
			}
			
			$z = 0;
			if(count($offer_list['others']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">Others</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['others'] as $item)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $item['item_id'] . '.gif"></td>
							<td><strong>' . $item['name'] . '</strong> (' . $item['points'] . ' points)<br /><i>' . $item['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$item['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$item['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table>';
			}
			
			$z = 0;
			if(count($offer_list['container']) > 0)
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td colspan="3" style="font-weight: bold;">Containers</td>
					</tr>
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td width="50" align="center" style="font-weight: bold;">Picture</td>
						<td width="350" align="left" style="font-weight: bold;">Description</td>
						<td width="250" align="center" style="font-weight: bold;">Select product</td>
					</tr>';
					
					foreach($offer_list['container'] as $container)
					{
						$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .= '
						<tr bgcolor="' . $bgcolor . '">
							<td align="center"><img src="images/items/' . $container['item_id'] . '.gif"></td>
							<td><strong>' . $container['name'] . '</strong> (' . $container['points'] . ' points)<br /><i>' . $container['description'] . '</i></td>
							<td align="center">' . (!$logged ? "Login to Buy" : "<form action=\"?subtopic=shopsystem&action=select_player\" method=\"POST\"><input type=\"hidden\" name=\"buy_id\" value=\"{$container['id']}\"><input type=\"image\" src=\"{$layout_name}/images/buttons/buy.png\" value=\"Buy\"><br /><b>for {$container['points']} points</b></form>") . '</td>
						</tr>';
						
						$z++;
					}
					
					$main_content .= '
				</table><br />';
			}
		}
		elseif($action == 'select_player')
		{
			unset($_SESSION['viewed_confirmation_page']);
			if(!$logged)
				$main_content .= 'Please login first.';
			else
			{
				$buy_id = (int) $_REQUEST['buy_id'];
				if(empty($buy_id))
					$main_content .= 'Please <a href="?subtopic=shopsystem">select item</a> first.';
				else
				{
					$buy_offer = getItemByID($buy_id);
					if(isset($buy_offer['id']))
					{
						if($buy_offer['type'] != 'changename')
						{
							if($user_premium_points >= $buy_offer['points'])
							{
								$main_content .= '
								<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
									<tr bgcolor="' . $config['site']['vdarkborder'] . '">
										<td colspan="2" class="white" style="font-weight: bold;">Selected Offer</td>
									</tr>
									<tr bgcolor="' . $config['site']['darkborder'] . '">
										<td width="20%" style="font-weight: bold;">Name:</td>
										<td>' . $buy_offer['name'] . '</td>
									</tr>
									<tr bgcolor="' . $config['site']['lightborder'] . '">
										<td width="20%" style="font-weight: bold;">Description:</td>
										<td>' . $buy_offer['description'] . '</td>
									</tr>
								</table><br />
								
								<form action="?subtopic=shopsystem&action=confirm_transaction" method="POST">
									<input type="hidden" name="buy_id" value="' . $buy_id . '">
									<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
										<tr bgcolor="' . $config['site']['vdarkborder'] . '">
											<td colspan="2" class="white" style="font-weight: bold;">Give ITEM/PACC to player from your account</td>
										</tr>
										<tr bgcolor="' . $config['site']['darkborder'] . '">
											<td width="20%" style="font-weight: bold;">Name:</td>
											<td><select name="buy_name">';
												$players_from_logged_acc = $account_logged->getPlayersList();
												if(count($players_from_logged_acc) > 0)
												{
													$players_from_logged_acc->orderBy('name');
													foreach($players_from_logged_acc as $player)
													{
														$main_content .= '<option>' . $player->getName() . '</option>';
													}
												}
												else
												{
													$main_content .= 'You don\'t have any character on your account.';
												}
												$main_content .= '
												</select> 
												<input type="image" name="Submit" src="' . $layout_name . '/images/buttons/submit.png" border="0" width="120" height="18">
											</td>
										</tr>
									</table>
								</form><br />
							
								<form action="?subtopic=shopsystem&action=confirm_transaction" method="POST">
									<input type="hidden" name="buy_id" value="' . $buy_id . '">
									<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
										<tr bgcolor="' . $config['site']['vdarkborder'] . '">
											<td colspan="2" class="white" style="font-weight: bold;">Give ITEM/PACC to other player</td>
										</tr>
										<tr bgcolor="' . $config['site']['darkborder'] . '">
											<td width="20%" style="font-weight: bold;">To player (name):</td>
											<td><input type="text" name="buy_name"></td>
										</tr>
										<tr bgcolor="' . $config['site']['lightborder'] . '">
											<td width="20%" style="font-weight: bold;">From</td>
											<td><input type="text" name="buy_from"> <input type="image" name="Submit" src="' . $layout_name . '/images/buttons/give.png" border="0" width="120" height="18"> - your nick, \'empty\' = Anonymous</td>
										</tr>
									</table>
								</form><br />';
							}
							else
							{
								$main_content .= '<br />For this item you need <b>' . $buy_offer['points'] . '</b> points. You have only <b>' . $user_premium_points . '</b> premium points. Please <a href="?subtopic=shopsystem">select other item</a> or buy premium points.';
							}
						}
					}
					else
					{
						$main_content .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="subtopic=shopsystem">select item</a> again.';
					}
				}
			}
		}
		elseif($action == 'confirm_transaction')
		{
			if(!$logged)
				$main_content .= 'Please login first.';
			else
			{
				$buy_id = (int)$_POST['buy_id'];
				$buy_name = stripslashes(urldecode($_POST['buy_name']));
				$buy_from = stripslashes(urldecode($_POST['buy_from']));
				if(empty($buy_id))
					$main_content .= 'Please <a href="?subtopic=shopsystem">select item</a> first.';
				else
				{
					if($buy_offer['type'] == 'changename')
					{
						if(!check_name_new_char($buy_from))
						{
							$main_content .= 'Invalid name format of new name.';
						}
					}
					else
					{
						$buy_offer = getItemByID($buy_id);
						$check_name_in_database = $ots->createObject('Player');
						$check_name_in_database->find($buy_from);
					
						if(isset($buy_offer['id']))
						{
							if($user_premium_points >= $buy_offer['points'])
							{
								if(check_name($buy_name))
								{
									$buy_player = new OTS_Player();
									$buy_player->find($buy_name);
									if($buy_player->isLoaded())
									{
										$buy_player_account = $buy_player->getAccount();
										if($_SESSION['viewed_confirmation_page'] == 'yes' && $_POST['buy_confirmed'] == 'yes')
										{
											if($buy_offer['type'] == 'pacc')
											{
												$player_premdays = $buy_player_account->getCustomField('premdays');
												$player_lastlogin = $buy_player_account->getCustomField('lastday');
												
												$db->query('INSERT INTO '.$db->tableName('z_shop_history_pacc').' (id, to_name, to_account, from_nick, from_account, price, pacc_days, trans_state, trans_start, trans_real) VALUES (NULL, '.$db->quote($buy_player->getName()).', '.$db->quote($buy_player_account->getId()).', '.$db->quote($buy_from).',  '.$db->quote($account_logged->getId()).', '.$db->quote($buy_offer['points']).', '.$db->quote($buy_offer['days']).', \'realized\', '.$db->quote(time()).', '.$db->quote(time()).');');
												$db->query('UPDATE `z_shop_offer` SET `bought` = bought + 1 WHERE `id` ='.$buy_offer['id'].';');  
												
												$buy_player_account->setCustomField('premdays', $player_premdays + $buy_offer['days']);
												$account_logged->setCustomField('premium_points', $user_premium_points - $buy_offer['points']);
												$user_premium_points = $user_premium_points - $buy_offer['points'];
												
												if($player_premdays == 0)
													$buy_player_account->setCustomField('lastday', time());
													
												$main_content .= '<h2>PACC added!</h2><b>' . $buy_offer['days'] . ' days</b> of Premium Account added to account of player <b>' . $buy_player->getName() . '</b> for <b>' . $buy_offer['points'] . ' premium points</b> from your account.<br />Now you have <b>' . $user_premium_points . ' premium points</b>.<br /><a href="?subtopic=shopsystem">Back</a>';
											}
											elseif($buy_offer['type'] == 'donator' || $buy_offer['type'] == 'magicans' || $buy_offer['type'] == 'knights' || $buy_offer['type'] == 'paladins' || $buy_offer['type'] == 'all' || $buy_offer['type'] == 'others')
											{
												$db->query('INSERT INTO '.$db->tableName('z_ots_comunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$db->quote($buy_player->getName()).', \'login\', \'give_item\', '.$db->quote($buy_offer['item_id']).', '.$db->quote($buy_offer['item_count']).', \'\', \'\', \'item\', '.$db->quote($buy_offer['name']).', \'\', \'1\');');
												$db->query('INSERT INTO '.$db->tableName('z_shop_history_item').' (id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real) VALUES ('.$db->lastInsertId().', '.$db->quote($buy_player->getName()).', '.$db->quote($buy_player_account->getId()).', '.$db->quote($buy_from).',  '.$db->quote($account_logged->getId()).', '.$db->quote($buy_offer['points']).', '.$db->quote($buy_offer['name']).', \'wait\', '.$db->quote(time()).', \'0\');');
												$db->query('UPDATE `z_shop_offer` SET `bought` = `bought` + 1 WHERE `id` =' . $buy_offer['id'] . ';');  
												
												$account_logged->setCustomField('premium_points', $user_premium_points - $buy_offer['points']);
												$user_premium_points = $user_premium_points - $buy_offer['points'];
												
												$main_content .= '<div id="tdno"><table><tr><td id="ired"><b>Item added!</b></td></tr><tr><td id="tdno"><b>'.$buy_offer['name'].'</b> added to player <b>'.$buy_player->getName().'</b> items (he will get this items after relog) for <b>'.$buy_offer['points'].' premium points</b> from your account.</td></tr><tr><td id="igreen">Now you have <b>'.$user_premium_points.' premium points</b>.<a href="?subtopic=shopsystem">&nbsp;GO TO MAIN SHOP SITE</a></td></tr></table></div>';
											}
											elseif($buy_offer['type'] == 'container')
											{
												$sql = 'INSERT INTO '.$db->tableName('z_ots_comunication').' (id, name, type, action, param1, param2, param3, param4, param5, param6, param7, delete_it) VALUES (NULL, '.$db->quote($buy_player->getName()).', \'login\', \'give_item\', '.$db->quote($buy_offer['item_id']).', '.$db->quote($buy_offer['item_count']).', '.$db->quote($buy_offer['container_id']).', '.$db->quote($buy_offer['container_count']).', \'container\', '.$db->quote($buy_offer['name']).', \'\', \'1\');';
												$db->query($sql);
												$save_transaction = 'INSERT INTO '.$db->tableName('z_shop_history_item').' (id, to_name, to_account, from_nick, from_account, price, offer_id, trans_state, trans_start, trans_real) VALUES ('.$db->lastInsertId().', '.$db->quote($buy_player->getName()).', '.$db->quote($buy_player_account->getId()).', '.$db->quote($buy_from).',  '.$db->quote($account_logged->getId()).', '.$db->quote($buy_offer['points']).', '.$db->quote($buy_offer['name']).', \'wait\', '.$db->quote(time()).', \'0\');';
												$db->query($save_transaction);
												$account_logged->setCustomField('premium_points', $user_premium_points-$buy_offer['points']);
												$user_premium_points = $user_premium_points - $buy_offer['points'];
												$main_content .= '<div id="tdno"><table><tr><td id="ired"><b>Container of items has been added!</b></td></tr><tr><td id="tdno"><b>'.$buy_offer['name'].'</b> added to player <b>'.$buy_player->getName().'</b> items (he will get this items after relog) for <b>'.$buy_offer['points'].' premium points</b> from your account.</td></tr><tr><td id="igreen">Now you have <b>'.$user_premium_points.' premium points</b>.<a href="?subtopic=shopsystem">&nbsp;GO TO MAIN SHOP SITE</a></td></tr></table></div>';
											}
										}
										else
										{
											if($buy_offer['type'] != 'changename')
											{
												$set_session = TRUE;
												$_SESSION['viewed_confirmation_page'] = 'yes';
												
												$main_content .= '
												<div id="tdno"><table border="0" cellpadding="1" cellspacing="1" width="100%">
												<tr bgcolor="black"><td id="ired" colspan="3"><font size="4"><b>Confirm transaction</b></font></td></tr>
												<tr bgcolor="FFDEAD"><td id="tdno" width="100"><b>Name:</b></td><td id="tdno" width="550" colspan="2">'.$buy_offer['name'].'</td></tr>
												<tr bgcolor="FFDEAD"><td id="tdno" width="100"><b>Description:</b></td><td id="tdno" width="550" colspan="2">'.$buy_offer['description'].'</td></tr>
												<tr bgcolor="FFDEAD"><td id="tdno" width="100"><b>Cost:</b></td><td id="tdno" width="550" colspan="2"><b>'.$buy_offer['points'].' premium points</b> from your account</td></tr>
												<tr bgcolor="FFDEAD"><td id="tdno" width="100"><b>For Player:</b></td><td id="tdno" width="550" colspan="2"><font color="red">'.$buy_player->getName().'</font></td></tr>
												<tr bgcolor="FFDEAD"><td id="tdno" width="100"><b>From:</b></td><td id="tdno" width="550" colspan="2"><font color="red">'.$buy_from.'</font></td></tr>
												<tr bgcolor="FFDEAD"><td id="tdno" width="100"><b>Transaction?</b></td><td id="tdno" width="275" align="left">
												<form action="?subtopic=shopsystem&action=confirm_transaction" method="POST"><input type="hidden" name="buy_confirmed" value="yes"><input type="hidden" name="buy_id" value="'.$buy_id.'"><input type="hidden" name="buy_from" value="'.urlencode($new_name).'"><input type="hidden" name="buy_name" value="'.urlencode($buy_name).'"><input type="submit" value="Accept"></form></td>
												<td id="tdno" align="right"><form action="?subtopic=shopsystem" method="POST"><input type="submit" value="Cancel"></form></td></tr>
												</table></div>';
											}
											else
											{
												$set_session = TRUE;
												$_SESSION['viewed_confirmation_page'] = 'yes';
												
												$main_content .= '<h2>Confirm change name</h2>
												<table border="0" cellpadding="1" cellspacing="1" width="650">
												<tr bgcolor="black"><td colspan="3"><font color="gold" size="4"><b>Confirm transaction</b></font></td></tr>
												<tr bgcolor="FFDEAD"><td width="100"><b>Name:</b></td><td width="550" colspan="2">'.$buy_offer['name'].'</td></tr>
												<tr bgcolor="FFDEAD"><td width="100"><b>Description:</b></td><td width="550" colspan="2">'.$buy_offer['description'].'</td></tr>
												<tr bgcolor="FFDEAD"><td width="100"><b>Cost:</b></td><td width="550" colspan="2"><b>'.$buy_offer['points'].' premium points</b> from your account</td></tr>
												<tr bgcolor="FFDEAD"><td width="100"><b>Current Name:</b></td><td width="550" colspan="2"><font color="red">'.$buy_player->getName().'</font></td></tr>
												<tr bgcolor="FFDEAD"><td width="100"><b>New Name:</b></td><td width="550" colspan="2"><font color="red">'.$buy_from.'</font></td></tr>
												<tr bgcolor="red"><td width="100"><b>Change Name?</b></td><td width="275" align="left">
												<form action="?subtopic=shopsystem&action=confirm_transaction" method="POST"><input type="hidden" name="buy_confirmed" value="yes"><input type="hidden" name="buy_id" value="'.$buy_id.'"><input type="hidden" name="buy_from" value="'.urlencode($buy_from).'"><input type="hidden" name="buy_name" value="'.urlencode($buy_name).'"><input type="submit" value="Accept"></form></td>
												<td align="right"><form action="?subtopic=shopsystem" method="POST"><input type="submit" value="Cancel"></form></td></tr>
												</table>';
											}
										}
									}
									else
									{
										$main_content .= 'Player with name <b>'.$buy_name.'</b> doesn\'t exist. Please <a href="?subtopic=shopsystem&action=select_player&buy_id='.$buy_id.'">select other name</a>.';
									}
								}
								else
								{
									$main_content .= 'Invalid name format. Please <a href="?subtopic=shopsystem&action=select_player&buy_id='.$buy_id.'">select other name</a> or contact with administrator.';
								}
							}
							else
							{
								$main_content .= 'For this item you need <b>'.$buy_offer['points'].'</b> points. You have only <b>'.$user_premium_points.'</b> premium points. Please <a href="?subtopic=shopsystem">select other item</a> or buy premium points.';
							}
						}
						else
						{
							$main_content .= 'Offer with ID <b>'.$buy_id.'</b> doesn\'t exist. Please <a href="?subtopic=shopsystem">select item</a> again.';
						}
					}
				}
			}
			
			if(!$set_session)
				unset($_SESSION['viewed_confirmation_page']);
		}
		elseif($action == 'show_history')
		{
			if(!$logged)
				$main_content .= 'Please login first.';
			else
			{
				$items_history_received = $db->query('SELECT * FROM '.$db->tableName('z_shop_history_item').' WHERE '.$db->fieldName('to_account').' = '.$db->quote($account_logged->getId()).' OR '.$db->fieldName('from_account').' = '.$db->quote($account_logged->getId()).';');
				if(is_object($items_history_received))
				{
					foreach($items_history_received as $item_received)
					{
						if($account_logged->getId() == $item_received['to_account'])
							$char_color = 'green';
						else
							$char_color = 'red';
						$items_received_text .= '<tr bgcolor="'.$config['site']['lightborder'].'"><td><font color="'.$char_color.'">'.$item_received['to_name'].'</font></td><td>';
						if($account_logged->getId() == $item_received['from_account'])
							$items_received_text .= '<i>Your account</i>';
						else
							$items_received_text .= $item_received['from_nick'];
						$items_received_text .= '</td><td>'.$item_received['offer_id'].'</td><td>'.date("j F Y, H:i:s", $item_received['trans_start']).'</td>';
						if($item_received['trans_real'] > 0)
							$items_received_text .= '<td>'.date("j F Y, H:i:s", $item_received['trans_real']).'</td>';
						else
							$items_received_text .= '<td><b><font color="red">Not realized yet.</font></b></td>';
						$items_received_text .= '</tr>';
					}
				}
				$paccs_history_received = $db->query('SELECT * FROM '.$db->tableName('z_shop_history_pacc').' WHERE '.$db->fieldName('to_account').' = '.$db->quote($account_logged->getId()).' OR '.$db->fieldName('from_account').' = '.$db->quote($account_logged->getId()).';');
				if(is_object($paccs_history_received)) {
					foreach($paccs_history_received as $pacc_received)
					{
						if($account_logged->getId() == $pacc_received['to_account'])
							$char_color = 'green';
						else
							$char_color = 'red';
						$paccs_received_text .= '<tr bgcolor="FFDEAD"><td><font color="'.$char_color.'">'.$pacc_received['to_name'].'</font></td><td>';
						if($account_logged->getId() == $pacc_received['from_account'])
							$paccs_received_text .= '<i>Your account</i>';
						else
							$paccs_received_text .= $pacc_received['from_nick'];
						$paccs_received_text .= '</td><td>'.$pacc_received['pacc_days'].' days</td><td>'.$pacc_received['price'].' Points</td><td>'.date("j F Y, H:i:s", $pacc_received['trans_real']).'</td></tr>';
					}
				}
				$main_content .= '<center><h1>Transactions History</h1></center>';
				if(!empty($items_received_text))
				{
					$main_content .= '<table BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100% id=iblue><tr><td><table BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100% id=iblue><tr bgcolor="'.$config['site']['vdarkborder'].'"><td><b>To:</b></td><td><b>From:</b></td><td><b>Offer name</b></td><td><b>Bought on page</b></td><td><b>Received on Karmia</b></td></tr>'.$items_received_text.'</table></td></tr></table><br />';
				}
				if(!empty($paccs_received_text))
				{
					$main_content .= '<table BORDER=0 CELLPADDING=1 CELLSPACING=1 WIDTH=100%><tr bgcolor="'.$config['site']['vdarkborder'].'"><td><b>To:</b></td><td><b>From:</b></td><td><b>Duration</b></td><td><b>Cost</b></td><td><b>Added:</b></td></tr>'.$paccs_received_text.'</table><br />';
				}
				if(empty($paccs_received_text) && empty($items_received_text))
					$main_content .= 'You did not buy/receive any item or PACC.';
			}
		}
	
		if($logged)
			$main_content .= '<h3><div class="alert alert-success">You have ' . $user_premium_points . ' premium points.</div></h3>';
		else
			$main_content .= '<h3><div class="alert alert-error">You must be logged to check your premium points.</div></h3>';
	}
	
	?>
