<?php 
	$countriesTop = array();
	$players = $db->query("SELECT `level`, `country` FROM `players` WHERE `group_id` < 3;")->fetchAll();
	foreach($players as $playerData) 
	{
		if(!empty($playerData['country']) && $playerData['country'] != "unknown")
			$countriesTop[$playerData['country']] += $playerData["level"];
	}
	
	arsort($countriesTop);

	$main_content .= '
	<table border="0" cellspacing="3" cellpadding="4" width="100%" style="background: #251c16;border:1px solid #32231b;">
		<tr>
			<td colspan="3" class="title">Best Countries on Selura PvP 8.6!</td>
		</tr>
		<tr>'; 
			foreach($countriesTop as $countryName => $countryPoints)
			{
				$countCountries++;
				if($countCountries > 3)
					break;
					
				$main_content .= '
				<td width="33%" class="title">
					<center>
						<img src="/images/flags_big/flag_' . $countryName . '.png" />
						<h2 style="margin-bottom:-10px;">' . ucfirst($countries[$countryName]) . '</h2><br />
						<font style="color:red; font-size:16pt; font-weight:bold;">#' . $countCountries . '</font><br /><br />
						<font style="font-weight:bold; font-size:12pt;">Points: ' . $countryPoints . '</font>
					</center>
				</td>'; 
			}
			$main_content .= '
		</tr>
	</table>';
?>