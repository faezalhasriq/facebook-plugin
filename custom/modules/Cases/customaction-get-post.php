<?php
	require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
	global $db;
	$acc_token = $_SESSION['fb_access_token'];
	$fb = new Facebook\Facebook([
	  'app_id' => '1846034682318845',
	  'app_secret' => 'e82e8129a2411ec6bffd8b1581283ee5',
	  'default_graph_version' => 'v2.8',
	  ]);
	
	// to retrieve feeds from page including admin post /{page-id}/feed
	echo '<pre>';
	$response = $fb->get('/185059835322329/feed', $acc_token);
	#print_r($response->getDecodedBody());
	$post_data = $response->getDecodedBody();
	#print_r($post_data);
	echo "<table style='width:1100px;' class='list view'>";
	echo "<thead><tr><th>No.</th><th>Visitor Post</th><th>Date</th><th>From</th><th>Reply</th></tr></thead>";
	echo "<tbody>";
	$count = 1;
	$container = array();
	echo "<form id='form_comment' method='POST' action='index.php?module=Cases&action=customaction-get-post')'>";
	foreach($post_data['data'] as $data)
	{
		#print_r($data);
		$from = $fb->get('/'.$data['id'].'?fields=from', $acc_token);
		$from = $from->getDecodedBody();
		#print_r($from);
		$comments = $fb->get('/'.$data['id'].'/comments', $acc_token);
		$comments = $comments->getDecodedBody();
		#print_r($comments);
		$container['post'] = $data;
		$container['post']['from'] = $from['from'];
		
		$table_rows = "";
		$table_rows .= "<tr>";
		$table_rows .= "<td><label>".$count."</label><br><input type='submit' name='createCase[{$data['id']}]' value='Create Case'></td>";
		$table_rows .= "<td><label>".$data['message']."(".$data['id'].")</label></td>";
		$table_rows .= "<td><label>".$data['created_time']."</label></td>";
		$table_rows .= "<td><label>".$from['from']['name']."</label></td>";
		$table_rows .= "<td><input type='text' name='addComment[{$data['id']}]'><input type='submit' name='reply' value='Reply'>
						<input type='hidden' name='pageAction' value='pageReply' /></td>";
		foreach($comments['data'] as $comment)
		{
			$table_rows .= "<tr><td></td>";
			$table_rows .= "<td><label>Comment: ".$comment['message']."\nFrom: ".$comment['from']['name']."\nDate: ".$comment['created_time']."</label></td></tr>";
			$container['comment'] = $comment;
			
		}
		$table_rows .= "</tr>";
		
		echo $table_rows;
		$count ++;
		#print_r($container);
	}
	echo "</tbody></table>";
	echo "</form>";
	#print_r($_POST); // get value what being posted
	#print_r($_GET); // get value from url param
	#print_r($_REQUEST); // get all
	if(isset($_POST["createCase"]) && !empty($_POST["createCase"]))
	{
		foreach($_POST["createCase"] as $key=>$value)
		{
			print_r($key);
			$caseBean = new aCase();
			$caseBean->facebook_post_id = $key;
			$response = $fb->get('/'.$key, $acc_token);
			$post_message = $response->getDecodedBody();
			$caseBean->description = $post_message['message'];
			$from = $fb->get('/'.$post_message['id'].'?fields=from', $acc_token);
			$from = $from->getDecodedBody();
			print_r($from);
			$caseBean->name = 'Case from ' . $from['from']['name'];
			$caseBean->status = 'New';
			$caseBean->save();
			
			//create account
			$sql = "SELECT COUNT(*) as found FROM accounts WHERE facebook = 'https://www.facebook.com/".$from['from']['id']."' AND deleted = 0";
			$result = $db->query($sql);
			$row = $db->fetchByAssoc($result);
			$accountBean = new Account();
			$fb_link = "https://www.facebook.com/".$from['from']['id'];
			error_log($fb_link);
			if($row['found'] > 0)
			{
				error_log('Account already exist');
				$accountBean->retrieve_by_string_fields(array('facebook' => $fb_link));
				error_log($accountBean->id);
			}
			else
			{
				$accountBean->name = $from['from']['name'];
				$accountBean->facebook = 'https://www.facebook.com/' . $from['from']['id'];
				$accountBean->save();
			}
			$caseBean->account_id = $accountBean->id;
			$caseBean->save();
		}
	}
	
	if(isset($_POST["pageAction"]) && $_POST['pageAction'] == 'pageReply' && isset($_POST['addComment']) && !empty($_POST['addComment']))
	{
		foreach($_POST['addComment'] as $key=>$value)
		{
			if(trim($value) && !empty($value))
			{
				$message = [
					  'message' => $value,
					  ];
				$post_id = $key;
			}
		}
		print_r($message);
		$add_reply = $fb->post('/'.$post_id.'/comments', $message, $acc_token);
		unset($message);
	}
	else
	{
		print_r('error');
	}
	
	
	
	
	//error_log(print_r($_POST['add_comment']));
	
	// submit a comment eg
	/* $message = [
	  'link' => 'http://www.example.com',
	  'message' => 'User provided message',
	  ];
	$comment = $fb->post('/{post-id}/comments', $message, $acc_token);
	print_r($comment->getDecodedBody()); */
?>