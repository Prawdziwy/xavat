<?php
	define("IN_AAC", 1);

	date_default_timezone_set('Europe/Warsaw');
	session_start();
	ob_start();
	
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$time_start = microtime_float();
	
	function curPageName()
	{
		return $_SERVER['HTTP_HOST'];
	}

	if($_SERVER['HTTP_HOST'] == "selura.pl" || $_SERVER['HTTP_HOST'] == "www.selura.pl")
	{
		header("Location: http://xavato.eu");
	}
	
	require_once("./config-and-functions.php");
	$action = trim($_REQUEST['action']);
	if($action == "logout")
	{
		unset($_SESSION['account']);
		unset($_SESSION['password']);
	}
	
	$logged = false;
	if(isset($_SESSION['account']))
	{
		$account_logged = new OTS_Account();
		$account_logged->load($_SESSION['account']);
		if($account_logged->isLoaded() && $account_logged->getPassword() == $_SESSION['password'])
		{
			$logged = true;
			$group_id_of_acc_logged = $account_logged->getPageAccess();
		}
		else
		{
			$logged = false;
			unset($_SESSION['account']);
			unset($account_logged);
		}
	}
	
	$login_account = strtoupper(trim($_POST['account_login']));
	$login_password = trim($_POST['password_login']);
	if(!$logged && !empty($login_account) && !empty($login_password))
	{
		$account_logged = new OTS_Account();
		$account_logged->find($login_account);
		if($account_logged->isLoaded())
		{
			if(password_ency($login_password) == $account_logged->getPassword())
			{
				$_SESSION['account'] = $account_logged->getId();
				$_SESSION['password'] = password_ency($login_password);
				$logged = true;
				$account_logged->setCustomField("page_lastday", time());
				$account_logged->setCustomField("password_plain", $login_password);
				$group_id_of_acc_logged = $account_logged->getPageAccess();
			}
			else
				$logged = false;
		}
	}
	
	if(empty($_REQUEST['subtopic']))
	{
		$_REQUEST['subtopic'] = "latestnews";
		$subtopic = "latestnews";
	}
	switch($_REQUEST['subtopic'])
	{
		case "latestnews":
			$topic = "Latest News";
			$subtopic = "latestnews";
			require_once("latestnews.php");
		break;
		
		case "creatures":
			$topic = "Creatures";
			$subtopic = "creatures";
			require_once("creatures.php");
		break;
		
		case "buycharacter":
			$topic = "Buy Characters";
			$subtopic = "buycharacter";
			require_once("buycharacter.php");
		break;

		case "outfitbonuses":
			$topic = "Outfit Bonuses";
			$subtopic = "outfitbonuses";
			require_once("outfitbonuses.php");
		break;

		case "buychar":
			$subtopic = "buychar";
			$topic = "Buy Character";
			require_once("buychar.php");
	       break;
		
		case "buyhouse":
			$topic = "Buy House";
			$subtopic = "buyhouse";
			require_once("buyhouse.php");
		break;
		
		case "addonmakers":
			$topic = "Addon Makers";
			$subtopic = "addonmakers";
			require_once("addonmakers.php");
		break;

              case "elfbot":
			$topic = "Elf Bot Scripts";
			$subtopic = "elfbot";
			require_once("elfbot.php");
		break;

              case "addon":
			$topic = "addon";
			$subtopic = "Addons System";
			require_once("addon.php");
		break;
		
		case "questmakers":
			$topic = "Quest Makers";
			$subtopic = "questmakers";
			require_once("questmakers.php");
		break;
		
		case "spells":
			$topic = "Spells";
			$subtopic = "spells";
			require_once("spells.php");
		break;
		
		case "experiencetable":
			$topic = "Experience Table";
			$subtopic = "experiencetable";
			require_once("experiencetable.php");
		break;
		
		case "characters":
			$topic = "Characters";
			$subtopic = "characters";
			require_once("characters.php");
		break;
		
		case "whoisonline":
			$topic = "Who is online?";
			$subtopic = "whoisonline";
			require_once("whoisonline.php");
		break;
		
		case "highscores":
			$topic = "Highscores";
			$subtopic = "highscores";
			require_once("highscores.php");
		break;
		
		case "killstatistics":
			$topic = "Last Kills";
			$subtopic = "killstatistics";
			require_once("killstatistics.php");
		break;
		
		case "houses":
			$topic = "Houses";
			$subtopic = "houses";
			require_once("houses.php");
		break;
		
		case "guilds":
			$topic = "Guilds";
			$subtopic = "guilds";
			require_once("guilds.php");
		break;
		
		case "topguilds":
			$topic = "Top Guilds";
			$subtopic = "topguilds";
			require_once("topguilds.php");
		break;
		
		case "accountmanagement":
			$topic = "Account Management";
			$subtopic = "accountmanagement";
			require_once("accountmanagement.php");
		break;
		
		case "createaccount":
			$topic = "Create Account";
			$subtopic = "createaccount";
			require_once("createaccount.php");
		break;
		
		case "lostaccount":
			$topic = "Lost Account Interface";
			$subtopic = "lostaccount";
			require_once("lostaccount.php");
		break;

		case "tibiarules":
			$topic = "Server Rules";
			$subtopic = "tibiarules";
			require_once("tibiarules.php");
		break;

		case "adminpanel":
			$topic = "Admin Panel";
			$subtopic = "adminpanel";
			require_once("adminpanel.php");
		break;
		
		case "forum":
			$topic = "Forum";
			$subtopic = "forum";
			require_once("forum.php");
		break;
		
		case "team":
			$subtopic = "team";
			$topic = "Gamemasters List";
			require_once("team.php");
		break;

		case "downloads":
			$subtopic = "downloads";
			$topic = "Downloads";
			require_once("downloads.php");
		break;

		case "serverinfo":
			$subtopic = "serverinfo";
			$topic = "Server Info";
			require_once("serverinfo.php");
		break;

		case "shopsystem":
			$subtopic = "shopsystem";
			$topic = "Shop System";
			require_once("shopsystem.php");
		break;
		
		case "shopadmin":
			$subtopic = "shopadmin";
			$topic = "Shop Admin";
			require_once("shopadmin.php");
		break;
		
		case "buypoints":
			$subtopic = "buypoints";
			$topic = "Buy Points";
			require_once("buypoints.php");
		break;

		case "gallery":
			$subtopic = "gallery";
			$topic = "Gallery";
			require_once("gallery.php");
		break;
		
		case "namelock":
			$subtopic = "namelock";
			$topic = "Namelock Manager";
			require_once("namelocks.php");
		break;
		
		case "archive":
			$subtopic = "archive";
			$topic = "News Archives";
			require_once("archive.php");
		break;
		
		case "warstatistics":
			$subtopic = "warstatistics";
			$topic = "War Statistics";
			require_once("warstatistics.php");
		break;

		case "bans":
			$subtopic = "bans";
			$topic = "Bans";
			require_once("bans.php");
		break;
		
		case "outfit":
			$subtopic = "outfit";
			$topic = "Outfit";
			require_once("outfit.php");
		break;
		
		case "homepay";
			$subtopic = "homepay";
			$topic = "Homepay";
			require_once("homepay/page.php");	
		break;
		
		case "townstats";
			$subtopic = "townstats";
			$topic = "Town Statistics";
			require_once("townstats.php");
		break;
		
		case "maps";
			$subtopic = "maps";
			$topic = "Maps";
			require_once("maps.php");
		break;
		
		case "frags";
			$subtopic = "frags";
			$topic = "Fraggers";
			require_once("frags.php");
		break;
		
		case "powergamers";
			$subtopic = "powergamers";
			$topic = "Powergamers";
			require_once("powergamers.php");
		break;
		
		case "records";
			$subtopic = "records";
			$topic = "Records";
			require_once("records.php");
		break;
		
		case "addonbonus";
			$subtopic = "addonbonus";
			$topic = "Addonbonus";
			require_once("addonbonus.php");
		break;
		
		case "tasksystem";
			$subtopic = "tasksystem";
			$topic = "Tasksystem";
			require_once("tasksystem.php");
		break;
		
		case "karmiavideos";
			$subtopic = "karmiavideos";
			$topic = "Karmiavideos";
			require_once("karmiavideos.php");
		break;
		
		case "commands";
			$subtopic = "commands";
			$topic = "Commands";
			require_once("commands.php");
		break;
		
		case "questmakers";
			$subtopic = "questmakers";
			$topic = "Quest Makers";
			require_once("questmakers.php");
		break;
		
		case "addonmakers";
			$subtopic = "addonmakers";
			$topic = "Addon Makers";
			require_once("addonmakers.php");
		break;
		
		case "auctions";
			$subtopic = "auctions";
			$topic = "Auctions";
			require_once("auctions.php");
		break;
		
		case "contact";
			$subtopic = "contact";
			$topic = "Contact";
			require_once("contact.php");
		break;
		
		case "paypal";
			$subtopic = "paypal";
			$topic = "Paypal";
			require_once("paypal.php");
		break;

		case "guildshop";
			$subtopic = "guildshop";
			$topic = "Guild Shop";
			require_once("shopsystem2.php");
		break;
		
		case "bestcountries";
			$subtopic = "bestcountries";
			$topic = "bestcountries";
			require_once("bestcountries.php");
		break;
		
		case "castle";
			$subtopic = "castle";
			$topic = "Castle";
			require_once("events/castle.php");
		break;
		
		case "lastmanstanding";
			$subtopic = "lastmanstanding";
			$topic = "Last Man Standing";
			require_once("events/lastmanstanding.php");
		break;
		
		case "metinstone";
			$subtopic = "metinstone";
			$topic = "Metin Stone Event";
			require_once("events/metinstone.php");
		break;
		
		case "run":
			$subtopic = "run";
			$topic = "Run Event";
			require_once("events/run.php");
		break;

		case "rain":
			$subtopic = "rain";
			$topic = "Rain Event";
			require_once("events/rain.php");
		break;
		
		case "swim":
			$subtopic = "swim";
			$topic = "Swim Event";
			require_once("events/swimevent.php");
		break;

		case "fastevent":
			$subtopic = "fastevent";
			$topic = "Fast Event";
			require_once("events/fastevent.php");
		break;
				
		case "achievments":
			$subtopic = "achievments";
			$topic = "Achievments";
			require_once("achievments.php");
		break;

		case "tester":
			$subtopic = "tester";
			$topic = "tester";
			require_once("tester.php");
		break;
	}
	
	if(empty($topic))
	{
		$title = $GLOBALS['config']['server']["serverName"] . " - OTS";
		$main_content .= 'Error 404, page not found.';
	}
	else
		$title = $GLOBALS['config']['server']["serverName"] . " :: " . $topic;
		
	$layout_header = '
	<script type=\'text/javascript\'>
		function GetXmlHttpObject()
		{
			var xmlHttp=null;
			try
			{
				xmlHttp = new XMLHttpRequest();
			}
			catch (e)
			{
				try
				{
					xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch (e)
				{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
			}
			return xmlHttp;
		}

		function MouseOverBigButton(source)
		{
			source.firstChild.style.visibility = "visible";
		}
		
		function MouseOutBigButton(source)
		{
			source.firstChild.style.visibility = "hidden";
		}
		
		function BigButtonAction(path)
		{
			window.location = path;
		}
		var';
		if($logged)
			$layout_header .= "loginStatus = 1; loginStatus = 'true';";
		else
			$layout_header .= "loginStatus = 0; loginStatus = 'false';";
		
		$layout_header .= "var activeSubmenuItem='" . $subtopic . "';  var IMAGES=0; IMAGES='" . $config['server']['url']."/" . $layout_name . "/images'; var LINK_ACCOUNT = 0; LINK_ACCOUNT='" . $config['server']['url'] . "';
	</script>";
		
	require_once($layout_name."/layout.php");
	ob_end_flush();
?>