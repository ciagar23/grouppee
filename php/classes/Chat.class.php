<?php

/* The Chat class exploses public static methods, used by ajax.php */

class Chat{
	
	public static function login($name,$password){
		if(!$name || !$password){
			throw new Exception('Fill in all the required fields.');
		}
		
		$user = new ChatUser(array(
			'name'		=> $name,
			'password'	=> $password
		));
		
		// The save method returns a MySQLi object
		if($user->login()->affected_rows == !1){
			throw new Exception('This nick is in use.');
		}
		
		$_SESSION['user']	= array(
			'name'		=> $name,
			'gravatar'	=> $gravatar
		);
		
		return array(
			'status'	=> 1,
			'name'		=> $name,
			'gravatar'	=> Chat::gravatarFromHash($gravatar)
		);
	}
	
	public static function checkLogged(){
		$response = array('logged' => false);
			
		if($_SESSION['user']['name']){
			$response['logged'] = true;
			$response['loggedAs'] = array(
				'name'		=> $_SESSION['user']['name'],
				'gravatar'	=> Chat::gravatarFromHash($_SESSION['user']['gravatar'])
			);
		}
		
		return $response;
	}
	/*
	public static function logout(){
		DB::query("DELETE FROM user WHERE name = '".DB::esc($_SESSION['user']['name'])."'");
		
		$_SESSION = array();
		unset($_SESSION);

		return array('status' => 1);
	}
	*/
	
	public static function submitChat($chatText,$roomId){
		if(!$_SESSION['user']){
			throw new Exception('You are not logged in');
		}
		
		if(!$chatText){
			throw new Exception('You haven\' entered a chat message.');
		}
	
		$chat = new ChatLine(array(
			'author'	=> $_SESSION['user']['name'],
			'gravatar'	=> $_SESSION['user']['gravatar'],
			'text'		=> $chatText,
			'roomId'	=> $roomId,
		));
	
		// The save method returns a MySQLi object
		$insertID = $chat->save()->insert_id;
	
		return array(
			'status'	=> 1,
			'insertID'	=> $insertID
		);
	}
	
	public static function getUsers(){
		if($_SESSION['user']['name']){
			$user = new ChatUser(array('name' => $_SESSION['user']['name']));
			$user->update();
		}
		
		// Deleting chats older than 5 minutes and users inactive for 30 seconds
		
		/*
		DB::query("DELETE FROM webchat_lines WHERE ts < SUBTIME(NOW(),'0:5:0')");
		DB::query("DELETE FROM user WHERE last_activity < SUBTIME(NOW(),'0:0:30')");
		*/
		
		$result = DB::query('SELECT * FROM user ORDER BY name ASC LIMIT 18');
		
		$users = array();
		while($user = $result->fetch_object()){
			$user->gravatar = Chat::gravatarFromHash($user->gravatar,30);
			$users[] = $user;
		}
	
		return array(
			'users' => $users,
			'total' => DB::query('SELECT COUNT(*) as cnt FROM user')->fetch_object()->cnt
		);
	}
	
	public static function getChats($lastID,$room){
		$lastID = (int)$lastID;
		$room = (int)$room;
	
		$result = DB::query('SELECT * FROM chat WHERE id > '.$lastID.' AND roomId='.$room.' ORDER BY id ASC');
	
		$chats = array();
		while($chat = $result->fetch_object()){
			
			// Returning the GMT (UTC) time of the chat creation:
			
			$chat->time = array(
				'hours'		=> gmdate('H',strtotime($chat->ts)),
				'minutes'	=> gmdate('i',strtotime($chat->ts))
			);
			
			$chat->gravatar = Chat::gravatarFromHash($chat->gravatar);
			
			$chats[] = $chat;
		}
	
		return array('chats' => $chats);
	}
	
	public static function gravatarFromHash($hash, $size=23){
		return 'img/none.jpg'.$hash.'?size='.$size.'&amp;default='.
				urlencode('img/none.jpg'.$hash.'?size='.$size);
	}
}


?>