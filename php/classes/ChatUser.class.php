<?php

class ChatUser extends ChatBase{
	
	protected $name = '', $password = '';
	
	public function save(){
		
		DB::query("
			INSERT INTO user (name, password, isLogin)
			VALUES (
				'".DB::esc($this->name)."',
				'".DB::esc($this->password)."',
				1
		)");
		
		return DB::getMySQLiObject();
	}
	
	public function login(){
		
		DB::query("
			UPDATE user SET isLogin=1 
			WHERE name = '".DB::esc($this->name)."' AND
			password = '".DB::esc($this->password)."'
		");
		
		
		
		return DB::getMySQLiObject();
	}
	
	public function update(){
		DB::query("
			UPDATE user SET last_activity=NOW()
			WHERE name = '".DB::esc($this->name)."'"
			);
	}
}

?>