<?php
	function time_left($integer)
	{
		$weeks = 0;
		$days = 0;
		$hours = 0;
		$minutes = 0;
		$second = 0;
		$return = null;
		if($integer <= 0)
			return "Finished";
			
		$seconds = $integer;
		if($seconds / 60 >= 1)
		{
			$minutes = floor($seconds / 60);
			if($minutes / 60 >= 1)
			{
				$hours = floor($minutes / 60);
				if ($hours / 24 >= 1)
				{
					$days = floor($hours / 24);
					if ($days / 7 >= 1)
					{
						$weeks = floor($days / 7);
						if ($weeks >= 2)
							$return = "$weeks weeks";
						else
							$return = "$weeks week";
					}
					
					$days = $days - (floor($days / 7)) * 7;
					if($weeks >= 1 && $days >= 1)
						$return = "$return, ";
						
					if($days >= 2)
						$return = "$return $days d";
						
					if($days == 1)
						$return = "$return $days d";
						
				}
				
				$hours = $hours - (floor($hours / 24)) * 24;
				if($days >= 1 && $hours >= 1)
					$return = "$return, ";
					
				if($hours >= 2 || $hours == 0)
					$return = "$return $hours h";
					
				if($hours == 1)
					$return = "$return $hours h";
			}
			
			$minutes = $minutes - (floor($minutes / 60)) * 60;
			if($hours >= 1 && $minutes >= 1)
				$return = "$return, ";
				
			if($minutes >= 2 || $minutes == 0)
				$return = "$return $minutes m";
				
			if($minutes == 1)
				$return = "$return $minutes m";
				
		}
		
		$seconds = $integer - (floor($integer / 60)) * 60;
		if ($minutes >= 1 && $seconds >= 1)
			$return = "$return, ";
			
		if ($seconds >= 2 || $seconds == 0)
			$return = "$return $seconds sec";
			
		if ($seconds == 1)
			$return = "$return $seconds sec";
			
		$return = "$return.";
		return $return;
	}
	
	$main_content .= '<script type="text/javascript">function countdown(a,b){if(a<=0){document.getElementById(b).innerHTML="Finished";return 0}setTimeout(countdown,1e3,a-1,b);days=Math.floor(a/(60*60*24));a%=60*60*24;hours=Math.floor(a/(60*60));a%=60*60;minutes=Math.floor(a/60);a%=60;seconds=a;dps="s";hps="s";mps="s";sps="s";if(days==1)dps="";if(hours==1)hps="";if(minutes==1)mps="";if(seconds==1)sps="";innerHTML=days+" day"+dps+" ";innerHTML+=hours+" hour"+hps+" ";innerHTML+=minutes+" minute"+mps+" and ";innerHTML+=seconds+" second"+sps;document.getElementById(b).innerHTML=innerHTML}function checkBuyNow(a,b,c){if(!checkLogin(a))return false;if(b<c){alert("This character cost "+c+". You have only "+b+".");return false}var d=confirm("This character cost "+c+". Do you want to buy it?");if(d)return true;else return false}function checkBid(a,b,c,d){if(!checkLogin(a))return false;var e=window.document.getElementById("bid").value;if(e<=d){alert("Current highest bid is "+d+". You can not bid "+e+".");return false}if(e>c){alert("You can not bid "+e+". You have only "+c+".");return false}if(a==b){var f=confirm("You have highest bid in this auction. Are you sure you want make higher bid?");if(f)return true;else return false}return true}function checkLogin(a){if(a==0){alert("You are not logged in.");return false}return true}var innerHTM</script>';

	$players_banned = $db->query("SELECT * FROM `bans` ORDER BY `bans`.`added` DESC")->fetchAll();
	if(empty($players_banned))
		$main_content .= "There are currently no players banned.";
	else
	{
		$number_of_players = 0;
		foreach($players_banned as $player)
		{
			$admin = new OTS_Player();
			$admin->load($player['admin_id']);
			if($admin->isLoaded())
				$banby = "<a href=?subtopic=characters&name={$admin->getName()}><font color ='green'>{$admin->getName()}</font></a>";
			else
				$banby = "Auto Ban";
				
			$banned = new OTS_Player();
			$banned->load($player['param']);
			if($banned->isLoaded())
				$playerz = $banned->getName();
			else
				$playerz = "Unknown";

			$bgcolor = ($number_of_players % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
			$players_rows .= '<TR BGCOLOR='.$bgcolor.'><TD WIDTH=15%><A HREF="?subtopic=characters&name='.$playerz.'">'.$playerz.'</A></TD><TD WIDTH=20%>'.$player['comment'].'</TD><TD align="center">'.$banby.'</TD><TD align="center">'.date("d/m/Y, G:i:s", $player['added']).'</TD><TD><div id="timerban_' . $player['id'] . '">'.time_left($player['expires'] - time()).'</div></TD></TR>';
			$timers['timerban_' . $player['id']] = $player['expires'] - time();
		
			$number_of_players++;
		}
		$main_content .= '<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue"><TR BGCOLOR="'.$config['site']['vdarkborder'].'"><TD CLASS=white><b><center>Banned Player</center></b></TD><TD class="white"><b><center>Reason</center></b></TD><TD class="white"><b><center>Banned By</center></b></TD><TD class="white"><b><center>Added</center></b></TD><TD class="white"><b><center>Expires</center></b></TD></TR>'.$players_rows.'</TABLE>';
	}
	
	$main_content .= '
	<script type="text/javascript">';
		if(count($timers) > 0)
		{
			foreach($timers as $timer_id => $time_left)
				$main_content .= 'countdown(' . $time_left . ', \'' . $timer_id . '\');';
		}	
		$main_content .= '
	</script>';
?>