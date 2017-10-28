<?php
/**
 * Initialize the Slim framework
 */
session_start();

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__) . '/../');
}

// Fetch DI Container
$container = new \Slim\Container($appConfig);
// Initialize DB connection
$container['db'] = function ($container) use ($appConfig) {
    $dsn      = "{$appConfig['pdo']['engine']}:host={$appConfig['pdo']['host']};dbname={$appConfig['pdo']['database']};charset={$appConfig['pdo']['charset']}";
    $username = $appConfig['pdo']['username'];
    $password = $appConfig['pdo']['password'];

    return new PDO($dsn, $username, $password, $appConfig['pdo']['options']);
};
// Setup Eloquent connection
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($appConfig['pdo']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['capsule'] = function ($container) use ($capsule) {
    return $capsule;
};

// Add error handler
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $container['response']->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write($exception);
    };
};

// Add validator
$container['validator'] = function ($container) {
    return new App\Validation\Validator;
};
// Add custom rules
\Respect\Validation\Validator::with("App\\Validation\\Rules\\");

// Create Slim App
$app = new \App\App($container);

// Register Twig View component on container
$container['view'] = function ($container) use ($appConfig)  {
	$view = new \Slim\Views\Twig(__DIR__ . '/view', [
		'cache' => ROOT_PATH . '/source/var/cache'
	]);

	// Instantiate and add Slim specific extension
	$basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
	$view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

	// Add variables as view globals
	$viewEnv = $view->getEnvironment();
	$viewEnv->addGlobal('myGlobale', []);
	if ($appConfig['settings']['displayErrorDetails']) {
		$viewEnv->enableDebug();
		$viewEnv->enableAutoReload();
	}
	return $view;
};

require __DIR__ . '/middleware.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/helpers.php';


// Run App
$app->run();
