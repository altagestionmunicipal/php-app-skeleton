<?php
/**
 * slim-boilerplate-code
 *
 * (c) Nazareth Gutiérrez http://jn6h.com
 * License: MIT
 */

/**
 * Display errors
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Default timezone
 */
date_default_timezone_set('America/Mexico_City');

/**
 * Define some constants
 */
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("VENDOR_DIR", ROOT . "vendor" . DS);
define("ROUTE_DIR", ROOT . "routes" . DS);
define("TEMPLATE_DIR", ROOT . "templates" . DS);

define('SLIM_MODE', getenv('SLIM_MODE') ? getenv('SLIM_MODE') : 'development');

/**
 * Include autoload file
 */
require_once VENDOR_DIR . "autoload.php";

/**
 * Include config files
 */
$configPaths = sprintf(
  '%s/config/{,*.}{global,%s,local}.php', ROOT, SLIM_MODE);
$config = Zend\Config\Factory::fromFiles(glob($configPaths, GLOB_BRACE));

/**
 * Create app
 */
$app = new Slim\Slim($config["slim"]);

$bootstrap = new Jn6h\Bootstrap($app, $config);
$app = $bootstrap->bootstrap();

/**
 * Include helpers
 */
 foreach (glob(ROOT . 'helpers' . DS . '*.php') as $filename) {
   require_once $filename;
 }

/**
 * Include all files located in routes directory
 */
foreach(glob(ROUTE_DIR . '*.route.php') as $router) {
  require_once $router;
}

/**
 * Run the application
 */
$app->run();
