<?php 

	$config['cor_primaria'] = "#713ABE";
	$config['cor_secundaria'] = "#5B0888";

	$id_superadmin = $_SESSION['user_superadmin']['id'];
	$query = "SELECT * FROM superadmin WHERE id = '$id_superadmin'";
	$mysqli_query = mysqli_query($conn, $query);
	while ($superadmin_data = mysqli_fetch_array($mysqli_query)) { $superadmin = $superadmin_data; }

?>