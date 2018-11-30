<?php
$main_content .= '
<table border="0" cellspacing="1" cellpadding="4" width="100%">
	<TR>
		<TD><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD>
		<TD>';

		if(isset($_GET['page']) && $_GET['page'] == 'view' && isset($_POST['houseid']))
		{
			$beds = array("", "one", "two", "three", "fourth", "fifth");
			$houseId = (int)$_POST['houseid'];
			$house = $db->query('SELECT * FROM `houses` WHERE `id` = ' . $houseId);
			if($house->rowCount() > 0)
			{
				$house = $house->fetch();
				$main_content .= '
				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4>
					<TR><TD VALIGN=top>';
						$img_path = 'houses/' . $houseId . '.gif';
						if(file_exists($img_path))
							$main_content .= '<IMG SRC="' . $img_path . '">';
						else
							$main_content .= '<IMG SRC="images/under_construction.jpg" WIDTH=200 HEIGHT=120>';

						$main_content .= '
						</TD>
						<TD VALIGN=top><B>' . $house['name'] . '</B><BR>This house ';
						$houseBeds = $house['beds'];
						if($houseBeds > 0)
							$main_content .= 'has ' . ($beds[$houseBeds] != NULL ? $beds[$houseBeds] : $houseBeds) . ' bed' . ($houseBeds > 1 ? 's' : '');
						else
							$main_content .= 'dont have any beds';

						$main_content .= '.<BR><BR>The house has a size of <B>' . $house['size'] . ' square meters</B>. The monthly rent is <B>' . $house['rent'] . ' gold</B> and will be debited to the bank account on <B>'.$config['server']['serverName'].'</B>.';
						
						$houseOwner = $house['owner'];
						if($houseOwner > 0)
						{
							$main_content .= '<BR><BR>The house has been rented by ';
							if($house['guild'] == 1)
							{
								$guild = new OTS_Guild();
								$guild->load($houseOwner);
								$main_content .= '<a href="?subtopic=guilds&action=show&guild='.$guild->getName().'">'.$guild->getName().'</a>';
							}
							else
								$main_content .= getCreatureName($houseOwner) . '.';

							$housePaid = $house['paid'];
							if($housePaid > 0)
							{
								$who = '';
								if($guild)
									$who = $guild->getName();
								else
								{
									$player = $ots->createObject('Player');
									$player->load($houseOwner);
									if($player->isLoaded())
									{
										$sexs = array("She", "He");
										$who = $sexs[$player->getSex()];
									}
								}
								$main_content .= ' ' . $who . ' has paid the rent until <B>' . date("M d Y, H:i:s", $house['paid']) . ' CEST</B>.';
							}
						}

						$main_content .= '</TD></TR></TABLE>';
			}
			else
				$main_content .= 'House with id ' . $houseId . ' does not exists.';
		}
		else
		{
			$main_content .= '
				Here you can see the list of all available houses, flats or guildhall.
				Click on any view button to get more information about a house or adjust
				the search criteria and start a new search.<br/><br/>';
				//$cleanOld = (int)((int)$config['server']['houseCleanOld'] / (60 * 60 * 24));
				$cleanOld = (eval('return ' . $config['server']['houseCleanOld'] . ';') / 60 / 60 / 24);
				$houseRent = strtolower($config['server']['houseRentPeriod']);
				if($cleanOld > 0 || $houseRent != 'never')
				{
					$main_content .= '<b>Every morning during global server save there is automatic house cleaning. Server delete house owners who have not logged in last ' . $cleanOld . ' days';
					if($houseRent != 'never')
					{
						$main_content .= ' or have not paid ' . $houseRent . ' house rent. Remember to leave money for a rent in ';
						$bank = getBooleanFromString($config['server']['bankSystem']);
						if($bank)
							$main_content .= ' your house bank account or ';

						$main_content .= 'depo in same city where you have house!';
					}
					else
						$main_content .= '.';

					$main_content .= '</b><br/><br/>';
				}

				$main_content .= '<br/>';

				if(isset($_POST['town']) && isset($_POST['state']) && isset($_POST['order']) && isset($_POST['type']))
				{
					$order = $_POST['order'];
					$orderby = '`name`';
					if(!empty($order))
					{
						if($order == 'size')
							$orderby = '`size`';
						else if($order == 'rent')
							$orderby = '`rent`';
					}

					$whereby = '`town` = ' .(int)$_POST['town'];
					$state = $_POST['state'];
					if(!empty($state))
						$whereby .= ' AND `owner` ' . ($state == 'free' ? '' : '!'). '= 0';

					$type = $_POST['type'];
					if(!empty($type) && $type != 'all')
							$whereby .= ' AND `guild` ' . ($type == 'guildhalls' ? '!' : '') . '= 0';
	
					$houses_info = $db->query('SELECT * FROM `houses` WHERE ' . $whereby. ' ORDER BY ' . $orderby);

				$main_content .= '
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<TR BGCOLOR='.$config['site']['vdarkborder'].'>
						<TD COLSPAN=6 CLASS=white><B>Available ' . ($type == 'guildhalls' ? 'Guildhalls' : 'Houses and Flats').' in '.$towns_list[$_POST['town']].' on <b>'.$config['server']['serverName'].'</b></B></TD>
					</TR>
					<TR BGCOLOR='.$config['site']['darkborder'].'>';
					if($houses_info->rowCount() > 0)
					{
					$main_content .= '
						<TD WIDTH=40%><B>Name</B></TD>
						<TD WIDTH=10%><B>Size</B></TD>
						<TD WIDTH=10%><B>Rent</B></TD>

						<TD WIDTH=40%><B>Status</B></TD>
						<TD>&#160;</TD>';
					}
					else
						$main_content .= '<TD>No ' . ($type == 'guildhalls' ? 'guildhalls' : 'houses') . ' with specified criterias.</TD>';

					$main_content .= '</TR>';

					$players_info = $db->query("SELECT `houses`.`id` AS `houseid` , `players`.`name` AS `ownername` , `accounts`.`premdays` AS `premdays` , `accounts`.`lastday` AS `lastlogin` FROM `houses` , `players` , `accounts` WHERE `players`.`id` = `houses`.`owner` AND `accounts`.`id` = `players`.`account_id`");
					$players = array();
					foreach($players_info->fetchAll() as $player)
						$players[$player['houseid']] = array('name' => $player['ownername']);

					$rows = 1;
					foreach($houses_info->fetchAll() as $house)
					{
						$owner = $players[$house['id']];
						$bgcolor = ($rows % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
						$main_content .=
						'<TR BGCOLOR="' . $bgcolor . '">
							<TD WIDTH="40%"><NOBR>'.$house['name'].'</TD>
							<TD WIDTH="10%"><NOBR>'.$house['size'].' sqm</TD>
							<TD WIDTH="10%"><NOBR>'.$house['rent'].' gold</TD>
							<TD WIDTH="40%"><NOBR>';
						if($house['guild'] == 1 && $house['owner'] != 0)
						{
							$guild = new OTS_Guild();
							$guild->load($house['owner']);
							$main_content .=
								'Rented by <a href="?subtopic=guilds&action=show&guild='.$guild->getName().'">'.$guild->getName().'</a>';
						}
						else
						{
							if(!empty($owner['name']))
								$main_content .=
									'Rented by <a href="?subtopic=characters&name='.urlencode($owner['name']).'">'.$owner['name'].'</a>';
							else
								$main_content .=
									'Free';
						}

						$main_content .= '
							</TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<FORM ACTION=?subtopic=houses&page=view METHOD=post>
										<TR><TD>
											<INPUT TYPE=hidden NAME=houseid VALUE='.$house['id'].'>
											<INPUT TYPE=image NAME="View" ALT="View" SRC="'.$layout_name.'/images/buttons/sbutton_view.gif" BORDER=0 WIDTH=120 HEIGHT=18>
										</TD></TR>
									</FORM>
								</TABLE>
							</TD>
						</TR>';
						$rows++;
					}
					$main_content .=
					'</TABLE>'.
					'<BR><BR>';
				}

				$main_content .= '
				<FORM METHOD=post>
				<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
					<TR BGCOLOR='.$config['site']['vdarkborder'].'>
						<TD COLSPAN=4 CLASS=white><B>House Search</B></TD>
					</TR>
					<TR BGCOLOR='.$config['site']['darkborder'].'>
						<TD WIDTH=25%><B>Town</B></TD>
						<TD WIDTH=25%><B>Status</B></TD>
						<TD WIDTH=25%><B>Order</B></TD>
					</TR>
					<TR BGCOLOR='.$config['site']['darkborder'].'>
						<TD VALIGN=top ROWSPAN=2>';
						$townId = $_POST['town'];
						$i = 0;
						$checked = false;
						foreach($towns_list[0] as $id => $name)
						{
							if($id == 0)
								continue;

							$i++;
							//echo 'id ' . $id . ' townid ' . '<br>' . (empty($townId) ? 'tak' : 'nie');
							if(((empty($townId) && !empty($name)) || $id == $townId) && !$checked)
							{
								$add = 'CHECKED';
								$checked = true;
							}
							else
								$add = '';

							if(!empty($name))
								$main_content .= '<INPUT TYPE=radio NAME="town" VALUE="'.$id.'" '.$add.'> '.$name.'<BR>';
						}

						$main_content .= '
						</TD>
						<TD VALIGN=top>
							<INPUT TYPE=radio NAME="state" VALUE="" '.(empty($state) ? 'CHECKED' : '').'> all states<BR>
							<INPUT TYPE=radio NAME="state" VALUE="free" '.($state == 'free' ? 'CHECKED' : '').'> free<BR>
							<INPUT TYPE=radio NAME="state" VALUE="rented" '.($state == 'rented' ? 'CHECKED' : '').'> rented<BR>
						</TD>
						<TD VALIGN=top ROWSPAN=2>
							<INPUT TYPE=radio NAME="order" VALUE="" '.(empty($order) ? 'CHECKED' : '').'> by name<BR>
							<INPUT TYPE=radio NAME="order" VALUE="size" '.($order == 'size' ? 'CHECKED' : '').'> by size<BR>
							<INPUT TYPE=radio NAME="order" VALUE="rent" '.($order == 'rent' ? 'CHECKED' : '').'> by rent<BR>
						</TD>
					</TR>

					<TR BGCOLOR='.$config['site']['darkborder'].'>
						<TD VALIGN=top>
							<INPUT TYPE=radio NAME="type" VALUE="" '.(empty($type) ? 'CHECKED' : '').'> all<BR>
							<INPUT TYPE=radio NAME="type" VALUE="houses" '.($type == 'houses' ? 'CHECKED' : '').'> houses and flats<BR>
							<INPUT TYPE=radio NAME="type" VALUE="guildhalls" '.($type == 'guildhalls' ? 'CHECKED' : '').'> guildhalls<BR>
						</TD>
					</TR>
				</TABLE>

				<BR>
				<CENTER>
					<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><TR><TD>
						<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18>
					</TD></TR></FORM></TABLE>
				</CENTER>';
			}
			$main_content .= '
			</TD>
			<TD><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD>
		</TR>
	</TABLE>
	';
?>