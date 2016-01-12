<?php
class DataManager{
	
	
	private $connection;
	private $user_id;
	
	//kui tekitan new, siis kaivitakse see funktsioon
	function __construct($mysqli, $user_id_from_session){
		
		//selle klassi muutuja
		$this->connection = $mysqli;
		$this->user_id = $user_id_from_session;
		
		echo "Andmete haldus kaivitatud, kasutaja=".$this->user_id;
		
	}
	
	
	function addData($new_data){
		
		// teen objekti 
		// seal on error, ->id ja ->message
		// voi success ja sellel on ->message
		$response = new StdClass();
		

		$stmt = $this->connection->prepare("SELECT id FROM register WHERE name=?");
		$stmt->bind_param("s", $new_data);
		$stmt->bind_result($name);
		$stmt->execute();
		
		// kas sain rea andmeid
		if($stmt->fetch()){
			
			// annan errori, et selline firma olemas
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Andmed <strong>".$new_data."</strong> on juba olemas!";
			
			$response->error = $error;
			
			// koik mis on parast returni enam ei kaivitata
			return $response;
			
		}
		
		// panen eelmise paringu kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO register ('name', 'address', 'phone number', 'register code') VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $new_data);
		
		// sai edukalt salvestatud
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Andmed on lisatud!";
			
			$response->success = $success;
			
		}else{
			
			// midagi laks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi laks katki!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
	}
		
	function createDropdown(){
		
		$html = '';
		
		$html .= '<select name="new_dd_selection">';
		
		//$html .= '<option>1</option>';
		
		//$html .= '<option>2</option>';
		
		//$html .= '<option>3</option>';
		
		//$stmt = $this->connection->prepare("Select id, name FROM interests");
		
		//kuvame ainult puuduolevad andmed
		$stmt = $this->connection->prepare("SELECT register.register_id, register.name FROM register LEFT JOIN register_user ON register.register_id = register_user.user_id WHERE register_user.user_id IS NULL OR register_user.user_id !=?");
		
		
		$stmt->bind_param("i", $this->user_id);
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		//iga rea kohta
		while($stmt->fetch()){
			
			$html .= '<option value="'.$id.'">'.$name.'</option>';
			
		}
		
		$html .= '</select>';
		return $html;
		
	}
	
	function addUserData($new_data_id){
		
		// teen objekti 
		// seal on error, ->id ja ->message
		// voi success ja sellel on ->message
		$response = new StdClass();
		
		
		$stmt = $this->connection->prepare("SELECT id FROM register_user WHERE user_id=? AND register_id=?");
		$stmt->bind_param("ii", $this->user_id, $new_data_id);
		$stmt->bind_result($data_id);
		$stmt->execute();
		
		// kas sain rea andmeid
		if($stmt->fetch()){
			
			// annan errori, et andmed olemas
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Need andmed on sinul juba olemas!";
			
			$response->error = $error;
			
			// koik mis on parast returni enam ei kaivitata
			return $response;
			
		}
		
		// panen eelmise paringu kinni
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO register_user (user_id, register_id) VALUES (?,?)");
		$stmt->bind_param("ii", $this->user_id, $new_data_id);
		
		// sai edukalt salvestatud
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Andmed on lisatud!";
			
			$response->success = $success;
			
		}else{
			
			// midagi laks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi laks katki!";
			
			$response->error = $error;
			
		}
		
		$stmt->close();
		
		return $response;
		
	}
	
	function getUserData(){
		
		$html = '';
		
		$stmt = $this->connection->prepare("SELECT register.name FROM register_user INNER JOIN register ON register_user.user_id = register.register_id WHERE register_user.user_id = ?");
		$stmt->bind_param("i", $this-user_id);
		$stmt->bind_result($name);
		$stmt-execute();
		
		//iga reale kohta
		while($stmt->fetch()){
			
			$html .= '<p>'.$name.'</p>';
			
		}
		
		return $html;
		
	}
	
}?>