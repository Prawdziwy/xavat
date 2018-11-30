<?php
	function imageFragsType($frags)
	{
		$skulls = array
		(
			"<img src='images/whiteskull.gif'>", 
			"<img src='images/redskullhalf.gif'>", 
			"<img src='images/redskull.gif'>", 
			"<img src='images/blackskull.gif'>"
		);
		if($count > 500)
			return $skulls[3] . $skulls[3] . $skulls[3] . $skulls[3] . $skulls[3] . $skulls[3] . $skulls[3] . $skulls[3];
		if($count > 300) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/blackskull.gif'><img src='images/blackskull.gif'><img src='images/blackskull.gif'>";
		if($count > 260) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/blackskull.gif'><img src='images/blackskull.gif'>";
		if($count > 230) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskullhalf.gif'>";
		if($count > 190) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'>";
		if($count > 150) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskullhalf.gif'>";
		if($count > 120) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskull.gif'>";
		if($count > 90) return "<img src='images/redskull.gif'><img src='images/redskull.gif'><img src='images/redskullhalf.gif'>";
		if($count > 70) return "<img src='images/redskull.gif'><img src='images/redskull.gif'>";
		if($count > 50) return "<img src='images/redskull.gif'><img src='images/redskullhalf.gif'>";
		if($count > 30) return "<img src='images/redskull.gif'>";
		if($count > 15) return "<img src='images/whiteskull.gif'><img src='images/whiteskull.gif'>";
		if($count > 1) return "<img src='images/whiteskull.gif'>";
	}

	$main_content .= '<div style="text-align: center; font-weight: bold;">'.$lang['site']['TOPF_T_1'].' ' . $config['server']['serverName'] . '</div>
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="text-align: center; font-weight: bold;">'.$lang['site']['TOPF_T_2'].'</td>
			<td class="white" style="text-align: center; font-weight: bold;">'.$lang['site']['TOPF_T_3'].'</td>
		</tr>';

		$i = 0;
		foreach($db->query('SELECT `name`, `frags` FROM `players` ORDER BY `frags` DESC LIMIT 0, 30;') as $player)
		{
			$main_content .= '
			<tr bgcolor="' . (($i % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . '">
				<td><a href="?subtopic=characters&name=' . urlencode($player['name']) . '">' . $player['name'] . '</a></td>
				<td style="text-align: center;">' . $player['frags'] . ' '.$lang['site']['TOPF_T_4'].' <br />' . imageFragsType($player['frags']) . '</td>
			</tr>';
			$i++;
		}
		$main_content .= '
	</table>';
?>