<!DOCTYPE html>
<html>
	<head>
	  	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?= $title ?></title>
	</head>
	<body>

		<header>
			<h1><?= $title ?></h1>
			<?php if ($this->auth()) { ?>
				<nav>
					<li><a href="index.php">Home</a></li>
				</nav>
				<ul>Hi, <?= $_SESSION['username'] ?>.
					<li><a id="profile" href="index.php?c=dashboard&a=profile">Profile</a></li>
					<li><a id="logout" href="index.php?c=dashboard&a=logout">Log Out</a></li>
				</ul>
			<?php } ?>
		</header>

		<section>
	