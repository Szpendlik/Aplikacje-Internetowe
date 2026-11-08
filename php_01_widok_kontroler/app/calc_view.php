<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator jednostek prędkości</title>
</head>
<body>

<h3>Kalkulator jednostek prędkości</h3>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
	<label for="id_val">Wartość prędkości: </label>
	<input id="id_val" type="text" name="value" value="<?php if (isset($value)) print($value); ?>" /><br /><br />

	<label for="id_from">Z jednostki: </label>
	<select id="id_from" name="unit_from">
		<option value="kmh" <?php if (isset($unit_from) && $unit_from == 'kmh') echo 'selected'; ?>>km/h</option>
		<option value="ms"  <?php if (isset($unit_from) && $unit_from == 'ms') echo 'selected'; ?>>m/s</option>
		<option value="mph" <?php if (isset($unit_from) && $unit_from == 'mph') echo 'selected'; ?>>mph</option>
		<option value="kn"  <?php if (isset($unit_from) && $unit_from == 'kn') echo 'selected'; ?>>kn (węzły)</option>
		<option value="kms" <?php if (isset($unit_from) && $unit_from == 'kms') echo 'selected'; ?>>km/s</option>
	</select><br /><br />

	<label for="id_to">Na jednostkę: </label>
	<select id="id_to" name="unit_to">
		<option value="ms"  <?php if (!isset($unit_to) || $unit_to == 'ms') echo 'selected'; ?>>m/s</option>
		<option value="kmh" <?php if (isset($unit_to) && $unit_to == 'kmh') echo 'selected'; ?>>km/h</option>
		<option value="mph" <?php if (isset($unit_to) && $unit_to == 'mph') echo 'selected'; ?>>mph</option>
		<option value="kn"  <?php if (isset($unit_to) && $unit_to == 'kn') echo 'selected'; ?>>kn (węzły)</option>
		<option value="kms" <?php if (isset($unit_to) && $unit_to == 'kms') echo 'selected'; ?>>km/s</option>
	</select><br /><br />

	<input type="submit" value="Przelicz" />
</form>	

<?php
//wyświetlenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Wynik: '.$result; ?>
</div>
<?php } ?>

</body>
</html>
