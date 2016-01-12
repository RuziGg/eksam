<?php 

class User {
	
	private $connection;
	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
	}
	

	function loginUser($email1, $password1){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT id FROM register_user WHERE email=?");
		$stmt->bind_param("s", $email1);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if(!$stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellist kasutajat ei ole!";
			
			$response->error = $error;
			return $response;
		}
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT id, email FROM register_user WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email1, $password1);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			
			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisselogitud!";
			
			$response->success = $success;
			
			$user = new StdClass();
			$user->id = $id_from_db;
			$user->email = $email_from_db;
			
			$response->user = $user;
			
		}else{
			
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Parool oli vale!";
			
			$response->error = $error;
			
		}
		$stmt->close();
		
		return $response;
	}
	
} ?>