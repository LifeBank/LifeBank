<pre><?php
$requested = strtolower($_SERVER['REQUEST_URI']);
$pagex = preg_replace('|https?://|', '', $requested);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
	$dir = basename(dirname(__FILE__));
  $pagex = preg_replace("|^.*$dir|i", "", $pagex);
}

$pagex = preg_replace('/^\//', "", $pagex);
$pagex = preg_replace('/\?.*$/', '', $pagex);
$pages = explode("/", $pagex);

print_r($pages);
?>