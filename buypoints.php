<?php
	$config['homepay'] = array();
	$config['homepay_user_id'] = 545;
	$config['homepay_active'] = true;
	$config['homepay_active_sms'] = true;
	$config['homepay_active_ivr'] = false;
	$config['homepay_active_transfer'] = true;
	
	// SMS
	$config['homepay'][1]['acc_id'] = 6793;
	$config['homepay'][1]['addpoints'] = 100;
	$config['homepay'][1]['sms_number'] = "7355";
	$config['homepay'][1]['type'] = "sms";
	$config['homepay'][1]['sms_text'] = "HPAY.XAV1";
	$config['homepay'][1]['sms_cost'] = "3";
	
	// SMS
	$config['homepay'][2]['acc_id'] = 6794;
	$config['homepay'][2]['addpoints'] = 300;
	$config['homepay'][2]['sms_number'] = "7955";
	$config['homepay'][2]['type'] = "sms";
	$config['homepay'][2]['sms_text'] = "HPAY.XAV2";
	$config['homepay'][2]['sms_cost'] = "9";
	
	// SMS
	$config['homepay'][3]['acc_id'] = 6795;
	$config['homepay'][3]['addpoints'] = 640;
	$config['homepay'][3]['sms_number'] = "91955";
	$config['homepay'][3]['type'] = "sms";
	$config['homepay'][3]['sms_text'] = "HPAY.XAV3";
	$config['homepay'][3]['sms_cost'] = "19";

	// SMS
	$config['homepay'][4]['acc_id'] = 6796;
	$config['homepay'][4]['addpoints'] = 840;
	$config['homepay'][4]['sms_number'] = "92555";
	$config['homepay'][4]['type'] = "sms";
	$config['homepay'][4]['sms_text'] = "HPAY.XAV4";
	$config['homepay'][4]['sms_cost'] = "25";
	
	// IVR
	$config['homepay'][5]['acc_id'] = 293;
	$config['homepay'][5]['addpoints'] = 150;
	$config['homepay'][5]['number'] = 704404991;
	$config['homepay'][5]['type'] = "ivr";
	$config['homepay'][5]['ivr_cost'] = "4.06";
	
	// IVR
	$config['homepay'][6]['acc_id'] = 294;
	$config['homepay'][6]['addpoints'] = 400;
	$config['homepay'][6]['number'] = 704704991;
	$config['homepay'][6]['type'] = "ivr";
	$config['homepay'][6]['ivr_cost'] = "10.15";
	
	// IVR
	$config['homepay'][7]['acc_id'] = 295;
	$config['homepay'][7]['addpoints'] = 1200;
	$config['homepay'][7]['number'] = 704904020;
	$config['homepay'][7]['type'] = "ivr";
	$config['homepay'][7]['ivr_cost'] = "28.7";
	

	// Transfer
	$config['homepay'][10]['acc_id'] = 2672;
	$config['homepay'][10]['addpoints'] = 400;
	$config['homepay'][10]['type'] = "przelew";
	$config['homepay'][10]['przelew_text'] = "XAV1";
	$config['homepay'][10]['przelew_cost'] = "10.00 zl brutto";

	// Transfer
	$config['homepay'][11]['acc_id'] = 2673;
	$config['homepay'][11]['addpoints'] = 800;
	$config['homepay'][11]['type'] = "przelew";
	$config['homepay'][11]['przelew_text'] = "XAV2";
	$config['homepay'][11]['przelew_cost'] = "20.00 zl brutto";

	// Transfer
	$config['homepay'][12]['acc_id'] = 2674;
	$config['homepay'][12]['addpoints'] = 1600;
	$config['homepay'][12]['type'] = "przelew";
	$config['homepay'][12]['przelew_text'] = "XAV3";
	$config['homepay'][12]['przelew_cost'] = "40.00 zl brutto";
	
	$config['paypal'] = array();
	$config['paypal_active'] = true;
	
	$config['paygol'] = array();
	$config['paygol_active'] = true;

	function logTransaction($file, $acc, $code)
	{
		$fd = fopen($file, "a");
		$str = date("d.m.Y, H:i:s") . ' - accountID: ' . $acc . ', code: ' . $code;
		fwrite($fd, $str . PHP_EOL);
		fclose($fd);
	}

	function check_code_homepay($code, $usluga)
	{
		global $config;
		if(!preg_match("/^[A-Za-z0-9]{8}$/", $code))
			return 0;
		
		$code = urlencode($code);
		$handle = fopen("http://homepay.pl/sms/check_code.php?usr_id=" . (int)$config['homepay_user_id'] . "&acc_id=" . (int)($config['homepay'][$usluga]['acc_id']) . "&code=" . $code, 'r');

		$status = fgets($handle, 8);
		fclose($handle);
		return $status;
	}

	function check_tcode_homepay($code, $usluga)
	{
		global $config;
		if(!preg_match("/^[A-Za-z0-9]{8}$/", $code))
			return 0;
		
		$code = urlencode($code);
		$handle = fopen("http://homepay.pl/API/check_tcode.php?usr_id=" . (int)$config['homepay_user_id'] . "&acc_id=" . (int)($config['homepay'][$usluga]['acc_id']) . "&code=" . $code, 'r');

		$status = fgets($handle, 8);
		fclose($handle);
		return $status;
	}
	
	function check_icode_homepay($code, $usluga)
	{
		global $config;
		if(!preg_match("/^[A-Za-z0-9]{8}$/", $code))
			return 0;
		
		$code = urlencode($code);
		$handle = fopen("http://homepay.pl/API/check_icode.php?usr_id=" . (int)$config['homepay_user_id'] . "&acc_id=" . (int)($config['homepay'][$usluga]['acc_id']) . "&code=" . $code, 'r');

		$status = fgets($handle, 8);
		fclose($handle);
		return $status;
	}

	function add_points(OTS_Account $account, $number_of_points)
	{
		if($account->isLoaded())
		{
			$account->setCustomField('premium_points', ($account->getCustomField('premium_points') + $number_of_points));
			return true;
		}
		else
			return false;
	}

	if($_REQUEST['system'] == 'homepay' && $config['homepay_active'])
	{
		$main_content .= '<center><img src="http://homepay.pl/theme/default/image/logo/homepay_logo26.png"/></center>';
	
		$sms_type = (int)$_POST['sms_type'];
		$posted_code = trim($_POST['code']);
		$to_user = trim($_POST['to_user']);
		$verify_code = trim($_POST['verify_code']);
		
		if(!empty($to_user))
		{
			if(is_numeric($to_user))
			{
				$account = new OTS_Account();
				$account->find($to_user);
			}
			else
			{
				$player = new OTS_Player();
				$player->find($to_user);
				if($player->isLoaded())
					$account = $player->getAccount();
				else
					$account = new OTS_Account();
			}

			if(empty($posted_code))
				$errors[] = 'Prosze wpisac kod z SMSa/przelewu.';

			if(!$account->isLoaded())
				$errors[] = 'Konto/konto postaci o podanym nicku nie istnieje.';

			if(count($errors) == 0)
			{
				if(!preg_match('/^[a-zA-Z0-9]{8}$/D', $posted_code)) 
					die("W tym polu mozesz jedynie uzywac liter: A-Z oraz cyfr: 0-9");
					
				if($config['homepay'][$sms_type]['type'] == 'sms')
					$code_info = check_code_homepay($posted_code, $sms_type);
				elseif($config['homepay'][$sms_type]['type'] == 'ivr')
					$code_info = check_icode_homepay($posted_code, $sms_type);
				elseif($config['homepay'][$sms_type]['type'] == 'przelew')
					$code_info = check_tcode_homepay($posted_code, $sms_type);
				else
					die();

				if($code_info != "1")
					$errors[] = 'Podany kod z SMSa/IVRa/przelewu jest niepoprawny lub wybrano zla opcje SMSa/IVRa/przelewu.';
				else
				{
					if(add_points($account, $config['homepay'][$sms_type]['addpoints']))
					{
						logTransaction('trans/homepay.log', $account->getId(), $posted_code);
						$main_content .= '<h1><font color="red">Dodano ' . $config['homepay'][$sms_type]['addpoints'] . ' punktow premium do konta: ' . $to_user . ' !</font></h1>';
					}
					else
						$errors[] = 'Wystapil blad podczas dodawania punktow do konta, sproboj ponownie.';
				}
			}
		}
		
		if(count($errors) > 0)
		{
			$main_content .= 'Wystapily bledy:';
			foreach($errors as $error)
				$main_content .= '<br />* ' . $error;
				$main_content .= '<hr /><hr />';
		}
		
		if($config['homepay_active_sms'])
		{
			$main_content .= '<h1>SMS</h1>';
			foreach($config['homepay'] as $homepay)
			{
				if($homepay['type'] == 'sms')
				{
					$main_content .= '
					* Na numer <span style="color: green; font-weight: bold;">' . $homepay['sms_number'] . '</span> o tresci <span style="color: green; font-weight: bold;">' . $homepay['sms_text'] . '</span> za <span style="color: green; font-weight: bold;">' . number_format($homepay['sms_cost'] * 1.23, 2) . '</span> zł brutto, a za kod otrzymasz <span style="color: green; font-weight: bold;">' . $homepay['addpoints'] . '</span> punktów premium.<br />';
				}
			}
		}
		if($config['homepay_active_ivr'])
		{
			$main_content .= '<h1>IVR</h1>Zadzwon ...<br />';
			foreach($config['homepay'] as $homepay)
			{
				if($homepay['type'] == 'ivr')
				{
					$main_content .= '
					* Na numer <span style="color: green; font-weight: bold;">' . $homepay['number'] . '</span>, koszt to <span style="color: green; font-weight: bold;">' . number_format($homepay['ivr_cost'] * 1.23, 2) . '</span> zł brutto, a za kod otrzymasz <span style="color: green; font-weight: bold;">' . $homepay['addpoints'] . '</span> punktów premium.<br />';
				}
			}
		}
		if($config['homepay_active_transfer'])
		{
			$main_content .= '<h1>Przelew</h1>';
			foreach($config['homepay'] as $homepay)
			{
				if($homepay['type'] == 'przelew')
				{
					$main_content .= '
					<center>* Adres - <a href="https://ssl.homepay.pl/wplata/' . $homepay['acc_id'] . '-' . $homepay['przelew_text'] . '"><span style="color: green; font-weight: bold;">https://ssl.homepay.pl/wplata/' . $homepay['acc_id'] . '-' . $homepay['przelew_text'] . '</span></a> koszt <span style="color: green; font-weight: bold;">' . $homepay['przelew_cost'] . '</span>, a za kod dostaniesz <span style="color: green; font-weight: bold;">' . $homepay['addpoints'] . '</span> punktow premium.</center>';
				}
			}
		}
		
		$main_content .= '
		<br /><hr /><br />
		<form action="?subtopic=buypoints&system=homepay" method="POST">
			<table>
				<tr>
					<td><b>Nick postaci: </b></td>
					<td><input type="text" size="20" value="' . $to_user . '" name="to_user" /></td>
				</tr>
				<tr>
					<td><b>Kod z SMSa: </b></td>
					<td><input type="text" size="20" value="' . $posted_code . '" name="code" /></td>
				</tr>
				<tr>
					<td><b>Typ wyslanego SMSa: </b></td>
					<td><select name="sms_type">';
						foreach($config['homepay'] as $id => $typ)
						{
							if($typ['type'] == 'sms' && $config['homepay_active_sms'])
								$main_content .= '<option value="' . $id . '">numer ' . $typ['sms_number'] . ' - kod ' . $typ['sms_text'] . ' - SMS za ' . number_format($typ['sms_cost'] * 1.23, 2) . ' zł brutto</option>';
							elseif($typ['type'] == 'ivr' && $config['homepay_active_ivr'])
								$main_content .= '<option value="' . $id . '">ivr - numer ' . $typ['number'].' - za ' . number_format($typ['ivr_cost'] * 1.23, 2) . ' zł brutto</option>';	
							elseif($typ['type'] == 'przelew' && $config['homepay_active_transfer'])
								$main_content .= '<option value="' . $id . '">przelew - kod ' . $typ['przelew_text'] . ' - za ' . $typ['przelew_cost'] . '</option>';
						}
						$main_content .= '
					</select></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Sprawdz" /></td>
				</tr>
			</table>
		</form><br />
		
		<br /><hr /><br />
		Serwis SMS obsługiwany jest przez <a href="http://homepay.pl">Homepay.pl</a><br />
		Regulamin: <a href="http://homepay.pl/regulamin/regulamin_sms_premium">http://homepay.pl/regulamin/regulamin_sms_premium</a><br />
		Usługa dostępna jest we <strong>wszystkich polskich</strong> sieciach komórkowych.<br /><br />
		Serwis IVR obsługiwany jest przez "Numer IVR Mobiltek"<br />
		<br /><hr /><br />
		<b>Regulamin usług dostępnych na stronie:</b>
		<br/>
		<b>1.a)</b> Kiedy Twój poprawnie wysłany SMS zostanie dostarczony otrzymasz SMS zwrotny z kodem.
		<br/>
		<b>1.b)</b> Kiedy Twój przelew zostanie zaksięgowany (z kart kredytowych i bankow internetowych z listy, jest to kwestia paru sekund) na e-mail który podałeś w formularzu otrzymasz kod.
		<br/>
		<b>2.</b> Po otrzymaniu kodu SMS/przelewu i wpisaniu go wraz z nazwą konta w powyższym formularzu, na serwerze ' . $config['server']['serverName'] . ' podane konto zostanie automatycznie doładowane o okresloną ilość <b>punktów premium</b> które nastepnie moga byc zamienione na wirtualne przedmioty w grze Open Tibia Serwer zwaną <b>'.$config['server']['serverName'].'</b>.
		<br/>
		<b>3.</b> Do pełnego skorzystania z usługi wymagana jest przeglądarka internetowa oraz połączenie z siecić Internet.
		<br/>
		<b>4.</b> <b>' . $config['server']['serverName'] . '</b> nie odpowieda za źle wpisane tresci SMS.
		<br/>
		<b>5.</b> Użytkownik nie ma możliwości odzyskania punktów premium czy też pieniędzy za żle wysłaną wiadomość której treść była nieprawidłowa lub wpisano błędny numer odbiorcy.
		<br/>		
		<b>6.</b> Gracz w zamian za dobrowolną dotację na rzecz serwera nabywa prawo do użytkowania przedmiotów. Nie staje się ich właścicielem. Właścicielem nadal pozostaje administrator serwera Xavato.eu.
		<br/>
        <b>7.</b> Administracja serwera nie ponosi odpowiedzialności za utratę przedmiotów.
		<br/>
		<b>8.</b> W razie problemów z działaniem usługi należy kontaktować się z <a href="mailto:xavato@gmail.com">xavato@gmail.com</a>
		<br/>
		<b>9.</b> Gracz dokonując dobrowolnej dotacji na rzecz serwera wyraża zgodę na otrzymywanie informacji zwiazanych z produktami lub usługami oferowanymi przez ' . $config['server']['serverName'] . ', darmowych produktów lub usług ' . $config['server']['serverName'] . ' jak również informacji na temat promocji, konkursów oraz innych działań komercyjnych prowadzonych przez ' . $config['server']['serverName'] . '
		<br /><br /><hr /><br />';
	}
	elseif($_REQUEST['system'] == 'paygol' && $config['paygol_active'])
	{
		$main_content .= '<center><img src="images/payments/paygol_logo.png"/></center>';
	
		$main_content .= '
		<h1>Information</h1>
		<li>Enter your account number.</li>
		<li>Choose your payment price.</li>
		<li>Click on the red Pay by mobile button.</li>
		<li>Follow the instructions.</li>
		<br />
		<h1>Offers</h1>
		* <span style="color: green; font-weight: bold;">100 premium points</span> for <span style="color: green; font-weight: bold;">3 EUR</span><br />
		* <span style="color: green; font-weight: bold;">400 premium points</span> for <span style="color: green; font-weight: bold;">9 EUR</span><br />
		* <span style="color: green; font-weight: bold;">900 premium points</span> for <span style="color: green; font-weight: bold;">18 EUR</span><br />
		* <span style="color: green; font-weight: bold;">2500 premium points</span> for <span style="color: green; font-weight: bold;">50 EUR</span><br />
		<br />';

		$main_content .= '
		<center>
			<script src="http://www.paygol.com/micropayment/js/paygol.js" type="text/javascript"></script>
			<form name="pg_frm">
				<strong>Account Name: </strong><input type="text" name="pg_custom" value=""><br />
				<input type="hidden" name="pg_serviceid" value="43941">
				<input type="hidden" name="pg_currency" value="EUR">
				<input type="hidden" name="pg_name" value="Premium Points">
				<strong>Select Offer: </strong><select name="pg_price">
					<option value="1">100 premium points for 3 EUR</option>
					<option value="2">400 premium points for 9 EUR</option>
					<option value="3">900 premium points for 18 EUR</option>
					<option value="4">2500 premium points for 50 EUR</option>
				</select><br />
				<input type="hidden" name="pg_return_url" value="http://xavato.eu/?subtopic=shopsystem">
				<input type="hidden" name="pg_cancel_url" value="">
				<input type="image" name="pg_button" class="paygol" src="http://www.paygol.com/micropayment/img/buttons/125/red_en_pwp.png" border="0" alt="Make payments with PayGol: the easiest way!" title="Make payments with PayGol: the easiest way!" onClick="pg_reDirect(this.form)">
			</form>
		</center>'; 
	}
	else
	{
		if($config['homepay_active'])
			$main_content .= '<br /><br /><div class="news-top"></div><div class="news-mid"><div class="title-news-buy"><a href="?subtopic=buypoints&system=homepay"><h2>Homepay - LINK</h2><img border="0" src="images/payments/homepay_logo.png"></a><h3>Zaplac SMS, karta kredytowa lub przelewem bankowym. Pay credit card or bank transfer.</div></div><div class="news-bottom"></div></h3>';
		if($config['paypal_active'])
			$main_content .= '<br /><br /><div class="news-top"></div><div class="news-mid"><div class="title-news-buy"><a href="?subtopic=paypal"><h2><b>Paypal</b> - LINK</h2><img border="0" src="images/payments/paypal_logo.png"/></a><h3>Buy points via paypal for all country users (<span style="color: red;">new, better price than PayGol!</span>)</h3></div></div><div class="news-bottom"></div>';
		if($config['paygol_active'])
			$main_content .= '<br /><br /><div class="news-top"></div><div class="news-mid"><div class="title-news-buy"><a href="?subtopic=buypoints&system=paygol"><h2><b>Paygol</b> - LINK</h2><img border="0" src="images/payments/paygol_logo.png"/></a><h3>Buy points via paygol for all country users.</h3></div></div><div class="news-bottom"></div>';
	}
?> 