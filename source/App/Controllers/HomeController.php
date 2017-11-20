<?php

namespace App\Controllers;

use App\Models\Medium;
use App\Models\WordpressReader;
use Medium\Post;

class HomeController extends AbstractController {

	/**
	 * Renders the home page
	 * @return \Psr\Http\Message\ResponseInterface|\Slim\Http\Response
	 */
	public function get() {
		$data = [];

		// Basic data
		$data['page'] = [
			'title'        => 'Stefania Spalletta - International Business Developement Manager',
			'social_media' => [
				'twitter'  => 'https://www.twitter.com/stefiusviralog',
				'xing'     => 'https://www.xing.com/profile/Stefania_Spalletta',
				'linkedIn' => 'https://www.linkedin.com/in/stefaniaspalletta/',
			],
			'copyright'    => date( 'Y' ) . ' Stefania Spalletta',
			'navigation' => [
				'logo' => [
					'title' => 'Stefania Spalletta'
				]
			]
		];

		$data['parallax'] = [
			'title'        => 'My name is Stefania Spalletta',
			'items' => [
				['title' => "I'm an international Business Development Manager", 'visible' => true],
				['title' => "I'm a strategic thinker", 'visible' => false],
				['title' => "I'm a networker", 'visible' => false],
				['title' => "I see opportunities everywhere!", 'visible' => false],
			],
			'copyright'    => date( 'Y' ) . ' Stefania Spalletta',
			'background' => [
				'src' => '/images/background/parallax.jpg'
			]
		];



		// Add blog section
		//$data['blog'] = $this->getBlog();

		// Add about section
		$data['about'] = [
			'name'        => 'Stefania Spalletta',
			'slogan'      => "Hallo, ich bin E-Commerce Business Manager aus Köln. Ich halte einen Master of Science Titel sowie ein Advanced Diploma of Marketing.",
			'location'    => 'Köln, Deutschland',
			'email'       => 'stefania.spalletta@gmail.com',
			'image'       => '/images/stefania-spalletta.jpg',
			'nationality' => 'Italienisch',
			'phone'       => '+49 (176) 84564363',
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
					'icon'        => 'icon-genius',
					'title'       => 'Business Development',
					'description' => 'Key Account Management, Partner Management, Strategic Sales & Acquisition, Partner Enabling'
				],
				[
					'icon'        => 'icon-megaphone',
					'title'       => 'Marketing',
					'description' => 'Messen & Events, Social Media, Integrated Marketing, SEO, E-Mail, Corporate Identity, Analytics'
				],
				[
					'icon'        => 'icon-basket',
					'title'       => 'E-Commerce',
					'description' => 'Shop-Systeme, Integrations/APIs, Payment (PCI), Sales, KPIs'
				],
				[
					'icon'        => 'icon-wallet',
					'title'       => 'Credit Management',
					'description' => 'Lieferanten-Prüfung, Score-Cards, Unternehmensbewertung, Bilanz-Analyse, Konsumenten-Bewertung, Predictive Analytics'
				],
				[
					'icon'        => 'icon-calendar',
					'title'       => 'Produkt-Management',
					'description' => 'Software, SaaS, Konzeption, Projektmanagement, Schnittstellen'
				],
				[
					'icon'        => 'icon-mobile',
					'title'       => 'IT & Usability',
					'description' => 'MS Office Suite, HTML, CSS, Wordpress, Typo3, UX, UI'
				],
				[
					'icon'        => 'icon-shield',
					'title'       => 'Datenschutz & Datensicherheit',
					'description' => 'BDSG, EU-DSGVO, EU-GDPR'
				],
				[
					'icon'        => 'icon-presentation',
					'title'       => 'Präsentation & Workshop',
					'description' => 'Anwender-Schulungen, Training, Workshops, Präsentationen, Key-Notes'
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

		$medium     = new \Sbuckpesch\Medium\Reader( '@sbuckpesch' );
		$posts      = $medium->getPosts();
		$postsArray = [];
		/** @var \Sbuckpesch\Medium\Post $post */
		foreach ( $posts as $post ) {
			$data                 = $post->toArray();
			$data['previewImage'] = $post->getPreviewImage( 600 );
			$data['timestamp']    = $post->getPublishedAt() / 1000;
			$data['publishedAt']  = date( 'd F Y', $post->getPublishedAt() / 1000 );
			$postsArray[]         = $data;
		}

		// Get wordpress posts from App-Arena.com
		$wpReader = new WordpressReader( 6 );
		$wpPosts  = $wpReader->getPosts();
		foreach ( $wpPosts as $post ) {
			$data                 = $post->toArray();
			$data['previewImage'] = $post->getPreviewImage();
			$data['timestamp']    = $post->getPublishedAt();
			$data['publishedAt']  = date( 'd F Y', $post->getPublishedAt() );
			$postsArray[]         = $data;
		}

		// Order posts by date
		$timestamp = [];
		foreach ( $postsArray as $key => $row ) {
			$timestamp[ $key ] = $row['timestamp'];
		}
		array_multisort( $timestamp, SORT_DESC, $postsArray );

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
					'years'       => '2010 - 2011',
					'title'       => 'Dublin Business School',
					'description' => 'E-Commerce, Interactive Marketing Communication, Strategic Marketing, Marketing Services',
					'degree'      => 'Advanced Diploma in Marketing',
					'grade'       => false,
					'image'       => '/images/logos/dbs-logo.png'
				],
				[
					'years'       => '2010',
					'title'       => 'Paypal',
					'description' => 'Compliance, Fraud-Prevention',
					'degree'      => 'Schulungen',
					'grade'       => false,
					'image'       => '/images/logos/paypal-logo.png'
				],
				[
					'years'       => '2002 - 2007',
					'title'       => 'Università degli Studi di Palermo, Italien',
					'description' => 'EU Vergleichsrecht, Ital. Zivilrecht',
					'degree'      => 'Master of Science European Studies',
					'grade'       => [
						'title'       => 'Note 110 cum laude',
						'description' => '(+)110 bis 60(-)',
					],
					'image'       => '/images/logos/universita-palermo.jpg'
				],
			],

		];

		return $response;

	}
}