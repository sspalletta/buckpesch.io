<?php
// Define named route
$app->group('/v2', function() use ($container) {

	$this->route(['GET'], '/404', \App\Controllers\Error404Controller::class);
    // Password protected API routes
	$this->group('/api', function() {
		//$this->route(['POST'], '/items/upload', \App\Controllers\UploadController::class);
	})->add(new \App\Middleware\AuthMiddleware($container));
});