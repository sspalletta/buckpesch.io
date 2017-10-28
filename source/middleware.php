<?php
/**
 * Add Slim framework middleware here, so that it can be used in your routes
 */
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

/*$container['csrf'] = function($container) {
	return new \Slim\Csrf\Guard;
};
$app->add(new \App\Middleware\CsrfViewMiddleware($container));
$app->add($container->csrf);*/

// Authentication middleware
$container['auth'] = function($container) {
	return new App\Auth\Auth;
};