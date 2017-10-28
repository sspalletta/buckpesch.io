<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 14:36
 */

namespace App\Middleware;


class Middleware {

	protected $container;

	/**
	 * Middleware constructor.
	 *
	 * @param $container
	 */
	public function __construct( $container ) {
		$this->container = $container;
	}


}