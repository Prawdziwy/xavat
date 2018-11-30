<?PHP
	if(file_exists('questmakers.txt') && time() - filemtime('questmakers.txt') < 7200)
		$cache = file_get_contents('questmakers.txt');
	else
	{
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

		$quest_list = $quests;
		if(!$quest_list)
		{
			$main_content .= 'Uzupe³nij storage questow w cofingu';
			break;
		}

		$nr_gracza = 0;
		$players = $db->query('SELECT * FROM `players` WHERE deleted = 0 AND `group_id` = 1 AND `account_id` != 1')->fetchAll();

		$cache .= '
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td align="left" colspan="2" class="white" style="font-weight: bold;">Best quest makers</td>
			</tr>';
			foreach ($players as $player)
			{
				$ilosc_questow_wykonanych = 0;
				$ilosc_questow = 0;
				foreach($quest_list as $storage => $name)
				{
					$ilosc_questow++;
					$quest_baza = $db->query("SELECT * FROM `player_storage` WHERE `player_id` = " . $player['id'] . " AND `key` = '" . $quest_list[$storage] . "'")->fetchAll();
					foreach($quest_baza as $idd)
						$ilosc_questow_wykonanych++;
				}
				
				$ilosc_procent = ($ilosc_questow_wykonanych / $ilosc_questow) * 100;
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
					<td>' . number_format($procent, 0) . '%<div title="' . number_format($procent, 0) . '%" style="width: 100%; height: 7px; background: white;"><div style="background: green; width: ' . $procent . '%; height: 7px;"></td>
				</tr>';
			}
			$cache .= '
		</table>';
		file_put_contents('questmakers.txt', $cache);
	}
	
	$main_content .= $cache;
?>