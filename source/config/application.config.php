<?php
// please rename to application.config.php ...
return [
	'env'                        => 'development',
	'settings'                   => [
		// Slim Settings
		'displayErrorDetails'               => false,
		'determineRouteBeforeAppMiddleware' => true,
		'addContentLengthHeader'            => false,
	],
	'pdo'                        => [
		'driver'    => 'mysql',
		'engine'    => 'mysql',
		'host'      => 'localhost',
		'database'  => 'web',
		'username'  => 'root',
		'password'  => 'root',
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'options'   => [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => true,
		],
	],
	// Redis cache cluster
	'redis'                      => [
		'activated' => true,
		'host'      => '127.0.0.1',
		'port'      => 6379,
	],
];