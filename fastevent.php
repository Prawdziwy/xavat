<?PHP

$main_content .= '<div class="news-top"></div><div class="news-mid"><div class="title-news-buy">Fast EVENT! w czasie gry otrzymujemy wiadomosc, przez broadcast dotyczaca eventu, osoba ktora najszybciej wykona zadanie otrzyma od<b> 50 - 110</b> darmowych premium punktow. Event odbywa sie raz dziennie. <br><br>
Ponizej znajdziemy liste zwyciezcow :)</div></div><div class="news-bottom"></div> ';
if($action == '')
{
	$storage = $db->query("SELECT * FROM `event_fast`");
	foreach($storage as $wynik) {
       $gracze++;
            if(is_int($gracze / 2))
                $bgcolor = $config['site']['lightborder'];
            else
                $bgcolor = $config['site']['darkborder'];
			$n = $db->query("SELECT `price`, `name` FROM `event_fast`;")->fetch();
        $tresc .= '<TR BGCOLOR='.$bgcolor.'><TD><center>'.$gracze.'</center></TD><TD><center>'.$wynik['name'].'</center></TD><TD><center>'.$wynik['price'].'</center></TD>';
    }
	
	
	$main_content .= "<table style=\"width: 100%;\" cellpadding=\"4\" cellspacing=\"1\" align=\"center\">
						
						<tr style=\"background: ".$config['site']['vdarkborder']."; \">
								<td class=\"white\" width=\"10%\"><b>Lp.</b></td>
								<td class=\"white\" width=\"50%\"><b>Nick</b></td>
								<td class=\"white\" width=\"50%\"><b>Ilosc zdobytych punktow</b></td>
		
						</tr>
						".$tresc."
	
					</table>
	";

$main_content .= '<br><br><br><br><a href="http://otland.net/members/bartastkd/"><p align="right">Scripted By Bartastkd</a>';

}



?>