<?php 
	$submitted = !empty($_POST);
	if ($submitted)
		setcookie('username', $_POST['username']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bookstore</title>
</head>
<body>
	<?php if ($submitted): ?>
			<p>Your login info is</p>
			<ul>
				<li><b>Username</b>: <?php echo $_POST['username']; ?></li>
				<li><b>Password</b>: <?php echo $_POST['password']; ?></li>
			</ul>
	<?php else : ?>
			<p>You did not submit anything.</p>
	<?php endif; ?>
</body>
</html>