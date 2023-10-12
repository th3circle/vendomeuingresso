<?php 

	require "../../../../config/conn.php";

	$id = $_GET['id'];
	$status = $_GET['status'];
	if ($status == 0) { $status = 1; } else { $status = 0; }

	$query = "UPDATE producer SET status = '$status' WHERE id = '$id'";
	if ($conn->query($query) === TRUE) {
		echo '<script>window.location.href="../"</script>';
	} else {
		echo '<script>window.location.href="../"</script>';
	}

?>