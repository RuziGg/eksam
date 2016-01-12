<?php
	require_once("functions.php");
	require_once("DataManager.class.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		//see katkestab faili edasile lugemise
		exit();
	}
	
	if(isset($_GET["logout"])){

		session_destroy();
		
		header("Location: login.php");
	}
	
	//uus instants klassist
	$DataManager = new DataManager($mysqli, $_SESSION["logged_in_user_id"]);
	
	
	if(isset($_GET["new_data"])){
		
		$add_new_response = $DataManager->addData($_GET["new_data"]);
		
		
	}
	
	if(isset($_GET["new_dd_selection"])){
		
		$add_new_userdata_response = $DataManager->addUserData($_GET["new_dd_selection"]);
		
	}
	
?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2>Lisa andmed</h2>

  <?php if(isset($add_new_response->error)): ?>
  
	<p style="color:red;">
		<?=$add_new_response->error->message;?>
	</p>
  
  <?php elseif(isset($add_new_response->success)): ?>
	
	<p style="color:green;" >
		<?=$add_new_response->success->message;?>
	</p>
	
  <?php endif; ?>


<form>
	<input name="new_data">
	<input type="submit">
</form>


<h2>Minu andmed</h2>

  <?php if(isset($add_new_userdata_response->error)): ?>
  
	<p style="color:red;">
		<?=$add_new_userdata_response->error->message;?>
	</p>
  
  <?php elseif(isset($add_new_userdata_response->success)): ?>
	
	<p style="color:green;" >
		<?=$add_new_userdata_response->success->message;?>
	</p>
	
  <?php endif; ?>

<form>
	<!-- siia jarele tuleb rippmenuu -->
	<?=$DataManager->createDropdown();?>
	<input type="submit">
</form>

<br><br>

<?=$DataManager->getUserData();?>

