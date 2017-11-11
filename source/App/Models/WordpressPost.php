<?php

namespace App\Models;

class WordpressPost {

	private $title;
	private $subtitle;
	private $publishedAt;
	private $previewImage;
	private $meta;
	private $tags = [];
	private $url;

	/**
	 * Post constructor.
	 *
	 * @param array $data Post data as received from Medium json feed
	 */
	public function __construct( $data ) {
		// Parse most important data
		$this->title       = $data['title']['rendered'] ?? null;
		$this->subtitle    = $data['excerpt']['rendered'] ?? null;
		$this->publishedAt = $data['date'] ?? null;
		$this->meta        = [
			'wordCount'   => $data['virtuals']['wordCount'] ?? null,
			'imageCount'  => $data['virtuals']['imageCount'] ?? null,
			'readingTime' => $data['virtuals']['readingTime'] ?? null,
		];
		/*// Get tags
		foreach ( $data['virtuals']['tags'] as $tag ) {
			$this->tags[] = $tag['name'];
		}*/
		$this->url          = $data['link'];
		$this->previewImage = $data['_embedded']['wp:featuredmedia'][0]['source_url'];
	}

	/**
	 * Returns all available data of the medium post in an array
	 * @return array
	 */
	public function toArray() {
		return [
			'title'        => $this->getTitle(),
			'subtitle'     => $this->getSubtitle(),
			'publishedAt'  => $this->getPublishedAt(),
			'previewImage' => $this->getPreviewImage(),
			'meta'         => $this->getMeta(),
			'tags'         => $this->getTags(),
			'url'          => $this->getUrl(),
		];
	}

	/**
	 * @return mixed|null
	 */
	public function getTitle() {
		return html_entity_decode( $this->title );
	}

	/**
	 * @return null
	 */
	public function getSubtitle() {
		return html_entity_decode( $this->subtitle );
	}

	/**
	 * @return mixed|null
	 */
	public function getPublishedAt() {
		$timestamp = $this->publishedAt;

		return strtotime( $timestamp );
	}

	/**
	 *
	 * @return string Image url
	 */
	public function getPreviewImage() {

		return $this->previewImage;
	}

	/**
	 * @return array
	 */
	public function getMeta(): array {
		return $this->meta;
	}

	/**
	 * @return array
	 */
	public function getTags(): array {
		return $this->tags;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}

}