<?php
	$list = trim($_REQUEST['list']);
	$page = (int)$_REQUEST['page'];
	$voc = (int)$_REQUEST['voc'];

	if(empty($voc) || $voc > 5 || $voc < 1)
		$voc = 0;

	switch($list)
	{
		case "fist":
			$id = 0;
			$list_name = 'Fist Fighting';
		break;
		
		case "club":
			$id = 1;
			$list_name = 'Club Fighting';
		break;
		
		case "sword":
			$id = 2;
			$list_name = 'Sword Fighting';
		break;
		
		case "axe":
			$id = 3;
			$list_name = 'Axe Fighting';
		break;
		
		case "distance":
			$id = 4;
			$list_name = 'Distance Fighting';
		break;
		
		case "shield":
			$id = 5;
			$list_name = 'Shielding';
		break;
		
		case "fishing":
			$id = 6;
			$list_name = 'Fishing';
		break;
	}
	
	if(!isset($id))
	{
		if($list == "magic")
			$list_name = "Magic Level";
		else
		{
			$list_name = 'Experience';
			$list = 'experience';
		}
	}

	$show_records = $_SESSION['show_records'];
	if( empty($show_records) )
	{
		$_SESSION['show_records'] = 50;
	}

	if( $_POST['set_records'] == 1 )
	{
		$_SESSION['show_records'] = (int) $_POST['records'];
		header("location: ?subtopic=highscores&list=".$list."&page=0");
	}

	if( $show_records < 1 )
	{
		$_SESSION['show_records'] = 50;
		header("location: ?subtopic=highscores&list=".$list."&page=0");
	}

	$offset = $page * $show_records;
	
	if($voc == 0)
	{
		$que = "";
	}
	else
	{
		if($voc == 5)
			$voc = 0;
		
		$que = " AND players.vocation = " . $voc;
	}
	
	if(isset($id))
		$skills = $db->query('SELECT `id`, `name`, `online`, `value`, `level`, `vocation`, `promotion`, `lastip`, `lookbody`, `lookfeet`, `lookhead`, `looklegs`, `looktype`, `lookaddons` FROM `players`, `player_skills` WHERE `players`.`deleted` = 0 AND `account_id` != 1 AND `players`.`id` = `player_skills`.`player_id` AND `player_skills`.`skillid` = ' . $id . '' . $que . ' AND `group_id` < 3 ORDER BY `value` DESC, `count` DESC LIMIT 51 OFFSET ' . $offset);
	elseif($list == "magic")
		$skills = $db->query('SELECT id,name,online,maglevel,level,vocation,promotion,lastip,lookbody,lookfeet,lookhead,looklegs,looktype,lookaddons FROM players WHERE players.deleted = 0 AND account_id != 1 AND `group_id` < 3 AND name != "Account Manager"'.$que.' ORDER BY maglevel DESC, manaspent DESC LIMIT 51 OFFSET '.$offset);
	elseif($list == "experience")
		$skills = $db->query('SELECT id,name,online,experience,level,vocation,promotion,lastip,lookbody,lookfeet,lookhead,looklegs,looktype,lookaddons FROM players WHERE players.deleted = 0 AND account_id != 1 AND `group_id` < 3 AND name != "Account Manager"'.$que.' ORDER BY level DESC, experience DESC LIMIT 51 OFFSET '.$offset);

	$main_content .= '<center><h2>Ranking for ' . $list_name . ' on ' . $config['server']['serverName'] . '</h2></center><br />';

	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td colspan="5" class="white" style="font-weight: bold;">Choose a vocation</TD>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td align="center" width="30%"><a href="index.php?subtopic=highscores&list='.$list.'">All Vocations</a></td>
			<td align="center" width="20%"><a href="index.php?subtopic=highscores&voc=1&list='.$list.'">Sorcerers</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&voc=2&list='.$list.'">Druids</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&voc=3&list='.$list.'">Paladins</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&voc=4&list='.$list.'">Knight</a></td>
		</tr>
	</table><br />';
	
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td colspan="8" class="white" style="font-weight: bold;">Choose a skill</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td align="center" width="10%"><a href="index.php?subtopic=highscores&list=experience">Experience</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&list=magic">Magic</a></td>
			<td align="center" width="10%"><a href="index.php?subtopic=highscores&list=shield">Shielding</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&list=distance">Dist</a></td>
			<td align="center" width="10%"><a href="index.php?subtopic=highscores&list=club">Club</a></td>
			<td align="center" width="10%"><a href="index.php?subtopic=highscores&list=sword">Sword</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&list=axe">Axe</a></td>
			<td align="center" width="15%"><a href="index.php?subtopic=highscores&list=fist">Fist</a></td>
		</tr>
	</table><br />';
	
	$main_content .= '
	<table border="0" cellpadding="4" cellspacing="1" width="100%" id="iblue">
		<tr align="right" style="background: '.$config['site']['darkborder'].'"> 
			<form action="?subtopic=highscores&list='.$list.'&page=0" method="post">
				<td width="100%">How many records should be displayed?</td>
				<td>
					<input type="hidden" value="1" name="set_records" />
					<input type="text" value="'.$show_records.'" size="2" name="records" maxlength="3" />
				</td>
				<td>
					<input type="image" src="' . $layout_name . '/images/buttons/submit.png" value="Set" />
				</td>
			</form>
		</tr>
	</table><br />';
	
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor=' . $config['site']['vdarkborder'] . '>
			<td width="5%" class="white" align="center" style="font-weight: bold">Rank</td>
			<td width="5%" class="white" style="font-weight: bold" align="center">Outfit</td>
			<td width="75%" class="white" style="font-weight: bold;">Name</td>
			<td width="15%" class="white" style="font-weight: bold;" align="center">Level</td>';
			if($list == "experience")
				$main_content .= '<td class="white" style="font-weight: bold;" align="center">Points</td>';
				
			$main_content .= '
		</tr>';
		foreach($skills as $skill)
		{
			$cc = strtolower(geoip_country_code_by_name(revertIp(long2ip($skill['lastip']))));
			if(empty($cc))
				$cc = "unknown";

			if($number_of_rows < $show_records)
			{
				if($list == "magic")
					$skill['value'] = $skill['maglevel'];
					
				if($list == "experience")
					$skill['value'] = $skill['level'];
					
				$bgcolor = ($number_of_rows % 2) ? "background: " . $config['site']['darkborder'] . "" : "background: " . $config['site']['lightborder'] . "";
				$number_of_rows++;

				$main_content .= '<tr style="' . $bgcolor . '"><td>' . ($offset + $number_of_rows) . '.</td><td align="center"><img src="outfiter.php?id=' . $skill['looktype'] . '&addons=' . $skill['lookaddons'] . '&head=' . $skill['lookhead'] . '&body=' . $skill['lookbody'] . '&legs=' . $skill['looklegs'] . '&feet=' . $skill['lookfeet'] . '" border="0" /></td><td><img src="./images/flags/'.$cc.'.gif" border="0" /> <a href="?subtopic=characters&name=' . urlencode($skill['name']) . '">' . ($skill['online'] > 0 ? "<font color=\"green\">" . $skill['name'] . "</font>" : "<font color=\"red\">" . $skill['name'] . "</font>") . '</a><br /><small>' . $skill['level'] . ', ' . $vocation_name[0][$skill['promotion']][$skill['vocation']] . ', ' . $config['server']['serverName'] . '</small></td><td align="center">' . $skill['value'] . '</td>';
				if($list == "experience")
					$main_content .= '<td align="center">' . $skill['experience'] . '</td>';
				
				$main_content .= '</tr>';
			}
			else
				$show_link_to_next_page = TRUE;
		}

		$main_content .= '
	</table>';
	
	$main_content .= '
	<table border="0" cellpadding="4" cellspacing="1" width="100%">
		<tr>
			<td align="center">';
				
				if($page > 0)
					$main_content .= '<a href="?subtopic=highscores&list=' . $list . '&page=' . ($page - 1) . '"> < </a>';
					
				$main_content .= '<a href="?subtopic=highscores&list=' . $list . '&page=' . $page . '">' . ($page + 1) . '</a>';
				
				if($show_link_to_next_page)
					$main_content .= '<a href="?subtopic=highscores&stats=main&list=' . $list . '&page=' . ($page + 1) . '"> > </a>';
			
				$main_content .= '		
			</td>
		</tr>
	</table>';
?>