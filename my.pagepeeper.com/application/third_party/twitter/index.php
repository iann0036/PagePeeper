<?php
	require "twitteroauth/autoload.php";
	
	use Abraham\TwitterOAuth\TwitterOAuth;

	$connection = new TwitterOAuth('NWwxKkdlWiijPhkvoXBmwODi7', '5X606N53fXqwq1pSVtul9SUsyiGnmvwQPoQ3Fg6LoMk9tyMBIV'); //, '3286400322-8I0d3PP9g3e9V3zRrIkEWkMjoTIeqZHlMItCKOn', 'Yo4MAzGXdCejAaIQhccsyhzIRXtUnSRk1JSlU28isWSrE');
	$request_token = $connection->oauth('oauth/request_token');
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	// $content = $connection->get("account/verify_credentials");
	header("Location: ".$url);
