<?PHP
$main_content .= '
';
$main_content = " 

<script type=\"text/javascript\"><!-- 
function show_hide(flip) 
{ 
    var tmp = document.getElementById(flip); 
    if(tmp) 
        tmp.style.display = tmp.style.display == 'none' ? '' : 'none'; 
} 
--></script>"; 

$main_content .= '<script language="JavaScript">
TargetDate = "08/25/2012 1:00 PM";
CountActive = true;
CountStepper = -1;
LeadingZero = false;
DisplayFormat = "<font size=\'5\'><center>Do startu <font color=\"green\"><b>OTSMATERIA.PL</b></font> pozostalo:<br/> <font color=\"red\">%%D%%</font> dni, <font color=\"red\">%%H%%</font> godzin, <font color=\"red\">%%M%%</font> minut oraz <font color=\"red\"><b>%%S%%</b></font> sekund!<br></font>25 sierpien - sobota - godz. 13:00</center></br>";
FinishMessage = "";
</script>
<script language="JavaScript" src="http://scripts.hashemian.com/js/countdown.js"></script>

';

/////////////////////////////////////////////////////////////////////////////////////////
//The new edition of my script: Best Player, Last joined and something new Server Motd.//
/////////////////////////Everything in the new appearance.///////////////////////////////
//////////////////////////////////////by  Aleh///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
///Queries ///
$query = $SQL->query('SELECT `players`.`name`,`players`.`id`,`players`.`level`, `players`.`experience`, `server_motd`.`id`, `server_motd`.`text` FROM `players`,`server_motd` WHERE `players`.`group_id` < '.$config['site']['players_group_id_block'].' AND `players`.`name` != "Account Manager" ORDER BY `players`.`level` DESC, `players`.`experience` DESC, `server_motd`.`id` DESC LIMIT 1;')->fetch();
$query2 = $SQL->query('SELECT `id`, `name` FROM `players` ORDER BY `id` DESC LIMIT 1;')->fetch();
$housesfree = $SQL->query('SELECT COUNT(*) FROM `houses` WHERE `owner`=0;')->fetch();
$housesrented = $SQL->query('SELECT COUNT(*) FROM `houses` WHERE `owner`=1;')->fetch();
$players = $SQL->query('SELECT COUNT(*) FROM `players` WHERE `id`>0;')->fetch();
$accounts = $SQL->query('SELECT COUNT(*) FROM `accounts` WHERE `id`>0;')->fetch();
$guilds = $SQL->query('SELECT COUNT(*) FROM `guilds` WHERE `id`>0;')->fetch();
///End Queries ///




$main_content .= '<center><div class="NewsHeadline">
	<div class="NewsHeadlineBackground" style="background-image:url(' . $layout_name . '/images/news/newsheadline_background.gif)">
		<table border="0">
			<tr>
				<td style="text-align: center; font-weight: bold;">
					<font color="white">WELCOME to ' . $config['server']['serverName'] . ' !</font>
				</td>
			</tr>
		</table>
	</div>
</div></center>


';



$kutas = $accounts[0] + 300;
$kutas1 = $players[0] + 300;
$kutas2 = $guilds[0] + 4;







    $main_content .= '
    <tr bgcolor='. $config['site']['lightborder'] .'><td><center>Ostatnio dolaczyl do nas: <b><a href="?subtopic=characters&name='.urlencode($query2['name']).'">'.$query2['name'].'</a></b>, gracz numer '.$kutas1.'.</center></td></tr>
    <tr bgcolor='. $config['site']['lightborder'] .'><td><center>Obecnie najlepszym graczem na serwerze jest: <b><a href="index.php?subtopic=characters&name='.urlencode($query['name']).'"> '.$query['name'].'</a> ('.urlencode($query['level']).')</b>.</center></td></tr>
    <table border=0 cellpadding=0 cellspacing=1 width=100%>    
    <tr bgcolor='. $config['site']['lightborder'] .'><td><center><b>Accounts</b> in database: '.$kutas.'.</center></td>
    <td><center><b>Players</b> in database: '.$kutas1.'.</center></td></tr>
    <tr bgcolor='. $config['site']['lightborder'] .'><td><center><b>House</b> in game: 514.</center></td>
    <td><center><b>Guilds</b> in databese: '.$kutas2.'.</center></td></tr>

</table></td></tr></b></table>';

$cache_sec = 20;
$f = 'cache/news.tmp';
if(file_exists($f) && filemtime($f) > (time() - $cache_sec))
	$main_content = file_get_contents($f);
else
{


$guilds_list = $ots->createObject('Guilds_List');
$guilds_list->setFilter($filter);
$guilds_list->orderBy('name');
if(count($guilds_list) > 0) 
{
	foreach($SQL->query('SELECT `guild_name` FROM `castle` ORDER BY `id` DESC LIMIT 1;') as $result)
	{
		if($result['guild_name'] == 'No one')
			$main_content .= '<center><img src="http://images.stimax.pl/i2/zamek.gif" alt="xxx" /><b> Wlasciciel zamku: </b> No one is castle owner</center>';
		else
		{
			foreach($guilds_list as $guild) 
			{
				if($guild->getName() == $result['guild_name'])
				{
					foreach(array("/", "\\", "..") as $char) 
						$guild_logo = str_replace($char, "", $guild->getCustomField('logo_gfx_name'));
					
					if(empty($guild_logo) || !file_exists("images/guilds/".$guild_logo)) 
						$guild_logo = "default_logo.gif";
					
					$main_content .= '<center><img src="http://images.stimax.pl/i2/zamek.gif" alt="xxx" /><b> Wlasciciel zamku: </b> <a href="?subtopic=guilds&action=show&guild=' . $guild->getId() . '">' . $result['guild_name'] . '</a></center>';
				}
			}
		}
	}
}



$main_content .= '
<div class="NewsHeadline">
	<div class="NewsHeadlineBackground" style="background-image:url(' . $layout_name . '/images/news/newsheadline_background.gif)">
		<table border="0">
			<tr>
				<td style="text-align: center; font-weight: bold;">
					<font color="white">Most powerfull guilds & TOP 3 players</font>
				</td>
			</tr>
		</table>
	</div>
</div>
<table border="0" cellspacing="3" cellpadding="4" width="100%" bgcolor="#D4C0A1">
	<tr >';

foreach($SQL->query('SELECT `g`.`id` AS `id`, `g`.`name` AS `name`,  
    `g`.`logo_gfx_name` AS `logo`, COUNT(`g`.`name`) as `frags`  
FROM `killers` k  
    LEFT JOIN `player_killers` pk ON `k`.`id` = `pk`.`kill_id`  
    LEFT JOIN `players` p ON `pk`.`player_id` = `p`.`id`  
    LEFT JOIN `guild_ranks` gr ON `p`.`rank_id` = `gr`.`id`  
    LEFT JOIN `guilds` g ON `gr`.`guild_id` = `g`.`id`  
WHERE `k`.`final_hit` = 1  
    GROUP BY `name`  
    ORDER BY `frags` DESC, `name` ASC  
    LIMIT 0, 6;') as $guild) 
    $main_content .= '        <td style="width: 62px; text-align: center;" bgcolor="#F1E0C6">
            <a href="?subtopic=guilds&action=show&guild=' . $guild['id'] . '"><img src="guilds/' . ((!empty($guild['logo']) && file_exists('guilds/' . $guild['logo'])) ? $guild['logo'] : 'default_logo.gif') . '" width="64" height="64" border="0" class="avatar" /><br />' . $guild['name'] . '</a><br />' . $guild['frags'] . ' kills
        </td>';

$main_content .= '    </tr>
</table>';


// ##### TOP 5 GRACZY CREATE BY COLLOCORPUS FROM MATERIAOTS, WSZYSTKIE PRAWA ZABRONIONE! KONTAKT 7284838 // 
$order = 0; 
$skills = $SQL->query('SELECT name,online,world_id,level,maglevel,vocation,promotion FROM players WHERE players.deleted = 0 AND players.group_id < '.$config['site']['players_group_id_block'].' AND name != "Account Manager" ORDER BY level DESC, experience DESC LIMIT 3;'); 
foreach($skills as $skill)  
{ 
    if ( $skill['online'] == 1 ) 
    {  
        $online_gracz = '<font color="green"><img src="http://www.nazwa.pl/fileadmin/nazwa/10/images/domain-status1.png"></font>';  
    } 
    else  
    {  
        $online_gracz = '<font color="red"><img src="http://www.nazwa.pl/fileadmin/nazwa/10/images/domain-status2.png"></font>';  
    } 
    $order++; 
    $players_skill .= ' 
    <tr height="10px" BGCOLOR="#F2EEE3"> 
        <td align="center">'.$order.'.</td> 
        <td align="left" width="240"><a href="?subtopic=characters&name='.urlencode($skill['name']).'"><b>'.($skill['online']>0 ? "<font color=\"green\">".$skill['name']."</font>" : "".$skill['name']."</font>").'</b></a></td> 
        <td align="left" width="135"><font color="989177"><em>Level '.$skill['level'].'</em></font></td> 
        <td align="center" width="220"><font color="989177"><em>'.$vocation_name[$skill['world_id']][$skill['promotion']][$skill['vocation']].'</em></font></td> 
        <td align="center" width="200"><font color="989177"><em>'.$online_gracz.'</em></font></td> 
    </tr>'; 
} 

$main_content .= '<table><tr bgcolor="#F1E0C6"><td><table>' . $players_skill . '</table></td></tr></table>';


	file_put_contents($f, $main_content);
}

   /*
///////// TO WYWALIC PO STARCIE !!
$main_content .= '
<div class="NewsHeadline">
	<div class="NewsHeadlineBackground" style="background-image:url(' . $layout_name . '/images/news/newsheadline_background.gif)">
		<table border="0">
			<tr>
				<td style="text-align: center; font-weight: bold;">
					<font color="white">[auto- refresh] - KTO BEDZIE U NAS GRAL ?</font>
				</td>
			</tr>
		</table>
	</div>
</div>';

$main_content .= '<table><tr BGCOLOR="#F2EEE3"><td>';
$accept = $SQL->query('SELECT guildid, players FROM `application` WHERE `accept` = 1');
foreach($accept as $a)
{
	$guild = $SQL->query('SELECT `name` FROM `guilds` WHERE `id` = '.$a['guildid'].' LIMIT 1')->fetch();
	$main_content .= ' <b>'.$guild['name'].'</b> <font size="1">('.$a['players'].')</font>, ';
}

$main_content .= 'and few others..</td></tr></table>';

///////// TO WYWALIC PO STARCIE !!

    */



 






if ($logged){
$players_from_account = $SQL->query("SELECT `players`.`name`, `players`.`id` FROM `players` WHERE `players`.`account_id` = ".(int) $account_logged->getId())->fetchAll();
foreach($players_from_account as $player)
    {
        $str .= '<option value="'.$player['id'].'"';
            if($player['id'] == $char_id)
            $strt .= ' selected="selected"';
            $str .= '>'.$player['name'].'</option>';
    }
}
$time = time();

//adding news
if($action == "newnews") {
if($group_id_of_acc_logged >= $config['site']['access_news']) {
$text = ($_REQUEST['text']);
                $char_id = (int) $_REQUEST['char_id'];
                $post_topic = stripslashes(trim($_REQUEST['topic']));
                $smile = (int) $_REQUEST['smile'];
				$news_icon = (int) $_REQUEST['icon_id'];
if(empty($news_icon)) {
$news_icon = 0;
}
if(empty($post_topic)) {
$an_errors[] .= 'You can\'t add news without topic.';
}
if(empty($text)) {
$an_errors[] .= 'You can\'t add empty news.';
}
if(empty($char_id)) {
$an_errors[] .= 'Select character.';
}
//execute query
if(empty($an_errors)) {
$SQL->query("INSERT INTO `z_forum` (`id` ,`first_post` ,`last_post` ,`section` ,`replies` ,`views` ,`author_aid` ,`author_guid` ,`post_text` ,`post_topic` ,`post_smile` ,`post_date` ,`last_edit_aid` ,`edit_date`, `post_ip`, `icon_id`) VALUES ('NULL', '0', '".time()."', '1', '0', '0', '".$account_logged->getId()."', '".(int) $char_id."', ".$SQL->quote($text).", ".$SQL->quote($post_topic).", '".(int) $smile."', '".time()."', '0', '0', '".$_SERVER['REMOTE_ADDR']."', '".$news_icon."')");
                        $thread_id = $SQL->lastInsertId();
                        $SQL->query("UPDATE `z_forum` SET `first_post`=".(int) $thread_id." WHERE `id` = ".(int) $thread_id);//show added data

$main_content .= '<form action="?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
}
else
{
//show errors
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
foreach($an_errors as $an_error) {
	$main_content .= '<li>'.$an_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
//okno edycji newsa z wpisanymi danymi przeslanymi wczesniej
$main_content .= '<form action="?subtopic=latestnews&action=newnews" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="images/news/icon_0.gif" width="20"></td><td><img src="images/news/icon_1.gif" width="20"></td><td><img src="images/news/icon_2.gif" width="20"></td><td><img src="images/news/icon_3.gif" width="20"></td><td><img src="images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="F1E0C6"><b>Topic:</b></td><td><input type="text" name="topic" maxlenght="50" style="width: 300px" value="'.$post_topic.'"></td></tr><tr><td align="center" bgcolor="D4C0A1"><b>News<br>text:</b></td><td bgcolor="F1E0C6"><textarea name="text" rows="6" cols="60">'.$text.'</textarea></td></tr><tr><td width="180"><b>Character:</b></td><td><select name="char_id"><option value="0">(Choose character)</option>'.$str.'</select></td></tr><tr><td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="location.href=\'?subtopic=latestnews\';" alt="CancelAddNews" /></div></div></td></tr></table>';
}
}
else
{
$main_content .= 'You don\'t have site-admin rights. You can\'t add news.';}
}
//####################Show script with new news panel############################								
if($group_id_of_acc_logged >= $config['site']['access_news'] && $action != 'newnews')
{

$main_content .= '<script type="text/javascript">

var showednewnews_state = "0";
function showNewNewsForm()
{
if(showednewnews_state == "0") {
document.getElementById("newnewsform").innerHTML = \'<form action="?subtopic=latestnews&action=newnews" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="images/news/icon_0.gif" width="20"></td><td><img src="images/news/icon_1.gif" width="20"></td><td><img src="images/news/icon_2.gif" width="20"></td><td><img src="images/news/icon_3.gif" width="20"></td><td><img src="images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="F1E0C6"><b>Topic:</b></td><td><input type="text" name="topic" maxlenght="50" style="width: 300px" ></td></tr><tr><td align="center" bgcolor="D4C0A1"><b>News<br>text:</b></td><td bgcolor="F1E0C6"><textarea name="text" rows="6" cols="60"></textarea></td></tr><tr><td width="180"><b>Character:</b></td><td><select name="char_id"><option value="0">(Choose character)</option>'.$str.'</select></td></tr><tr><td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="showNewNewsForm()" alt="CancelAddNews" /></div></div></td></tr></table>\';
document.getElementById("chicken").innerHTML = \'\';
showednewnews_state = "1";
}
else {
document.getElementById("newnewsform").innerHTML = \'\';
document.getElementById("chicken").innerHTML = \'<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddNews" src="'.$layout_name.'/images/buttons/addnews.gif" onClick="showNewNewsForm()" alt="AddNews" /></div></div>\';
showednewnews_state = "0";
}
}
</script><div id="newnewsform"></div><div id="chicken"><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddNews" src="'.$layout_name.'/images/buttons/addnews.gif" onClick="showNewNewsForm()" alt="AddNews" /></div></div></div><hr/>';$zapytanie = $SQL->query("SELECT `z_forum`.`icon_id`,`z_forum`.`post_topic`, `z_forum`.`author_guid`, `z_forum`.`post_date`, `z_forum`.`post_text`, `z_forum`.`id`, `z_forum`.`replies`, `players`.`name` FROM `z_forum`, `players` WHERE `section` = '1' AND `z_forum`.`id` = `first_post` AND `players`.`id` = `z_forum`.`author_guid` ORDER BY `post_date` DESC LIMIT 3;")->fetchAll();
}
///show news
$zapytanie = $SQL->query("SELECT `z_forum`.`icon_id`, `z_forum`.`post_topic`, `z_forum`.`author_guid`, `z_forum`.`post_date`, `z_forum`.`post_text`, `z_forum`.`id`, `z_forum`.`replies`, `players`.`name` FROM `z_forum`, `players` WHERE `section` = '1' AND `z_forum`.`id` = `first_post` AND `players`.`id` = `z_forum`.`author_guid` ORDER BY `post_date` DESC LIMIT 3;")->fetchAll();
foreach ($zapytanie as $row)
{
         $BB = array(
		'/\[youtube\](.*?)\[\/youtube\]/is' => '<center><object width="500" height="405"><param name="movie" value="http://www.youtube.com/v/$1&hl=pt-br&fs=1&rel=0&color1=0x3a3a3a&color2=0x999999&border=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/$1&hl=pt-br&fs=1&rel=0&color1=0x3a3a3a&color2=0x999999&border=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="500" height="405"></embed></object></center>',
		'/\[b\](.*?)\[\/b\]/is' => '<strong>$1</strong>',
		'/\[center\](.*?)\[\/center\]/is' => '<center>$1</center>',
		'/\[quote\](.*?)\[\/quote\]/is' => '<table cellpadding="0" style="background-color: #c4c4c4; width: 480px; border-style: dotted; border-color: #007900; border-width: 2px"><tr><td>$1</td></tr></table>',
		'/\[u\](.*?)\[\/u\]/is' => '<u>$1</u>',
		'/\[i\](.*?)\[\/i\]/is' => '<i>$1</i>',
		'/\[letter\](.*?)\[\/letter\]/is' => '<img src=images/letters/$1.gif alt=$1 />',
		'/\[url](.*?)\[\/url\]/is' => '<a href=$1>$1</a>',
		'/\[color\=(.*?)\](.*?)\[\/color\]/is' => '<span style="color: $1;">$2</span>',
		'/\[img\](.*?)\[\/img\]/is' => '<img src=$1 alt=$1 />',
		'/\[player\](.*?)\[\/player\]/is' => '<a href='.$server['ip'].'?subtopic=characters&amp;name=$1>$1</a>',
		'/\[code\](.*?)\[\/code\]/is' => '<div dir="ltr" style="margin: 0px;padding: 2px;border: 1px inset;width: 500px;height: 290px;text-align: left;overflow: auto"><code style="white-space:nowrap">$1</code></div>'
		);
		$message = preg_replace(array_keys($BB), array_values($BB), nl2br($row['post_text']));
        $main_content .= '<div class=\'NewsHeadline\'>
		<div class=\'NewsHeadlineBackground\' style=\'background-image:url('.$layout_name.'/images/news/newsheadline_background.gif)\'>
		<table border=0><tr><td><img src="'.$layout_name.'/images/news/icon_'.$row['icon_id'].'.gif" class=\'NewsHeadlineIcon\' alt=\'\' />
		</td><td><font color="'.$layout_ini['news_title_color'].'">'.date('d.m.y H:i:s', $row['post_date']).' - <b>'.$row['post_topic'].'</b></font></td></tr></table>
		</div>
		</div>
		<table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'><tr>
		<td><img src="'.$layout_name.'/images/global/general/blank.gif" width=10 height=1 border=0 alt=\'\' /></td>';
		if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
		{
			$main_content .='<td width="100%">'.$message.'<br><h6><i>Posted by </i><font color="green">'.$row['name'].'</font><br>

<div class="fb-like" data-href="http://www.facebook.com/otsmateriaPL" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="trebuchet ms"></div>


<br><br>
</h6><p align="right"><a href="?subtopic=forum&action=remove_post&id='.$row['id'].'"><font color="red">[Delete this news]</font></a>  <a href="?subtopic=forum&action=edit_post&id='.$row['id'].'"><font color="green">[Edit this news]</font></a><br>

';
		}
		else		
		{
			$main_content .='<td width="100%">'.$message.'<br><h6><i>Posted by </i><font color="green">'.$row['name'].'</font></h6><p align="right"></p>
<div class="fb-like" data-href="http://www.facebook.com/otsmateriaPL" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="trebuchet ms"></div>
<br><br>';		
		}
		$main_content .= '</td>
		<td><img src="'.$layout_name.'/images/global/general/blank.gif" width=10 height=1 border=0 alt=\'\' /></td>
		</tr></table>';
}

?>

