<?php

/* Chat line is used for the chat entries */

class ChatLine extends ChatBase{
	
	protected $text = '', $author = '', $gravatar = '', $roomId='';
	
	public function save(){
		DB::query("
			INSERT INTO chat (author, gravatar, text, roomId)
			VALUES (
				'".DB::esc($this->author)."',
				'".DB::esc($this->gravatar)."',
				'".DB::esc($this->text)."',
				'".DB::esc($this->roomId)."'
		)");
		
		// Returns the MySQLi object of the DB class
		
		return DB::getMySQLiObject();
	}
}

?>