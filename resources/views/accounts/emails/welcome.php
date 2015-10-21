<?php
    $url = $base_url.'activate/'.$user->id.'/'.$act->code;
?><!DOCTYPE html>
<html>
<head>
	<title>Welcome to Portphilio! Activate your account...</title>
</head>
<body>
	<p>Hello <?= $user->first_name ?>!</p>
	<p>Welcome to Portphilio! To complete your registration, please:</p>
	<p>&nbsp;&nbsp;&nbsp;
		<strong>
			<a href="<?= $url ?>">Click this link to activate your account</a>
		</strong>
	</p>
	<p>Or you may copy and paste the link below into your browser's address bar:</p>
	<p>&nbsp;&nbsp;&nbsp;<?= $url ?></p>
	<p>We look forward to seeing the amazing things you'll produce!</p>
	<p><em>The Portphilio Team</em></p>
</body>
</html>
