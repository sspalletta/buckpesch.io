<?php

namespace App\Controllers;

class HomeController extends AbstractController {

	/**
	 * Renders the home page
	 * @return \Psr\Http\Message\ResponseInterface|\Slim\Http\Response
     */
	public function get() {
		$data = [];

		// Basic data
		$data['page'] = [
			'title' => 'Sebastian Buckpesch - CTO and professional cloud developer'
		];

		// Add about section
		$data['about'] = [
			'name'        => 'Sebastian Buckpesch',
			'email'       => 's.buckpesch@gmail.com',
			'image'       => 'https://s3.buckpesch.io/images/sebastian-buckpesch-grey.jpg',
			'nationality' => 'Germany',
			'phone'       => '+49 (176) 80092736',
			'resume'      => 'https://s3.buckpesch.io/downloads/Sebastian-Buckpesch-CV.pdf'
		];

		return $this->view->render( $this->response, 'home.html.twig', $data );
	}
}