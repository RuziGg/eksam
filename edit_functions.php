<?php

	require_once("../config_global.php");
	$database = "if15_ruzjaa_3";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT name, address, 'phone number', 'register code' FROM register WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($name, $address, $phone_number, $register_code);
		$stmt->execute();
		
		//object
		$data = new StdClass();
		
		// kas sain uhe rea andmeid katte
		//$stmt->fetch() annab uhe rea andmeid
		if($stmt->fetch()){
			//sain
			$Data1->name = $name;
			$Data1->address = $address;
			$Data1->phone_number = $phone_number;
			$Data1->register_code = $register_code;
			
		}else{
			// ei saanud
			// id ei olnud olemas, id=123123123
			// rida on kustutatud, deleted ei ole NULL
			header("Location: register.php");
		}
		
		return $Data1;
		
		
		$stmt->close();
		$mysqli->close();
		
	}
	
		function updateData($register_id, $name, $address, $phone_number, $register_code){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE register SET name=?, address=?, 'phone number'=?, 'register code'=? WHERE id=?");
		$stmt->bind_param("ssssi", $name, $address, $phone_number, $register_code, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tuhjaks
			// header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		
		
	}


?>
