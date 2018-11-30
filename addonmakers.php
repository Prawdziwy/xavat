<?PHP
	if(file_exists('addonmakers.txt') && time() - filemtime('addonmakers.txt') < 7200)
		$cache = file_get_contents('addonmakers.txt');
	else
	{
		$nr_gracza = 0;
		$players = $db->query('SELECT `id`, `name` FROM `players` WHERE `deleted` = 0 AND `group_id` < ' . $config['site']['players_group_id_block'] . ' AND `account_id` != 1')->fetchAll();

		$cache .= '
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td align="left" colspan="2" class="white" style="font-weight: bold;">Best addon makers</td>
			</tr>';
			foreach ($players as $player)
			{
				$ilosc_addonow_wykonanych = 0;
				$ilosc_addonow = 0;
				for($storage = 40001; $storage <= 40046; $storage++)
				{
					$ilosc_addonow++;
					$quest_baza = $db->query("SELECT * FROM `player_storage` WHERE `player_id` = " . $player['id'] . " AND `key` = " . $storage . "")->fetchAll();
					foreach($quest_baza as $idd)
						$ilosc_addonow_wykonanych++;
				}
				
				$ilosc_procent = ($ilosc_addonow_wykonanych / $ilosc_addonow) * 100;
				$gracz_wynik[$player['name']] = $ilosc_procent;
			}
			
			$gracze_wyniki = arsort($gracz_wynik);
			foreach($gracz_wynik as $player => $procent)
			{
				$bgcolor = ($nr_gracza % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
				$nr_gracza++;
				if($nr_gracza > 50)
					break;
				
				$cache .= '
				<tr bgcolor="' . $bgcolor . '">
					<td width="40%"><a href="?subtopic=characters&name=' . urlencode($player) . '">' . $player . '</a></td>
					<td>' . number_format($procent, 0) . '%<div title="' . number_format($procent, 0) . '%" style="width: 100%; height: 7px; background: white;"><div style="background: red; width: ' . $procent . '%; height: 7px;"></td>
				</tr>';
			}
			$cache .= '

		</table>';
		file_put_contents('addonmakers.txt', $cache);
	}
	
	$main_content .= $cache;
?>