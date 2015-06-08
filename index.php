<?php
namespace app;

require './app/core/conf/init.php';
require './app/core/models/Database.php';

/*
|--------------------------------------------------------------------------
| DatePusher - License info
|--------------------------------------------------------------------------
|
| Author      - Alex Sims
|
| License     - GPL : Feel free to use this code for learning purposes, do
|				not attempt to rebrand this as your own work.
|
| Description - Technical test for interview
|
|
|--------------------------------------------------------------------------
| Instantiate route constants
|--------------------------------------------------------------------------
|
| Define any path constants here to point to different functional areas
| of the site, BASEPATH, VIEWPATH, COREPATH, CONFPATH, CLASSPATH
|
| Only define constants if they are not already defined in the application.
|
*/

defined('BASE_PATH') or define('BASE_PATH', ".");
defined('VIEW_PATH') or define('VIEW_PATH', BASE_PATH."/app/views/");
defined('CORE_PATH') or define('CORE_PATH', BASE_PATH."/app/core/");
defined('CONF_PATH') or define('CONF_PATH', BASE_PATH."/app/config/");

/*
|--------------------------------------------------------------------------
| Instantiate directory constants
|--------------------------------------------------------------------------
|
| Define any constants which point to a public directory, these can then
| be used as a quick clean reference to any of the public directories.
|
*/

defined('CSS_DIR') or define('CSS_DIR', BASE_PATH."/public/css/");
defined('IMG_DIR') or define('IMG_DIR', BASE_PATH."/public/img/");
defined('LIB_DIR') or define('LIB_DIR', BASE_PATH."/public/lib/");

/*
|--------------------------------------------------------------------------
| Route user to requested page
|--------------------------------------------------------------------------
|
| If a valid page is requested then serve that view to the user, else
| we are on the index (home) page.
|
| We also require the header and footer here, this gives us the full markup
| for our document
|
*/

require_once(VIEW_PATH . "components/header.php");

if(isset($_GET['page'])) {
    $view = $_GET['page'];
    if(file_exists(VIEW_PATH.$view.".php")) {
        require_once(VIEW_PATH.$view.".php");
    } else {
        header("Status: 404 Not Found");
        header('HTTP/1.0 404 Not Found');
        require_once(CORE_PATH . "http_responses/404.php");
    }
} else {
    // This should only happen when a bogus URL is requested
    require_once(VIEW_PATH."home.php");
}
require_once(VIEW_PATH . "components/footer.php");