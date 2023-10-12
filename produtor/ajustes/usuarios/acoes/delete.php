<?php 

	require "../../../../config/conn.php";
	$id = $_GET['id'];
	$query = "DELETE FROM producer WHERE id = '$id'";
	if ($conn->query($query) === TRUE) {
		echo '<script>window.location.href="../"</script>';
	} else {
		echo '<script>window.location.href="../"</script>';
	}

?>