<?php

class UserModel extends Model{
	public function register(){
		//encrypt password to send to db -- use other type of encryption best than md5
		$password = md5($post['password']);

		// Sanitize POST
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if($post['submit']){
			if($post['name'] == '' || $post['email'] == '' || $post['password'] == '' ){
				Messages::setMsg('Fill all fields please', 'error');
				return;
			}

			// insert data into mysql
			$this->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
			$this->bind(':name', $post['name']);
			$this->bind(':email', $post['email']);
			$this->bind(':password', $post['password']);
			$this->execute();
			// verify
			if($this->lastInsertId()){
				//Redirect
				header('Location: '.ROOT_URL.'users/login');
			}
		}
		return;
	}

	public function login(){
		//encrypt password to send to db -- use other type of encryption best than md5
		$password = md5($post['password']);

		// Sanitize POST
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if($post['submit']){
			// COMPARE LOGIN from DB
			$this->query('SELECT * FROM users WHERE email = :email AND password=:password');
			$this->bind(':email', $post['email']);
			$this->bind(':password', $post['password']);

			//confirm and retrieve data from db
			$row = $this->single();
			if($row){
				$_SESSION['is_logged_in'] = true;
				$_SESSION['user_data'] = array(
					'id'	=> $row['id'],
					'name'	=> $row['name'],
					'email'	=> $row['email']
				);
				header('Location: '.ROOT_URL.'shares');
			}else{
				Messages::setMsg('incorret login', 'error');
			}
		}
		return;
	}
}