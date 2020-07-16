<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

$max_execution_time = 300;
if (defined('STDIN')) {
    foreach($argv as $argument) {
        if(strpos($argument, 'max-execution-time') !== false) {
            $argumentKeyValue = explode('=', $argument);
            $max_execution_time = intval($argumentKeyValue[1]);
            if(empty($max_execution_time)) {
                $max_execution_time = 300;
            }
        }
    }
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('max_execution_time', $max_execution_time);
ini_set("memory_limit","4000M");
// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Load constants
require 'config/constant.config.php';
require 'config/environment.config.php';

// Set timezone
date_default_timezone_set(DATETIMEZONE);

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();

