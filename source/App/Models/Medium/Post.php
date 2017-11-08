<?php

namespace App\Models\Medium;

class Post {

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
		$this->title       = $data['title'] ?? null;
		$this->subtitle    = $data['content']['subtitle'] ?? null;
		$this->publishedAt = $data['latestPublishedAt'] ?? null;
		$this->meta        = [
			'wordCount'   => $data['virtuals']['wordCount'] ?? null,
			'imageCount'  => $data['virtuals']['imageCount'] ?? null,
			'readingTime' => $data['virtuals']['readingTime'] ?? null,
		];
		// Get tags
		foreach ( $data['virtuals']['tags'] as $tag ) {
			$this->tags[] = $tag['name'];
		}
		$this->url          = 'https://medium.com/' . $data['user'] . '/' . $data['uniqueSlug'];
		$this->previewImage = $data['virtuals']['previewImage']['imageId'];
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
		return $this->title;
	}

	/**
	 * @return null
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * @return mixed|null
	 */
	public function getPublishedAt() {
		return $this->publishedAt;
	}

	/**
	 * @param int $width Required image width
	 *
	 * @return string Image url
	 */
	public function getPreviewImage( $width = 800 ) {
		$size = $width . '/';

		return 'https://cdn-images-1.medium.com/max/' . $size . $this->previewImage;
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