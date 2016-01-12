<?php 
	
	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	session_start();
	
		
	
	
	
	function loginUser($login_email, $login_password){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT user_id, email FROM register_user WHERE email=? AND password=?");
		echo $mysqli->error;
		$stmt->bind_param("ss", $login_email, $login_password);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Email ja parool oiged, kasutaja id=".$id_from_db;
			
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
		}else{
			echo "Wrong redentials";
		}
				
		$stmt->close();
		
		$mysqli->close();
	}
	
	function addData($name, $address, $phone_number, $register_code){
		
		echo $name;
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO register (register_id, name, address, 'phone number', 'register code') VALUES (?,?,?,?,?)");
		$stmt->bind_param("issss", $_SESSION["logged_in_user_id"], $name, $address, $phone_number, $register_code);
		
		//sonum
		$message = "";
		
		if($stmt->execute()){
			//kui on tõene, siis INSERT õnnestus
			$message = "Sai edukalt lisatud";
		}else{
			//kui on väär, siis kuvame error
			echo $stmt->error;
		}
		
		return $message;
		
		$stmt->close();
		
		$mysqli->close();
	}
		
		
	function getData($keyword=""){
		
				$search = "%%";
		
		//kas otsisona on tuhi
		if($keyword==""){
			//ei otsi midagi
			echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin ".$keyword;
			$search = "%".$keyword."%";
		
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT register_id, user_id, name, address, 'phone number', 'register code' from register WHERE deleted IS NULL AND (name LIKE ? OR address LIKE ? OR 'phone numer' LIKE ? OR 'register code' LIKE ?) ");
		
		//echo $stmt->error;
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $search, $search);
		$stmt->bind_result($register_id, $user_id_from_database, $name, $address, $phone_number, $register_code);
		$stmt->execute();
		
		// tekitan tuhja massiivi, kus edaspidi hoian objekte
		$data_array = array();
		
		//tee midagi seni, kuni saame ab'ist uhe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			// tekitan objekti, kus hakkan hoidma vaartusi
			$Data1 = new StdClass();
			$Data1->register_id = $register_id;
			$Data1->name = $name;
			$Data1->user_id = $user_id_from_database;
			$Data1->address = $address;
			$Data1->phone_number = $phone_number;
			$Data1->register_code = $register_code;
			
			//lisan massiivi uhe rea juurde
			array_push($data_array, $Data1);
			//var dump utleb muutuja tuubi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus koik read sees
		return $data_array;
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
	function deleteData($register_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE register SET deleted=NOW() WHERE id=?");
		
		echo $mysqli->error;
		
		$stmt->bind_param("i", $register_id);
		
		echo $stmt->error;
		
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tuhjaks
			header("Location: register.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
	
	function updateData($register_id, $name, $address, $phone_number, $register_code){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE register SET name=?, address=?, 'phone number'=?, 'register code'=? WHERE register_id=?");
		$stmt->bind_param("ssssi", $name, $address, $phone_number, $register_code, $register_id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tuhjaks
			// header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}
?>