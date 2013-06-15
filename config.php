<?php
define("Token", "1511239506-z7ABQ0ov2TiE155CJKpF7IZxUsubMJZrLyNCoo8");
define("Secret", "KEM6MfoczpUEan7XPRo9swr9G7PAmcbgi7YpmYLjJQ");
define("TwitterOauthKey", "8TF5bADf85x8aIPVuuinJw");
define("TwitterOauthSecret", "evsSLub5u0ifh9ZpClCbOM24ubOpBMxjBKxs4KOeZPI");
define("TwitterCallback", "http://localhost/ray/lifebank/user/twitter-callback");

session_start();
mysql_select_db("localhost", "root", "");
mysql_connect("lifebank");
?>