<?php

namespace App\Controllers;

class HomeController extends AbstractController {

	/**
	 * @return \Psr\Http\Message\ResponseInterface|\Slim\Http\Response
     */
	public function get() {

        return $this->view->render($this->response, 'home.html.twig', [
        	'name' => 'Sebastian Buckpesch',
        	'title' => 'Sebastian Buckpesch - CTO and professional cloud developer',

        ]);
	}
}