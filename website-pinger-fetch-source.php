<?php
if (isset($_POST['url'])) {
	$url = $_POST['url'];

	function fetch_source_code($url) {
		$ch = curl_init($url);

		// Set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout for the request

		// Disable SSL verification (if necessary)
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		// Set headers to simulate a Google search referral
		$headers = [
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36',
			'Referer: https://www.google.com/search?q=computermixx&num=10&newwindow=1&sca_esv=b92988c8c5d34d5a&hl=en&biw=1278&bih=1385&ei=71YIZ9-aGfT-ptQPlb_8-AY&ved=0ahUKEwifzpqE8ISJAxV0v4kEHZUfH28Q4dUDCA8&uact=5&oq=computermixx&gs_lp=Egxnd3Mtd2l6LXNlcnAiDGNvbXB1dGVybWl4eDILEC4YgAQYxwEYrwEyCBAAGIAEGKIEMggQABiABBiiBDIIEAAYgAQYogQyCBAAGIAEGKIEMhoQLhiABBjHARivARiXBRjcBBjeBBjgBNgBAUjyW1CTTViLW3AGeAGQAQCYAaMBoAGFCaoBAzYuNbgBA8gBAPgBAZgCEaACyQnCAgoQABiwAxjWBBhHwgIKEC4YgAQYQxiKBcICCxAAGIAEGJECGIoFwgIREC4YgAQYsQMY0QMYgwEYxwHCAgUQLhiABMICCxAAGIAEGLEDGIMBwgIQEAAYgAQYsQMYgwEYigUYCsICCxAuGIAEGLEDGIMBwgIZEC4YgAQYQxiKBRiXBRjcBBjeBBjgBNgBAcICChAAGIAEGEMYigXCAhAQLhiABBjRAxhDGMcBGIoFwgIQEC4YgAQYQxjHARiKBRivAcICEBAAGIAEGLEDGEMYgwEYigXCAhkQLhiABBhDGMcBGJgFGJkFGIoFGJ4FGK8BwgIREC4YgAQYkQIYxwEYigUYrwHCAh8QLhiABBhDGMcBGIoFGK8BGJcFGNwEGN4EGOAE2AEBwgINEAAYgAQYsQMYQxiKBcICCBAAGIAEGLEDwgIIEAAYgAQYyQPCAggQABiABBiSA8ICCxAAGIAEGJIDGIoFwgIFEAAYgATCAgcQABiABBgKmAMAiAYBkAYIugYGCAEQARgUkgcEMTAuN6AHqoYB&sclient=gws-wiz-serp',
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// Execute the cURL request and fetch the page source
		$source_code = curl_exec($ch);

		// Check for cURL errors
		if (curl_errno($ch)) {
			return "cURL error: " . curl_error($ch);
		}

		// Close the cURL session
		curl_close($ch);

		return $source_code;
	}

	// Get the source code of the provided URL
	$source = fetch_source_code($url);

	// Output the fetched source code
	echo htmlspecialchars($source); // Escaping for HTML output
} else {
	echo "No URL provided.";
}
?>