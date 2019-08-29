<?php 
dd(env("APP_ENV"));
	return [
		'admin_email' => (env("APP_ENV") == 'local') ? "vbmourya123@gmail.com" : "allensaraf@gmail.com",
		'admin_bcc_email' => (env("APP_ENV") == 'local') ? "sgstest2505@gmail.com" : "masisdavidian@gmail.com"
	];