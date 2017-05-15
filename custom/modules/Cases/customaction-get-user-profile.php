<?php
	require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
	
	$acc_token = $_SESSION['fb_access_token'];
	$fb = new Facebook\Facebook([
	  'app_id' => '1846034682318845',
	  'app_secret' => 'e82e8129a2411ec6bffd8b1581283ee5',
	  'default_graph_version' => 'v2.2',
	  ]);

	try 
	{
		// Returns a `Facebook\FacebookResponse` object
		// to get fields use ?fields={field-name}
		$response = $fb->get('/me?fields=id,name,link', $acc_token);
	} 
	catch(Facebook\Exceptions\FacebookResponseException $e) 
	{
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} 
	catch(Facebook\Exceptions\FacebookSDKException $e) 
	{
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	$user = $response->getGraphUser();

	echo 'Name: ' . $user['name'];
	echo '<pre>';
	print_r($user);
	// OR
	// echo 'Name: ' . $user->getName();
	echo '<h3>Access Token</h3>';
	$page_token = $fb->get('/185059835322329?fields=access_token', $acc_token);
	print_r($page_token);
	
?>