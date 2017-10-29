<?php
// Define named route
$app->route(['GET'], '/', \App\Controllers\HomeController::class);
$app->route(['GET'], '/404', \App\Controllers\Error404Controller::class);

// Password protected API routes
$app->group('/api', function() {
	//$this->route(['POST'], '/items/upload', \App\Controllers\UploadController::class);
})->add(new \App\Middleware\AuthMiddleware($container));