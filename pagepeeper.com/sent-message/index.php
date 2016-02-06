<?php
	if (isset($_POST['quick-contact-form-name']) && isset($_POST['quick-contact-form-email']) && isset($_POST['quick-contact-form-message'])) {
		$to      = 'iann0036@gmail.com';
		$subject = 'Contact Form - Page Peeper';
		$message = '--- Name: '.$_POST['quick-contact-form-name'].' --- '.$_POST['quick-contact-form-message'];
		$headers = 'From: ' . $_POST['quick-contact-form-email'];

		mail($to, $subject, $message, $headers);
	}
?><!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Page Peeper" />
	<meta name="description" content="The easiest and most convenient tool to monitor changes to websites.">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="/css/responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lt IE 9]>
		<script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->

	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/plugins.js"></script>

	<title>Page Peeper - Sent Message | Watch websites for changes</title>
</head>

<body class="stretched">

	<div id="wrapper" class="clearfix">

		<section id="content">

			<div class="content-wrap">

				<div class="container center clearfix">

					<div class="heading-block center">
						<h1>Message Sent</h1>
						<span>Your message has successfully been sent to us!</span>
					</div>

					<p>Thanks for getting in touch. We'll respond to you in less than 24 hours.</p>

					<a href="/" class="btn btn-default topmargin-sm">&lArr; Back to the homepage</a>

				</div>

			</div>

		</section>

	</div>

	<div id="gotoTop" class="icon-angle-up"></div>

	<script type="text/javascript" src="/js/functions.js"></script>
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-50859151-3', 'auto');
	  ga('send', 'pageview');

	</script>
</body>
</html>