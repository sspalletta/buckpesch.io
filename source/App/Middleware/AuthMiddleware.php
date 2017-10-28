<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 17:10
 */

namespace App\Middleware;


use App\Auth\Auth;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware extends Middleware {
	/**
	 * @param Request $request
	 * @param Response $response
	 * @param $next
	 *
	 * @return mixed
	 */
	public function __invoke( $request, $response, $next ) {

		// Check if the user is signed in
		/** @var Auth $auth Auth object */
		$auth = $this->container->auth;
		if (!$auth->check()) {
			return $response->withRedirect($this->container->router->pathFor('auth'));
		}

		return $next($request, $response);
	}
}