<?php
/**
 * User: s.buckpesch
 * Date: 08.11.2017
 * Time: 22:36
 */

namespace App\Models;

use App\Models\Medium\Post;
use GuzzleHttp\Client;

class Medium {

	private $user;

	/** @var array of Medium Posts */
	private $posts;

	/**
	 * Medium constructor.
	 *
	 * @param string $user Medium username, e.g. @sbuckpesch
	 */
	public function __construct( $user ) {

		$this->user = $user;

		// Fetch data from medium json feed
		$data = $this->fetch( $user );

		// Populate posts
		$this->setPosts( $data['references']['Post'] ?? [] );

	}

	private function fetch( $user, $slug = 'latest' ) {
		$client = new Client();

		try {
			$res = $client->request( 'GET', sprintf( 'https://medium.com/%s/%s?format=json', $user, $slug ) );
		} catch ( \Exception $exception ) {
			return false;
		}

		if ( ! $res->getStatusCode() == 200 ) {
			return false;
		}

		$body = json_decode( str_replace( '])}while(1);</x>', '', $res->getBody() ), true );

		if ( ! isset( $body['success'], $body['payload'] ) ) {
			return false;
		}

		return $body['payload'];
	}

	/**
	 * @return array
	 */
	public function getPosts(): array {
		$timestamp = [];
		foreach ( $this->posts as $key => $row ) {
			$timestamp[ $key ] = $row->getPublishedAt();
		}
		array_multisort( $timestamp, SORT_DESC, $this->posts );

		return $this->posts;
	}

	/**
	 * @param array $posts
	 */
	public function setPosts( array $posts ) {
		$mediumPosts = [];

		foreach ( $posts as $post ) {
			$post['user']  = $this->user;
			$mediumPosts[] = new Post( $post );
		}

		$this->posts = $mediumPosts;
	}
}