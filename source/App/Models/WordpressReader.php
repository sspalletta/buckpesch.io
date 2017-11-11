<?php
/**
 * User: s.buckpesch
 * Date: 08.11.2017
 * Time: 22:36
 */

namespace App\Models;

use GuzzleHttp\Client;

class WordpressReader {

	private $userId;

	/** @var array of Medium Posts */
	private $posts;

	/**
	 * Medium constructor.
	 *
	 * @param string $user Medium username, e.g. @sbuckpesch
	 */
	public function __construct( $userId ) {

		$this->userId = $userId;

		// Fetch data from medium json feed
		$data = $this->fetch( $userId );

		// Populate posts
		$this->setPosts( $data ?? [] );

	}

	private function fetch( $userId ) {
		$client = new Client();
		$url    = 'https://www.app-arena.com/wp-json/wp/v2/posts';
		$params = [
			'_embed'   => true,
			'status'   => 'publish',
			'author'   => $userId,
			'per_page' => 3,
		];
		$url    .= '?' . http_build_query( $params );

		try {
			$res = $client->request( 'GET', $url );
		} catch ( \Exception $exception ) {
			return false;
		}

		if ( ! $res->getStatusCode() == 200 ) {
			return false;
		}

		$body = json_decode( $res->getBody(), true );

		return $body;
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
			$mediumPosts[] = new WordpressPost( $post );
		}

		$this->posts = $mediumPosts;
	}
}