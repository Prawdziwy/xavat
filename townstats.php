<?php
	$main_content .= '
	<table width=100% cellspacing=0 cellpadding=0 border=0 id=iblue>
		<tr>
			<td>
				<table border="0px" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<tr>
						<th bgcolor="' . $config['site']['vdarkborder'] . '">' . $lang['site']['TOWN'] . '</th>
						<th bgcolor="' . $config['site']['vdarkborder'] . '">' . $lang['site']['CITIZENS'] . '</th>
					</tr>';
$row = 1;
$worlds = $config['site']['worlds'];
// $main_content .= '<b>Towns:</b> ';
    foreach($worlds as $wid => $wname) {
        switch($_GET['world']) {
            case $wid:
                $towns = $towns_list[$wid];
            break;
        }
 //       $main_content .= '<a href="?subtopic=houses&world='.$wid.'">'.$wname.'</a>, ';           
        foreach($towns as $idd => $name) {
            $color = ($row % 2 ? $config['site']['darkborder'] : $config['site']['lightborder']);
            $row++;
            $main_content .= '<tr bgcolor="'.$color.'"><td>'.$name.'</td>';
            $c = $db->query('SELECT id, COUNT(town_id) FROM players WHERE town_id = '.$idd.' AND world_id = '.$wid)->fetch();    
            $main_content .= '<td>'.$c[COUNT(town_id)].'</td></tr>';
        }
    }
$main_content .= '</table></td></tr></table>';
?>
