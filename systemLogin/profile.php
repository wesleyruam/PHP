<?php
require 'conDB.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$stmt = $pdo->prepare('SELECT password, email FROM accounts WHERE id = ?');

$stmt->bindParam(1, $_SESSION['id']);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);


$password = $result['password'];
$email = $result['email'];
?>




<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Profile Page</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
		integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
		crossorigin="anonymous" referrerpolicy="no-referrer">
	<style media="screen">
		.navtop {
			background-color: #2f3947;
			height: 60px;
			width: 100%;
			border: 0;
		}

		.navtop div {
			display: flex;
			margin: 0 auto;
			width: 1000px;
			height: 100%;
		}

		.navtop div h1,
		.navtop div a {
			display: inline-flex;
			align-items: center;
		}

		.navtop div h1 {
			flex: 1;
			font-size: 24px;
			padding: 0;
			margin: 0;
			color: #eaebed;
			font-weight: normal;
		}

		.navtop div a {
			padding: 0 20px;
			text-decoration: none;
			color: #c1c4c8;
			font-weight: bold;
		}

		.navtop div a i {
			padding: 2px 8px 0 0;
		}

		.navtop div a:hover {
			color: #eaebed;
		}

		body.loggedin {
			background-color: #f3f4f7;
		}

		.content {
			width: 1000px;
			margin: 0 auto;
		}

		.content h2 {
			margin: 0;
			padding: 25px 0;
			font-size: 22px;
			border-bottom: 1px solid #e0e0e3;
			color: #4a536e;
		}

		.content>p,
		.content>div {
			box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
			margin: 25px 0;
			padding: 25px;
			background-color: #fff;
		}

		.content>p table td,
		.content>div table td {
			padding: 5px;
		}

		.content>p table td:first-child,
		.content>div table td:first-child {
			font-weight: bold;
			color: #4a536e;
			padding-right: 15px;
		}

		.content>div p {
			padding: 5px;
			margin: 0 0 10px 0;
		}
	</style>
</head>

<body class="loggedin">
	<nav class="navtop">
		<div>
			<h1>Website Title</h1>
			<a href="home.php"><i class="fas fa-house"></i>Home</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
		</div>
	</nav>
	<div class="content">
		<h2>Profile Page</h2>
		<div>
			<p>Your account details are below:</p>
			<table>
				<tr>
					<td>Username:</td>
					<td>
						<?= $_SESSION['name'] ?>
					</td>
				</tr>
				<tr>
					<td>Password:</td>
					<td>
						<?= $password ?>
					</td>
				</tr>
				<tr>
					<td>Email:</td>
					<td>
						<?= $email ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>

</html>