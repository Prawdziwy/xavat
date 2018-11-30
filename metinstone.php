<?php
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td><center><img src="images/events/metinstone.png" /></center></td>
		</tr>
	</table><br />
	
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="text-align: center; font-weight: bold;" colspan="2">Opis Kamieni</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>
				Co 4 godziny jest <strong>30%</strong> szans na zespawnowanie kamienia, pojawia sie komunikat:<br /><br />
				<span style="color: red"><i>"[Event Stones] NAZWA_KAMIENIA have been spawn. Find and defeat it!"</i></span><br /><br />
				Kamień respi sie w losowym ustalonym miejscu na mapie.
				Inteligetnie respi potwory (nie można ich zlurowac, sa posłuszne kamieniowi) które chronią go przed atakujacymi.
				Sam kamień nie jest groźny, lecz gdy traci hp staje sie coraz silniejszy ze swoimi sługami.
				Atakujacy powinni pamietać, że jedyny sposób zniszczenia kamienia jest jako pierwsze zabijanie jego summonów.<br /><br />
				<span style="color: lime">Po zabiciu kamienia można zdobyć bardzo wartościowy loot.</span>
			</td>
		</tr>
	</table><br />
	
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="text-align: center; font-weight: bold;" colspan="2">Opis Kamieni</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="15%" height="15%">
				<center>
					<img src="http://wiki.metin2.pl/images/c/ca/Administrator_Forum.gif" alt="xxx" /><br />
					<img src="http://images2.wikia.nocookie.net/__cb20080609150919/tibia/en/images/e/e2/Mossy_Stone_(Normal).gif" alt="xxx" /><br />
					<img src="http://wiki.metin2.pl/images/c/ca/Administrator_Forum.gif" alt="xxx" />
				</center>
			</td>
			<td><b>Earth Stone</b>:<br>
				<li><b>HP:</b> xxxx</li>
				<li>90% - slime,bonelord,earth elemental bonelord,elder bonelord,earth elemental.</li>
				<li>70% - massive earth elemental,bog raider, earth elemental, bog raider,medusa,wyvern.</li>
				<li>50% - medusa,defiler,slime.</li>
				<li>40% - medusa,serpent spawn,slime,wyvern,defiler.</li>
				<li>20% - defiler,plaguesmith,phantasm.</li>
				<li>5% - plaguesmith,defiler,demon.</li>
			</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="15%" height="15%">
				<center>
					<img src="http://wiki.metin2.pl/images/7/79/Community_Manager.gif" alt="xxx" />
					<img src="http://images.wikia.com/tibia/en/images/d/d7/Blue_Shrine_Stone.gif" alt="xxx" /><br />
					<img src="http://wiki.metin2.pl/images/7/79/Community_Manager.gif" alt="xxx" />
				</center>
			</td>
			<td><b>Ice Stone</b>:<br>
				<li><b>HP:</b> xxxx</li>
				<li>90% - ice golem,crystal spider.</li>
				<li>70% - crystal spider,ice witch,mammoth.</li>
				<li>50% - crystal spider,frost dragon,ice witch.</li>
				<li>30% - crystal spider,frost dragon,warlock.</li>
				<li>10% - frost dragon,warlock.</li>
				<li>5% - frost dragon,warlock.</li>
			</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="15%" height="15%">
				<center>
					<img src="http://wiki.metin2.pl/images/c/c8/Administrator_Gry.gif" alt="xxx" />
					<img src="http://images.wikia.com/tibia/en/images/9/9c/Red_Shrine_Stone.gif" alt="xxx" /><br />
					<img src="http://wiki.metin2.pl/images/c/c8/Administrator_Gry.gif" alt="xxx" />
				</center>
			</td>
			<td><b>Fire Stone</b>:<br>
				<li><b>HP:</b> xxxx</li>
				<li>90% - fire elemental,fire devil.</li>
				<li>70% - dragon,fire elemental.</li>
				<li>50% - dragon,dragon lord,massive fire elemental.</li>
				<li>40% - dragon lord,massive fire elemental,diabolic imp.</li>
				<li>20% - diabolic imp,hellfire fighter,demon,infernalist.</li>
				<li>5% - demon,hellfire fighter,infernalist,hellhound.</li>
			</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td width="15%" height="15%">
				<center>
					<img src="http://wiki.metin2.pl/images/6/65/Administrator_Rekrutacji.gif" alt="xxx" />
					<img src="http://www.otland.eu/images/metin_stone/Stone_(Normal).gif" alt="xxx" /><br />
					<img src="http://wiki.metin2.pl/images/6/65/Administrator_Rekrutacji.gif" alt="xxx" />
				</center>
			</td>
			<td><b>Wind Stone</b>:<br>
				<li><b>HP:</b> xxxx</li>
				<li>90% - fire elemental,fire devil.</li>
				<li>70% - dragon,fire elemental.</li>
				<li>50% - dragon,dragon lord,massive fire elemental.</li>
				<li>40% - dragon lord,massive fire elemental,diabolic imp.</li>
				<li>20% - diabolic imp,hellfire fighter,demon,infernalist.</li>
				<li>5% - demon,hellfire fighter,infernalist,hellhound.</li>
			</td>
		</tr>
		
	</table><br />
	
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="font-weight: bold;" colspan="5" align="center">Ostatni zabójcy</td>
		</tr>
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="font-weight: bold;">#</td>
			<td class="white" style="font-weight: bold;">Player</td>
			<td class="white" style="font-weight: bold;">Date</td>
			<td class="white" style="font-weight: bold;">Reward</td>
		</tr>';

		$i = 0;
		foreach($db->query("SELECT * FROM `e_metinstone` ORDER BY `date` DESC LIMIT 10") as $event)
		{
			$player = new OTS_Player();
			$player->load($event['player_id']);
			if($player->isLoaded())
			{
				$bgcolor = ($i % 2) ? $config['site']['lightborder'] : $config['site']['darkborder'];
				$main_content .= '
				<tr bgcolor="' . $bgcolor . '">
					<td width="5%">' . ($i + 1) . '. </td>
					<td width="40%"><a href="?subtopic=characters&name=' . $player->getName() . '">' . $player->getName() . '</a></td>
					<td><td>' . date("d.m.Y, H:i:s", $event['date']) . '</td></td>
					<td></td>
				</tr>';
				$i++;
			}
		}
		$main_content .= '
	</table>';
?>