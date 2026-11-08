<?php
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<title>Kalkulator Prędkości</title>
	<link rel="stylesheet" href="<?php print(_APP_URL); ?>/assets/css/main.css" />
	<noscript><link rel="stylesheet" href="<?php print(_APP_URL); ?>/assets/css/noscript.css" /></noscript>
	<style>
		select option {
			background-color: #1b1f22;
			color: #ffffff;
		}
		.msg-result {
			margin-top: 1.5em;
			padding: 1.2em 1.5em;
			border-radius: 6px;
			background: rgba(46, 204, 113, 0.2);
			border: 1px solid #2ecc71;
		}
		.msg-result h4 {
			color: #2ecc71;
			margin-bottom: 0.3em;
			font-size: 1em;
			letter-spacing: 0.1em;
			text-transform: uppercase;
		}
		.msg-result p {
			font-size: 1.25em;
			font-weight: 600;
			margin-bottom: 0;
			color: #ffffff;
		}
		.msg-error {
			margin-top: 1.5em;
			padding: 1.2em 1.5em;
			border-radius: 6px;
			background: rgba(235, 77, 75, 0.2);
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
		.user-badge {
			display: inline-block;
			padding: 0.2em 0.8em;
			border-radius: 4px;
			font-weight: bold;
			text-transform: uppercase;
			font-size: 0.85em;
			letter-spacing: 0.1em;
		}
		.badge-admin {
			background: rgba(46, 204, 113, 0.3);
			color: #2ecc71;
			border: 1px solid #2ecc71;
		}
		.badge-user {
			background: rgba(52, 152, 219, 0.3);
			color: #3498db;
			border: 1px solid #3498db;
		}
	</style>
</head>
<body class="is-preload">

	<div id="wrapper">

		<!-- Header -->
		<header id="header">
			<div class="logo">
				<span class="icon fa-tachometer-alt"></span>
			</div>
			<div class="content">
				<div class="inner">
					<h1>Kalkulator Prędkości</h1>
					<p>
						Zalogowano jako: 
						<span class="user-badge <?php echo ($role == 'admin') ? 'badge-admin' : 'badge-user'; ?>">
							<i class="fas <?php echo ($role == 'admin') ? 'fa-user-shield' : 'fa-user'; ?>"></i> <?php print($role); ?>
						</span>
					</p>
				</div>
			</div>
			<nav>
				<ul>
					<li><a href="#calc">Kalkulator</a></li>
					<li><a href="<?php print(_APP_URL); ?>/app/security/logout.php" style="color: #ff7675;">Wyloguj</a></li>
				</ul>
			</nav>
		</header>

		<!-- Main -->
		<div id="main">

			<!-- Calculator Article -->
			<article id="calc">
				<h2 class="major">Przelicznik prędkości</h2>
				
				<?php if ($role == 'admin'): ?>
					<p style="color: #2ecc71; font-size: 0.9em;"><strong>Tryb Administratora:</strong> Masz pełny dostęp do wszystkich jednostek (w tym węzłów <code>kn</code> oraz <code>km/s</code>).</p>
				<?php else: ?>
					<p style="color: #f39c12; font-size: 0.9em;"><strong>Tryb Użytkownika:</strong> Dostęp do jednostek standardowych. Jednostki specjalne (węzły <code>kn</code> oraz <code>km/s</code>) są zastrzeżone dla Administratora.</p>
				<?php endif; ?>

				<form method="post" action="<?php print(_APP_URL); ?>/app/calc.php#calc">
					<div class="fields">
						<div class="field">
							<label for="id_val">Wartość prędkości:</label>
							<input type="text" name="value" id="id_val" value="<?php out($value); ?>" placeholder="Wpisz liczbę, np. 120" />
						</div>

						<div class="field half">
							<label for="id_from">Z jednostki:</label>
							<select id="id_from" name="unit_from">
								<option value="kmh" <?php if (isset($unit_from) && $unit_from == 'kmh') echo 'selected'; ?>>km/h</option>
								<option value="ms"  <?php if (isset($unit_from) && $unit_from == 'ms') echo 'selected'; ?>>m/s</option>
								<option value="mph" <?php if (isset($unit_from) && $unit_from == 'mph') echo 'selected'; ?>>mph</option>
								<option value="kn"  <?php if (isset($unit_from) && $unit_from == 'kn') echo 'selected'; ?>>kn (węzły) <?php if ($role != 'admin') echo '[tylko Admin]'; ?></option>
								<option value="kms" <?php if (isset($unit_from) && $unit_from == 'kms') echo 'selected'; ?>>km/s <?php if ($role != 'admin') echo '[tylko Admin]'; ?></option>
							</select>
						</div>

						<div class="field half">
							<label for="id_to">Na jednostkę:</label>
							<select id="id_to" name="unit_to">
								<option value="ms"  <?php if (!isset($unit_to) || $unit_to == 'ms') echo 'selected'; ?>>m/s</option>
								<option value="kmh" <?php if (isset($unit_to) && $unit_to == 'kmh') echo 'selected'; ?>>km/h</option>
								<option value="mph" <?php if (isset($unit_to) && $unit_to == 'mph') echo 'selected'; ?>>mph</option>
								<option value="kn"  <?php if (isset($unit_to) && $unit_to == 'kn') echo 'selected'; ?>>kn (węzły) <?php if ($role != 'admin') echo '[tylko Admin]'; ?></option>
								<option value="kms" <?php if (isset($unit_to) && $unit_to == 'kms') echo 'selected'; ?>>km/s - kosmiczna <?php if ($role != 'admin') echo '[tylko Admin]'; ?></option>
							</select>
						</div>
					</div>

					<ul class="actions" style="margin-top: 1.5em;">
						<li><input type="submit" value="Przelicz" class="primary" /></li>
						<li><input type="reset" value="Wyczyść" /></li>
					</ul>
				</form>

				<?php if (isset($result)): ?>
					<div class="msg-result">
						<h4><i class="fas fa-check-circle"></i> Wynik obliczeń:</h4>
						<p><?php echo $result; ?></p>
					</div>
				<?php endif; ?>

				<?php if (isset($messages) && count($messages) > 0): ?>
					<div class="msg-error">
						<h4><i class="fas fa-exclamation-triangle"></i> Wystąpiły błędy:</h4>
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
		if (!window.location.hash || window.location.hash === '#') {
			window.location.hash = '#calc';
		}
	</script>

</body>
</html>
