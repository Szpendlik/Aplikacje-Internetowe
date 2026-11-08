<?php
require_once dirname(__FILE__).'/../config.php';
// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany

include _ROOT_PATH.'/app/security/check.php';

// pobranie parametrów
function getParams(&$value, &$unit_from, &$unit_to){
	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : null;
	$unit_from = isset($_REQUEST['unit_from']) ? $_REQUEST['unit_from'] : null;
	$unit_to = isset($_REQUEST['unit_to']) ? $_REQUEST['unit_to'] : null;	
}

// walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$value, &$unit_from, &$unit_to, &$messages){
	if ( ! (isset($value) && isset($unit_from) && isset($unit_to))) {
		return false;
	}

	if ( $value == "" ) {
		$messages [] = 'Nie podano wartości prędkości';
	}

	if (count ( $messages ) != 0) return false;

	$value = str_replace(',', '.', $value);

	if (! is_numeric( $value )) {
		$messages [] = 'Podana wartość prędkości nie jest liczbą';
	} else if ( floatval($value) < 0 ) {
		$messages [] = 'Prędkość nie może być wartością ujemną';
	}

	if (count ( $messages ) != 0) return false;
	else return true;
}

// 3. wykonaj zadanie jeśli wszystko w porządku
function process(&$value, &$unit_from, &$unit_to, &$messages, &$result){
	global $role;
	$special_units = array('kn', 'kms');
	if ($role != 'admin' && (in_array($unit_from, $special_units) || in_array($unit_to, $special_units))) {
		$messages [] = 'Tylko administrator może przeliczać jednostki specjalne (węzły morskie [kn] oraz km/s)! Zaloguj się na konto administratora.';
		return;
	}

	$val = floatval($value);

	// Przeliczenie wartości na jednostkę bazową: metry na sekundę [m/s]
	switch ($unit_from) {
		case 'kmh':
			$meters_per_sec = $val / 3.6;
			break;
		case 'ms':
			$meters_per_sec = $val;
			break;
		case 'mph':
			$meters_per_sec = $val * 0.44704;
			break;
		case 'kn':
			$meters_per_sec = $val * (1852 / 3600);
			break;
		case 'fts':
			$meters_per_sec = $val * 0.3048;
			break;
		case 'kms':
			$meters_per_sec = $val * 1000;
			break;
		default:
			$meters_per_sec = $val;
			break;
	}

	// Przeliczenie z jednostki bazowej (m/s) na jednostkę docelową
	switch ($unit_to) {
		case 'kmh':
			$result_val = $meters_per_sec * 3.6;
			break;
		case 'ms':
			$result_val = $meters_per_sec;
			break;
		case 'mph':
			$result_val = $meters_per_sec / 0.44704;
			break;
		case 'kn':
			$result_val = $meters_per_sec / (1852 / 3600);
			break;
		case 'fts':
			$result_val = $meters_per_sec / 0.3048;
			break;
		case 'kms':
			$result_val = $meters_per_sec / 1000;
			break;
		default:
			$result_val = $meters_per_sec;
			break;
	}

	$unit_names = array(
		'kmh' => 'km/h',
		'ms'  => 'm/s',
		'mph' => 'mph',
		'kn'  => 'kn (węzły)',
		'fts' => 'ft/s',
		'kms' => 'km/s'
	);

	$from_label = isset($unit_names[$unit_from]) ? $unit_names[$unit_from] : $unit_from;
	$to_label = isset($unit_names[$unit_to]) ? $unit_names[$unit_to] : $unit_to;

	$rounded = round($result_val, 4);

	$result = $value.' '.$from_label.' = '.$rounded.' '.$to_label;
}

$value = null;
$unit_from = null;
$unit_to = null;
$result = null;
$messages = array();

getParams($value, $unit_from, $unit_to);
if ( validate($value, $unit_from, $unit_to, $messages) ) { // gdy brak błędów
	process($value, $unit_from, $unit_to, $messages, $result);
}

include 'calc_view.php';
