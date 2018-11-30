<?php
$main_content .= '
                        <br>        
<table width="100%" cellspacing="1" cellpadding="5" id="iblue">
<tbody><tr><td class="white" colspan="5" bgcolor="' . $config['site']['vdarkborder'] . '"><b><font color="white">INFO</font></b></td></tr><tr><td bgcolor="' . $config['site']['lightborder'] . '">
<b>Addon System</b> polega na zabijaniu wyznaczonej liczby potworow. Jezeli chcesz zdobyc jakis addon, musisz rozpoczac zadanie, wpisujac odpowiednia komende 
ktora znajdziesz w tabeli ponizej.<br>Dla przykladu:<br>
Jezeli chcesz zostac posiadaczem first citizen addon wpisujesz:<br>
<b>!task minotaur</b> zadanie zostaje aktywowane i musisz zabic 300 Minotaurow. Po zabiciu 300 minotaurow zostajesz automatycznie posiadaczem first citizen addon.<br>
<b><u>Przydatne komendy:</u></b><br>
<b>!task nazwa</b> - wpisanie tej komendy oznacza aktywacje zadania, jezeli wpiszesz ta komende ponownie zadanie sie dezaktywuje.<br>
<b>!task info</b> - gdy posiadasz rozpoczete zadanie, pojawiaja sie informacje dotyczace aktualnego stanu zadania (Ile potworow musisz zabic, ile juz zabiles)<br><br>
<b>Pamietaj, mozesz posiadac tylko jedno aktywne zadanie.</b>
</td></tr>
</tbody></table>
<br>
<table width="100%" cellspacing="1" cellpadding="5" id="iblue">
<tbody><tr><td bgcolor="' . $config['site']['vdarkborder'] . '" class="white" colspan="5"><b><font color="white">TAKS SYSTEM Table</font></b></td></tr>  
<tr><td><table border="0" cellpadding="2" cellspacing="1" width="100%">  
<tbody><tr bgcolor="' . $config['site']['vdarkborder'] . '"><td width="10%"><b>Images</b></td><td width="50%"><b>Kills:</b></td><td width="30%"><b>Win:</b></td></tr>  

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/citizen1.jpg"></center></td><td><center>Aktywacja: <b>!task minotaur</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>1500 Minotaur</b></center></td><td><center> <li>First Citizen Addon</li></center></td></tr>
  
<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/citizen2.jpg"></center></td><td><center>Aktywacja: <b>!task bear</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>500 Bear</b></center></td><td><center> <li>Second Citizen Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/hunter1.jpg"></center></td><td><center>Aktywacja: <b>!task hunter</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>250 Hunter</b></center></td><td><center><li>First Hunter Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/hunter2.jpg"></center></td><td><center>Aktywacja: <b>!task lizard snakecharmer</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>750 Lizard snakecharmer</b></center></td><td><center> <li>Second Hunter Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/knight1.jpg"></center></td><td><center>Aktywacja: <b>!task dwarf guard</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2250 Dwarf Guard</b></center></td><td><center><li>First Knight Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/knight2.jpg"></center></td><td><center>Aktywacja: <b>!task behemoth</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>1000 Behemoth</b></center></td><td><center><li>Second Knight Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/mage1.jpg"></center></td><td><center>Aktywacja: <b>!task warlock</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2750 Warlock</b></center></td><td><center><li>First Mage Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/mage2.jpg"></center></td><td><center>Aktywacja: <b>!task ferumbras</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>1 Ferumbras</b></center></td><td><center><li>Second Mage Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/barbarian1.jpg"></center></td><td><center>Aktywacja: <b>!task fury</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2500 Fury</b></center></td><td><center><li>First Barbarian Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/barbarian2.jpg"></center></td><td><center>Aktywacja: <b>!task giant spider</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2750 Giant Spider</b></center></td><td><center><li>Second Barbarian Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/druid1.jpg"></center></td><td><center>Aktywacja: <b>!task wolf</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2500 Wolf</b></center></td><td><center><li>First Druid Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/druid2.jpg"></center></td><td><center>Aktywacja: <b>!task hydra</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2750 Hydra</b></center></td><td><center><li>Second Druid Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/nobleman1.jpg"></center></td><td><center>Aktywacja: <b>!task rotworm</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>1500 rotworm</b></center></td><td><center><li>First Nobleman Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/nobleman2.jpg"></center></td><td><center>Aktywacja: <b>!task orc warlord</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>500 Orc Warlord</b></center></td><td><center><li>Second Nobleman Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/oriental1.jpg"></center></td><td><center>Aktywacja: <b>!task wyrm</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>3500 Wyrm</b></center></td><td><center><li>First Oriental Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/oriental2.jpg"></center></td><td><center>Aktywacja: <b>!task blue djinn</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>1000 Blue Djinn</b></center></td><td><center><li>Second Oriental Adoon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/summoner1.jpg"></center></td><td><center>Aktywacja: <b>!task infernalist</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>4000 Infernalist</b></center></td><td><center><li>First Summoner Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/summoner2.jpg"></center></td><td><center>Aktywacja: <b>!task witch</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>500 Witch</b></center></td><td><center><li>Second Summoner Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/warrior1.jpg"></center></td><td><center>Aktywacja: <b>!task grim reaper</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>5000 Grim Reaper</b></center></td><td><center><li>First Warrior Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/warrior2.jpg"></center></td><td><center>Aktywacja: <b>!task undead dragon</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>3500 undead dragon</b></center></td><td><center><li>Second Warrior Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/wizard1.jpg"></center></td><td><center>Aktywacja: <b>!task hero</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>6000 Hero</b></center></td><td><center><li>First Wizard Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/wizard2.jpg"></center></td><td><center>Aktywacja: <b>!task medusa</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>4500 Medusa</b></center></td><td><center><li>Second Wizard Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/assassin1.jpg"></center></td><td><center>Aktywacja: <b>!task dragon lord</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>6000 Dragon Lord</b></center></td><td><center><li>First Assassin Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/assassin2.jpg"></center></td><td><center>Aktywacja: <b>!task frost dragon</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>6000 Frost Dragon</b></center></td><td><center><li>Second Assassin Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/beggar1.jpg"></center></td><td><center>Aktywacja: <b>!task bat</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>500 Bat</b></center></td><td><center><li>First Beggar Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/beggar2.jpg"></center></td><td><center>Aktywacja: <b>!task cyclops</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2000 Cyclops</b></center></td><td><center><li>Second Beggar Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/pirate1.jpg"></center></td><td><center>Aktywacja: <b>!task pirate skeleton</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>4000 Pirate Skeleton</b></center></td><td><center><li>First Pirate Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/pirate2.jpg"></center></td><td><center>Aktywacja: <b>!task pirate corsair</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>4000 Pirate Corsair</b></center></td><td><center><li>Second Pirate Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/shaman1.jpg"></center></td><td><center>Aktywacja: <b>!task kongra</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2500 Kongra</b></center></td><td><center><li>First Shaman Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/shaman2.jpg"></center></td><td><center>Aktywacja: <b>!task merlkin</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2500 Merlkin</b></center></td><td><center><li>Second Shaman Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/norseman1.jpg"></center></td><td><center>Aktywacja: <b>!task ice golem</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2000 Ice Golem</b></center></td><td><center><li>First Norseman Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/norseman2.jpg"></center></td><td><center>Aktywacja: <b>!task yeti</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>1000 Yeti</b></center></td><td><center><li>Second Norseman Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/nightmare1.jpg"></center></td><td><center>Aktywacja: <b>!task nightmare</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>6000 Nightmare</b></center></td><td><center><li>First Nightmare Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/nightmare2.jpg"></center></td><td><center>Aktywacja: <b>!task lost soul</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>5000 Lost Soul</b></center></td><td><center><li>Second Nightmare Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/brotherhood1.jpg"></center></td><td><center>Aktywacja: <b>!task blightwalker</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>3000 Blightwalker</b></center></td><td><center><li>First Brotherhood Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/brotherhood2.jpg"></center></td><td><center>Aktywacja: <b>!task betrayed wraith</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>3000 Betrayed Wraith</b></center></td><td><center><li>Second Brotherhood Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/jester1.jpg"></center></td><td><center>Aktywacja: <b>!task water elemental</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2000 Water Elemental</b></center></td><td><center><li>First Jester Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/jester2.jpg"></center></td><td><center>Aktywacja: <b>!task massive water elemental</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>2000 Massive Water Elemental</b></center></td><td><center><li>Second Jester Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/demonhunter1.jpg"></center></td><td><center>Aktywacja: <b>!task ghazbaran</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>25 Ghazbaran</b></center></td><td><center><li>First Demonhunter Addon</li></center></td></tr>

<tr bgcolor="' . $config['site']['lightborder'] . '"><td height="100" width="100"><center><img src="images/task/demonhunter2.jpg"></center></td><td><center>Aktywacja: <b>!task demon</b><br><br>Aby otrzymac nagrode za zrobionego taska musisz zabic <b>6000 Demon</b></center></td><td><center><li>Second Demonhunter Addon</li></center></td></tr>

</tbody></table></td></tr>  
</tbody></table>                                 ';
?>