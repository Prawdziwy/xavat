<?php
	$doc = new DomDocument();
	$doc->load('/home/bodek/karmia/data/monster/monsters.xml');
	$i = 60100;
	foreach($doc->getElementsByTagName('monster') as $monster)
	{
		echo "['" . strtolower($monster->getAttribute('name')) . "'] = " . $i . ",<br />";
		$i++;
	}
?>