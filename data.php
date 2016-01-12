<?php
$i = 0;
$array_menu = array();

$array_menu[$i]['url']="register.php";
$array_menu[$i++]['name']='Tabel';


echo "<ul>\n";
for ($i=0;$i<count($array_menu);$i++)
{
       echo ($_SERVER["REQUEST_URI"] == $array_menu[$i]['url']) ? '<li class="active">': '<li>';
       echo "<a href=\"".$array_menu[$i]['url']."\">".$array_menu[$i]['name']."</a></li>\n";
}
echo "</ul>";
?>

<?php
	require_once("functions.php");
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$name = $address = $phone_number = $register_code = "";
	$name_error = $address_error = $phone_number_error = $register_code_error = "";
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_data"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		if ( empty($_POST["name"]) ) {
			$name_error = "See väli on kohustuslik";
		}else{
			$name = cleanInput($_POST["name"]);
		}
		
		if ( empty($_POST["address"]) ) {
			$address_error = "See väli on kohustuslik";
		}else{
			$address = cleanInput($_POST["address"]);
		}
		
		if ( empty($_POST["phone_number"]) ) {
			$phone_number_error = "See väli on kohustuslik";
		}else{
			$phone_number = cleanInput($_POST["phone_number"]);
		}
		
		if ( empty($_POST["register_code"]) ) {
			$register_code_error = "See väli on kohustuslik";
		}else{
			$register_code = cleanInput($_POST["register_code"]);
		}
		
		// mõlemad on kohustuslikud
		if($address_error == "" && $name_error == "" && $phone_number_error == "" && $register_code_error == ""){
			//salvestate ab'i fn kaudu addNote
			//message funktioonist
			$msg = addData($name, $address, $phone_number, $register_code);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				$name = "";
				$address = "";
				$phone_number = "";
				$register_code = "";
				
				echo $msg;
			}
			
		}
		
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>


<h2>Lisa andmed</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="name">Nimi</label><br>
	<input id="name" name="name" type="text" value="<?php echo $name; ?>"> <?php echo $name_error; ?><br><br>
	<label for="address">Aadress</label><br>
	<input id="address" name="address" type="text" value="<?php echo $address; ?>"> <?php echo $address_error; ?><br><br>
	<label for="phone_number">Tel. number</label><br>
	<input id="phone_number" name="phone_number" type="text" value="<?php echo $phone_number; ?>"> <?php echo $phone_number_error; ?><br><br>
	<label for="register_code">Registri kood</label><br>
	<input id="register_code" name="register_code" type="text" value="<?php echo $register_code; ?>"> <?php echo $register_code_error; ?><br><br>
	<input type="submit" name="add_data" value="Salvesta">
</form>