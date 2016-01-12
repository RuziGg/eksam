<?php


	require_once("edit_functions.php");
	
	//edit.php
	//aadressireal on ?edit_id siis trukin valja selle vaartuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		
		//id oli adressireal
		//tahaks uhte rida koige uuemaid andmeid kus id on $_GET["edit.php"]
		$Data1 = getEditData($_GET["edit_id"]);
		var_dump($Data1);
		
	}else{
		//ei olnud adressireal
		echo "Viga";
		//die - edasi lehte ei laeta
		//die();
		
		//suuname kasutaja table.php lehele
		header("Location: register.php");
		
	}

	if(isset($_POST["update_data"])){
		//vajutas salvesta nuppu
		//number_plate ja color tulevad vormist
		//aga id aadresirealt
		
		updateData($_POST["register_id"], $_POST["name"], $_POST["address"], $_POST["phone_number"], $_POST["register_code"]);
		
		
	}

?>

<h2>Muuda markuse</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?$_GET["edit_id"];?>">
	<label for="name" >Nimi</label><br>
	<input id="name" name="name" type="text" value="<?=$Data1->name;?>"><br><br>
	<label for="address">Aadress</label><br>
	<input id="address" name="address" type="text" value="<?=$Data1->address;?>"><br><br>
	<label for="phone_number">Tel. number</label><br>
	<input id="phone_number" name="phone_number" type="text" value="<?=$Data1->phone_number;?>"><br><br>
	<label for="register_code">Registri kood</label><br>
	<input id="register_code" name="register_code" type="text" value="<?=$Data1->register_code;?>"><br><br>
	<input type="submit" name="update_data" value="Salvesta">
</form>