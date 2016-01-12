<?php
	require_once("../configglobal.php");
	$database = "if15_jarmhab";
	
	session_start();
	
	//lisame kasutaja andmebaasi
	function createUser($country_name, $create_email, $password_hash){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO eurovision_users (country_name, email, password) VALUES (?, ?, ?)");
				//echo $mysqli->error;
				//echo $stmt->error;
		$stmt->bind_param("sss", $country_name, $create_email, $password_hash);
		$stmt->execute();
		
		//header("Location: login.php");
		
		$stmt->close();
		
		$mysqli->close();		
	}
	
	//logime sisse
	
	function loginUser($email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
	
			$stmt = $mysqli->prepare("SELECT id, email FROM eurovision_users WHERE email=? AND password=?");
			echo $mysqli->error;
				$stmt->bind_param("ss", $email, $password_hash);
				
				//paneme vastused muutujatesse
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				if($stmt->fetch()){
					//leidis
					echo "kasutaja id=".$id_from_db;
					
					$_SESSION["id_from_db"] = $id_from_db;
					$_SESSION["user_email"] = $email_from_db;
					
					header("Location: main.php");
					
				}else{
					//tyhi ei leidnud
					echo "wrong password or email id";
				}
				
				$stmt->close();
				$mysqli->close();
	}

	function getData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, country, song, total_points FROM eurovision");
		$stmt->bind_result($country_id, $country, $song, $total_points);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			$list = new StdClass();
			
			$list->country_id = $country_id;
			$list->country = $country;
			$list->song = $song;
			$list->total_points = $total_points;
			array_push($array, $list);
		}
	
		$stmt->close();
		
		
		return $array;
	}
	
	function insertVote($country_id, $points){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO eurovision_points (voter_id, points, song_id) VALUES (?, ?, ?)");
		$stmt->bind_param("iii", $_SESSION["id_from_db"], $points, $country_id);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		} 	
		
	function getResults(){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT country, song, points FROM eurovision
				JOIN eurovision_points ON eurovision_points.song_id=eurovision.id
				WHERE eurovision_points.song_id=eurovision.id ORDER BY points");
		$stmt->bind_result($country, $song, $total_points);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			$results = new StdClass();
			
			$results->country = $country;
			$results->song = $song;
			$results->total_points = $total_points;
			array_push($array, $results);
		}
	
		$stmt->close();
		$mysqli->close();
		
		
		return $array;
	}
	

?>