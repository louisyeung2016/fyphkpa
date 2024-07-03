<?php
  header("HTTP/1.0 404 Not Found");
?>
<!doctype html>
<html lang="en">
  <head>
    <title>404 Error - Page Not Found</title>
  </head>
  <body>
	<h1>404 :(</h1>
	This page doesn't exist. Sorry!
	<br>
	<button onclick="history.back();">Go back</button>
  </body>
</html>
<?php
header("Refresh:3; url=./dashboard.php", TRUE, 301);
?>