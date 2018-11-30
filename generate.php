<?php
	$action = $_GET['action'];
	if($action == "monsters")
	{
		$mapa = ImageCreateFromPng("images/minimap.png");
		if($mapa === false)
			die("Cannot load minimap, report it to gamemaster!");
			
		$monster_name = trim($_GET['monster']);
		$point = ImageCreateFromPng("images/pointer.png");
		if($point === false)
			die("Cannot load pointer, report it to gamemaster!");
			
		$xml = simplexml_load_file("/home/bodek/karmia/data/world/world-spawn.xml"); 
		$spawns = new SimpleXMLElement($xml->asXML());  
		foreach ($spawns->spawn as $spawn)
		{
			foreach($spawn->monster as $monster)
			{
				if($monster['name'] == $monster_name)
				{
					$pos_x = $spawn['centerx'] + $monster['x'];
					$pos_y = $spawn['centery'] + $monster['y'];
					ImageCopy($mapa, $point, $pos_x, $pos_y, 0, 0, 12, 12);
				}
			}
		}

		header("Content-type: image/png");
		ImagePng($mapa);
		ImageDestroy($mapa);
	}
	elseif($action == "players")
	{
		try
		{
			$dbh = new PDO('mysql:dbname=xavato;host=127.0.0.1', 'root', '9imaXd9G');
		}
		catch (PDOException $e)
		{
			echo 'Connection failed: ' . $e->getMessage();
		}
	
		$cachefile = 'images/map_players.png';
		if(file_exists($cachefile) && (time() - 900 < filemtime($cachefile))) 
		{
			header("Content-type: image/png");
			echo file_get_contents($cachefile);
			exit;
		}
	
		$mapa = ImageCreateFromPng("images/minimap.png");
		if($mapa === false)
			die("Cannot load minimap, report it to gamemaster!");
			
		$point = ImageCreateFromPng("images/pointer.png");
		if($point === false)
			die("Cannot load pointer, report it to gamemaster!");	
	
		$black = imagecolorallocate($mapa, 0, 0, 0);
		$white = imagecolorallocate($mapa, 255, 255, 255);
		$players = $dbh->query("SELECT `posx`, `posy`, `name` FROM `players` WHERE `online` = 1;")->fetchAll();
		foreach($players as $player)
		{
			$pos_x = $player['posx'];
			$pos_y = $player['posy'];
			ImageCopy($mapa, $point, $pos_x, $pos_y, 0, 0, 12, 12);
			ImageString($mapa, 2, $pos_x, $pos_y, $player['name'], $black);
			ImageString($mapa, 2, $pos_x + 1, $pos_y - 1, $player['name'], $white);
			
		}
		
		header("Content-type: image/png");
		ImagePng($mapa, 'images/map_players.png', 9);
		ImageDestroy($mapa);
	}
?>