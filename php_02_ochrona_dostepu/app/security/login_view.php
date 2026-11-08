<?php
// Widok logowania - Dimension by HTML5 UP
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<title>Logowanie - Kalkulator Prędkości</title>
	<link rel="stylesheet" href="<?php print(_APP_URL); ?>/assets/css/main.css" />
	<noscript><link rel="stylesheet" href="<?php print(_APP_URL); ?>/assets/css/noscript.css" /></noscript>
	<style>
		select option {
			background-color: #1b1f22;
			color: #ffffff;
		}
		.msg-error {
			margin-top: 1.5em;
			padding: 1em 1.5em;
			border-radius: 6px;
			background: rgba(235, 77, 75, 0.25);
			border: 1px solid #eb4d4b;
		}
		.msg-error h4 {
			color: #ff7675;
			margin-bottom: 0.5em;
			font-size: 1em;
			letter-spacing: 0.1em;
			text-transform: uppercase;
		}
		.msg-error ul {
			margin-bottom: 0;
			padding-left: 1.2em;
		}
	</style>
</head>
<body class="is-preload">

	<div id="wrapper">

		<!-- Header -->
		<header id="header">
			<div class="logo">
				<span class="icon fa-lock"></span>
			</div>
			<div class="content">
				<div class="inner">
					<h1>Dostęp Ograniczony</h1>
					<p>Zaloguj się do kalkulatora prędkości!</p>
				</div>
			</div>
			<nav>
				<ul>
					<li><a href="#login">Zaloguj się</a></li>
				</ul>
			</nav>
		</header>

		<!-- Main -->
		<div id="main">

			<!-- Login Article -->
			<article id="login">
				<h2 class="major">Logowanie</h2>
				<p>Wprowadź swoje dane poniżej:</p>

				<form method="post" action="<?php print(_APP_URL); ?>/app/security/login.php#login">
					<div class="fields">
						<div class="field half">
							<label for="id_login">Login:</label>
							<input type="text" name="login" id="id_login" value="<?php out($form['login']); ?>" placeholder="admin / user" autocomplete="username" />
						</div>
						<div class="field half">
							<label for="id_pass">Hasło:</label>
							<input type="password" name="pass" id="id_pass" placeholder="••••••••" autocomplete="current-password" />
						</div>
					</div>
					<ul class="actions" style="margin-top: 1.5em;">
						<li><input type="submit" value="Zaloguj" class="primary" /></li>
						<li><input type="reset" value="Wyczyść" /></li>
					</ul>
				</form>

				<div style="margin-top: 2em; padding: 0.8em 1em; border-radius: 4px; background: rgba(255, 255, 255, 0.05); font-size: 0.85em; color: #aaa; text-align: center;">
					Konta: <code>admin</code> / <code>admin</code> (pełny dostęp) &bull; <code>user</code> / <code>user</code> (standard)
				</div>

				<?php if (isset($messages) && count($messages) > 0): ?>
					<div class="msg-error">
						<h4><i class="fas fa-exclamation-circle"></i> Błąd logowania:</h4>
						<ul>
							<?php foreach ($messages as $msg): ?>
								<li><?php echo htmlspecialchars($msg); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</article>

		</div>
	</div>

	<!-- Background -->
	<div id="bg"></div>

	<!-- Scripts -->
	<script src="<?php print(_APP_URL); ?>/assets/js/jquery.min.js"></script>
	<script src="<?php print(_APP_URL); ?>/assets/js/browser.min.js"></script>
	<script src="<?php print(_APP_URL); ?>/assets/js/breakpoints.min.js"></script>
	<script src="<?php print(_APP_URL); ?>/assets/js/util.js"></script>
	<script src="<?php print(_APP_URL); ?>/assets/js/main.js"></script>
	<script>
		// Automatyczne otwarcie modala logowania, jeśli żaden hash nie jest wybrany
		if (!window.location.hash || window.location.hash === '#') {
			window.location.hash = '#login';
		}
	</script>

</body>
</html>
