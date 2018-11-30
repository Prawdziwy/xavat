<?php
	$record = $db->query('SELECT * FROM `server_record` WHERE `record` > 0 ORDER BY `record` DESC LIMIT 20;')->fetchAll();
	
	$main_content .= '
	<center>
		Max amount of online players was of ' . $record[0]['record'] . ' players on ' . date("M j Y", $record[0]['timestamp']) . '.
	</center><br />';

	$main_content .= '
	<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
    <tr bgcolor="' . $config['site']['vdarkborder'] . '">
        <td align="center" width="30%">
            <span style="font-weight:bold;">Players</span>
        </td>
        <td width="70%" align="center">
            <span style="font-weight:bold;">Date</span>
        </td>
    </tr>';
	
	foreach($record as $record)
	{
		$main_content .= '
		<tr bgcolor="' . (($i % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . '">
			<td align="center" >' . $record['record'] . '</center></td>
			<td align="center">' . date("M j Y, H:i:s T", $record['timestamp']) . '</td>
		</tr>';
		$i++;
	}
	
	$main_content .= '
	</table>';
?>