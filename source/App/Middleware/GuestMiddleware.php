<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 17:10
 */

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class GuestMiddleware extends Middleware {
	/**
	 * @param Request $request
	 * @param Response $response
	 * @param $next
	 *
	 * @return mixed
	 */
	public function __invoke( $request, $response, $next ) {

		// Check if the user is signed in
		if ($this->container->auth->check()) {
			return $response->withRedirect($this->container->router->pathFor('admin'));
		}

		$response = $next($request, $response);

		return $response;
	}
}