<?php
	if($action == "")
	{
		$main_content .= '
		<script type="text/javascript">
		var accountHttp;

		//sprawdza czy dane konto istnieje czy nie
		function checkAccount()
		{
			if(document.getElementById("account_name").value=="")
			{
				document.getElementById("acc_name_check").innerHTML = \'<image src="../images/false.gif"> <font color="red">'.$lang['site']['CA_PANEL_T1'].'</font>\';
				return;
			}
			accountHttp=GetXmlHttpObject();
			if (accountHttp==null)
			{
				return;
			}
			var account = document.getElementById("account_name").value;
			var url="ajax/check_account.php?account=" + account + "&uid="+Math.random();
			accountHttp.onreadystatechange=AccountStateChanged;
			accountHttp.open("GET",url,true);
			accountHttp.send(null);
		} 

		function AccountStateChanged() 
		{ 
			if (accountHttp.readyState==4)
			{ 
				document.getElementById("acc_name_check").innerHTML=accountHttp.responseText;
			}
		}

		var emailHttp;

		//sprawdza czy dane konto istnieje czy nie
		function checkEmail()
		{
			if(document.getElementById("email").value=="")
			{
				document.getElementById("email_check").innerHTML = \'<image src="../images/false.gif"> <font color="red">'.$lang['site']['CA_PANEL_T2'].'</font>\';
				return;
			}
			emailHttp=GetXmlHttpObject();
			if (emailHttp==null)
			{
				return;
			}
			var email = document.getElementById("email").value;
			var url="ajax/check_email.php?email=" + email + "&uid="+Math.random();
			emailHttp.onreadystatechange=EmailStateChanged;
			emailHttp.open("GET",url,true);
			emailHttp.send(null);
		} 

		function EmailStateChanged() 
		{ 
			if (emailHttp.readyState==4)
			{ 
				document.getElementById("email_check").innerHTML=emailHttp.responseText;
			}
		}

		function validate_required(field,alerttxt)
		{
			with (field)
			{
				if (value==null||value==""||value==" ")
					{alert(alerttxt);return false;}
				else {return true}
			}
		}

		function validate_email(field,alerttxt)
		{
			with (field)
			{
				apos=value.indexOf("@");
				dotpos=value.lastIndexOf(".");
				if (apos<1||dotpos-apos<2) 
					{alert(alerttxt);return false;}
				else {return true;}
			}
		}

		function validate_form(thisform)
		{
			with (thisform)
			{
				if (validate_required(account_name, "'.$lang['site']['CA_PANEL_T3'].'")==false)
					{account_name.focus();return false;}
				if (validate_required(email,"'.$lang['site']['CA_PANEL_T4'].'")==false)
					{email.focus();return false;}
				if (validate_email(email,"'.$lang['site']['CA_PANEL_T5'].'")==false)
					{email.focus();return false;}
				if (verifpass==1) 
				{
					if (validate_required(passor,"'.$lang['site']['CA_PANEL_T6'].'")==false)
						{passor.focus();return false;}
					if (validate_required(passor2,"'.$lang['site']['CA_PANEL_T7'].'")==false)
						{passor2.focus();return false;}
					if (passor2.value!=passor.value)
						{alert("'.$lang['site']['CA_PANEL_T8'].'");return false;}
				}
				if (verifya==1) 
				{
					if (validate_required(verify,"'.$lang['site']['CA_PANEL_T9'].'")==false)
						{verify.focus();return false;}
				}
				if(rules.checked==false)
					{alert("'.$lang['site']['CA_PANEL_T10'].'");return false;}
				if(rulesServer.checked==false)
					{alert("'.$lang['site']['CA_PANEL_T10'].'");return false;}
			}
		}
		</script>';
	
	$main_content .= '
	'.$lang['site']['CA_PANEL_T11'].' ' . $config['server']['serverName'] . ' '.$lang['site']['CA_PANEL_T12'].'
	'.$lang['site']['CA_PANEL_T13'].'<br /><br />

	<form action="index.php?subtopic=createaccount&action=saveaccount" onsubmit="return validate_form(this)" method="POST">
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue">
			<tr>
				<td colspan="2" bgcolor="' . $config['site']['vdarkborder'] . '" class="white" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T14'].' ' . $config['server']['serverName'] . ' '.$lang['site']['CA_PANEL_T15'].'</td>
			</tr>

			<script type="text/javascript">var accountcustom = 1;</script>

			<tr bgcolor="' . $config['site']['darkborder'] . '">
				<td align="center" width="30%" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T16'].' </td>
				<td><input type="text" id="account_name" name="reg_name" OnKeyUp="checkAccount();" value="" size="31" maxlength="50"><font size="1" face="verdana, arial, helvetica"><div id="acc_name_check">'.$lang['site']['CA_PANEL_T17'].'</div></font></td>
			</tr>

			<tr bgcolor="' . $config['site']['lightborder'] . '">
				<td align="center" width="30%" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T18'].' </td>
				<td><input type="text" id="email" name="reg_email" onkeyup="checkEmail();" value="" size="31" maxlength="250"><font size="1" face="verdana, arial, helvetica"><div id="email_check">'.$lang['site']['CA_PANEL_T19'].' ' . $config['server']['serverName'] . ' '.$lang['site']['CA_PANEL_T20'].')</div></font></td>
			</tr>

			<script type="text/javascript">var verifpass=1;</script>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
				<td align="center" width="30%" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T21'].' </td>
				<td><input type="password" id="passor" name="reg_password" value="" size="31" maxlength="50"><br /><font size="1" face="verdana,arial,helvetica">'.$lang['site']['CA_PANEL_T22'].' '.$config['server']['serverName'].')</font></td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
				<td align="center" width="30%" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T23'].' </td>
				<td><input type="password" id="passor2" name="reg_password2" value="" size="31" maxlength="50"><br /><font size="1" face="verdana,arial,helvetica">'.$lang['site']['CA_PANEL_T24'].'</font></td>
			</tr>
			
			<script type="text/javascript">var verifpass=0;</script>';
				
			if($config['site']['verify_code'])
			{
				$main_content .= '
				<script type="text/javascript">var verifya=1;</script>
				<tr bgcolor="' . $config['site']['darkborder'] . '">
					<td align="center" width="30%" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T26'].' </td>
					<td><img src="imgverification/imagebuilder.php" border="0" alt="'.$lang['site']['CA_PANEL_T25'].'"></td>
				</tr>
				<tr bgcolor="' . $config['site']['lightborder'] . '">
					<td align="center" width="30%" style="font-weight: bold;">'.$lang['site']['CA_PANEL_T27'].' </td>
					<td><input type="text" id="verify" name="reg_code" value="" size="31" maxlength="50"><br /><font size="1" face="verdana,arial,helvetica">'.$lang['site']['CA_PANEL_T28'].'</font></td>
				</tr>';
			}
			
			$main_content .= '<script type="text/javascript">var verifya=0;</script>';
			$main_content .= '
			<tr bgcolor="' . $config['site']['darkborder'] . '">
				<td colspan="2">'.$lang['site']['CA_PANEL_T29'].'</td>
			</tr>
			<tr bgcolor="' . $config['site']['lightborder'] . '">
				<td colspan="2">
					<input type="checkbox" name="rulesServer" id="rulesServer" value="true" /><label for="rulesServer"> <u>'.$lang['site']['CA_PANEL_T30'].''.$config['server']['serverName'].' '.$lang['site']['CA_PANEL_T31'].'</a>.</u></label><br />
					<input type="checkbox" name="rules" id="rules" value="true" /><label for="rules"> <u>'.$lang['site']['CA_PANEL_T32'].'</u></label><br />
				</td>
			</tr>
			<tr bgcolor="' . $config['site']['darkborder'] . '">
				<td colspan="2">
					'.$lang['site']['CA_PANEL_T33'].' '.$config['server']['serverName'].' '.$lang['site']['CA_PANEL_T34'].'.<br />
					'.$lang['site']['CA_PANEL_T35'].' '.$config['server']['serverName'].' '.$lang['site']['CA_PANEL_T36'].'.
				</td>
			</TR>
		</table>
		
		<br />
		
		<table border="0" width="50%" align="center">
			<tr>
				<td align="center" valign="top">
					<input type=image name="I Agree" src="' . $layout_name . '/images/buttons/i_agree.png" border="0" /></form>
				</td>
				<td align="center">
					<form action="index.php?subtopic=latestnews" method="POST">
						<input type=image name="Cancel" SRC="' . $layout_name . '/images/buttons/cancel.png" border="0" />
					</form>
				</td>
			</tr>
		</table>';
	}
	if($action == "saveaccount")
	{
		$reg_name = strtoupper(trim($_POST['reg_name']));
		$reg_email = trim($_POST['reg_email']);
		$reg_password = trim($_POST['reg_password']);
		$reg_code = trim($_POST['reg_code']);
		
		if(empty($reg_name))
			$reg_form_errors[] = $lang['site']['CA_PANEL_T37'];
			
		elseif(!check_account_name($reg_name))
			$reg_form_errors[] = $lang['site']['CA_PANEL_T38'];
			
		if(empty($reg_email))
			$reg_form_errors[] = $lang['site']['CA_PANEL_T39'];
		else
		{
			if(!check_mail($reg_email))
				$reg_form_errors[] = $lang['site']['CA_PANEL_T40'];
		}
		
		if($config['site']['verify_code'])
		{
			$string = strtoupper($_SESSION['string']);
			$userstring = strtoupper($reg_code);
			session_destroy();
			if(empty($string))
				$reg_form_errors[] = $lang['site']['CA_PANEL_T41'];
			else
			{
				if(empty($userstring))
					$reg_form_errors[] = $lang['site']['CA_PANEL_T42'];
				else
				{
					if($string != $userstring)
						$reg_form_errors[] = $lang['site']['CA_PANEL_T43'];
				}
			}
		}
		
		if(empty($reg_password) && !$config['site']['create_account_verify_mail'])
			$reg_form_errors[] = $lang['site']['CA_PANEL_T44'];
		elseif(!$config['site']['create_account_verify_mail'])
		{
			if(!check_password($reg_password))
				$reg_form_errors[] = $lang['site']['CA_PANEL_T45'];
		}
		
		if(empty($reg_form_errors))
		{
			if($config['site']['one_email'])
			{
				$test_email_account = new OTS_Account();
				$test_email_account->findByEmail($reg_email);
				if($test_email_account->isLoaded())
					$reg_form_errors[] = $lang['site']['CA_PANEL_T46'];
			}
			
			$account_db = new OTS_Account();
			$account_db->find($reg_name);
			if($account_db->isLoaded())
				$reg_form_errors[] = $lang['site']['CA_PANEL_T47'];
		}
		
		if(empty($reg_form_errors))
		{
			//create object 'account' and generate new acc. number
			if($config['site']['create_account_verify_mail'])
			{
				$reg_password = '';
				for ($i = 1; $i <= 6; $i++)
					$reg_password .= mt_rand(0,9);
			}
			$reg_account = $ots->createObject('Account');
			$number = $reg_account->create(0, 9999999, $reg_name);
			// saves account information in database
			$reg_account->setEMail($reg_email);
			if($config['site']['choose_countr'])
			{
				$reg_account->setCustomField("flag", $reg_country);
			}
			if($config['site']['referrer'])
			{
				$reg_account->setCustomField("ref", $reg_referrer);
				$SQL->query('INSERT INTO z_referers (account_id, ref_account_id) valueS ('.$number.', '.$reg_referrer.')');
			}
			$reg_account->setPassword(password_ency($reg_password));
			$reg_account->unblock();
			$reg_account->save();
			$reg_account->setCustomField("created", time());
			$reg_account->setCustomField("lastday", time());
			$reg_account->setCustomField("password_plain", $reg_password);
			if($config['site']['newaccount_premdays'])
			{
				$reg_account->setCustomField("premdays", $config['site']['newaccount_premdays']);
			}
			//show information about registration
			$main_content .= ''.$lang['site']['CA_PANEL_T53'].'<BR><BR>
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
				<TR>
					<TD BGCOLOR="'.$config['site']['vdarkborder'].'" CLASS=white><B>'.$lang['site']['CA_PANEL_T52'].'</B></TD>
				</TR>
				<TR>
					<TD BGCOLOR="'.$config['site']['darkborder'].'">
						<TABLE BORDER=0 CELLPADDING=1>
							<TR>
								<TD>
									<FONT size=5>'.$lang['site']['CA_PANEL_T48'].' <B>'.$reg_name.'</B></FONT><BR><BR>'.$lang['site']['CA_PANEL_T49'].' <b>'.trim($_POST['reg_password']).'</b>.
									'.$lang['site']['CA_PANEL_T50'].' '.$config['server']['serverName'].'.
									'.$lang['site']['CA_PANEL_T51'].'<BR><BR>';
									if($config['site']['send_emails'] && $config['site']['create_account_verify_mail'])
									{
										$mailBody = '<html>
										<body>
										<h3>'.$lang['site']['CA_PANEL_T54'].'</h3>
										<p>'.$lang['site']['CA_PANEL_T55'].' <a href="'.$config['server']['url'].'"><b>'.$config['server']['serverName'].'</b></a> '.$lang['site']['CA_PANEL_T56'].'</p>
										<p>'.$lang['site']['CA_PANEL_T57'].' <b>'.$reg_name.'</b></p>
										<p>'.$lang['site']['CA_PANEL_T58'].' <b>'.trim($reg_password).'</b></p>
										<br />
										<p>'.$lang['site']['CA_PANEL_T59'].'</p>
										<li>'.$lang['site']['CA_PANEL_T60'].'
										<li>'.$lang['site']['CA_PANEL_T61'].'
										<li>'.$lang['site']['CA_PANEL_T62'].'
										</body>
										</html>';
										require("phpmailer/class.phpmailer.php");
										$mail = new PHPMailer();
										if ($config['site']['smtp_enabled'] == "yes")
										{
											$mail->IsSMTP();
											$mail->Host = $config['site']['smtp_host'];
											$mail->Port = (int)$config['site']['smtp_port'];
											$mail->SMTPAuth = ($config['site']['smtp_auth'] ? true : false);
											$mail->Username = $config['site']['smtp_user'];
											$mail->Password = $config['site']['smtp_pass'];
										}
										else
											$mail->IsMail();
										$mail->IsHTML(true);
										$mail->From = $config['site']['mail_address'];
										$mail->AddAddress($reg_email);
										$mail->Subject = $config['server']['serverName'] .$lang['site']['CA_PANEL_T63'];
										$mail->Body = $mailBody;
										if($mail->Send())
										{
											$main_content .= $lang['site']['CA_PANEL_T64'];
										}
										else
										{
											$main_content .= '<br /><small>'.$lang['site']['CA_PANEL_T65'].'</small>';
											$reg_account->delete();
										}
									}
									elseif($config['site']['send_emails'] && $config['site']['send_register_email'])
									{
										$mailBody = '<html>
										<body>
										<h3>'.$lang['site']['CA_PANEL_T54'].'</h3>
										<p>'.$lang['site']['CA_PANEL_T55'].' <a href="'.$config['server']['url'].'"><b>'.$config['server']['serverName'].'</b></a> '.$lang['site']['CA_PANEL_T56'].'</p>
										<p>'.$lang['site']['CA_PANEL_T57'].' <b>'.$reg_name.'</b></p>
										<p>'.$lang['site']['CA_PANEL_T58'].' <b>'.trim($reg_password).'</b></p>
										<br />
										<p>'.$lang['site']['CA_PANEL_T59'].'</p>
										<li>'.$lang['site']['CA_PANEL_T60'].'
										<li>'.$lang['site']['CA_PANEL_T61'].'
										<li>'.$lang['site']['CA_PANEL_T62'].'
										</body>
										</html>';
										require("phpmailer/class.phpmailer.php");
										$mail = new PHPMailer();
										if ($config['site']['smtp_enabled'] == "yes")
										{
											$mail->IsSMTP();
											$mail->Host = $config['site']['smtp_host'];
											$mail->Port = (int)$config['site']['smtp_port'];
											$mail->SMTPAuth = ($config['site']['smtp_auth'] ? true : false);
											$mail->Username = $config['site']['smtp_user'];
											$mail->Password = $config['site']['smtp_pass'];

										}
										else
											$mail->IsMail();
										$mail->IsHTML(true);
										$mail->From = $config['site']['mail_address'];
										$mail->AddAddress($reg_email);
										$mail->Subject = $config['server']['serverName'] .$lang['site']['CA_PANEL_T63'];
										$mail->Body = $mailBody;
										if($mail->Send())
											$main_content .= '<br /><small>'.$lang['site']['CA_PANEL_T66'].' <b>'.$reg_email.'</b>. '.$lang['site']['CA_PANEL_T67'].'';
										else
											$main_content .= '<br /><small>'.$lang['site']['CA_PANEL_T68'].'';
									}
										$main_content .= '
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
			</TABLE>';
		}
		else
		{
			//SHOW ERRORs if data from form is wrong
			$main_content .= '
				<div class="SmallBox" >
					<div class="MessageContainer" >
						<div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>
						<div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>
						<div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>
						<div class="ErrorMessage" >
							<div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>
							<div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>
							<div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div>
								<b>The Following Errors Have Occurred:</b><br/>';
								foreach($reg_form_errors as $show_msg)
								{
									$main_content .= '<li>'.$show_msg;
								}
								$main_content .= '
						</div>
						<div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>
						<div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>
						<div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>
					</div>
				</div><BR><BR>
				<CENTER>
					<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
						<FORM ACTION=index.php?subtopic=createaccount METHOD=post>
							<TR>
								<TD>
									<input type=image name="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18>
								</TD>
							</TR>
						</FORM>
					</TABLE>
				</CENTER>';
		}
}
?>