<?php

namespace App\Controllers;

use App\Models\Medium;

class HomeController extends AbstractController {

	/**
	 * Renders the home page
	 * @return \Psr\Http\Message\ResponseInterface|\Slim\Http\Response
	 */
	public function get() {
		$data = [];

		// Basic data
		$data['page'] = [
			'title'        => 'Sebastian Buckpesch - CTO and professional cloud developer',
			'social_media' => [
				'facebook' => 'https://www.facebook.com/sbuckpesch',
				'medium'   => 'https://medium.com/@sbuckpesch',
				'github'   => 'https://github.com/sbuckpesch',
				'xing'     => 'https://www.xing.com/profile/Sebastian_Buckpesch',
				'linkedIn' => 'https://www.linkedin.com/in/sbuckpesch/en',
			],
			'copyright'    => date( 'Y' ) . ' Sebastian Buckpesch'
		];

		// Add blog section
		$data['blog'] = $this->getBlog();

		// Add about section
		$data['about'] = [
			'name'        => 'Sebastian Buckpesch',
			'location'    => 'Cologne, Germany',
			'email'       => 's.buckpesch@gmail.com',
			'image'       => 'https://s3.buckpesch.io/images/sebastian-buckpesch-grey.jpg',
			'nationality' => 'Germany',
			'phone'       => '+49 (176) 80092736',
			'resume'      => 'https://s3.buckpesch.io/downloads/Sebastian-Buckpesch-CV.pdf'
		];

		// Add Skills
		$data['skills']    = $this->getSkills();
		$data['education'] = $this->getEducation();

		return $this->view->render( $this->response, 'home.html.twig', $data );
	}

	/**
	 * Returns a list of skills
	 * @return array Array list of skills
	 */
	private function getSkills() {
		$response = [
			'title' => 'Skills',
			'items' => [
				[
					'icon'        => 'icon-gears',
					'title'       => 'Backend',
					'description' => 'PHP / ZF2, Slim3, NodeJS / Walmart Electrode'
				],
				[
					'icon'        => 'icon-cloud',
					'title'       => 'Cloud',
					'description' => 'AWS (EC2, RDS, VPC, Lambda, ECS, DynamoDB, Cloudformation), Elasticsearch, Serverless Framework'
				],
				[
					'icon'        => 'icon-browser',
					'title'       => 'Frontend',
					'description' => 'React, Redux, BackboneJS, Bootstrap4, SCSS'
				],
				[
					'icon'        => 'icon-tools-2',
					'title'       => 'DevOps',
					'description' => 'CI/CD, Docker, Webpack, Bamboo, Ubuntu, Apache, SSL'
				],
				[
					'icon'        => 'icon-key',
					'title'       => 'APIs',
					'description' => 'HTTP/2, RESTful, GraphQL, SOAP, OAuth2, JWT'
				],
				[
					'icon'        => 'icon-circle-compass',
					'title'       => 'Architecture',
					'description' => 'MVC, SOA, Serverless Architecture, Micro-Service-Architecture'
				],
				[
					'icon'        => 'icon-shield',
					'title'       => 'Data security & privacy',
					'description' => 'BDSG, EU-DSGVO, EU-GDPR'
				],
				[
					'icon'        => 'icon-speedometer',
					'title'       => 'Controlling',
					'description' => 'Shareholder Reporting, KPIs, Web Performance, Analytics'
				],
				[
					'icon'        => 'icon-wallet',
					'title'       => 'Financials',
					'description' => 'Financial accounting, DATEV > Exactonline migration, KPI development'
				],
				[
					'icon'        => 'icon-lightbulb',
					'title'       => 'Pitch & Innovation',
					'description' => 'Pitchdecks, SaaS Business models, Business opportunity creation'
				],
				[
					'icon'        => 'icon-calendar',
					'title'       => 'Scrum',
					'description' => 'Product owner, Scrum master'
				],
				[
					'icon'        => 'icon-profile-male',
					'title'       => 'People management',
					'description' => 'Leadership, Training, Mentoring'
				],
			],

		];

		return $response;

	}

	/**
	 * Returns a list of blogs and all related information about recent publtications
	 * @return array Array list of skills
	 */
	private function getBlog() {

		$medium     = new Medium( '@sbuckpesch' );
		$posts      = $medium->getPosts();
		$postsArray = [];
		/** @var Medium\Post $post */
		foreach ( $posts as $post ) {
			$data                 = $post->toArray();
			$data['previewImage'] = $post->getPreviewImage( 600 );
			$data['publishedAt']  = date( 'd F Y', $post->getPublishedAt() / 1000 );
			$postsArray[]         = $data;
		}

		$response = [
			'title' => 'Blog',
			'items' => $postsArray,
		];

		return $response;

	}

	/**
	 * Returns a list of education items
	 * @return array Array list of education items
	 */
	private function getEducation() {
		$response = [
			'title' => 'Education',
			'items' => [
				[
					'years'       => '2017',
					'title'       => 'AWS Solution Architect',
					'description' => 'Specialisation: E-Business, Online Marketing',
					'degree'      => 'AWS Certified Solutions Architect - Associate Level',
					'grade'       => false,
					'image'       => 'https://s3.buckpesch.io/images/education/Solutions-Architect-Associate.png'
				],
				[
					'years'       => '2016',
					'title'       => 'IHK Köln',
					'description' => 'Job profiles: Qualified IT specialist, Marketing professionals, Media designers',
					'degree'      => 'Certified trainer / Zertifizierter Ausbilder',
					'grade'       => false,
					'image'       => 'https://s3.buckpesch.io/images/education/ihk-logo.png'
				],
				[
					'years'       => '2003 - 2010',
					'title'       => 'TU Darmstadt',
					'description' => 'Specialisation: E-Business, Online Marketing',
					'degree'      => 'Master of Science Bus. Inf. Syst.',
					'grade'       => [
						'title'       => 'Grade 1.4',
						'description' => '1.0 (best) to 6.0 (worst)',
					],
					'image'       => 'https://s3.buckpesch.io/images/education/tud_logo.png'
				],
				[
					'years'       => '2006 - 2007',
					'title'       => 'UCA Buenos Aires',
					'description' => 'Specialisation: Operations Research, Marketing',
					'degree'      => 'Studying abroad',
					'grade'       => false,
					'image'       => 'https://s3.buckpesch.io/images/education/UCA-Logo.jpg'
				],
			],

		];

		return $response;

	}
}