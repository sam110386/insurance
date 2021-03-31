<?php
$redirect='http://conv.clickjetmedia.com/?subid=cjtesting1234&payout=0&net=c&net2=qmw';
$ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $redirect);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	        $response = curl_exec($ch);
	        curl_close($ch);

			$LogFIle = '/var/www/vhosts/everythingautoinsurance.com/httpdocs/storage/logs/affiliate-'.date('Y-m-d'). ".log";
			error_log("\n" . date('Y-m-d H:i:s') . '=> ' . $redirect . ' <====> ' . $response, 3, $LogFIle);
?>