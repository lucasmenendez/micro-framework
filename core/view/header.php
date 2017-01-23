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
			<?php if ($this->checkUser()) { ?>
				<nav>
					<ul>
						<li><a href="/">Home</a></li>
						<li>Hi, <?= $_SESSION['username'] ?>.
							<ul>
								<li><a id="profile" href="/dashboard/profile">Profile</a></li>
								<li><a id="logout" href="/dashboard/logout">Log Out</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			<?php } ?>
		</header>
		<section>
