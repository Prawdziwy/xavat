<?php
	if($logged)
	{
		require_once('./paypal/config.php');
		$main_content .= '<h2>Automatic PayPal shop system</h2><br><b>Here are the steps you need to make:</b><br>
		1. You need a valid creditcard <b>or</b> a PayPal account with a required amount of money.<br>
		2. Choose how many points you want buy.<br />
		3. Click on the donate/buy button.<br>
		4. Make a transaction on PayPal.<br>
		5. After the transaction points will be automatically added to your account.<br>
		6. Go to Item shop and use your points.</b><br /><br />';

		$main_content .= '
		<table border="0" cellspacing="1" cellpadding="4" width="100%" id="iblue"><tr bgcolor="' . $config['site']['vdarkborder'] . '"><td colspan="2" class="white"><b>Select offer:</b></td></tr>';
		foreach($paypals as $paypal)
		{
			$main_content .= '<tr bgcolor="' . (($i % 2) ? $config['site']['darkborder'] : $config['site']['lightborder']) . '"><td>Buy ' . $paypal['premium_points'] . ' premium points for ' . $paypal['money_amount'] . ' ' . $paypal['money_currency'] . '</td><td style="text-align:center"><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="' . $paypal_payment_type . '">
			<input type="hidden" name="business" value="' . htmlspecialchars($paypal['mail']) . '">
			<input type="hidden" name="item_name" value="' . htmlspecialchars($paypal['name']) . '">
			<input type="hidden" name="custom" value="' . $account_logged->getID() . '">
			<input type="hidden" name="amount" value="' . htmlspecialchars($paypal['money_amount']) . '">
			<input type="hidden" name="currency_code" value="' . htmlspecialchars($paypal['money_currency']) . '">
			<input type="hidden" name="no_note" value="0">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="notify_url" value="' . trim($paypal_report_url) . '">
			<input type="hidden" name="return" value="' . trim($paypal_return_url) . '">
			<input type="hidden" name="rm" value="0">
			<input type="image" src="' . $paypal_image . '" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
			</form></td></tr>';
			$i++;
		}
		$main_content .= '</table>';
	}
	else
		$main_content .= 'You are not logged in. Login first to buy points.';
?>