<?php
	require_once("functions.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");

	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
	
//punktide andmiseks
	if(isset($_GET["vote"])){
		
		insertVote($_GET["country_id"], $_GET["points"]);
	}
	
	$song_list = getData();
	
?>
<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Eurovision Song Contest</h1>

<table border= 1>
	<tr>
		<th>id</th>
		<th>Country</th>
		<th>Song</th>
		<th>My Points</th>
		
	</tr>
	
	<?php
		for($i = 0; $i < count($song_list); $i++){
			
			if(isset($_GET["edit"]) && $song_list[$i]->country_id == $_GET["edit"]){
				
				echo "<form action=main.php method='get'>";
				echo "<td>".$song_list[$i]->country_id."</td>";
				echo "<input type='hidden' name='country_id' value='".$song_list[$i]->country_id."'>";
				echo "<td>".$song_list[$i]->country."</td>";
				echo "<td>".$song_list[$i]->song."</td>";
				echo "<td><input type='number' name='points'</td>";
				echo "<td><input type='submit' name='vote' value='Vote'></td>";
				echo "</form>";
				
			}else{
			echo "<tr>";
				echo "<td>".$song_list[$i]->country_id."</td>";
				echo "<td>".$song_list[$i]->country."</td>";
				echo "<td>".$song_list[$i]->song."</td>";
				echo "<td>".$song_list[$i]->total_points."</td>";
				echo "<td><a href='?edit=".$song_list[$i]->country_id."'>edit</a></td>";
			echo "</tr>";
			}
		}
			
		
	?>
</table>

<a href="results.php"> See final results</a>