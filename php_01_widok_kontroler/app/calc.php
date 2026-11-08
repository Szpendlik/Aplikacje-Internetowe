<?php
// KONTROLER strony kalkulatora jednostek prędkości
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// pobranie parametrów

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : null;
$unit_from = isset($_REQUEST['unit_from']) ? $_REQUEST['unit_from'] : null;
$unit_to = isset($_REQUEST['unit_to']) ? $_REQUEST['unit_to'] : null;

// walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($value) && isset($unit_from) && isset($unit_to))) {
	// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $value == "" ) {
	$messages [] = 'Nie podano wartości prędkości';
}

// nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// zamiana ewentualnego przecinka na kropkę dziesiętną
	$value = str_replace(',', '.', $value);

	// sprawdzenie, czy wartość jest liczbą
	if (! is_numeric( $value )) {
		$messages [] = 'Podana wartość prędkości nie jest liczbą';
	} else if ( floatval($value) < 0 ) {
		$messages [] = 'Prędkość nie może być wartością ujemną';
	}
	
}

//  wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	// konwersja parametru na float (prędkość może posiadać część ułamkową)
	$value = floatval($value);
	
	// Przeliczenie wartości na jednostkę bazową: metry na sekundę [m/s]
	switch ($unit_from) {
		case 'kmh':
			$meters_per_sec = $value / 3.6;
			break;
		case 'ms':
			$meters_per_sec = $value;
			break;
		case 'mph':
			$meters_per_sec = $value * 0.44704;
			break;
		case 'kn':
			$meters_per_sec = $value * (1852 / 3600);
			break;
		case 'fts':
			$meters_per_sec = $value * 0.3048;
			break;
		case 'kms':
			$meters_per_sec = $value * 1000;
			break;
		default:
			$meters_per_sec = $value;
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
		'kn'  => 'kn',
		'fts' => 'ft/s',
		'kms' => 'km/s'
	);

	$from_label = isset($unit_names[$unit_from]) ? $unit_names[$unit_from] : $unit_from;
	$to_label = isset($unit_names[$unit_to]) ? $unit_names[$unit_to] : $unit_to;

	// zaokrąglenie do 4 miejsc po przecinku
	$rounded = round($result_val, 4);

	$result = $value.' '.$from_label.' = '.$rounded.' '.$to_label;
}

// Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages, $value, $unit_from, $unit_to, $result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';
