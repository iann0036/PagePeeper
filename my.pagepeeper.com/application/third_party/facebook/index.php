<?php
require_once __DIR__ . '/facebook-sdk/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '902142706501154',
  'app_secret' => '942a2bee082cb4baf80f0c9f7bc16a0b',
  'default_graph_version' => 'v2.4',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://my.pagepeeper.com/login/facebook/', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
