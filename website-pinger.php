<?php

$urls = [
	'http://google.com',
	'http://google.com/xyz1234',
	'https://www.reddit.com',
	'https://x.com',
	'http://asdkjn349dlk.com',

];

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Website Pinger</title>
		<style>
			body, th{
				background-color:#111;
				color:#DDD;
			}
			[class^="status-"]{color:#000;}
			tr>td{background-color:#999;}
				table {
						width: 100%;
						border-collapse: collapse;
				}
				table, th, td {
						border: 1px solid black;
				}
				th, td {
						padding: 10px;
						text-align: left;
				}
				th {
		/*						background-color: #f2f2f2;*/
						cursor:pointer;
				}
				[class*=" - 2"]{background:hsla(100, 50%, 60%, 1);}
				[class*=" - 3"]{background:hsla(55, 50%, 60%, 1);}
				[class*=" - 4"]{background:hsla(0, 50%, 60%, 1);}
				[class*=" - 5"]{background:hsla(300, 100%, 60%, 1);}
				[class*=" - E"]{background:hsla(0, 100%, 60%, 1);}

				/* flash background */
				[class*=" - 302"], [class*=" - Error"] {
					-webkit-animation: attention-grabber 0.25s infinite;  /* Safari 4+ */
					-moz-animation: attention-grabber 0.25s infinite;  /* Fx 5+ */
					-o-animation: attention-grabber 0.25s infinite;  /* Opera 12+ */
					animation: attention-grabber 0.25s infinite;  /* IE 10+, Fx 29+ */
				}

				@-webkit-keyframes attention-grabber {
					0%, 49% {
						background-color: hsl(0, 100%, 50%);
						border: 3px solid hsl(0, 100%, 100%);
					}
					50%, 100% {
						background-color: hsl(0, 100%, 100%);
						border: 3px solid hsl(0, 100%, 50%);
					}
				}
		</style>
		<script>
			function checkStatus(url, rowId) {
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "website-pinger-status.php", true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4 && xhr.status == 200) {
							var statusCode = xhr.responseText.trim();
							var statusCell = document.getElementById('status-' + rowId);
							statusCell.innerText = statusCode;
							statusCell.className = 'status-' + statusCode;
					}
				};
				xhr.send("action=check&url=" + encodeURIComponent(url));
			}

			function checkAllStatuses() {
				var urls = <?php echo json_encode($urls); ?>;
				for (var i = 0; i < urls.length; i++) {
					document.getElementById('status-' + i).innerText = "Checking...";
					checkStatus(urls[i], i);
				}
			}

			window.onload = checkAllStatuses;
			// sotable table
			function sortTable(n) {
				var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
				table = document.getElementById("pinger");
				switching = true;
				// Set the sorting direction to ascending:
				dir = "asc";
				/* Make a loop that will continue until
				no switching has been done: */
				while (switching) {
					// Start by saying: no switching is done:
					switching = false;
					rows = table.rows;
					/* Loop through all table rows (except the
					first, which contains table headers): */
					for (i = 1; i < (rows.length - 1); i++) {
						// Start by saying there should be no switching:
						shouldSwitch = false;
						/* Get the two elements you want to compare,
						one from current row and one from the next: */
						x = rows[i].getElementsByTagName("TD")[n];
						y = rows[i + 1].getElementsByTagName("TD")[n];
						/* Check if the two rows should switch place,
						based on the direction, asc or desc: */
						if (dir == "asc") {
							if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						} else if (dir == "desc") {
							if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
					if (shouldSwitch) {
						/* If a switch has been marked, make the switch
						and mark that a switch has been done: */
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
						// Each time a switch is done, increase this count by 1:
						switchcount ++;
					} else {
						/* If no switching has been done AND the direction is "asc",
						set the direction to "desc" and run the while loop again. */
						if (switchcount == 0 && dir == "asc") {
							dir = "desc";
							switching = true;
						}
					}
				}
			}

			// re-run check
			setInterval(checkAllStatuses, 10000);

		</script>
	</head>
	<body>
		<h1>Website Pinger - <small id="datetime"></small></h1>
		<script>
			 function updateDateTime() {
					 const now = new Date();
					 const dateTimeString = now.toLocaleString(); // Gets the local date and time
					 document.getElementById('datetime').textContent = dateTimeString;
			 }

			 // Update the time every second
			 setInterval(updateDateTime, 1000);

			 // Display the current date and time when the page loads
			 updateDateTime();
		</script>

		<table id="pinger">
				<tr>
						<th onclick="sortTable(0)">URL</th>
						<th onclick="sortTable(1)">Status Code</th>
				</tr>
				<?php foreach ($urls as $index => $url): ?>
				<tr>
						<td><a href="<?php echo htmlspecialchars($url); ?>" target="_blank"><?php echo htmlspecialchars($url); ?></a></td>
						<td id="status-<?php echo $index; ?>" class="status-refresh status-not-checked">Not checked yet</td>
				</tr>
				<?php endforeach;?>
		</table>


		<!-- get source of URL and refresh -->
		<script>
				function fetchSourceCode() {
						var xhr = new XMLHttpRequest();
						xhr.open('GET', 'website-pinger-fetch-source.php', true); // 'fetch-source.php' contains the PHP code that fetches the page source
						xhr.onload = function() {
								if (this.status == 200) {
										document.getElementById('sourceCode').innerHTML = this.responseText;
								}
						};
						xhr.send();
				}

				// Refresh the source code every 10 seconds
				setInterval(fetchSourceCode, 10000);

				// Fetch the source code when the page loads
				window.onload = fetchSourceCode;
		</script>
		<div id="sourceCode" style="border: 1px solid #CCC; padding: 10px; overflow: hidden; max-height: 400px;">
				Loading source code...
		</div>
	</body>
</html>

