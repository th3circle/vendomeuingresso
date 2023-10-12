<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if (isset($_POST['logout'])) { session_start(); session_destroy(); header('Location: ../'); } ?>
</head>
<body>
	Você está logado como Superadmin
	<br><form method="POST" action=""><input type="hidden" name="logout"><button>Logout</button></form>
</body>
</html>