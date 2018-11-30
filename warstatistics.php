<?php
$main_content = "
<h1 align=\"center\">".$lang['site']['WSTAT_T_1']."</h1>
<script type=\"text/javascript\"><!--
function show_hide(flip)
{
	var tmp = document.getElementById(flip);
	if(tmp)
		tmp.style.display = tmp.style.display == 'none' ? '' : 'none';
}
--></script>

<h2><center><a onclick=\"show_hide('war-details-info'); return false;\">".$lang['site']['WSTAT_T_2']."</a></center></h2>
<div id=\"war-details-info\" style=\"display: none;\">
	<center>".$lang['site']['WSTAT_T_3']."</center>
	<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\" id=\"iblue\">
		<tr style=\"background: none repeat scroll 0% 0% rgb(100, 100, 100);\">
			<td style=\"background: " . $config['site']['vdarkborder'] . "\" class=\"white\"><b>".$lang['site']['WSTAT_T_4']."</b></td>
			<td style=\"background: " . $config['site']['vdarkborder'] . "\" class=\"white\"><b>".$lang['site']['WSTAT_T_5']."</b></td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_6']." </td><td>".$lang['site']['WSTAT_T_7']."</td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_8']." </td><td>".$lang['site']['WSTAT_T_9']."</td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_10']." </td><td>".$lang['site']['WSTAT_T_11']."</td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_12']." </td><td>".$lang['site']['WSTAT_T_13']."</td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_14']."</td><td>".$lang['site']['WSTAT_T_15']."</td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_16']."</td><td>".$lang['site']['WSTAT_T_17']."</td>
		</tr> 
		<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
			<td>".$lang['site']['WSTAT_T_18']."</td><td>".$lang['site']['WSTAT_T_19']."</td>
		</tr>
	</table>
</div>
	<br />
<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\" id=\"iblue\">
<tr>
<td style=\"background: " . $config['site']['vdarkborder'] . "\" class=\"white\" width=\"150\"><b>".$lang['site']['WSTAT_T_20']."</b></td>
<td style=\"background: " . $config['site']['vdarkborder'] . "\" class=\"white\"><b>".$lang['site']['WSTAT_T_21']."</b></td>
<td style=\"background: " . $config['site']['vdarkborder'] . "\" class=\"white\" width=\"150\"><b>".$lang['site']['WSTAT_T_22']."</b></td>
</tr>";
 
$count = 0;
foreach($db->query('SELECT * FROM `guild_wars` WHERE `status` IN (1,4) OR ((`end` >= (UNIX_TIMESTAMP() - 604800) OR `end` = 0) AND `status` IN (0,5));') as $war)
{
	$a = $ots->createObject('Guild');
	$a->load($war['guild_id']);
	if(!$a->isLoaded())
		continue;
 
	$e = $ots->createObject('Guild');
	$e->load($war['enemy_id']);
	if(!$e->isLoaded())
		continue;
 
	$count++;
	$main_content .= "<tr style=\"background: " . (is_int($count % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
<td align=\"center\" width=\"25%\"><a href=\"?subtopic=guilds&action=show&guild=".$a->getId()."\"><img src=\"guilds/".$a->getId().".jpg\" width=\"64\" height=\"64\" border=\"0\"/><br />".$a->getName()."</a></td>
<td align=\"center\">";
	switch($war['status'])
	{
		case 0:
		{
			$main_content .= "<b>".$lang['site']['WSTAT_T_23']."</b><br />".$lang['site']['WSTAT_T_24']." " . date("M d Y, H:i:s", $war['begin']) . " ".$lang['site']['WSTAT_T_25']." " . ($war['end'] > 0 ? (($war['end'] - $war['begin']) / 86400) : "unspecified") . " ".$lang['site']['WSTAT_T_26']." " . $war['frags'] . " ".$lang['site']['WSTAT_T_27'].", " . ($war['payment'] > 0 ? "".$lang['site']['WSTAT_T_28']." " . $war['payment'] . " ".$lang['site']['WSTAT_T_29']."." : "".$lang['site']['WSTAT_T_30']."")."<br />".$lang['site']['WSTAT_T_31']."";
			break;
		}
 
		case 3:
		{
			$main_content .= "<s>".$lang['site']['WSTAT_T_32']."</s><br />".$lang['site']['WSTAT_T_33']." " . date("M d Y, H:i:s", $war['begin']) . ", ".$lang['site']['WSTAT_T_34']." " . date("M d Y, H:i:s", $war['end']) . ".";
			break;
		}
 
		case 2:
		{
			$main_content .= "".$lang['site']['WSTAT_T_35']."<br />".$lang['site']['WSTAT_T_36']." " . date("M d Y, H:i:s", $war['begin']) . ", ".$lang['site']['WSTAT_T_37']." " . date("M d Y, H:i:s", $war['end']) . ".";
			break;
		}
 
		case 1:
		{
			$main_content .= "<font size=\"12\"><span style=\"color: red;\">" . $war['guild_kills'] . "</span> : <span style=\"color: lime;\">" . $war['enemy_kills'] . "</span></font><br /><br /><span style=\"color: darkred; font-weight: bold;\">".$lang['site']['WSTAT_T_38']."</span><br />".$lang['site']['WSTAT_T_39']." " . date("M d Y, H:i:s", $war['begin']) . ($war['end'] > 0 ? ", ".$lang['site']['WSTAT_T_40']." " . date("M d Y, H:i:s", $war['end']) : "") . ".<br />".$lang['site']['WSTAT_T_41']." " . $war['frags'] . " ".$lang['site']['WSTAT_T_42'].", " . ($war['payment'] > 0 ? "".$lang['site']['WSTAT_T_43']." " . $war['payment'] . " ".$lang['site']['WSTAT_T_44']."." : "".$lang['site']['WSTAT_T_45'].".");
			break;
		}
 
		case 4:
		{
			$main_content .= "<font size=\"12\"><span style=\"color: red;\">" . $war['guild_kills'] . "</span> : <span style=\"color: lime;\">" . $war['enemy_kills'] . "</span></font><br /><br /><span style=\"color: darkred;\">".$lang['site']['WSTAT_T_46']."</span><br />".$lang['site']['WSTAT_T_47']." " . date("M d Y, H:i:s", $war['begin']) . ", ".$lang['site']['WSTAT_T_48']." " . date("M d Y, H:i:s", $war['end']) . ".<br />".$lang['site']['WSTAT_T_49']." " . $war['frags'] . " ".$lang['site']['WSTAT_T_50'].". ".($war['payment'] > 0 ? "".$lang['site']['WSTAT_T_51']." " . $war['payment'] . " ".$lang['site']['WSTAT_T_52']."." : "".$lang['site']['WSTAT_T_53'].".");
			break;
		}
 
		case 5:
		{
			$main_content .= "<i>".$lang['site']['WSTAT_T_54']."</i><br />".$lang['site']['WSTAT_T_55']." " . date("M d Y, H:i:s", $war['begin']) . ", ".$lang['site']['WSTAT_T_56']." " . date("M d Y, H:i:s", $war['end']) . ". ".$lang['site']['WSTAT_T_57']." <span style=\"color: red;\">" . $war['guild_kills'] . "</span> to <span style=\"color: lime;\">" . $war['enemy_kills'] . "</span>.";
			break;
		}
 
		default:
		{
			$main_content .= $lang['site']['WSTAT_T_58'];
			break;
		}
	}
 
	$main_content .= "<br /><br /><a onclick=\"show_hide('war-details:" . $war['id'] . "'); return false;\" style=\"cursor: pointer;\">&raquo; ".$lang['site']['WSTAT_T_59']." &laquo;</a></td>
<td align=\"center\" width=\"25%\"><a href=\"?subtopic=guilds&action=show&guild=".$e->getId()."\"><img src=\"guilds/".$e->getId().".jpg\" width=\"64\" height=\"64\" border=\"0\"/><br />".$e->getName()."</a></td>
</tr>
<tr id=\"war-details:" . $war['id'] . "\" style=\"display: none; background: " . (is_int($count / 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . ";\">
<td colspan=\"3\">";
	if(in_array($war['status'], array(1,4,5)))
	{
		$deaths = $db->query('SELECT `pd`.`id`, `pd`.`date`, `gk`.`guild_id` AS `enemy`, `p`.`name`, `pd`.`level`
FROM `guild_kills` gk
	LEFT JOIN `player_deaths` pd ON `gk`.`death_id` = `pd`.`id`
	LEFT JOIN `players` p ON `pd`.`player_id` = `p`.`id`
WHERE `gk`.`war_id` = ' . $war['id'] . ' AND `p`.`deleted` = 0
	ORDER BY `pd`.`date` DESC')->fetchAll();
		if(!empty($deaths))
		{
			foreach($deaths as $death)
			{
				$killers = $db->query('SELECT `p`.`name` AS `player_name`, `p`.`deleted` AS `player_exists`, `k`.`war` AS `is_war`
FROM `killers` k
	LEFT JOIN `player_killers` pk ON `k`.`id` = `pk`.`kill_id`
	LEFT JOIN `players` p ON `p`.`id` = `pk`.`player_id`
WHERE `k`.`death_id` = ' . $death['id'] . '
	ORDER BY `k`.`final_hit` DESC, `k`.`id` ASC')->fetchAll();
				$count = count($killers); $i = 0;
 
				$others = false;
				$main_content .= date("j M Y, H:i", $death['date']) . " <span style=\"font-weight: bold; color: " . ($death['enemy'] == $war['guild_id'] ? "red" : "lime") . ";\">+</span>
<a href=\"?subtopic=characters&name=" . urlencode($death['name']) . "\"><b>".$death['name']."</b></a> ";
				foreach($killers as $killer)
				{
					$i++;
					if($killer['is_war'] != 0)
					{
						if($i == 1)
							$main_content .= "".$lang['site']['WSTAT_T_60']." <b>".$death['level']."</b> ".$lang['site']['WSTAT_T_61']." ";
						else if($i == $count && $others == false)
							$main_content .= " ".$lang['site']['WSTAT_T_62']." ";
						else
							$main_content .= ", ";
 
						if($killer['player_exists'] == 0)
							$main_content .= "<a href=\"?subtopic=characters&name=" . urlencode($killer['player_name']) . "\">";
 
						$main_content .= $killer['player_name'];
						if($killer['player_exists'] == 0)
							$main_content .= "</a>";
					}
					else
						$others = true;
 
					if($i == $count)
					{
						if($others == true)
							$main_content .= " ".$lang['site']['WSTAT_T_63']."";
 
						$main_content .= ".<br />";
					}
				}
			}
		}
		else
			$main_content .= "<center>".$lang['site']['WSTAT_T_64']."</center>";
	}
	else
		$main_content .= "<center>".$lang['site']['WSTAT_T_65']."</center>";
 
	$main_content .= "</td>
</tr>";
}
 
if($count == 0)
	$main_content .= "<tr style=\"background: ".$config['site']['darkborder'].";\">
<td colspan=\"3\">".$lang['site']['WSTAT_T_66']."</td>
</tr>";
 
$main_content .= "</table>";
?>