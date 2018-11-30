<?PHP
$time = time();
	if($action == "")
	{
		$number_of_tickers = 0;
		$tickers = $db->query('SELECT * FROM `z_news_tickers` WHERE `hide_ticker` = 0 ORDER BY `date` DESC LIMIT ' . $config['site']['news_ticks_limit'])->fetchAll();
		if(!empty($tickers))
		{
			foreach($tickers as $ticker)
			{
				$color = ($number_of_tickers % 2) ? "Odd" : "Even";
				
				$tickers_to_add .= '
					<div id="TickerEntry-' . $number_of_tickers . '" class="Row" onclick=\'TickerAction("TickerEntry-' . $number_of_tickers . '")\'>
						<div class="' . $color . '">
							<div class="NewsTickerIcon" style="background-image: url(' . $layout_name . '/images/news/icon_small_' . $ticker['image_id'] . '.gif);"></div>
							<div id="TickerEntry-' . $number_of_tickers . '-Button" class="NewsTickerExtend" style="background-image: url(' . $layout_name . '/images/general/plus.gif);"></div>
							<div class="NewsTickerText">
								<span class="NewsTickerDate">' . date("M d Y", $ticker['date']) . ' -</span>
								<div id="TickerEntry-' . $number_of_tickers . '-ShortText" class="NewsTickerShortText">';
									if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
										$tickers_to_add .= '<a href="?subtopic=latestnews&action=deleteticker&id=' . $ticker['date'] . '"><img src="./images/news/gtk-delete.png" border="0" width="14px" height="14px" /></a> ';
										
									$tickers_to_add .= short_text($ticker['text'], 60);
									
									$tickers_to_add .= '
								</div>
								<div id="TickerEntry-' . $number_of_tickers . '-FullText" class="NewsTickerFullText">';	
									if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
										$tickers_to_add .= '<a href="?subtopic=latestnews&action=deleteticker&id=' . $ticker['date'] . '"><img src="./images/news/gtk-delete.png" border="0" width="14px" height="14px" /></a> ';
										
									$tickers_to_add .= $ticker['text'];
								
									$tickers_to_add .= '
								</div>
							</div>
						</div>
					</div>';

				$number_of_tickers++;
			}
		}

		if(!empty($tickers_to_add))
		{
			$news_content .= '
			<div id="newsticker" class="Box">
				<div class="Corner-tl" style="background-image: url('.$layout_name.'/images/content/corner-tl.gif);"></div>
				<div class="Corner-tr" style="background-image: url('.$layout_name.'/images/content/corner-tr.gif);"></div>
				<div class="Border_1" style="background-image: url('.$layout_name.'/images/content/border-1.gif);"></div>
				<div class="BorderTitleText" style="background-image: url('.$layout_name.'/images/content/title-background-green.gif);"></div>
				<img class="Title" src="'.$layout_name.'/images/header/headline-newsticker.gif" alt="Contentbox headline">
				<div class="Border_2">
					<div class="Border_3">
						<div class="BoxContent" style="background-image: url('.$layout_name.'/images/content/scroll.gif);">';
							$news_content .= $tickers_to_add;
							$news_content .= '
						</div>
					</div>
				</div>
				
				<div class="Border_1" style="background-image: url('.$layout_name.'/images/content/border-1.gif);"></div>
				<div class="CornerWrapper-b"><div class="Corner-bl" style="background-image: url('.$layout_name.'/images/content/corner-bl.gif);"></div></div>
				<div class="CornerWrapper-b"><div class="Corner-br" style="background-image: url('.$layout_name.'/images/content/corner-br.gif);"></div></div>
			</div>';
		}
		
		$countdown = true;
		if($countdown)
		{
			$main_content .= '
			<table width="100%">
				<tr><td>
					<br /><center><div id=\'countdown\'></div></center><br />
				</td></tr>
			</table><br />';
		}
		
		$lastJoined = $db->query("SELECT `id`, `name` FROM `players` ORDER BY `id` DESC LIMIT 1")->fetch();
		$bestPlayer = $db->query("SELECT `name`, `level` FROM `players` WHERE `group_id` < 3 ORDER BY `experience` DESC LIMIT 1")->fetch();
		$account = $db->query("SELECT COUNT(`id`) AS `count` FROM `accounts`;")->fetch();
		$player = $db->query("SELECT COUNT(`id`) AS `count` FROM `players`;")->fetch();
		$main_content .= '
		<table width="100%">
			<tr><td>
				<div class="title" align="center">Welcome to ' . $config['server']['serverName'] . ' Evo Fun 8.6!</div>
				<div class="text" align="center">
					Ostatnio dolaczyl do nas: <a href="?subtopic=characters&name=' . $lastJoined['name'] . '">' . $lastJoined['name'] . '</a>, gracz numer ' . $player['count'] . '<br />
					Obecnie najlepszym graczem na serwerze jest: <a href="?subtopic=characters&name=' . $bestPlayer['name'] . '">' . $bestPlayer['name'] . '</a> (' . $bestPlayer['level'] . ').
				</div>
				<div class="text" align="center">
					Ilość graczy w bazie danych: ' . $player['count'] . '
				</div>
				<div class="text" align="center">
					<table>
						<tr><td align="center">
							<div class="fb-like" data-href="https://www.facebook.com/Xavatopl" data-send="true" data-layout="box_count" data-width="450" data-show-faces="false" data-font="arial" data-colorscheme="dark"></div>
						</td></tr>
					</table>
				</div>
			</td></tr>
		</table><br />';
	
		$main_content .= '
		<table width="100%">
			<tr><td style="background: #251c16;border:1px solid #32231b;">
				<div class="title" align="center">
					<a href="index.php?subtopic=latestnews&langz=en"><img src="images/flags/us.gif" alt="" /></a>
					Set News Languague
					<a href="index.php?subtopic=latestnews&langz=pl"><img src="images/flags/pl.gif" alt="" /></a>
				</div>
			</td></tr>
		</table><br />';
	if($langz == 'en')
	{
		$newsLanguageSystem = 'topic_eng, text_eng';
		$newsTopicInfo = 'topic_eng';
		$newsTextInfo = 'text_eng';
	}
	elseif($langz == 'pl')
	{
		$newsLanguageSystem = 'topic, text';
		$newsTopicInfo = 'topic';
		$newsTextInfo = 'text';
	}
	elseif(empty($langz))
	{
		$newsLanguageSystem = 'topic, text';
		$newsTopicInfo = 'topic';
		$newsTextInfo = 'text';
	}
	else
	{
		$newsLanguageSystem = 'topic, text';
		$newsTopicInfo = 'topic';
		$newsTextInfo = 'text';
	}
	$news_DB = $db->query('SELECT image_id, date, author, '.$newsLanguageSystem.' FROM z_news_big WHERE hide_news != 1 ORDER BY date DESC LIMIT '.$config['site']['news_big_limit'].';');
	//dla kazdego duzego newsa
	if(!empty($news_DB)) 
	{
		if($group_id_of_acc_logged >= $config['site']['access_news'])
			$main_content .= '<script type="text/javascript">
				var showednewnews_state = "0";
				function showNewNewsForm()
				{
					if(showednewnews_state == "0") 
					{
						document.getElementById("newnewsform").innerHTML = \'<form action="index.php?subtopic=latestnews&action=newnews" method="post" ><table border="0"><tr><td bgcolor="D4C0A1" align="center"><b>Select icon:</b></td><td><table border="0" bgcolor="F1E0C6"><tr><td><img src="images/news/icon_0.gif" width="20"></td><td><img src="images/news/icon_1.gif" width="20"></td><td><img src="images/news/icon_2.gif" width="20"></td><td><img src="images/news/icon_3.gif" width="20"></td><td><img src="images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td></tr><tr><td align="center" bgcolor="F1E0C6"><b><img src="images/flags/us.png"> Topic defutal language:</b></td><td><input type="text" name="news_topic_eng" maxlenght="50" style="width: 300px" ></td></tr><tr><td align="center" bgcolor="F1E0C6"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> Topic onther language:</b></td><td><input type="text" name="news_topic" maxlenght="50" style="width: 300px" ></td></tr><tr><td align="center" bgcolor="D4C0A1"><b><img src="images/flags/us.png"> News text:</b></td><td bgcolor="F1E0C6"><textarea name="news_text_eng" rows="6" cols="40"></textarea></td></tr><tr><td align="center" bgcolor="D4C0A1"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> News text:</b></td><td bgcolor="F1E0C6"><textarea name="news_text" rows="6" cols="40"></textarea></td></tr><tr><td align="center" bgcolor="F1E0C6"><b>Your nick:</b></td><td><input type="text" name="news_name" maxlenght="40" style="width: 200px" ></td></tr><tr><td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="showNewNewsForm()" alt="CancelAddNews" /></div></div></td></tr></table>\';
						document.getElementById("chicken").innerHTML = \'\';
						showednewnews_state = "1";
					}
					else 
					{
						document.getElementById("newnewsform").innerHTML = \'\';
						document.getElementById("chicken").innerHTML = \'<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddNews" src="'.$layout_name.'/images/buttons/addnews.gif" onClick="showNewNewsForm()" alt="AddNews" /></div></div>\';
						showednewnews_state = "0";
					}
				}
			</script><div id="newnewsform"></div><div id="chicken"><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="AddNews" src="'.$layout_name.'/images/buttons/addnews.gif" onClick="showNewNewsForm()" alt="AddNews" /></div></div></div><hr/>';
			foreach($news_DB as $news)
			{
				$newsTopic = stripslashes($news[$newsTopicInfo]);
				$newsText = stripslashes($news[$newsTextInfo]);
				$main_content .= '
				<table width="100%">
					<tr><td style="background: #251c16;border:1px solid #32231b;">
						<div class="title">' . $newsTopic . '</div>
						<div class="text">' . parse_bbcode(nl2br($newsText)) . '</div>
						<div class="author"><a>Kind Regards,<br />' . $news['author'] . '</a></div>
					</td></tr>
				</table><br />';
					
				if($group_id_of_acc_logged >= $config['site']['access_news'])
					$main_content .= '<br /><a href="?subtopic=latestnews&action=editnews&edit_date=' . $news['date'] . '&edit_author=' . urlencode(stripslashes($news['author'])) . '"><img src="./images/news/gtk-edit.png" border="0" width="14px" height="14px" /></a> <a href="?subtopic=latestnews&action=deletenews&id=' . $news['date'] . '"><img src="./images/news/gtk-delete.png" border="0" width="14px" height="14px" /></a>';
			}
	}
}
//##################### ADD NEW TICKER #####################
if($action == "newticker") 
{
	if($group_id_of_acc_logged >= $config['site']['access_tickers']) 
	{
		$ticker_text = stripslashes(trim($_POST['new_ticker']));
		$ticker_icon = (int) $_POST['icon_id'];
		if(empty($ticker_text)) 
			$main_content .= 'You can\'t add empty ticker.';
		else
		{
			if(empty($ticker_icon)) 
				$ticker_icon = 0;
			$db->query('INSERT INTO '.$db->tableName('z_news_tickers').' (date, author, image_id, text, hide_ticker) VALUES ('.$db->quote($time).', '.$account_logged->getId().', '.$ticker_icon.', '.$db->quote($ticker_text).', 0)');
			$main_content .= '<center><h2><font color="red">Added new ticker:</font></h2></center><hr/><div id="newsticker" class="Box"><div id="TickerEntry-1" class="Row" onclick=\'TickerAction("TickerEntry-1")\'>
				<div class="Odd">
					<div class="NewsTickerIcon" style="background-image: url('.$layout_name.'/images/news/icon_'.$ticker['image_id'].'.gif);"></div>
					<div id="TickerEntry-1-Button" class="NewsTickerExtend" style="background-image: url('.$layout_name.'/images/general/plus.gif);"></div>
					<div class="NewsTickerText">
						<span class="NewsTickerDate">'.date("j M Y", $time).' -</span>
						<div id="TickerEntry-1-ShortText" class="NewsTickerShortText">';
					$main_content .= '<a href="index.php?subtopic=latestnews&action=deleteticker&id='.$time.'"><img src="http://i63.photobucket.com/albums/h122/Mister_Dude/delete.png" border="0"></a>';
					$main_content .= short_text($ticker_text, 60).'</div>
						<div id="TickerEntry-1-FullText" class="NewsTickerFullText">';
					$main_content .= '<a href="index.php?subtopic=latestnews&action=deleteticker&id='.$time.'"><img src="http://i63.photobucket.com/albums/h122/Mister_Dude/delete.png" border="0"></a>';
					$main_content .= $ticker_text.'</div>
					</div>
				</div>
			</div></div><hr/>';
		}
	}
	else
	{
		$main_content .= 'You don\'t have admin rights. You can\'t add new ticker.';
		$main_content .= '<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
	}
}
//#################### DELETE (HIDE only!) TICKER ############################
if($action == "deleteticker") 
{
	if($group_id_of_acc_logged >= $config['site']['access_tickers']) 
	{
		header("Location: index.php");
		$date = (int) $_REQUEST['id'];
		$db->query('UPDATE '.$db->tableName('z_news_tickers').' SET hide_ticker = 1 WHERE '.$db->fieldName('date').' = '.$date.';');
		$main_content .= '<center>News tickets with <b>date '.date("j F Y, g:i a", $date).'</b> has been deleted.<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
	else
		$main_content .= '<center>You don\'t have admin rights. You can\'t delete tickers.<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
//################## ADD NEW NEWS ##################
if($action == "newnews") 
{
	if($group_id_of_acc_logged >= $config['site']['access_news']) 
	{
		$news_icon = (int) $_POST['icon_id'];
		$news_text_eng = stripslashes(trim($_POST['news_text_eng']));
		$news_topic_eng = stripslashes(trim($_POST['news_topic_eng']));
		$news_text = stripslashes(trim($_POST['news_text']));
		$news_topic = stripslashes(trim($_POST['news_topic']));
		$news_name = stripslashes(trim($_POST['news_name']));
		if(empty($news_icon)) 
			$news_icon = 0;
		if(empty($news_topic_eng)) 
			$an_errors[] .= 'You can\'t add news without topic.';
		if(empty($news_text_eng)) 
			$an_errors[] .= 'You can\'t add empty news.';
		if(empty($news_topic)) 
			$an_errors[] .= 'You can\'t add news without topic.';
		if(empty($news_text)) 
			$an_errors[] .= 'You can\'t add empty news.';
		if(empty($news_name)) 
			$an_errors[] .= 'You can\'t add news without author.';
		if(empty($an_errors)) 
		{
			$db->query('INSERT INTO z_news_big (hide_news, date, author, author_id, image_id, topic_eng, text_eng, topic, text) VALUES (0, '.$time.', '.$db->quote($news_name).', '.$account_logged->getId().', '.$news_icon.', '.$db->quote($news_topic_eng).', '.$db->quote($news_text_eng).', '.$db->quote($news_topic).', '.$db->quote($news_text).')');
			//show added data
			$main_content .= '<center><h2><font color="red">Added to news:</font></h2></center><hr/><div class=\'NewsHeadline\'>
				<div class=\'NewsHeadlineBackground\' style=\'background-image:url('.$layout_name.'/images/news/newsheadline_background.gif)\'>
					<table border=0><tr><td><img src="'.$layout_name.'/images/news/icon_'.$news_icon.'.gif" class=\'NewsHeadlineIcon\'  alt=\'\' />
						</td><td><font color="'.$layout_ini['news_title_color'].'">'.date("j M Y", $time).' - <b>'.$news_topic_eng.' or '.$news_topic.'</b></font></td></tr></table>
				</div>
			</div>
			<table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'>
				<tr>
					<td><img src="'.$layout_name.'/images/global/general/blank.gif" width=10 height=1 border=0 alt=\'\' /></td>
					<td width="100%"><img src="images/flags/us.png"> '.$news_text_eng.'<br><br><img src="images/flags/'.$config['site']['chooseLang'].'.png"> '.$news_text.'<br><br><h6><i>Posted by </i><font color="green">'.$news_name.'</font>&nbsp;
					<a href="index.php?subtopic=latestnews&action=editnews&edit_date='.$time.'&edit_author='.urlencode($news_name).'"><img src="'.$layout_name.'/images/news/edit_news.png" border="0"></a>&nbsp;<a href="index.php?subtopic=latestnews&action=deletenews&id='.$time.'"><img src="'.$layout_name.'/images/news/delete_news.png" border="0"></a></h6></td>
					<td><img src="'.$layout_name.'/images/global/general/blank.gif" width=10 height=1 border=0 alt=\'\' /></td>
				</tr>
			</table><br/><hr/>';
			//back button
			$main_content .= '<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
		}
		else
		{
			//show errors
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
			foreach($an_errors as $an_error) 
				$main_content .= '<li>'.$an_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
			//okno edycji newsa z wpisanymi danymi przeslanymi wczesniej
			$main_content .= '<form action="index.php?subtopic=latestnews&action=newnews" method="post" >
				<table border="0">
					<tr>
						<td bgcolor="'.$config['site']['darkborder'].'" align="center"><b>Select icon:</b></td>
						<td><table border="0" bgcolor="'.$config['site']['lightborder'].'"><tr><td><img src="'.$layout_name.'/images/news/icon_0.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_1.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_2.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_3.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b><img src="images/flags/us.png"> Topic defutal language:</b></td>
						<td><input type="text" name="news_topic_eng" maxlenght="50" style="width: 300px" value="'.$news_topic_eng.'" /></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> Topic onther language:</b></td>
						<td><input type="text" name="news_topic" maxlenght="50" style="width: 300px" value="'.$news_topic.'" /></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$config['site']['darkborder'].'"><b><img src="images/flags/us.png"> News text:</b></td>
						<td bgcolor="'.$config['site']['lightborder'].'"><textarea name="news_text_eng" rows="6" cols="60">'.$news_text_eng.'</textarea></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$config['site']['darkborder'].'"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> News text:</b></td>
						<td bgcolor="'.$config['site']['lightborder'].'"><textarea name="news_text" rows="6" cols="60">'.$news_text.'</textarea></td>
					</tr>
					<tr>
						<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b>Your nick:</b></td>
						<td><input type="text" name="news_name" maxlenght="40" style="width: 200px" value="'.$news_name.'" /></td>
					</tr>
					<tr>
						<td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form></td>
						<td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="window.location =\'index.php?subtopic=latestnews\'" alt="CancelAddNews" /></div></div></td>
					</tr>
				</table>';
		}
	}
	else
	{
		$main_content .= 'You don\'t have site-admin rights. You can\'t add news.';
		//back button
		$main_content .= '<br><form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
	}
}
//################## EDIT NEWS ##################
if($action == "editnews") 
{
	if(!empty($_REQUEST['edit_date'])) 
	{
		if(!empty($_REQUEST['edit_author'])) 
		{
			if($group_id_of_acc_logged >= $config['site']['access_news']) 
			{
				$news_date = (int) $_REQUEST['edit_date'];
				$news_old_name = stripslashes(trim($_REQUEST['edit_author']));
				if($_POST['saveedit'] == 1) 
				{
					$news_icon = (int) $_POST['icon_id'];
					$news_text_eng = stripslashes(trim($_POST['news_text_eng']));
					$news_topic_eng = stripslashes(trim($_POST['news_topic_eng']));
					$news_text = stripslashes(trim($_POST['news_text']));
					$news_topic = stripslashes(trim($_POST['news_topic']));
					$news_name = stripslashes(trim($_POST['news_name']));
					if(empty($news_icon)) 
						$news_icon = 0;
					if(empty($news_topic_eng)) 
						$an_errors[] .= 'You can\'t save news without topic.';
					if(empty($news_text_eng)) 
						$an_errors[] .= 'You can\'t save empty news.';
					if(empty($news_topic)) 
						$an_errors[] .= 'You can\'t save news without topic.';
					if(empty($news_text)) 
						$an_errors[] .= 'You can\'t save empty news.';
					if(empty($news_name))
						$an_errors[] .= 'You can\'t save news without author.';
					if(empty($an_errors)) 
					{
						$db->query('UPDATE z_news_big SET hide_news = "0", author = "'.$news_name.'", author_id = '.$account_logged->getId().', image_id = '.$news_icon.', topic_eng = "'.$news_topic_eng.'", text_eng = "'.$news_text_eng.'", topic = "'.$news_topic.'", text = "'.$news_text.'" WHERE author = "'.$news_old_name.'" AND date = '.$news_date.';');
						//show added data
						$main_content .= '<center><h2><font color="red">After edit:</font></h2></center><hr/><div class=NewsHeadline>
							<div class=NewsHeadlineBackground style=background-image:url('.$layout_name.'/images/news/newsheadline_background.gif)>
								<table border=0>
									<tr>
										<td><img src="'.$layout_name.'/images/news/icon_'.$news_icon.'.gif" class="NewsHeadlineIcon" alt="" /></td>
										<td><font color="'.$layout_ini['news_title_color'].'">'.date("j M Y", $time).' - <b>'.$news_topic_eng.' or '.$news_topic.'</b></font></td>
									</tr>
								</table>
							</div>
						</div>
						<table style=clear:both border=0 cellpadding=0 cellspacing=0 width=\'100%\'>
							<tr>
								<td width="100%"><img src="images/flags/us.png" alt=""> '.$news_text_eng.'<br><br><img src="images/flags/'.$config['site']['chooseLang'].'.png" alt=""> '.$news_text.'<br><br><h6><i>Posted by </i><font color="green">'.$news_name.'</font>&nbsp;
								<a href="index.php?subtopic=latestnews&action=editnews&edit_date='.htmlspecialchars($news_date).'&edit_author='.htmlspecialchars($news_name).'"><img src="'.$layout_name.'/images/news/edit_news.png" border="0"></a>&nbsp;
								<a href="index.php?subtopic=latestnews&action=deletenews&id='.$news_date.'"><img src="'.$layout_name.'/images/news/delete_news.png" border="0"></a></h6></td>
							</tr>
						</table><br/><hr/>';
						//back button
						$main_content .= '<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
					}
					else
					{
						//show errors
						$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
						foreach($an_errors as $an_error) 
							$main_content .= '<li>'.$an_error;
						$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
						//okno edycji newsa z wpisanymi danymi przeslanymi wczesniej
						//<img src="images/flags/us.png">
						//<img src="images/flags/'.$config['site']['chooseLang'].'.png">
						$main_content .= '<form action="index.php?subtopic=latestnews&action=editnews" method="post" >
							<input type="hidden" name="saveedit" value="1"><input type="hidden" name="edit_date" value="'.$_REQUEST['edit_date'].'">
							<input type="hidden" name="edit_author" value="'.$_REQUEST['edit_author'].'">
								<table border="0">
									<tr>
										<td bgcolor="'.$config['site']['darkborder'].'" align="center"><b>Select icon:</b></td>
										<td><table border="0" bgcolor="'.$config['site']['lightborder'].'"><tr><td><img src="'.$layout_name.'/images/news/icon_0.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_1.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_2.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_3.gif" width="20"></td><td><img src="'.$layout_name.'/images/news/icon_4.gif" width="20"></td></tr><tr><td><input type="radio" name="icon_id" value="0" checked="checked"></td><td><input type="radio" name="icon_id" value="1"></td><td><input type="radio" name="icon_id" value="2"></td><td><input type="radio" name="icon_id" value="3"></td><td><input type="radio" name="icon_id" value="4"></td></tr></table></td>
									</tr>
									<tr>
										<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b><img src="images/flags/us.png"> Topic defutal language:</b></td>
										<td><input type="text" name="news_topic_eng" maxlenght="50" style="width: 300px" value="'.$news_topic_eng.'" /></td>
									</tr>
									<tr>
										<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> Topic onther language:</b></td>
										<td><input type="text" name="news_topic" maxlenght="50" style="width: 300px" value="'.$news_topic.'" /></td>
									</tr>
									<tr>
										<td align="center" bgcolor="'.$config['site']['darkborder'].'"><b>News text:</b></td>
										<td bgcolor="'.$config['site']['lightborder'].'"><textarea name="news_text_eng" rows="6" cols="60">'.$news_text_eng.'</textarea></td>
									</tr>
									<tr>
										<td align="center" bgcolor="'.$config['site']['darkborder'].'"><b>News text:</b></td>
										<td bgcolor="'.$config['site']['lightborder'].'"><textarea name="news_text" rows="6" cols="60">'.$news_text.'</textarea></td>
									</tr>
									<tr>
										<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b>Your nick:</b></td>
										<td><input type="text" name="news_name" maxlenght="40" style="width: 200px" value="'.$news_nick.'" /></td>
									</tr>
									<tr>
										<td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form></td>
										<td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="window.location =\'index.php?subtopic=latestnews\'" alt="CancelAddNews" /></div></div></td>
									</tr>
								</table>';
					}
				}
				else
				{
					//wyswietlic zaladowany z bazy news do edycji wedlug ID
					$edited = $db->query('SELECT * FROM z_news_big WHERE '.$db->fieldName('date').' = "'.$news_date.'" AND '.$db->fieldName('author').' = '.$db->quote($news_old_name).';')->fetch();
					$main_content .= '<form action="index.php?subtopic=latestnews&action=editnews" method="post" >
						<input type="hidden" name="edit_date" value="'.$_REQUEST['edit_date'].'">
						<input type="hidden" name="edit_author" value="'.htmlspecialchars(stripslashes($_REQUEST['edit_author'])).'">
						<input type="hidden" name="saveedit" value="1">
						<table border="0">
							<tr>
								<td bgcolor="'.$config['site']['darkborder'].'" align="center"><b>Select icon:</b></td>
								<td>
									<table border="0" bgcolor="'.$config['site']['lightborder'].'">
										<tr>
											<td><img src="'.$layout_name.'/images/news/icon_0.gif" width="20"></td>
											<td><img src="'.$layout_name.'/images/news/icon_1.gif" width="20"></td>
											<td><img src="'.$layout_name.'/images/news/icon_2.gif" width="20"></td>
											<td><img src="'.$layout_name.'/images/news/icon_3.gif" width="20"></td>
											<td><img src="'.$layout_name.'/images/news/icon_4.gif" width="20"></td>
										</tr>
										<tr>
											<td><input type="radio" name="icon_id" value="0" checked="checked"></td>
											<td><input type="radio" name="icon_id" value="1"></td>
											<td><input type="radio" name="icon_id" value="2"></td>
											<td><input type="radio" name="icon_id" value="3"></td>
											<td><input type="radio" name="icon_id" value="4"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b><img src="images/flags/us.png"> Topic defutal language:</b></td>
								<td><input type="text" name="news_topic_eng" maxlenght="50" style="width: 300px" value="'.htmlspecialchars(stripslashes($edited['topic_eng'])).'" /></td>
							</tr>
							<tr>
								<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> Topic onther language:</b></td>
								<td><input type="text" name="news_topic" maxlenght="50" style="width: 300px" value="'.htmlspecialchars(stripslashes($edited['topic'])).'" /></td>
							</tr>
							<tr>
								<td align="center" bgcolor="'.$config['site']['darkborder'].'"><b><img src="images/flags/us.png"> News text:</b></td>
								<td bgcolor="'.$config['site']['lightborder'].'"><textarea name="news_text_eng" rows="6" cols="60">'.stripslashes($edited['text_eng']).'</textarea></td>
							</tr>
							<tr>
								<td align="center" bgcolor="'.$config['site']['darkborder'].'"><b><img src="images/flags/'.$config['site']['chooseLang'].'.png"> News text:</b></td>
								<td bgcolor="'.$config['site']['lightborder'].'"><textarea name="news_text" rows="6" cols="60">'.stripslashes($edited['text']).'</textarea></td>
							</tr>
							<tr>
								<td align="center" bgcolor="'.$config['site']['lightborder'].'"><b>Your nick:</b></td>
								<td><input type="text" name="news_name" maxlenght="40" style="width: 200px" value="'.htmlspecialchars(stripslashes($edited['author'])).'"></td>
							</tr>
							<tr>
								<td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></form></td>
								<td><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><img class="ButtonText" id="CancelAddNews" src="'.$layout_name.'/images/buttons/_sbutton_cancel.gif" onClick="window.location = \'index.php?subtopic=latestnews\'" alt="CancelEditNews" /></div></div></td>
							</tr>
						</table>';
				}
			}
			else
			{
				$main_content .= 'You don\'t have site-admin rights. You can\'t edit news.';
				//back button
				$main_content .= '<br><form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form>';
			}
		}
	}
}
//################## DELETE (hide only!) NEWS ##################
if($action == "deletenews") 
{
	if($group_id_of_acc_logged >= $config['site']['access_news']) 
	{
		header("Location: index.php");
		$date = (int) $_REQUEST['id'];
		$db->query('UPDATE '.$db->tableName('z_news_big').' SET hide_news = "1" WHERE date = '.$date);
		$main_content .= '<center>News with <b>date '.date("j F Y, g:i a", $date).'</b> has been deleted.<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
	else
		$main_content .= '<center>You don\'t have admin rights. You can\'t delete news.<form action="index.php?subtopic=latestnews" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
}
?>