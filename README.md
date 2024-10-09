# Website Pinger and Source Code Fetcher

This project contains three PHP scripts designed to monitor website statuses and retrieve the source code of a specified website. The scripts allow for periodic pings of a list of URLs to check their HTTP status codes and display the HTML source code of a webpage (like `google.com`) on the page, refreshing every 10 seconds.

The Inspiration for this was finding a wordpress website that was redirecting me to other websites sometimes but not every time (youtu.be/9VTHPrTLwPU) so it was seemingly random and very hard to reproduce.  `website-pinger.php` automates the process of checking the website so i don't need to refresh the website and/or source code view in my browser manually.

## Screenshot
![Alt text](screenshot-2024.10.09_080749.jpg?raw=true "screenshot")

## Files Overview

1. **`website-pinger-fetch-source.php` -**
	A helper PHP script that fetches the HTML source code of a specified URL (like `https://www.google.com`) to display it on the `website-pinger.php` page. The source code refreshes every 10 seconds using JavaScript in the `website-pinger.php` file.

2. **`website-pinger-status.php` -**
	A helper PHP script that pings a provided URL and returns its HTTP status code. This file is called by `website-pinger.php` through an AJAX request to check the status of multiple websites.

3. **`website-pinger.php` -**
	The main script for pinging a list of websites, this is the one to open in your web browser. It displays a table of URLs and their corresponding HTTP status codes, which are refreshed every 10 seconds without reloading the page. Uses AJAX to periodically call `website-pinger-status.php`.

## Features

- **Automatic Status Checking**: Pings multiple URLs to check their HTTP status codes.
- **Live Status Updates**: The HTTP status codes for the websites are updated every 10 seconds without refreshing the page.
- **Source Code Fetching**: Fetches and displays the HTML source code of a specified URL and refreshes it every 10 seconds.
- **AJAX-Driven**: Uses JavaScript's `XMLHttpRequest` to make non-blocking requests for status and source code fetching.

## Setup Instructions

### Prerequisites

- A web server with PHP support (e.g., Apache, Nginx, XAMPP, etc.).
- Internet access (to ping external websites and fetch their source code).
- A web browser.

### Installation

1. **Clone the repository**:
	```bash
	git clone https://github.com/yourusername/website-pinger.git
	```

2. **Move the files to your web server's document root**:
	For example, if you're using XAMPP, move the files to the `htdocs` folder:
	```bash
	mv website-pinger /path-to-your-server/htdocs/
	```

3. **Ensure PHP is properly configured**: The scripts use `file_get_contents()` and `cURL` to fetch external URLs, so make sure these PHP functions are enabled on your server.

### Configuration

- In `website-pinger.php`, you can customize the list of URLs to ping by editing the `$urls` array:
	```php
	$urls = [
		 'http://google.com',
		 'http://google.com/xyz1234',
		 'https://www.reddit.com',
		 'https://www.twitter.com',
		 'http://asdkjn349dlk.com',
	];
	```
- In `website-pinger-fetch-source.php`, you can customize the URL for the `id="sourceCode"` DIV by changing this line:
	```php
	$url = "https://h5bp.com";
	```

### Running the Application

1. Open your browser and navigate to the script by visiting:
	```bash
	http://localhost/website-pinger/website-pinger.php
	```

	You should see a table with the list of websites and their respective HTTP status codes, which will automatically refresh every 10 seconds.


### File Descriptions

#### 1. `website-pinger.php`

- **Purpose**: Pings a list of websites and displays their HTTP status codes in a table.
- **AJAX Functionality**: Uses JavaScript to make an asynchronous request every 10 seconds to `website-pinger-status.php` to update the status codes without reloading the page.
- **Customization**: Edit the `$urls` array in the PHP code to add/remove websites.

#### 2. `website-pinger-status.php`

- **Purpose**: Responds to AJAX requests from `website-pinger.php` to return the HTTP status code of a provided URL.
- **Request Handling**: Accepts a URL via `POST` and returns its HTTP status code using `get_headers()`.

#### 3. `website-pinger-fetch-source.php`

- **Purpose**: Fetches and displays the source code of a specific URL (by default `https://www.google.com`).
- **JavaScript Functionality**: Uses JavaScript to refresh the source code every 10 seconds without reloading the entire page.
- **Customization**: Modify the URL being fetched by changing the `$url` variable in the PHP code.

## Known Limitations

- Some websites may block requests from `file_get_contents()` or `cURL` due to security policies (such as CORS or anti-scraping measures).
- Websites with large amounts of content might slow down the refresh functionality due to the size of the response.

## Contributing

Feel free to fork this repository and submit pull requests with improvements or new features. Bug reports and feature requests are welcome!

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
