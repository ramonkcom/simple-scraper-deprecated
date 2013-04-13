<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
require_once 'SimpleScraper.class.php';
$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
try {
	$scraper = new SimpleScraper($url);
	$data = $scraper->getAllData();
	$response = array(
		'success' => true,
		'ogp' => $data['ogp'],
		'dump' => print_r($data, true)
	);
} catch (Exception $e) {
	$response = array(
		'success' => false,
		'message' => 'Something went wrong.',
		'log' => "$e"
	);
}

echo json_encode($response);