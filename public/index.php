<?php
require __DIR__ . '/../vendor/autoload.php';

// Set environment and initialize configuration
if (!defined('APPLICATION_PATH')) {
	define('APPLICATION_PATH', realpath(__DIR__) . '/../source');
}
$appConfig = include APPLICATION_PATH . '/config/application.config.php';
if (file_exists(APPLICATION_PATH . '/config/development.config.php')) {
	$appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APPLICATION_PATH . '/config/development.config.php');
}
$environment = $appConfig['env'] ?? getenv('APP_ENV');
if ( $environment === 'development' ) {
	ini_set('display_errors', 1);
} else {
	ini_set( 'display_errors', 0 );
}

require __DIR__ . '/../source/start.php';
