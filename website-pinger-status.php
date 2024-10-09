<?php
function get_http_response_code($url) {

	$headers = @get_headers($url);
	if ($headers === false) {
		return "Error";
	}
	$status_line = $headers[0];
	preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
	return $match[1] ?? "Unknown";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'check') {
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
		$timestamp = date("Y.m.d H:i:s");
		echo $timestamp, " - ";
		echo get_http_response_code($url);
	}
	exit();
}
?>