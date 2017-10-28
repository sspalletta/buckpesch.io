<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 14:37
 */

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class ValidationErrorsMiddleware extends Middleware {


	/**
	 * @param Request $request
	 * @param Response $response
	 * @param $next
	 *
	 * @return mixed
	 */
	public function __invoke( $request, $response, $next ) {

		// Get validation errors from the session and clean it up
		$this->container->view->errors = false;
		if (isset($_SESSION['errors'])) {
			$this->container->view->errors = $_SESSION['errors'];
			unset($_SESSION['errors']);
		}

		return $next($request, $response);
	}

}