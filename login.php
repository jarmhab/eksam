<?php

	//laeme funktsiooni faili
	require_once("functions.php");
	
	//kontrollin, kas kasutaja on sisse loginud
	if(isset($_SESSION["id_from_db"])){
		//suunan data lehele
		header("Location: main.php");
	}
	
// muutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$country_name_error = "";
	$create_email_error = "";
	$create_password_error = "";
	
 // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$country_name = "";
	$create_email = "";
	$create_password = "";
	
	//kontrollin kas keegi vajutas nuppu
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
	// *********************
    // **** LOGI SISSE *****
    // *********************
				
				// kontrollin mis nuppu vajutati
		if(isset($_POST["login"])){
			
				//kas e-post on tyhi
			if( empty($_POST["email"])) {
				//jah oli tyhi
				$email_error = "See väli on kohustuslik";
				}else{
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);				
			}
			if( empty($_POST["password"])) {
				//jah oli tyhi
				$password_error = "See väli on kohustuslik";
				
			}else{
				$password = cleanInput($_POST["password"]);
			}
		// Kui oleme siia jõudnud, võime kasutaja sisse logida	
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$email;
				
				$password_hash = hash("sha512", $password);
				
				// functions php failis käivitan funktsiooni
				 loginUser($email, $password_hash);
				
				
				
				
			}
		} 
		// *********************
		// ** LOO KASUTAJA *****
		// *********************
		if(isset($_POST["create"])){
		
			if( empty($_POST["country_name"])) {
				//jah oli tyhi
				$country_name_error = "See väli on kohustuslik";
				}else{
				$country_name = cleanInput($_POST["country_name"]);				
			}
			
		
			
			if( empty($_POST["create_email"])) {
				//jah oli tyhi
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if( empty($_POST["create_password"])) {
				//jah oli tyhi
				$create_password_error = "See väli on kohustuslik";
			}else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == "" && $country_name_error == ""){
				echo "Kasutajakonto edukalt loodud! Kasutajanimi on ".$create_email;

			$password_hash = hash("sha512", $create_password);
								
				// functions.php failis käivina funktsiooni
				createUser($country_name, $create_email, $password_hash);

			}
		} // create if end
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
	 
	<h2>Login</h2>
	<form action="login.php" method="post">
	<input name="email" type="email" placeholder="E-post"><?php echo $email_error ?> <br><br>
	<input name="password"type="password" placeholder="Parool" ><?php echo $password_error ?> <br><br>
	<input name="login" type="submit" value="Logi sisse"> <br><br>
	</form>
	<h2> Create Account</h2>
	<form action="login.php" method="post" >
	<input name="country_name" type="text" placeholder="Country name"><?php echo $country_name_error ?> <br><br>
	<input name="create_email" type="email" placeholder="E-mail"><?php echo $create_email_error ?> <br><br>
	<input name="create_password" type="password" placeholder="Parool"><?php echo $create_password_error ?> <br><br>
	<input name="create" type="submit" value="Registreeri">
	</form>