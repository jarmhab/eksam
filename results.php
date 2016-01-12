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
	
	$results_list = getResults();
?>

<p>
	Sisse logitud kasutajaga <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Eurovision Song Contest Results</h1>

<table border= 1>
	<tr>
		
		<th>Country</th>
		<th>Song</th>
		<th>Points</th>
		
	</tr>
	
	<?php
		for($i = 0; $i < count($results_list); $i++){
			echo "<tr>";
			echo "<td>".$results_list[$i]->country."</td>";
			echo "<td>".$results_list[$i]->song."</td>";
			echo "<td>".$results_list[$i]->total_points."</td>";
			echo "</tr>";
		}
	?>
</table>