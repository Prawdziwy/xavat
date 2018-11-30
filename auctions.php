<?php
	function time_left($integer)
	{
		$weeks = 0;
		$days = 0;
		$hours = 0;
		$minutes = 0;
		$second = 0;
		$return = null;
		if($integer <= 0)
			return "Finished";
			
		$seconds = $integer;
		if($seconds / 60 >= 1)
		{
			$minutes = floor($seconds / 60);
			if($minutes / 60 >= 1)
			{
				$hours = floor($minutes / 60);
				if ($hours / 24 >= 1)
				{
					$days = floor($hours / 24);
					if ($days / 7 >= 1)
					{
						$weeks = floor($days / 7);
						if ($weeks >= 2)
							$return = "$weeks weeks";
						else
							$return = "$weeks week";
					}
					
					$days = $days - (floor($days / 7)) * 7;
					if($weeks >= 1 && $days >= 1)
						$return = "$return, ";
						
					if($days >= 2)
						$return = "$return $days d";
						
					if($days == 1)
						$return = "$return $days d";
						
				}
				
				$hours = $hours - (floor($hours / 24)) * 24;
				if($days >= 1 && $hours >= 1)
					$return = "$return, ";
					
				if($hours >= 2 || $hours == 0)
					$return = "$return $hours h";
					
				if($hours == 1)
					$return = "$return $hours h";
			}
			
			$minutes = $minutes - (floor($minutes / 60)) * 60;
			if($hours >= 1 && $minutes >= 1)
				$return = "$return, ";
				
			if($minutes >= 2 || $minutes == 0)
				$return = "$return $minutes m";
				
			if($minutes == 1)
				$return = "$return $minutes m";
				
		}
		
		$seconds = $integer - (floor($integer / 60)) * 60;
		if ($minutes >= 1 && $seconds >= 1)
			$return = "$return, ";
			
		if ($seconds >= 2 || $seconds == 0)
			$return = "$return $seconds sec";
			
		if ($seconds == 1)
			$return = "$return $seconds sec";
			
		$return = "$return.";
		return $return;
	}
	
	$main_content .= '<script type="text/javascript">function countdown(a,b){if(a<=0){document.getElementById(b).innerHTML="Finished";return 0}setTimeout(countdown,1e3,a-1,b);days=Math.floor(a/(60*60*24));a%=60*60*24;hours=Math.floor(a/(60*60));a%=60*60;minutes=Math.floor(a/60);a%=60;seconds=a;dps="s";hps="s";mps="s";sps="s";if(days==1)dps="";if(hours==1)hps="";if(minutes==1)mps="";if(seconds==1)sps="";innerHTML=days+" day"+dps+" ";innerHTML+=hours+" hour"+hps+" ";innerHTML+=minutes+" minute"+mps+" and ";innerHTML+=seconds+" second"+sps;document.getElementById(b).innerHTML=innerHTML}function checkBuyNow(a,b,c){if(!checkLogin(a))return false;if(b<c){alert("This character cost "+c+". You have only "+b+".");return false}var d=confirm("This character cost "+c+". Do you want to buy it?");if(d)return true;else return false}function checkBid(a,b,c,d){if(!checkLogin(a))return false;var e=window.document.getElementById("bid").value;if(e<=d){alert("Current highest bid is "+d+". You can not bid "+e+".");return false}if(e>c){alert("You can not bid "+e+". You have only "+c+".");return false}if(a==b){var f=confirm("You have highest bid in this auction. Are you sure you want make higher bid?");if(f)return true;else return false}return true}function checkLogin(a){if(a==0){alert("You are not logged in.");return false}return true}var innerHTM</script>';

	$items = items();
	$auction_p = (int)$_GET['auction'];
	if(!empty($auction_p))
	{
		$action = $_GET['action'];
		if($action == "show")
		{
			$main_content .= '
			<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<td style="font-weight: bold;" align="center" colspan="2">Item Informations</td>
				</tr>';
				
				$timers = array();
				$auction = $db->query("SELECT * FROM `items_auctions` WHERE `id` = " . $auction_p)->fetch();
				$main_content .= '
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td style="font-weight: bold;">Picture</td><td><img src="images/items/' . $auction['item'] . '.gif" /></td>
				</tr>

				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td style="font-weight: bold;">Item</td><td>' . $auction['count'] . 'x ' . $items[$auction['item']]['name'] . '</td>
				</tr>';
				
				if(!empty($items[$auctionInfo['item']]['description']))
					$main_content .= '
					<tr bgcolor="' . $config['site']['darkborder'] . '">
						<td width="20%">Description</td><td>' . $items[$auction['item']]['description'] . '</td>
					</tr>';
					
				$main_content .= '
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td width="20%" style="font-weight: bold;">Best Offer</td><td>' . $auction['bid'] . ' premium points</td>
				</tr>';
				
				$timers['timer_' . $auction['id']] = $auction['finish_time'] - time();
				$main_content .= '
			</table><br />
			
			<center>Jeśli chciałbyś nabyć ten przedmiot i posiadasz wystarczającą ilość punktów premium zalicytuj w aukcji.
			W przypadku gdy czas aukcji zakończy się i Twoja oferta będzie największa przejdzie ona do aukcji czekajacych na odebranie. Po wybraniu postaci na którą ma zostać dostarczony przedmiot dostaniesz go w grze.
			Jeśli zaś ktoś przebije Twoją ofertę punkty które wydałeś na licytacje zostaną Ci zwrócone na konto.
			Każda nowa oferta przedłuża czas trawania aukcji o 5 minut.</center><br />';
			
			$main_content .= '
			<center><strong>Auction will end in</strong>';
			if($auction['finish_time'] < time())
				$main_content .= '<br />Finished<br />';
			else
				$main_content .= '
				<div id="timer_' . $auction['id'] . '">
					' . time_left($auction['finish_time'] - time()) . '
				</div>';
				
			$main_content .= '[' . date("j.m.Y, G:i:s", $auction['finish_time']) . ']<br /><br />';
			
			$main_content .= '
			<script type="text/javascript">';
				if(count($timers) > 0)
				{
					foreach($timers as $timer_id => $time_left)
						$main_content .= 'countdown(' . $time_left . ', \'' . $timer_id . '\');';
				}	
				$main_content .= '
			</script>';
			
			if($auction['finish_time'] > time())
			{
				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr bgcolor="' . $config['site']['vdarkborder'] . '">
						<td style="font-weight: bold;" align="center" colspan="2">Status</td>
					</tr>
					<tr bgcolor="' . $config['site']['darkborder'] . '">
						<td width="30%">Current bid: ' . $auction['bid'] . '</td>';
						if($logged)
							$main_content .= '
							<td align="center">
								<form action="?subtopic=auctions&auction=' . $auction_p . '&action=show" method="POST">
									Twoja oferta:<br />
									<input type="text" name="yourOffer" />
									<input type="submit" name="submitOffer" value="Licytuj!" />
								</form>
							</td>';
						else
							$main_content .= '
							<td align="center">
								Log in to bid auction
							</td>';
							
						$main_content .= '	
					</tr>
				</table>';
				
				if(isset($_POST['submitOffer']))
				{
					$bid = (int)$_POST['yourOffer'];
					if($bid < $auction['bid'])
						$main_content .= 'Your bid is too low, must be higher than ' . $auction['bid'] . '!';
					elseif($auction['bidder'] == $account_logged->getId())
						$main_content .= 'You cannot bid himself.';
					elseif($account_logged->getCustomField("page_access") < 5 && $auction['seller'] == $account_logged->getId())
						$main_content .= 'You cannot bid himself.';	
					elseif($account_logged->getCustomField("premium_points") < $auction['bid'])
						$main_content .= 'You don\'t have enoguh premium points to bid.';
					else
					{
						$account_logged->setCustomField("premium_points", $account_logged->getCustomField("premium_points") - $bid);
						if($auction['bidder'] != 0)
						{
							$account = new OTS_Account();
							$account->load($auction['bidder']);
							if($account->isLoaded())
							{
								$account->setCustomField("premium_points", $account->getCustomField("premium_points") + $auction['bid']);
							}
						}
						$db->query("UPDATE `items_auctions` SET `bid` = " . $bid . ", `bidder` = " . $account_logged->getId() . ", `finish_time` = `finish_time` + " . (5 * 60) . " WHERE `id` = " . $auction_p . ";");
						header("Location: ?subtopic=auctions&auction=" . $auction_p . "&action=show");
					}
				}
			}
		}
		elseif($action == "get")
		{
			$check = $db->query("SELECT * FROM `items_auctions` WHERE `id` = " . $auction_p . " AND `finish_time` < " . time() . ";")->fetch();
			if($check['bidder'] == 0)
			{
				if($check['seller'] == $account_logged->getId())
				{
					$account_players = $account_logged->getPlayersList();
					$main_content .= '
					<form action="?subtopic=auctions&auction=' . $auction_p . '&action=get" method="POST">
						<tr bgcolor="' . $config['site']['darkborder'] . '">
							<td style="font-weight: bold;">Character</td>
							<td>
								<select name="characterName">';
									foreach($account_players as $player)
									{
										$main_content .= '<option value="' . $player->getName() . '">' . $player->getName() . '</option>';
									}
									$main_content .= '
								</select>
							</td>
						</tr>
						<tr bgcolor="' . $config['site']['darkborder'] . '">			
							<td colspan="2">
								<input type="submit" name="submitItem" value="Submit" />
							</td>
						</tr>
					</form>';
					if(isset($_POST['submitItem']))
					{
						$winner = trim($_POST['characterName']);
						$db->query("INSERT INTO `z_ots_comunication` (`name`, `type`, `action`, `param1`, `param2`, `param5`, `param6`, `delete_it`) VALUES ('" . $winner . "', 'login', 'give_item', " . $check['item'] . ", " . $check['count'] . ", 'item', '" . $items[$check['item']]['name'] . "', 1);");
						$db->query("DELETE FROM `items_auctions` WHERE `id` = " . $auction_p . ";");			
						$main_content .= 'Twój przedmiot powrócił na Twoją postać, zaloguj się do gry by go odebrać.';
					}
				}
			}
			else
			{
				if($check['bidder'] != $account_logged->getId())
					$main_content .= 'You didn\'t win this auction or auction is not finished yet.';
				else
				{
					$account_players = $account_logged->getPlayersList();
					$account_players->orderBy('name');
					
					$main_content .= '
					<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
						<tr bgcolor="' . $config['site']['vdarkborder'] . '">
							<td style="font-weight: bold;" align="center" colspan="2">Select Character</td>
						</tr>
						<form action="?subtopic=auctions&auction=' . $auction_p . '&action=get" method="POST">
							<tr bgcolor="' . $config['site']['darkborder'] . '">
								<td style="font-weight: bold;">Character</td>
								<td>
									<select name="characterName">';
										foreach($account_players as $player)
										{
											$main_content .= '<option value="' . $player->getName() . '">' . $player->getName() . '</option>';
										}
										$main_content .= '
									</select>
								</td>
							</tr>
							<tr bgcolor="' . $config['site']['darkborder'] . '">			
								<td colspan="2">
									<input type="submit" name="submitItem" value="Submit" />
								</td>
							</tr>
						</form>
					</table>';
					
					if(isset($_POST['submitItem']))
					{
						$winner = trim($_POST['characterName']);
						$db->query("INSERT INTO `z_ots_comunication` (`name`, `type`, `action`, `param1`, `param2`, `param5`, `param6`, `delete_it`) VALUES ('" . $winner . "', 'login', 'give_item', " . $db->quote($check['item']) . ", " . $check['count'] . ", 'item', " . $db->quote($items[$check['item']]['name']) . ", 1);");
						$db->query("INSERT INTO `items_auctions_history` (`finish_time`, `completion_time`, `item`, `count`, `bid`, `bidder`, `seller`, `character`) VALUES (" . $check['finish_time'] . ", " . time() . ", " . $check['item'] . ", " . $check['count'] . ", " . $check['bid'] . ", " . $check['bidder'] . ", " . $check['seller'] .", '" . $winner . "')");
						$db->query("DELETE FROM `items_auctions` WHERE `id` = " . $auction_p . ";");			
						if($check['seller'] != 0)
						{
							$account = new OTS_Account();
							$account->load($check['seller']);
							if($account->isLoaded())
							{
								$account->setCustomField("premium_points", $account->getCustomField("premium_points") + $check['bid']);
							}
						}
						$main_content .= 'Przedmiot zostal pomyslnie wyslany, zaloguj sie do gry by go odebrac.';
					}
				}
			}
		}
	}
	else
	{
		$main_content .= '
		<center>Na serwerze ' . $config['server']['serverName'] . ' został wprowodzony nowy system sms shop. 
		Działa on na zasadzie aukcji - kto da najwięcej zgarnia dany przedmiot. 
		Najlepsze w tym jest to że można po ciekawych cenach zgarnąć unikalne przedmioty beż zbyt dużej ilości danego itema na serwerze. 
		Jeśli ktoś przebije Twoją oferte punkty są zwracane na Twoje konto. 
		Przedmioty są wystawiane przez graczy na serwerze za pomocą komendy <strong>!auction</strong>.</center><br />
		
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td width="50" align="center" style="font-weight: bold;">#</td>
				<td width="30%" class="white" style="font-weight: bold;">Item</td>
				<td width="15%" align="center" class="white" style="font-weight: bold;">Points</td>
				<td width="35%" class="white" style="font-weight: bold;">Time left</td>
				<td class="white" style="font-weight: bold;">Action</td>
			</tr>';
			
		$i = 0;
		$timers = array();	
		foreach($db->query('SELECT * FROM `items_auctions` WHERE `finish_time` > ' . time())->fetchAll() as $auctionInfo)
		{
			$bgcolor = ($i % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
			$main_content .= '
			<tr bgcolor="' . $bgcolor . '">
				<td align="center">
					<img src="images/items/' . $auctionInfo['item'] . '.gif" />
				</td>
				<td>
					' . $auctionInfo['count'] . 'x ' . $items[$auctionInfo['item']]['name'];
					if(!empty($items[$auctionInfo['item']]['description']))
						$main_content .= '<br /><br /><span style="color: lime;">' . $items[$auctionInfo['item']]['description'] . '</span>';
					
					$main_content .= '
				</td>
				<td align="center">
					' . $auctionInfo['bid'];
					if($logged)
					{
						if($auctionInfo['bidder'] == $account_logged->getId())
							$main_content .= '<br /><font color="lime"><i>Wygrywasz</i></font>';
					}
					$main_content .= '
				</td>
				<td>
					<div id="timer_' . $auctionInfo['id'] . '">
						' . time_left($auctionInfo['finish_time'] - time()) . '
					</div>
				</td>
				<td>
					<a href="?subtopic=auctions&auction=' . $auctionInfo['id'] . '&action=show"><img src="' . $layout_name . '/images/buttons/bid.png" /></a>
				</td>
			</tr>';
			
			$i++;
			$timers['timer_' . $auctionInfo['id']] = $auctionInfo['finish_time'] - time();
		}
		
		if($i == 0)
		{
			$main_content .= '
			<tr bgcolor="' . $config['site']['lightborder'] . '">
				<td colspan="5">Currently there is any active auctions.</td>
			</tr>';
		}
		
		$main_content .= '</table><br />';
		$main_content .= '
		<script type="text/javascript">';
			if(count($timers) > 0)
			{
				foreach($timers as $timer_id => $time_left)
					$main_content .= 'countdown(' . $time_left . ', \'' . $timer_id . '\');';
			}	
			$main_content .= '
		</script>';
		
		$main_content .= '
		<center>Tutaj znajdują się zakończone licytacje gdzie przedmiot nie został jeszcze odebrany przez zwycięzce.
		Jeśli licytowałeś w jednej z tych aukcji sprawdz czy nie jesteś zwycięzcą!</center><br />
		
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td width="50" align="center" style="font-weight: bold;">#</td>
				<td width="30%" class="white" style="font-weight: bold;">Item</td>
				<td width="15%" align="center" class="white" style="font-weight: bold;">Points</td>
				<td width="35%" class="white" style="font-weight: bold;">Time left</td>
				<td class="white" style="font-weight: bold;">Action</td>
			</tr>';
			
		$s = 0;
		foreach($db->query('SELECT * FROM `items_auctions` WHERE `finish_time` < ' . time())->fetchAll() as $auctionInfo)
		{
			$bgcolor = ($s % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
			$main_content .= '
			<tr bgcolor="' . $bgcolor . '">
				<td align="center">
					<img src="images/items/' . $auctionInfo['item'] . '.gif" />
				</td>
				<td>
					' . $auctionInfo['count'] . 'x ' . $items[$auctionInfo['item']]['name'];
					if(!empty($items[$auctionInfo['item']]['description']))
						$main_content .= '<br /><br /><span style="color: lime;">' . $items[$auctionInfo['item']]['description'] . '</span>';
					
					$main_content .= '
				</td>
				<td align="center">
					' . $auctionInfo['bid'] . '
				</td>
				<td>
					0:00
				</td>
				<td>';
						if($logged)
						{
							if($auctionInfo['bidder'] == $account_logged->getId() || $auctionInfo['bidder'] == 0 && $auctionInfo['seller'] == $account_logged->getId())
								$main_content .= '<a href="?subtopic=auctions&auction=' . $auctionInfo['id'] . '&action=get">Get it!</a>';
							else
								$main_content .= '<a href="?subtopic=auctions&auction=' . $auctionInfo['id'] . '&action=show">Show!</a>';
						}
						else
							$main_content .= '<a href="?subtopic=auctions&auction=' . $auctionInfo['id'] . '&action=show">Show!</a>';
				
					$main_content .= '
				</td>
			</tr>';
			
			$s++;
		}
		
		if($s == 0)
		{
			$main_content .= '
			<tr bgcolor="' . $config['site']['lightborder'] . '">
				<td colspan="5">Currently there is any winning auctions.</td>
			</tr>';
		}
		
		$main_content .= '</table>';
		
		$main_content .= '
		<center><br />Tutaj znajduje się 5 ostatnich sfinalizowanych aukcji gdzie przedmiot został odebrany przez zwycięzce.</center><br />
		
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td width="50" align="center" style="font-weight: bold;">#</td>
				<td width="50%" class="white" style="font-weight: bold;">Item</td>
				<td width="15%" align="center" class="white" style="font-weight: bold;">Points</td>
				<td width="35%" class="white" style="font-weight: bold;">Winner</td>
			</tr>';
			
		$z = 0;
		foreach($db->query("SELECT * FROM `items_auctions_history` ORDER BY `completion_time` DESC LIMIT 5;")->fetchAll() as $auctionInfo)
		{
			$bgcolor = ($z % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
			$main_content .= '
			<tr bgcolor="' . $bgcolor . '">
				<td align="center">
					<img src="images/items/' . $auctionInfo['item'] . '.gif" />
				</td>
				<td>
					' . $auctionInfo['count'] . 'x ' . $items[$auctionInfo['item']]['name'];
					if(!empty($items[$auctionInfo['item']]['description']))
						$main_content .= '<br /><br /><span style="color: lime;">' . $items[$auctionInfo['item']]['description'] . '</span>';
					
					$main_content .= '
				</td>
				<td align="center">
					' . $auctionInfo['bid'] . '
				</td>
				<td>
					<a href="?subtopic=characters&name=' . $auctionInfo['character'] . '">' . $auctionInfo['character'] . '</a>
				</td>
			</tr>';
			
			$z++;
		}
		
		if($z == 0)
		{
			$main_content .= '
			<tr bgcolor="' . $config['site']['lightborder'] . '">
				<td colspan="5">Currently there is any finalized auctions.</td>
			</tr>';
		}
		
		$main_content .= '</table>';
	}
?>