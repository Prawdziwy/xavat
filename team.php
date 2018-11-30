<?php
	if($groups = @simplexml_load_file($config['site']['server_path'] . '/data/XML/groups.xml') or die('<b>Could not load groups!</b>'))
	foreach($groups->group as $g)
		$groupList[(int)$g['id']] = $g['name'];

	$showed_players = 0;
	$list = $db->query("SELECT `name`, `online`, `group_id`, `lastip` FROM `players` WHERE `group_id` > 1 ORDER BY `group_id` DESC");

    $main_content .= '<h2 style="text-align: center;">Support in game</h2><br />';

    $headline = '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
        <tr style="background: ' . $config['site']['vdarkborder'] . '; repeat-x top; color: #FFFFFF">
			<td width="15%" class="white" style="font-weight: bold;">Group</td>
			<td width="70%" class="white" style="font-weight: bold;">Name</td>
			<td width="15%" class="white" style="font-weight: bold;">Status</td>';

			$group_id = 0;
			foreach($list as $gm)
			{
				if($group_id != (int)$gm['group_id'])
				{
					if($group_id != 0)
						$main_content .= '</table><br />';

					$main_content .= $headline;
					$group_id = (int)$gm['group_id'];
					
					$cc = strtolower(geoip_country_code_by_name(revertIp(long2ip($gm['lastip']))));
					if(empty($cc))
						$cc = "unknown";
				}

				$bgcolor = ($showed_players % 2) ? "background: " . $config['site']['darkborder'] . "" : "background: " . $config['site']['lightborder'] . "";
				$showed_players++;
				
				$main_content .= '<tr style="' . $bgcolor . '"><td>' . $groupList[(int)$gm['group_id']] . '</td><td><img src="./images/flags/' . $cc . '.gif" border="0" /> <a href="?subtopic=characters&name=' . urlencode($gm['name']) . '">' . $gm['name'] . '</a></td><td><font color="' . ($gm['online'] == 0 ? 'red">Offline' : 'green">Online') . '</font></td></tr>';
			}

    $main_content .= '</table>';
?>