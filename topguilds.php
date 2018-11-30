<?php
$main_content .= '
<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
	<tr>
		<th width="2%" bgcolor="' . $config['site']['vdarkborder'] . '">'.$lang['site']['TOPG_T_1'].'</th>
		<th width="58%" bgcolor="' . $config['site']['vdarkborder'] . '">'.$lang['site']['TOPG_T_2'].'</th>
		<th width="10%" bgcolor="' . $config['site']['vdarkborder'] . '">'.$lang['site']['TOPG_T_3'].'</th>
	</tr>';
	$i = 0; 
	foreach($db->query(' 
		SELECT  
			`g`.`id` AS `id`,
			`g`.`name` AS `name`,
			SUM(`p`.`frags`) AS `frags`
		FROM `players` p 
			LEFT JOIN `guild_ranks` gr ON `p`.`rank_id` = `gr`.`id`
			LEFT JOIN `guilds` g ON `gr`.`guild_id` = `g`.`id`
		WHERE `g`.`id` = `g`.`id`
		GROUP BY `name`
		ORDER BY `frags` DESC
		LIMIT 10
	') as $guild)  
	{
		$bgcolor = ($number_of_players_online % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
		$points = $guild['frags'];
		$gc .= '
		<tr bgcolor="' . $bgcolor . '">
			<td><img src="./guilds/' . $guild['id'] . '.jpg" border="0" /></td>
			<td><a style="text-decoration: none;" href="?subtopic=guilds&action=show&guild=' . $guild['id'] . '">' . $guild['name'] . '</a></td>
			<td>' . $points . '</td>
		</tr>'; 
		$i++;
	}
		
	$main_content .= $gc;
	$main_content .= '
</table>';
?>