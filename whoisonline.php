<?php
	$order = trim($_REQUEST['order']);
	if($order == 'level')
		$orderby = 'level';
	elseif($order == 'vocation')
		$orderby = 'vocation';
	if(empty($orderby))
		$orderby = 'name';	
		
	$number_of_players_online = 0;
	$players = $db->query("SELECT `name`, `level`, `vocation`, `promotion`, `lastip` FROM `players` WHERE `online` = 1 ORDER BY " . $orderby)->fetchAll();
	foreach($players as $player)
	{
		$number_of_players_online++;
		$bgcolor = ($number_of_players_online % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
		
		$cc = strtolower(geoip_country_code_by_name(revertIp(long2ip($player['lastip']))));
		if(empty($cc))
			$cc = "unknown";
			
		$vocs = array
		(
			1 => "sorcerer",
			2 => "druid",
			3 => "paladin",
			4 => "knight"
		);

		$players_rows .= '
		<tr bgcolor="' . $bgcolor . '">
			<td align="center"><img src="./images/vocs/' . $vocs[$player['vocation']] . '.png" border="0" /></td>
			<td><img src="./images/flags/' . $cc . '.gif" border="0" /> <a href="?subtopic=characters&name=' . urlencode($player['name']) . '">' . $player['name'] . '</a></td>
			<td>' . $player['level'] . '</td>
			<td>' . $vocation_name[0][$player['promotion']][$player['vocation']] . '</td>
		</tr>';
	}
	
	if($number_of_players_online == 0)
		$main_content .= '
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td class="white" style="font-weight: bold;">'.$lang['site']['WISO_T_1'].'</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
				<td>'.$lang['site']['WISO_T_2'].' <b>' . $config['server']['serverName'] . '</b>.</TD>
			</tr>
		</table>';
	else
	{
		//server status - someone is online
		$main_content .= '
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td class="white" style="font-weight: bold;">Server Status</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
				<td>Currently '.$number_of_players_online.' players are online!</td>
			</tr>
		</table><br />';
		
		//list of players
		$main_content .= '
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr>
				<th width="2%" bgcolor="' . $config['site']['vdarkborder'] . '">#</th>
				<th width="58%" bgcolor="' . $config['site']['vdarkborder'] . '"><a href="?subtopic=whoisonline&order=name">'.$lang['site']['WISO_T_5'].'</a></th>
				<th width="10%" bgcolor="' . $config['site']['vdarkborder'] . '"><a href="?subtopic=whoisonline&order=level">'.$lang['site']['WISO_T_6'].'</a></th>
				<th width="30%" bgcolor="' . $config['site']['vdarkborder'] . '"><a href="?subtopic=whoisonline&order=vocation">'.$lang['site']['WISO_T_7'].'</th>
			</tr>
			' . $players_rows . '
		</table><br />';
		
		//search bar
		$main_content .= '
		<form action="?subtopic=characters" method="post">
			<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
				<tr bgcolor="' . $config['site']['vdarkborder'] . '">
					<td>'.$lang['site']['WISO_T_8'].'</td>
				</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td>
						<table border="0" width="100%">
							<tr>
								<td width="20%">'.$lang['site']['WISO_T_9'].'</td>
								<td width="50%"><input name="name" value="" size="18" maxlength="30"></td>
								<td width="30%"><input type="image" name="submit" src="' . $layout_name . '/images/buttons/submit.png" border="0"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>';
	}
?>