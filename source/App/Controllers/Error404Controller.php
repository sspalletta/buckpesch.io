<?php

namespace App\Controllers;

class Error404Controller extends AbstractController {
	/**
	 * @return \Psr\Http\Message\ResponseInterface|\Slim\Http\Response
     */
	public function get() {
		$this->response = $this->response->withStatus( 404 );
        return $this->view->render($this->response, 'error404.twig', [
        	'text' => 'The App you are trying to display is not available. Please provide an App-ID to start the App.'
        ]);
	}
}