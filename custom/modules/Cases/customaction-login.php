<?php
	session_start();
	require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
	
	use Facebook\FacebookRequest;
	
	$fb = new Facebook\Facebook([
	  'app_id' => '1846034682318845', // Replace {app-id} with your app id
	  'app_secret' => 'e82e8129a2411ec6bffd8b1581283ee5',
	  'default_graph_version' => 'v2.8',
	  ]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email', 'publish_actions', 'pages_manage_cta', 'publish_pages']; // Optional permissions
	$loginUrl = $helper->getLoginUrl('http://localhost/sugarpro77/index.php?module=Cases&action=customaction-login-callback', $permissions);

	echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a><br>';
	echo '<pre>';
	
	$app_id = '1846034682318845';
	$app_secret = 'e82e8129a2411ec6bffd8b1581283ee5';
	
	$get_token = $fb->get('/oauth/access_token?client_id='.$app_id.'&client_secret='.$app_secret.'&grant_type=client_credentials');
	$access_token = $get_token->getDecodedBody();
	print_r($access_token['access_token']);
?>