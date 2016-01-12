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
		
		updateData($_POST["register_id"], $_POST["name"], $_POST["address"], $_POST["phone number"], $_POST["register code"]);
		
		
	}

?>

<h2>Muuda markuse</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?$_GET["edit_id"];?>">
	<label for="title" >Pealkiri</label><br>
	<input id="title" name="title" type="text" value="<?=$Note1->title;?>"><br><br>
	<label for="note">Markus</label><br>
	<input id="note" name="note" type="text" value="<?=$Note1->note;?>"><br><br>
	<input type="submit" name="update_note" value="Salvesta">
</form>