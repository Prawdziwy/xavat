<?php
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="font-weight: bold;" width="50%">About</td>
		</tr>
		<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>
				<table border="0" cellpadding="20" width="100%">
					<tbody>
						<tr>
							<td>
								<div style="text-align: justify;">
									Witamy na stronie głównej serwera ' . $config['server']['serverName'] . '. 
									Jest to serwer prywatny i darmowy z unikalną mapą zawierającą wiele osobliwych miejsc z oryginalnymi questami i expowiskami! Na serwerze istnieją niepowtarzalne dodatki, wzmożone mnożniki doświadczenia oraz umiejętności, które zachęcą do wielu godzin interesującej przygody dla każdej grupy wiekowej.
									Zostały również wprowadzone rozgrywki PVP - specjalnie miejsca do tego przeznaczone, mogące zapewnić wiele godzin wspaniałej zabawy! Administracja zawsze chętnie może pomóc jeśli tylko gracze będą się angażować w grę, odwzajemniona intensywność graczy będzie sowicie wynagrodzona.
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	<table><br />';
	
	$lastJoined = $db->query("SELECT `name` FROM `players` ORDER BY `id` DESC LIMIT 1")->fetch();
	$bestPlayer = $db->query("SELECT `name`, `level` FROM `players` ORDER BY `experience` DESC LIMIT 1")->fetch();
	
	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="text-align: center; font-weight: bold;" colspan="2">Status</td>
		</tr>
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="font-weight: bold;" width="50%">Name</td>
			<td class="white" style="font-weight: bold;">Value</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>Server</td>
			<td>' . ($config['status']['serverStatus_online'] == 1 ? "Online" : "Offline") . '</td>
		</tr>
		<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>Players</td>
			<td>' . $config['status']['serverStatus_players'] . '</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>Uptime</td>
			<td>' . $config['status']['serverStatus_uptime'] . '</td>
		</tr>
	</table><br />
	
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		<tr bgcolor="'.$config['site']['vdarkborder'].'">
			<td class="white" style="text-align: center; font-weight: bold;" colspan="2">Rates</td>
		</tr>
	<tbody>
	<tr bgcolor="' . $config['site']['vdarkborder'] . '">
	<td align="center"><b>Name</b></td>
	<td><b><center>Value</center></b></td>
	</tr>


	<tr bgcolor="' . $config['site']['darkborder'] . '">
	<td><b>Expierence</b></td>
	<td>
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">

	<thead>
	<tr bgcolor="'.$config['site']['vdarkborder'].'">
	<td class="middle">Exp from</center></td>
	<td class="middle">Exp to</center></td>
	<td>Rate</td>	
	</tr>
	</thead>

	
	<tbody>
	
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>1</td>
			<td>100</td>
			<td>x90</td>
		</tr>

		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>101</td>
			<td>150</td>
			<td>x50</td>
		</tr>
		
		<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>151</td>
			<td>200</td>
			<td>x35</td>
		</tr>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>201</td>
			<td>250</td>
			<td>x20</td>
		</tr>
		
		<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>251</td>
			<td>280</td>
			<td>x10</td>
		</tr>

		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>281</td>
			<td>300</td>
			<td>x5</td>
		</tr>

		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>301</td>
			<td>350</td>
			<td>x4</td>
		</tr>

		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>351</td>
			<td>400</td>
			<td>x3</td>
		</tr>

		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>401</td>
			<td>++</td>
			<td>x2</td>
		</tr>
		
	</table>		
		
	<tr bgcolor="' . $config['site']['lightborder'] . '">
		<td>Skill</td>
		<td class="middle">x30</td>
	</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
		<td>Magic</td>
		<td class="middle">x15</td>
	</tr>
		<tr bgcolor="' . $config['site']['lightborder'] . '">
		<td>Loot</td>
		<td class="middle">x3</td>
	</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
		<td>Spawn</td>
		<td class="middle">x2</td>
	</tr>
	</table>
	<br />
	
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
		
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="text-align: center; font-weight: bold;" colspan="2">Server Info</td>
		</tr>
		<tr bgcolor="' . $config['site']['vdarkborder'] . '">
			<td class="white" style="font-weight: bold;" width="50%">Name</td>
			<td class="white" style="font-weight: bold;">Value</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>World Type</td>
			<td>Open PvP</td>
		</tr>
		<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>Client Version</td>
			<td><a href="http://karmia.net/?subtopic=downloads">8.60 Click to download</a></td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>Server motd</td>
			<td>' . $config['server']['motd'] . '</td>
		</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>Last joined</td>
			<td><a href="?subtopic=characters&name=' . $lastJoined['name'] . '">' . $lastJoined['name'] . '</a></td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>Best Level</td>
			<td><a href="?subtopic=characters&name=' . $bestPlayer['name'] . '">' . $bestPlayer['name'] . ' [' . $bestPlayer['level'] . ']</a></td>
		</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
			<td>Quests</td>
			<td>
				<ul>
					<li>Warlord Arena</li>	
					<li>Scrapper Arena</li>	
					<li>Greenshore Arena</li>	
					<li>Begin Quest	</li>
					<li>Begin Quest 30lvl	</li>
					<li>Begin Quest 60lvl	</li>
					<li>Annihilator	</li>
					<li>Demon Helmet	</li>
					<li>Pits of Inferno	</li>
					<li>The Inquisition	</li>
					<li>Terra Set	</li>
					<li>Magma Set	</li>
					<li>Lightning Set	</li>
					<li>Glacier Set	</li>
					<li>Demon Oak Quest</li>
					<li>and much more...</li>
				</ul>
			</td>
		</tr>
		<tr bgcolor="' . $config['site']['darkborder'] . '">
			<td>Other</td>
			<td>
				<ul>
					<li>Perfect Vocations Balance</li>
					<li>Free Premium</li>
					<li>Tasks</li>
					<li>Powergamers</li>
					<li>Castle System</li>
					<li>Advanced system agains hacking</li>
					<li>Modern website</li>
					<li>Full security against attacks from outside</li>
					<li>Game without lags and problems</li>
				</ul>
			</td>
		</tr>
		
	</table>';
?>