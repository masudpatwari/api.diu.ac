<!DOCTYPE html>
<html>
<head>
	<title>Reset your password</title>
	<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap');
	body{
		font-family: 'Open Sans', sans-serif;
	}
	p{
		margin: 2px;
	}
	</style>
</head>
<body>
<h3 style="margin: 0">Hi, there !</h3>
<p>We're excited to have you get started. First, you need to reset your password. Just press the button below.</p>
<p style="text-align: center; margin: 10px 0">
	<a href="{{ env('STUDENT_SITE_URL').'/auth/reset_password?token='.$token }}" target="_blank" style="padding: 15px; font-family: 'Open Sans', sans-serif; color: #ffffff; font-weight: 600; text-align: center; background-color: #bd2130; text-decoration: none; text-transform: uppercase; border: none; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; display: inline-block;">Reset your password</a>
</p>
<p>If you are having any issues with your account, please don't hesitate to contact us.</p>
<p>Thanks !</p>
</body>
</html>