<?php
	$minTime = 7 * 24 * 60 * 60;
	$minLevel = 30;
	
	function cost( $level )
	{
		$values = array
		(
			array(0, 100, 50), 
			array(101, 150, 100),
			array(151, 200, 150), 
			array(201, 250, 200), 
			array(251, 300, 250),
			array(301, 350, 300),
			array(351, 400, 350),
			array(401, 450, 400),
			array(451, 500, 450),
			array(501, 550, 500),
			array(551, 600, 550),
			array(601, 650, 600),
			array(651, 700, 650),
			array(701, 750, 700),
			array(751, 800, 800) 
			
		);
		
		foreach($values as $value)
		{
			if($level >= $value[0] && $level <= $value[1])
				return $value[2];
		}
	}

	$page = intval($_GET['page']);
	$id = intval($_GET['id']);
	if(empty($id))
	{
		$main_content .= '
<div class="news-top"></div><div class="news-mid"><div class="title-news-buy">
					<FONT SIZE=3><b>Postacie do wykupienia</FONT SIZE></b><br /><br />
					<FONT SIZE=2>Na serwerze istnieje mozliwosc kupna nieuzywanej przez dluzszy czas postaci.<br> Jest to idealna opcja dla osob, ktore nie maja za wiele czasu na zdobywanie doswiadczenia i chca zaczac grac na naszym serwerze ale przerazaja je zbyt wysokie levele postaci.<br><u><b>Postac kupowana jest z wszelkimi przedmiotami jakie posiada (w DEPO, czy tez na sobie) oraz z domkiem jesli go ma.</b></u><br />
					Na liste ponizej trafiaja gracze, ktorzy nie logowali sie do gry przez ostatni tydzien. Jezeli Twoja postac trafila na liste postaci do kupienia (ponizej), a chcialbys by z niej zostala sciagnieta - wystarczy, ze zalogujesz sie do gry! Pospiesz sie jednak gdyz w przypadku gdy ktos juz kupi Twoja postac, nie ma mozliwosci zwrotu!<br /><br />
					<b>Aby kupic postac zaloguj sie na konto (musisz posiadac wymagana ilosc punktow w sms shopie), przy wybranej postaci kliknij "wykup".</Font Size></b>
</div></div><div class="news-bottom"></div>
		<table cellpadding="4" cellspacing="1" width="100%">
			<tr bgcolor="' . $config['site']['vdarkborder'] . '">
				<td width="30%" class="white" style="font-weight: bold">Nick</td> 
				<td width="14%" class="white" style="font-weight: bold" align="center">Poziom</td> 
				<td width="32%" class="white" style="font-weight: bold">Profesja</td> 
				<td width="14%" class="white" style="font-weight: bold">Cena</td>
				<td width="10%" class="white" style="font-weight: bold"></td>
			</tr>';
		
		$i = 0;
		$offset = (int)($page * 100);
		$players = $db->query("SELECT `id`, `name`, `level`, `vocation`, `promotion` FROM `players` WHERE `lastlogin` < UNIX_TIMESTAMP() - " . $minTime . " AND `level` >= " . $minLevel . " AND `id` > 5 AND `name` NOT IN ('Account Manager', 'Sprite', 'Bodzio Chelikopter', 'Alex', 'Xavato') ORDER BY `level` DESC LIMIT 151 OFFSET " . $offset)->fetchAll();
		foreach($players as $player)
		{
			$bgcolor = ($i % 2) ? $config['site']['darkborder'] : $config['site']['lightborder'];
			$main_content .= '
				<tr bgcolor="' . $bgcolor . '">
					<td><a href="?subtopic=characters&name=' . urlencode($player['name']) . '">' . $player['name'] . '</a></td>
					<td align="center">' . $player['level'] . '</td>
					<td>' . $vocation_name[0][$player['promotion']][$player['vocation']] . '</td>
					<td>' . cost($player['level']) . ' punktow</td>
					<td><a href="?subtopic=buychar&id=' . urlencode($player['id']) . '">Wykup</a></td>
				</tr>';
			$i++;
		}
		
		$main_content .= '</table>';
		if($page != 0)
			$main_content .= '<a href="?subtopic=buychar&page=' . ($page - 1) . '">Previous Page</a> ';
			
		if(empty($page) || $page > 0)
			$main_content .= '| <a href="?subtopic=buychar&page=' . ($page + 1) . '">Next Page</a> ';
	}
	else
	{
		if(!$logged)
		{
			if($action == "logout")
				$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Logout Successful</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>You have logged out of your '.$config['server']['serverName'].' account. In order to view your account you need to <a href="?subtopic=accountmanagement" >log in</a> again.</td></tr>          </table>        </div>  </table></div></td></tr>';
			else
				$main_content .= 'Please enter your account name and your password.<br/><a href="?subtopic=createaccount" >Create an account</a> if you do not have one yet.<br/><br/><form action="?subtopic=accountmanagement" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Login</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Account Name:</span></td><td style="width:100%;" ><input type="password" name="account_login" SIZE="10" maxlength="10" ></td></tr><tr><td class="LabelV" ><span >Password:</span></td><td><input type="password" name="password_login" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table width="100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=lostaccount" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Account lost?" alt="Account lost?" src="'.$layout_name.'/images/buttons/_sbutton_accountlost.gif" ></div></div></td></tr></form></table></td></tr></table>';
		}
		else
		{
			$player = new OTS_Player();
			$player->load($id);
			if($player->isLoaded())
			{
				if(isset($_POST['submit']))
				{
					if($account_logged->getCustomField('premium_points') >= cost($player->getLevel()))
					{
						$account_logged->setCustomField('premium_points', ($account_logged->getCustomField('premium_points') - cost($player->getLevel())));
						$player->setAccount($account_logged);
						$player->setLastLogin(time());
						$player->save();
						$main_content .= 'Kupiles pomylsnie postac! Pozostalo ci <b><font color="green">' . $account_logged->getCustomField('premium_points') . '</font></b> punktow premium.';
					}
					else
					{
						$main_content .= 'Nie masz wystarczajacej ilosci punktow premium.';
						return true;
					}
				}
				else
				{
					if($player->getLastLogin() < time() - $minTime)
					{
						$main_content .=
							'
							<form action="?subtopic=buychar&id=' . $id . '" method="POST">
								<table cellpadding="4" cellspacing="1" width="100%">
									<tr bgcolor="' . $config['site']['vdarkborder'] . '">
										<td class="white" style="font-weight: bold">Kupno postaci</td> 
									</tr>
									<tr bgcolor="' . $config['site']['lightborder'] . '">
										<td>
											Postac <i><strong>' . $player->getName() . '</strong></i> bedzie kosztowac cie <i><strong>' . cost($player->getLevel()) . '</strong></i> punktow premium.
										</td> 
									</tr>
									<tr bgcolor="' . $config['site']['darkborder'] . '">
										<td class="white" style="font-weight: bold" align="center">
											<input type="submit" name="submit" value="Buy this character!" />
										</td>
									</tr>
								</table>
							</form>';
					}
					else
					{
						$main_content .= 'Ta postac logowala sie w ciagu dwoch tygodni.';
						return true;
					}
				}
			}
		}
	}
?>