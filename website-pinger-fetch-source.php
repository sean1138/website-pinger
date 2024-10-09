<?php
// fetch-source.php
$url = "https://h5bp.com";

// Get the source code of the page
$sourceCode = @file_get_contents($url);

// Error handling in case the request fails
if ($sourceCode === FALSE) {
	echo "Unable to fetch the source code.";
} else {
	// Print the source code to the page
	echo "<pre>" . htmlspecialchars($sourceCode) . "</pre>";
}
?>
