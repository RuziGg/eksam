<?php
$i = 0;
$array_menu = array();

$array_menu[$i]['url']="data.php";
$array_menu[$i++]['name']='Lisa';


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
	
	if(!isset($_SESSION["logged_in_user_id"])){
	header("Location: login.php");
	}
	
	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//kaivitan funktsiooni, saadan kaasa id!
		deleteData($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		var_dump($_POST);
		updateData($_POST["register_id"], $_POST["name"], $_POST["address"], $_POST["phone_number"], $_POST["register_code"]);
	}
	
		$keywod = "";
	//aadressireal on keyword
	if(isset($_GET["keyword"])){
		
		//otsin
		$keyword = $_GET["keyword"];
		$array_of_data = getData($keyword);
		
	}else{
		
		//kusin koik andmed
	
	
	//kaivitan funktsiooni
	$array_of_data = getData();
	
	}
	
?>

<h2>Tabel</h2>

<form action="register.php" method="get" >
	<input type="search" name="keyword" >
	<input type="submit" >
</form>

<table border=1 >
	<tr>
		<th>id</th>
		<th>nimi</th>
		<th>aadress</th>
		<th>tel.number</th>
		<th>registri kood</th>
		<th>X</th>
		<th>edit</th>
		<th></th>
	</tr>
	
<?php
		// trukime valja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_data); $i++){
			//echo $array_of_notes[$i]->id;
			
			//kasutaja tahab muuta seda rida
			if(isset($_GET["edit"]) && $array_of_data[$i]->register_id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='register.php' method='post'>";
				echo "<input type='hidden' name='register_id' value='".$array_of_data[$i]->register_id."'>";
				echo "<td>".$array_of_data[$i]->register_id."</td>";
				echo "<td>".$array_of_data[$i]->register_id."</td>";
				echo "<td><input name='name' value='".$array_of_data[$i]->name."'></td>";
				echo "<td><input name='address' value='".$array_of_data[$i]->address."'></td>";
				echo "<td><input name='phone number' value='".$array_of_data[$i]->phone_number."'></td>";
				echo "<td><input name='register code' value='".$array_of_data[$i]->register_code."'></td>";
				echo "<td><a href='register.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$array_of_data[$i]->register_id."</td>";
				echo "<td>".$array_of_data[$i]->name."</td>";
				echo "<td>".$array_of_data[$i]->address."</td>";
				echo "<td>".$array_of_data[$i]->phone_number."</td>";
				echo "<td>".$array_of_data[$i]->register_code."</td>";
				
				
				
				echo "<td><a href='?delete=".$array_of_data[$i]->register_id."'>X</a></td>";
				echo "<td><a href='?edit=".$array_of_data[$i]->register_id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$array_of_data[$i]->register_id."'>edit.php</a></td>";
				
				
				echo "</tr>";
				
			}
			
		}
	
	
?>
</table>
