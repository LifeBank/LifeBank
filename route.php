    <?php

    error_reporting(E_ALL);

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
    
    if ($pages[0] == 'hospital') {
        include_once 'models/Hospital.php';
        $user = new User();
        
        if ($pages[1] == 'donors') {
            include_once 'Views/donors.php';
        }
    }else{
        include_once 'Views/index.php';
    }

    // Magic Quotes Fix
    if (ini_get('magic_quotes_gpc')) {

        function clean($data) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $data[clean($key)] = clean($value);
                }
            } else {
                $data = stripslashes($data);
            }

            return $data;
        }

        $_GET = clean($_GET);
        $_POST = clean($_POST);
        $_COOKIE = clean($_COOKIE);
    }

    $LIFEBANK = str_replace("route.php", "", realpath(__FILE__));
    define("LIFEBANK", $LIFEBANK);

    require_once(LIFEBANK . "lib/config.ini.php");


    require_once(LIFEBANK . "lib/class_db.php");
    $db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
    $db->connect();

    include(LIFEBAK . "lib/headerRefresh.php");
    if (!defined("_PIPN")) {
        require_once(LIFEBANK . "lib/class_filter.php");
        $request = new Filter();
    }

    //Start Core Class 
    require_once(LIFEBANK . "lib/class_core.php");
    $core = new Core();
    
    
    ?>