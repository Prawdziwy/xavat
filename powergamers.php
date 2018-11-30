<?php
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td width="40%" class="white" style="font-weight: bold">'.$lang['site']['PG_T_1'].'</td> 
			<td width="10%" class="white" style="font-weight: bold" align="center">'.$lang['site']['PG_T_2'].'</td> 
			<td width="25%" class="white" style="font-weight: bold">'.$lang['site']['PG_T_3'].'</td> 
			<td width="25%" class="white" style="font-weight: bold">'.$lang['site']['PG_T_4'].'</td>
		</tr>';
	
	$i = 0;
	$players = $db->query("SELECT `name`, `level`, `world_id`, `vocation`, `experience`, `online`, `promotion`, `exphist_lastexp` FROM `players` WHERE `group_id` < 3 AND `name` != 'Account Manager' AND `name` != 'Knight Sample' AND `name` != 'Paladin Sample' AND `name` != 'Druid Sample' AND `name` != 'Sorcerer Sample' AND `name` != 'Rook Sample' ORDER BY `experience` - `exphist_lastexp` DESC LIMIT 100")->fetchAll();
	foreach($players as $player)
	{
		$bgcolor = ($i % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
		$main_content .= '
			<tr bgcolor="' . $bgcolor . '">
				<td><a href="?subtopic=characters&name=' . urlencode($player['name']) . '">' . $player['name'] . '</a><BR><small>' . $player['level'] . ' Level, '.$vocation_name[$player['world_id']][$player['promotion']][$player['vocation']].'<small></td>
				<td align="center">' . (($player['online'] == 1) ? '<img src="./images/true.png" border="0" />' : '<img src="./images/false.png" border="0" />') . '</td>
				<td>' . coloured_value(($player['experience'] - $player['exphist_lastexp'])) . ' '.$lang['site']['PG_T_5'].'</td>
				<td>' . coloured_value(($player['experience'] - $player['exphist_lastexp']) / (date("H") + 1)) . ' '.$lang['site']['PG_T_6'].'</td>
			</tr>';
		$i++;
	}
	
	$main_content .= '</table>';
?>