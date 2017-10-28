<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 15:53
 */

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class CsrfViewMiddleware extends Middleware {

	/**
	 * @param Request $request
	 * @param Response $response
	 * @param $next
	 *
	 * @return mixed
	 */
	public function __invoke( $request, $response, $next ) {

		$this->container->view->csrf = [
			"field" => '
				<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '" >
				<input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '" >
			'
		];

		$response = $next($request, $response);

		return $response;
	}
}