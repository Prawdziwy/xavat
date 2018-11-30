<?php
	$config['site'] = @parse_ini_file('./config/config.ini');
	$lang['site'] = @parse_ini_file('./lang/lang_eng.lua');
	
	require_once('./config/config.php');
	require_once('./pot/OTS.php');

	if($config['site']['install'] != "no")
	{
		header("Location: install.php");
		exit;
	}

	$config['server'] = @parse_ini_file($config['site']['server_path'] . "config.lua");

	$mysqlhost = $config['server']['sqlHost'];
	$mysqluser = $config['server']['sqlUser'];
	$mysqlpass = $config['server']['sqlPass'];
	$mysqldatabase = $config['server']['sqlDatabase'];

	$passwordency = "";
	if(strtolower($config['server']['encryptionType']) == "md5")
		$passwordency = "md5";
	if(strtolower($config['server']['encryptionType']) == "sha1")
		$passwordency = "sha1";
	
	$ots = POT::getInstance();
	if(strtolower($config['server']['sqlType']) == "mysql")
	{
		try
		{
			$ots->connect(POT::DB_MYSQL, array('host' => $mysqlhost, 'user' => $mysqluser, 'password' => $mysqlpass, 'database' => $mysqldatabase) );
		}
		catch(PDOException $error)
		{
			echo 'Database error - can\'t connect to MySQL database. Possible reasons:<br>1. MySQL server is not running on host.<br>2. MySQL user, password, database or host isn\'t configured in: <b>'.$config['site']['server_path'].'config.lua</b> .<br>3. MySQL user, password, database or host is wrong.';
			die(0);
		}
	}
	elseif(strtolower($config['server']['sqlType']) == "sqlite")
	{
		$link_to_sqlitedatabase = $config['site']['server_path'].$sqlitefile;
		try
		{
			$ots->connect(POT::DB_SQLITE, array('database' => $link_to_sqlitedatabase));
		}
		catch(PDOException $error)
		{
			echo 'Database error - can\'t open SQLite database. Possible reasons:<br><b>'.$link_to_sqlitedatabase.'</b> - file isn\'t valid SQLite database.<br><b>'.$link_to_sqlitedatabase.'</b> - doesn\'t exist.<br><font color="red">Wrong PHP configuration. Default PHP does not work with SQLite databases!</font>';
			die(0);
		}
	}
	else
	{
		echo 'Database error. Unknown database type in <b>'.$config['site']['server_path'].'config.lua</b> . Must be equal to: "<b>mysql</b>" or "<b>sqlite</b>". Now is: "<b>'.strtolower($config['server']['sqlType']).'"</b>';
		die(0);
	}

	$db = POT::getInstance()->getDBHandle();
	$layout_name = "./layouts/" . $layout_name = $config['site']['layout'];
	$layout_ini = @parse_ini_file($layout_name . "/layout_config.ini");
	foreach($layout_ini as $key => $value)
		$config['site'][$key] = $value;
		
	function isPremium($premdays, $lastday)
	{
		return ($premdays - (date("z", time()) + (365 * (date("Y", time()) - date("Y", $lastday))) - date("z", $lastday)) > 0);
	}
	
	function saveconfig_ini($config)
	{
		$file = fopen("./config/config.ini", "w");
		foreach($config as $param => $data)
		{
			$file_data .= $param . ' = "' . str_replace('"', '', $data) . '"';
		}
		rewind($file);
		fwrite($file, $file_data);
		fclose($file);
	}
	
	function password_ency($password)
	{
		$ency = $GLOBALS['passwordency'];
		if(empty($ency))
			return $password;
		elseif($ency == 'sha1')
			return sha1($password);
		elseif($ency == 'md5')
			return md5($password);
	}
	
	function coloured_value($valuein)
	{
		if($valuein > 0)
			return '<font color="green">+' . number_format($valuein, 0, '.', '.') . '</font>';
		elseif($valuein < 0)
			return '<font color="red">' . number_format($valuein, 0, '.', '.') . '</font>';
		else
			return '<font color="black">' . number_format($valuein, 0, '.', '.') . '</font>';
	}
	
	if(isSet($_GET['langz']))
	{
		$langz = $_GET['langz'];
		$_SESSION['langz'] = $langz;
		setcookie('langz', $langz, time() + (3600 * 24 * 30));
	}
	else if(isSet($_SESSION['langz']))
	{
		$langz = $_SESSION['langz'];
	}
	else if(isSet($_COOKIE['langz']))
	{
		$langz = $_COOKIE['langz'];
	}
	else
	{
		$langz = 'pl';
	}
	
	function delete_player($name)
	{
		$db = $GLOBALS['db'];
		$player = new OTS_Player();
		$player->find($name);
		if($player->isLoaded())
		{
			try { $db->query("DELETE FROM player_skills WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM guild_invites WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_items WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_depotitems WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_spells WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_storage WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_viplist WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_deaths WHERE player_id = '".$player->getId()."';"); } catch(PDOException $error) {}
			try { $db->query("DELETE FROM player_deaths WHERE killed_by = '".$player->getId()."';"); } catch(PDOException $error) {}
			$rank = $player->getRank();
			if(!empty($rank))
			{
				$guild = $rank->getGuild();
				if($guild->getOwner()->getId() == $player->getId())
				{
					$rank_list = $guild->getGuildRanksList();
					if(count($rank_list) > 0)
					{
						$rank_list->orderBy('level');
						foreach($rank_list as $rank_in_guild)
						{
							$players_with_rank = $rank_in_guild->getPlayersList();
							$players_with_rank->orderBy('name');
							$players_with_rank_number = count($players_with_rank);
							if($players_with_rank_number > 0)
							{
								foreach($players_with_rank as $player_in_guild)
								{
									$player_in_guild->setRank();
									$player_in_guild->save();
								}
							}
							$rank_in_guild->delete();
						}
						$guild->delete();
					}
				}
			}
			$player->delete();
			return true;
		}
	}

function delete_guild($id)
{
	$guild = new OTS_Guild();
	$guild->load($id);
	if($guild->isLoaded())
	{
		$rank_list = $guild->getGuildRanksList();
		if(count($rank_list) > 0)
		{
			$rank_list->orderBy('level');
			foreach($rank_list as $rank_in_guild)
			{
				$players_with_rank = $rank_in_guild->getPlayersList();
				if(count($players_with_rank) > 0)
				{
					foreach($players_with_rank as $player_in_guild)
					{
						$player_in_guild->setRank();
						$player_in_guild->save();
					}
				}
				$rank_in_guild->delete();
			}
		}
		$guild->delete();
		return true;
	}
	else
		return false;
}

function check_name($name)
{
	$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- [ ] '");
	if($temp != strlen($name))
		return false;
	
	$ok = "/[a-zA-Z ']{1,25}/";
	return (preg_match($ok, $name)) ? true : false;
}

function check_account_name($name)
{
	$temp = strspn("$name", "QWERTYUIOPASDFGHJKLZXCVBNM0123456789");
	if($temp != strlen($name))
		return false;
	
	if(strlen($name) > 32)
		return false;

	$ok = "/[A-Z0-9]/";
	return (preg_match($ok, $name)) ? true : false;
}

function check_name_new_char($name)
{
	$name_to_check = strtolower($name);
	//first word can't be:
	//names blocked:
	$names_blocked = array('gm','cm', 'god', 'tutor');
	$first_words_blocked = array('gm ','cm ', 'god ','tutor ', "'", '-');
	//name can't contain:
	$words_blocked = array('gamemaster', 'game master', 'game-master', "game'master", '--', "''","' ", " '", '- ', ' -', "-'", "'-", 'fuck', 'sux', 'suck', 'noob', 'tutor');
	foreach($first_words_blocked as $word)
		if($word == substr($name_to_check, 0, strlen($word)))
			return false;
	if(substr($name_to_check, -1) == "'" || substr($name_to_check, -1) == "-")
		return false;
	if(substr($name_to_check, 1, 1) == ' ')
		return false;
	if(substr($name_to_check, -2, 1) == " ")
		return false;
	foreach($names_blocked as $word)
		if($word == $name_to_check)
			return false;
	foreach($GLOBALS['config']['site']['monsters'] as $word)
		if($word == $name_to_check)
			return false;
	foreach($GLOBALS['config']['site']['npc'] as $word)
		if($word == $name_to_check)
			return false;
	for($i = 0; $i < strlen($name_to_check); $i++)
		if($name_to_check[$i-1] == ' ' && $name_to_check[$i+1] == ' ')
			return false;
	foreach($words_blocked as $word)
		if (!(strpos($name_to_check, $word) === false))
			return false;
	for($i = 0; $i < strlen($name_to_check); $i++)
		if($name_to_check[$i] == $name_to_check[($i+1)] && $name_to_check[$i] == $name_to_check[($i+2)])
			return false;
	for($i = 0; $i < strlen($name_to_check); $i++)
		if($name_to_check[$i-1] == ' ' && $name_to_check[$i+1] == ' ')
			return false;
	$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- '");
	if ($temp != strlen($name))
		return false;
	else
	{
		$ok = "/[a-zA-Z ']{1,25}/";
		return (preg_match($ok, $name))? true: false;
	}
}

	function check_rank_name($name)
	{
		$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789-[ ] ");
		if($temp != strlen($name))
			return false;
			
		$ok = "/[a-zA-Z ]{1,60}/";
		return (preg_match($ok, $name)) ? true : false;
	}

	function check_guild_name($name)
	{
		$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789- ");
		if($temp != strlen($name))
			return false;
			
		$ok = "/[a-zA-Z ]{1,60}/";
		return (preg_match($ok, $name)) ? true : false;
	}

	function check_password($pass)
	{
		$temp = strspn("{$pass}", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890");
		if($temp != strlen($pass))
			return false;

		$ok = "/[a-zA-Z0-9]{1,40}/";
		return (preg_match($ok, $pass)) ? true : false;
	}

	function check_mail($email)
	{
		$ok = "/[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,4}/";
		return (preg_match($ok, $email)) ? true : false;
	}

	function short_text($text, $chars_limit) 
	{
		if(strlen($text) > $chars_limit)
			return substr($text, 0, strrpos(substr($text, 0, $chars_limit), " ")) . '...';
		else
			return $text;
	}
	
	function getExperienceForLevel($level)
	{
		$lv = $level - 1;
		return floor(((50 * $lv * $lv * $lv) - (150 * $lv * $lv) + (400 * $lv)) / 3);
	}

	function getExperiencePercent($level, $exp) 
    {    
        $lv = $level -1;$eX = (((50 * $lv * $lv * $lv) - (150 * $lv * $lv) + (400 * $lv)) / 3);
        $eXx = (((50 * $level * $level * $level) - (150 * $level * $level) + (400 * $level)) / 3);
        return floor((($exp - $eX) / ($eXx - $eX) * 100));
    }

	function getManaSpentPercentage($maglv, $spent, $voc) 
    {
        $array = array(0 => 4.0, 1 => 1.1, 2 => 1.1, 3 => 1.4, 4 => 3.0);
        return floor(($spent / (1600 * pow($array[$voc], $maglv))) * 100);
    }

	function getSkillTriesPercentage($skill, $level, $tries, $voc) 
    {
        $base = array(0 => 50, 1 => 50, 2 => 50, 3 => 50, 4 => 30, 5 => 100, 6 => 20);
        $array = array
		(
            0 => array(1.5, 2.0, 2.0, 2.0, 2.0, 1.5, 1.1),//none,rookie
            1 => array(1.5, 2.0, 2.0, 2.0, 2.0, 1.5, 1.1),//sorcerer
            2 => array(1.5, 1.8, 1.8, 1.8, 1.8, 1.5, 1.1),//druid
            3 => array(1.2, 1.2, 1.2, 1.2, 1.1, 1.1, 1.1),//paladin
            4 => array(1.1, 1.1, 1.1, 1.1, 1.4, 1.1, 1.1)//knight
		);
        $formula = floor(($tries / ($base[$skill] * pow($array[$voc][$skill], ($level+1) - 11)) * 100));
        return $formula > 100 ? 99 : $formula;
    }

	function news_place()
	{
		/*
		$news = "";
		if($GLOBALS['subtopic'] == "latestnews")
		{
			$news .= $GLOBALS['news_content'];
			$layout_name = $GLOBALS['layout_name'];
			$news .= '
			<div id="featuredarticle" class="Box">
				<div class="Corner-tl" style="background-image:url('.$layout_name.'/images/content/corner-tl.gif);"></div>
				<div class="Corner-tr" style="background-image:url('.$layout_name.'/images/content/corner-tr.gif);"></div>
				<div class="Border_1" style="background-image:url('.$layout_name.'/images/content/border-1.gif);"></div>
				<div class="BorderTitleText" style="background-image:url('.$layout_name.'/images/content/title-background-green.gif);"></div>
				<img class="Title" src="'.$layout_name.'/images/strings/headline-featuredarticle.gif" alt="Contentbox headline" />
				<div class="Border_2">
					<div class="Border_3">
						<div class="BoxContent" style="background-image:url('.$layout_name.'/images/content/scroll.gif);">
							<div id=\'TeaserThumbnail\'>
								<img src="'.$layout_name.'/images/news/features.jpg" width=150 height=100 border=0 alt="" />
							</div>
							<div id=\'TeaserText\'>
								<div style="position: relative; top: -2px; margin-bottom: 2px;">Title</div>
								Content
							</div>
						</div>
					</div>
				</div>
					
				<div class="Border_1" style="background-image:url('.$layout_name.'/images/content/border-1.gif);"></div>
				<div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url('.$layout_name.'/images/content/corner-bl.gif);"></div></div>
				<div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url('.$layout_name.'/images/content/corner-br.gif);"></div></div>
			</div>';
		}
		
		return $news;
		*/
	}
	
	function logo_monster()
	{
		return str_replace(" ", "", trim(mb_strtolower($GLOBALS['layout_ini']['logo_monster'])));
	}
	
	$statustimeout = 1;
	foreach(explode("*", str_replace(" ", "", $config['server']['statusTimeout'])) as $status_var)
		if($status_var > 0)
			$statustimeout = $statustimeout * $status_var;
			
		$statustimeout = $statustimeout / 1000;
		$config['status'] = @parse_ini_file('config/serverstatus');
		if($config['status']['serverStatus_lastCheck']+$statustimeout < time())
		{
			$config['status']['serverStatus_checkInterval'] = $statustimeout + 3;
			$config['status']['serverStatus_lastCheck'] = time();
			$info = chr(6).chr(0).chr(255).chr(255).'info';
			$sock = @fsockopen($config['server']['ip'], $config['server']['statusPort'], $errno, $errstr, 1);
			if($sock)
			{
				fwrite($sock, $info); 
				$data=''; 
				while(!feof($sock))
					$data .= fgets($sock, 1024);
				
				fclose($sock);
				preg_match('/players online="(\d+)" max="(\d+)"/', $data, $matches);
				$config['status']['serverStatus_online'] = 1;
				$config['status']['serverStatus_players'] = $matches[1];
				$config['status']['serverStatus_playersMax'] = $matches[2];
				preg_match('/uptime="(\d+)"/', $data, $matches);
				$h = floor($matches[1] / 3600);
				$m = floor(($matches[1] - $h * 3600) / 60);
				$config['status']['serverStatus_uptime'] = $h . 'h ' . $m . 'm';
				preg_match('/monsters total="(\d+)"/', $data, $matches);
				$config['status']['serverStatus_monsters'] = $matches[1];
				preg_match('/npcs total="(\d+)"/', $data, $matches);
				$config['status']['serverStatus_npcs'] = $matches[1];
			}
			else
			{
				$config['status']['serverStatus_online'] = 0;
				$config['status']['serverStatus_players'] = 0;
				$config['status']['serverStatus_playersMax'] = 0;
			}
			
			$file = fopen("./config/serverstatus", "w");
			foreach($config['status'] as $param => $data)
			{
				$file_data .= $param.' = "'.str_replace('"', '', $data).'"
				';
			}
			
			rewind($file);
			fwrite($file, $file_data);
			fclose($file);
		}

	$views_counter = "./usercounter.dat";
	if(file_exists($views_counter))
	{
		$actie = fopen($views_counter, "r+"); 
		$page_views = fgets($actie, 9); 
		$page_views++; 
		rewind($actie); 
		fputs($actie, $page_views, 9); 
		fclose($actie); 
	}
	else
	{
		$actie = fopen($views_counter, "w"); 
		$page_views = 1; 
		fputs($actie, $page_views, 9); 
		fclose($actie); 
	}
	
	function revertIp($str)
	{
		$ip = explode(".", $str);
		return $ip[3] . "." . $ip[2] . "." . $ip[1] . "." . $ip[0];
	}
	
	function items()
	{
		$items = array();
		/*
		$doc = new DOMDocument;
		$doc->load('/home/xavato/xavato/data/items/items.xml');
		foreach($doc->getElementsByTagName('item') as $item)
		{
			$items[$item->getAttribute('id')] = array();
			$items[$item->getAttribute('id')]['article'] = $item->getAttribute('article') or 'a';
			$items[$item->getAttribute('id')]['name'] = $item->getAttribute('name') or 'Unknown';
			$items[$item->getAttribute('id')]['plural'] = $item->getAttribute('plural') or 'Unknowns';
			foreach($item->getElementsByTagName('attribute') as $attr)
				$items[$item->getAttribute('id')][$attr->getAttribute('key')] = $attr->getAttribute('value');
		}
		*/

		return $items;
	}
	
	function makeOrder($arr, $order, $default)
	{
		// Function by Colandus!
		$type = 'asc';
		if(isset($_GET['order']))
		{
			$v = explode('_', strrev($_GET['order']), 2);
			if(count($v) == 2)
				if($orderBy = $arr[strrev($v[1])])
					$default = $orderBy;
					
				$type = (strrev($v[0]) == 'asc' ? 'desc' : 'asc');
		}

		return 'ORDER BY ' . $default . ' ' . $type;
	}

	function getOrder($arr, $order, $this)
	{
		// Function by Colandus!
		$type = 'asc';
		if($orderBy = $arr[$this])
			if(isset($_GET[$order]))
			{
				$v = explode('_', strrev($_GET[$order]), 2);
				if(strrev($v[1]) == $this)
					$type = (strrev($v[0]) == 'asc' ? 'desc' : 'asc');
		}

		return $this . '_' . $type;
	} 
	
	class EQShower
	{
		function item_info($val, $attributes)
		{
			$EQShower = new EQShower;
			$cl = $EQShower->item_grade($attributes, $val[0]);

			empty($val[1]) ? $desc_str = "" : $desc_str = "<br /><br />" . $val[1];
			empty($val[2]) ? $arm_str = "" : $arm_str = "Armor: " . $val[2] . "<br />";
			empty($val[4]) ? $size_str = "" : $size_str = "Size: " . $val[4]." slots<br />";
			empty($val[5]) ? $att_str = "" : $att_str = "Attack: " . $val[5] . "<br />";
			empty($val[6]) ? $sp_str = "" : $sp_str = "Speed: +" . $val[6] . "<br />";
			empty($val[13]) ? $def_a = "" : $def_a = "+ " . $val[13];
			empty($val[7]) ? $def_str = "" : $def_str = "Defense: " . $val[7] . "$def_a<br />";
			if(!empty($val[8]))
				$el_str = "Fire: " . $val[8] . "<br />";
				
			if(!empty($val[9]))
				$el_str = "Ice: " . $val[9] . "<br />";
				
			if(!empty($val[10]))
				$el_str = "Earth: " . $val[10] . "<br />";
				
			if(!empty($val[11]))
				$el_str = "Energy: " . $val[11] . "<br />";
				
			empty($val[12]) ? $ran_str = "" : $ran_str = "Range: " . $val[12] . "<br />";
			empty($val[14]) ? $sk_sh = "" : $sk_sh = "Shielding: +" . $val[14] . "<br />";
			empty($val[15]) ? $sk_mag = "" : $sk_mag = "Magic: +" . $val[15] . "<br />"; 
			empty($val[16]) ? $eb_all = "" : $eb_all = "Protection All: " . $val[16] . "%<br />"; 
			empty($val[17]) ? $charg_str = "" : $charg_str = "Charges: " . $val[17] . "<br />";
			empty($val[18]) ? $sk_dist = "" : $sk_dist = "Distance: +" . $val[18] . "<br />"; 
			empty($val[19]) ? $eb_fire = "" : $eb_fire = "Protection fire: " . $val[19] . "%<br />"; 
			empty($val[20]) ? $eb_earth = "" : $eb_earth = "Protection earth: " . $val[20] . "%<br />"; 
			empty($val[21]) ? $eb_ice = "" : $eb_ice = "Protection ice: " . $val[21] . "%<br />"; 
			empty($val[22]) ? $eb_ene = "" : $eb_ene = "Protection energy: " . $val[22] . "%<br />";   
			empty($val[23]) ? $eb_dth = "" : $eb_dth = "Protection death: " . $val[23] . "%<br />"; 
			empty($val[24]) ? $eb_hol = "" : $eb_hol = "Protection holy: " . $val[24] . "%<br />"; 
			empty($val[25]) ? $eb_pys = "" : $eb_pys = "Protection physical: " . $val[25] . "%<br />"; 
			empty($val[26]) ? $sk_axe = "" : $sk_axe = "Axe: +" . $val[26] . "<br />";
			empty($val[27]) ? $sk_club = "" : $sk_club = "Club: +" . $val[27] . "<br />";
			empty($val[28]) ? $sk_sword = "" : $sk_sword = "Sword: +" . $val[28] . "<br />";
			empty($val[29]) ? $dura = "" : $dura = "Duration: " . $val[29] . " minutes.<br />";
			empty($val[30]) ? $sk_fist = "" : $sk_fist = "Fist: +" . $val[30] . "<br />";
			empty($val[31]) ? $eb_mana = "" : $eb_mana = "Protection manadrain: " . $val[31] . "%<br />"; 
			empty($val[32]) ? $eb_life = "" : $eb_life = "Protection lifedrain: " . $val[32] . "%<br />";
			empty($val[33]) ? $eb_drop = "" : $eb_drop = "Protection drop: " . $val[33] . "%<br />";
			empty($val[34]) ? $hit_ch = "" : $hit_ch = "Hit chance: " . $val[34] . "%<br />";
			empty($val[35]) ? $sh_type = "" : $sh_type = "Element: " . $val[35] . "<br />";

			if(empty($val[8]) and empty($val[9]) and empty($val[10]) and empty($val[11]))
				$ele_str = "";

			$str = "<div class=\'$cl\' >" . strtoupper($val[0]) . "<br /><br /></div><font class=\'attr\'>$arm_str $sp_str $sh_type $att_str $ran_str $def_str $hit_ch $sk_sh $sk_sword $sk_axe $sk_club $sk_fist $sk_mag $sk_dist $eb_all $eb_drop $eb_mana $eb_life $eb_fire $eb_earth $eb_ice $eb_ene $eb_dth $eb_hol $eb_pys $el_str $charg_str $dura $size_str Weight: ".($val[3]/100)."oz.</font><font class=\'description\'>$desc_str</font>";
			return $str;
		}

		function item_grade($attributes,$name)
		{
			require('equipshower/eqshower-config.php');

			if(!array_key_exists($name,$exceptions))
			{
				if($attributes <= $config['normal']['attributes'])
					return $config['class']['normal'];
					
				if($attributes == $config['rare']['attributes'])
					return $config['class']['rare'];
					
				if($attributes == $config['epic']['attributes'])
					return $config['class']['epic'];
					
				if($attributes >= $config['legendary']['attributes'])
					return $config['class']['legendary'];
			}
			else
				return $config['class'][$exceptions[$name]];
		}

		function table_exists($table, $db)
		{ 
			$tables = mysql_list_tables($db); 
			while(list($temp) = mysql_fetch_array($tables))
			{
				if($temp == $table)
					return true;
			}
			
			return false;
		}
	}
		
	function parse_bbcode($text, $xhtml = true)
	{
		$tags = array(
			'#\[b\](.*?)\[/b\]#si' => ($xhtml ? '<strong>\\1</strong>' : '<b>\\1</b>'),
			'#\[i\](.*?)\[/i\]#si' => ($xhtml ? '<em>\\1</em>' : '<i>\\1</i>'),
			'#\[u\](.*?)\[/u\]#si' => ($xhtml ? '<span style="text-decoration: underline;">\\1</span>' : '<u>\\1</u>'),
			'#\[s\](.*?)\[/s\]#si' => ($xhtml ? '<strike>\\1</strike>' : '<s>\\1</s>'),
			'#\[color=(.*?)\](.*?)\[/color\]#si' => ($xhtml ? '<span style="color: \\1;">\\2</span>' : '<font color="\\1">\\2</font>'),
			'#\[img\](.*?)\[/img\]#si' => ($xhtml ? '<img src="\\1" border="0" alt="" />' : '<img src="\\1" border="0" alt="">'),
			'#\[url=(.*?)\](.*?)\[/url\]#si' => '<a href="\\1" title="\\2">\\2</a>',
			'#\[email\](.*?)\[/email\]#si' => '<a href="mailto:\\1" title="Email \\1">\\1</a>',
			'#\[code\](.*?)\[/code\]#si' => '<code>\\1</code>',
			'#\[align=(.*?)\](.*?)\[/align\]#si' => ($xhtml ? '<div style="text-align: \\1;">\\2</div>' : '<div align="\\1">\\2</div>'),
			'#\[br\]#si' => ($xhtml ? '<br style="clear: both;" />' : '<br>'),
		);

		foreach ($tags AS $search => $replace)
		{
			$text = preg_replace($search, $replace, $text);
		}
		return $text;
	}
	
	function getIP()
	{
		$ip = "";
		if(getenv('HTTP_CLIENT_IP'))
			$ip = getenv('HTTP_CLIENT_IP');
		elseif (getenv('HTTP_X_FORWARDED_FOR'))
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		elseif (getenv('HTTP_X_FORWARDED'))
			$ip = getenv('HTTP_X_FORWARDED');
		elseif (getenv('HTTP_FORWARDED_FOR'))
			$ip = getenv('HTTP_FORWARDED_FOR');
		elseif (getenv('HTTP_FORWARDED'))
			$ip = getenv('HTTP_FORWARDED');
		else
			$ip = $_SERVER['REMOTE_ADDR'];
			
		return $ip;
	}
	
	$countries = array(
		'af'=>'afghanistan',
		'al'=>'albania',
		'dz'=>'algeria',
		'as'=>'american samoa',
		'ad'=>'andorra',
		'ao'=>'angola',
		'ai'=>'anguilla',
		'aq'=>'antarctica',
		'ag'=>'antigua and barbuda',
		'ar'=>'argentina',
		'am'=>'armenia',
		'aw'=>'aruba',
		'au'=>'australia',
		'at'=>'austria',
		'az'=>'azerbaijan',
		'bs'=>'bahamas',
		'bh'=>'bahrain',
		'bd'=>'bangladesh',
		'bb'=>'barbados',
		'by'=>'belarus',
		'be'=>'belgium',
		'bz'=>'belize',
		'bj'=>'benin',
		'bm'=>'bermuda',
		'bt'=>'bhutan',
		'bo'=>'bolivia',
		'ba'=>'bosnia and herzegovina',
		'bw'=>'botswana',
		'bv'=>'bouvet island',
		'br'=>'brazil',
		'io'=>'british indian ocean territory',
		'bn'=>'brunei darussalam',
		'bg'=>'bulgaria',
		'bf'=>'burkina faso',
		'bi'=>'burundi',
		'kh'=>'cambodia',
		'cm'=>'cameroon',
		'ca'=>'canada',
		'cv'=>'cape verde',
		'ky'=>'cayman islands',
		'cf'=>'central african republic',
		'td'=>'chad',
		'cl'=>'chile',
		'cn'=>'china',
		'cx'=>'christmas island',
		'cc'=>'cocos (keeling) islands',
		'co'=>'colombia',
		'km'=>'comoros',
		'cg'=>'congo',
		'cd'=>'congo, the democratic republic of the',
		'ck'=>'cook islands',
		'cr'=>'costa rica',
		'ci'=>'cote d ivoire',
		'hr'=>'croatia',
		'cu'=>'cuba',
		'cy'=>'cyprus',
		'cz'=>'czech republic',
		'dk'=>'denmark',
		'dj'=>'djibouti',
		'dm'=>'dominica',
		'do'=>'dominican republic',
		'tp'=>'east timor',
		'ec'=>'ecuador',
		'eg'=>'egypt',
		'sv'=>'el salvador',
		'gq'=>'equatorial guinea',
		'er'=>'eritrea',
		'ee'=>'estonia',
		'et'=>'ethiopia',
		'fk'=>'falkland islands (malvinas)',
		'fo'=>'faroe islands',
		'fj'=>'fiji',
		'fi'=>'finland',
		'fr'=>'france',
		'gf'=>'french guiana',
		'pf'=>'french polynesia',
		'tf'=>'french southern territories',
		'ga'=>'gabon',
		'gm'=>'gambia',
		'ge'=>'georgia',
		'de'=>'germany',
		'gh'=>'ghana',
		'gi'=>'gibraltar',
		'gr'=>'greece',
		'gl'=>'greenland',
		'gd'=>'grenada',
		'gp'=>'guadeloupe',
		'gu'=>'guam',
		'gt'=>'guatemala',
		'gn'=>'guinea',
		'gw'=>'guinea-bissau',
		'gy'=>'guyana',
		'ht'=>'haiti',
		'hm'=>'heard island and mcdonald islands',
		'va'=>'holy see (vatican city state)',
		'hn'=>'honduras',
		'hk'=>'hong kong',
		'hu'=>'hungary',
		'is'=>'iceland',
		'in'=>'india',
		'id'=>'indonesia',
		'ir'=>'iran, islamic republic of',
		'iq'=>'iraq',
		'ie'=>'ireland',
		'il'=>'israel',
		'it'=>'italy',
		'jm'=>'jamaica',
		'jp'=>'japan',
		'jo'=>'jordan',
		'kz'=>'kazakstan',
		'ke'=>'kenya',
		'ki'=>'kiribati',
		'kp'=>'korea democratic peoples republic of',
		'kr'=>'korea republic of',
		'kw'=>'kuwait',
		'kg'=>'kyrgyzstan',
		'la'=>'lao peoples democratic republic',
		'lv'=>'latvia',
		'lb'=>'lebanon',
		'ls'=>'lesotho',
		'lr'=>'liberia',
		'ly'=>'libyan arab jamahiriya',
		'li'=>'liechtenstein',
		'lt'=>'lithuania',
		'lu'=>'luxembourg',
		'mo'=>'macau',
		'mk'=>'macedonia, the former yugoslav republic of',
		'mg'=>'madagascar',
		'mw'=>'malawi',
		'my'=>'malaysia',
		'mv'=>'maldives',
		'ml'=>'mali',
		'mt'=>'malta',
		'mh'=>'marshall islands',
		'mq'=>'martinique',
		'mr'=>'mauritania',
		'mu'=>'mauritius',
		'yt'=>'mayotte',
		'mx'=>'mexico',
		'fm'=>'micronesia, federated states of',
		'md'=>'moldova, republic of',
		'mc'=>'monaco',
		'mn'=>'mongolia',
		'ms'=>'montserrat',
		'ma'=>'morocco',
		'mz'=>'mozambique',
		'mm'=>'myanmar',
		'na'=>'namibia',
		'nr'=>'nauru',
		'np'=>'nepal',
		'nl'=>'netherlands',
		'an'=>'netherlands antilles',
		'nc'=>'new caledonia',
		'nz'=>'new zealand',
		'ni'=>'nicaragua',
		'ne'=>'niger',
		'ng'=>'nigeria',
		'nu'=>'niue',
		'nf'=>'norfolk island',
		'mp'=>'northern mariana islands',
		'no'=>'norway',
		'om'=>'oman',
		'pk'=>'pakistan',
		'pw'=>'palau',
		'ps'=>'palestinian territory, occupied',
		'pa'=>'panama',
		'pg'=>'papua new guinea',
		'py'=>'paraguay',
		'pe'=>'peru',
		'ph'=>'philippines',
		'pn'=>'pitcairn',
		'pl'=>'poland',
		'pt'=>'portugal',
		'pr'=>'puerto rico',
		'qa'=>'qatar',
		're'=>'reunion',
		'ro'=>'romania',
		'ru'=>'russian federation',
		'rw'=>'rwanda',
		'sh'=>'saint helena',
		'kn'=>'saint kitts and nevis',
		'lc'=>'saint lucia',
		'pm'=>'saint pierre and miquelon',
		'vc'=>'saint vincent and the grenadines',
		'ws'=>'samoa',
		'sm'=>'san marino',
		'st'=>'sao tome and principe',
		'sa'=>'saudi arabia',
		'sn'=>'senegal',
		'sc'=>'seychelles',
		'sl'=>'sierra leone',
		'sg'=>'singapore',
		'sk'=>'slovakia',
		'si'=>'slovenia',
		'sb'=>'solomon islands',
		'so'=>'somalia',
		'za'=>'south africa',
		'gs'=>'south georgia and the south sandwich islands',
		'es'=>'spain',
		'lk'=>'sri lanka',
		'sd'=>'sudan',
		'sr'=>'suriname',
		'sj'=>'svalbard and jan mayen',
		'sz'=>'swaziland',
		'se'=>'sweden',
		'ch'=>'switzerland',
		'sy'=>'syrian arab republic',
		'tw'=>'taiwan, province of china',
		'tj'=>'tajikistan',
		'tz'=>'tanzania, united republic of',
		'th'=>'thailand',
		'tg'=>'togo',
		'tk'=>'tokelau',
		'to'=>'tonga',
		'tt'=>'trinidad and tobago',
		'tn'=>'tunisia',
		'tr'=>'turkey',
		'tm'=>'turkmenistan',
		'tc'=>'turks and caicos islands',
		'tv'=>'tuvalu',
		'ug'=>'uganda',
		'ua'=>'ukraine',
		'ae'=>'united arab emirates',
		'gb'=>'united kingdom',
		'us'=>'united states',
		'um'=>'united states minor outlying islands',
		'uy'=>'uruguay',
		'uz'=>'uzbekistan',
		'vu'=>'vanuatu',
		've'=>'venezuela',
		'vn'=>'viet nam',
		'vg'=>'virgin islands, british',
		'vi'=>'virgin islands, u.s.',
		'wf'=>'wallis and futuna',
		'eh'=>'western sahara',
		'ye'=>'yemen',
		'yu'=>'yugoslavia',
		'zm'=>'zambia',
		'zw'=>'zimbabwe',
	);
?>