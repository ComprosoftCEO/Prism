<?php

	require_once 'Scripts/color.php';

	//The function to draw the header information
	function head($PageName) {
		
		//Set up cookies
		if (!isset($_COOKIE['login_id']) || $_COOKIE['login_id'] == null) {
			setcookie('login_id',0);
			header('Location: index.php');
			exit;
			
		}
		
		//Do the login or logout
		Login();
		Logout();
		
		?>
	<html>
	<head>
		<link rel="stylesheet" href="Styles/mainstyle.css">
		<link rel="stylesheet" href="Styles/pwdwidget.css">
		<link rel="stylesheet" href="Styles/fg_membersite.css">
		<link rel="shortcut icon" href="icon.png" />
		
		<script type='text/javascript' src='Scripts/gen_validatorv31.js'></script>
		<script src="Scripts/pwdwidget.js" type="text/javascript"></script>      
		<title>Prism</title>
	</head>
	
	<body style="background: linear-gradient(#1f1f21, #3a3f47);">
	
	<div style="float:center;align:center;text-align:center;">
		<img src="prism.png" alt="PRISM" style="width:425px;height:200px;">
	</div>
		<nav>
			<ul>
				<li><a href="index.php" class="button" id=<?php echo TestPage($PageName, 'index'); ?>>Home</a></li> 
				<li><a href="archives.php" class="button" id=<?php echo TestPage($PageName, 'archives'); ?>>Archives</a></li>
				  				
			<?php if ($_COOKIE['login_id'] == 0) { ?>
				<li><a href="register.php" class="button" id=<?php echo TestPage($PageName, 'register'); ?>>Sign up</a></li>
				<li style="float:right">
			
				<form action="" method="POST">
					Username: 
					<input type="text" name="username" size="15">
					Password:
					<input type="password" name="password" size="15">
					<input type="submit" value="Log In">
					<input type="hidden" name="failed" value="1"></input>
					<?php if (isset($_POST['failed']) && $_POST['failed'] == 1) { ?>
						<br/><label style="font-size: 8pt; color: red;">Incorrect Username or Password</label>
					<?php } ?>
				  </form>
					<?php 
						} else {
					?>
					<li><a href="myblogs.php" class="button" id=<?php echo TestPage($PageName, 'entries'); ?>>My Entries</a></li>
					<li><a href="editblog.php?id=0" class="button" id=<?php echo TestPage($PageName, 'new'); ?>>New</a></li>
					<li style="float:right">
						<form action="" method="POST">
							<label>Welcome,</label>
							<a href="preferences.php" class="welcome"><?php echo htmlspecialchars(get_name($_COOKIE['login_id'])); ?></a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="hidden" name="logout" value="1"></input>
							<input type="submit" name="" value="Log Out"></input>
						</form>
					<?php } ?>
				  <form style="float: right;" action="search.php" >
				    <input type="text" name="search_text" value="" size="38"></input>
					<input type="submit" name="" value="Search"></input>
				  </form>
				</li>
			</ul>
		</nav>
		<br/>
		<br/>
		<?php
	}


	//Draw the PHP footer
	function foot() {
		?>
			<br/><br/><br/><br/><br/>
			<p>Website by Ethan Aguilar, Bryan McClain, Melissa Ruiz, Tyler Ruth, and Arica Simon </p>
		
		</body>
	</html>
		
		<?php
	}

	
	//Print an article for the front page
	function print_article($title, $author, $date, $content, $id) {
	
		?>
		<div class="blogpost">
			<h1 <?php echo getcolor(); ?> ><?php echo htmlspecialchars($title); ?></h1>
			<p <?php echo getcolor(); ?> >By <?php echo htmlspecialchars($author); ?><br/> <?php echo $date; ?></p>
			<p <?php echo getcolor(); ?> ><?php echo nl2br(htmlspecialchars(substr($content,0,1000)));?>...</p><br/>
			<a href="blog.php?id=<?php echo $id; ?>" id="post" style="color:#b3b3ff;">Read More...</a>
			<hr/>
		</div>
		<?php
	}
	
	//Since each page has a different button active along the top,
	//  check if the current page should be active
	function TestPage($input, $test) {
		
		if ($input == $test) {
			return "active";
		}
		return "";
	}
?>
