<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SRLabs\EloquentSTI\SingleTableInheritanceTrait;

/**
 * Abstract Item class
 * Class AbstractItem
 * @package App\Models
 */
class AbstractItem extends Model {

	/*****************************************************************************
	 *  Eloquent Configuration
	 *****************************************************************************/

	//protected $guarded  = [ 'id' ];
	//protected $fillable = [ 'name', 'description', 'status' ];
	protected $appends   = [ 'picture', 'thumbnail' ];
	public    $picture   = false;
	public    $thumbnail = false;

	/*****************************************************************************
	 * Single Table Inheritance Configuration
	 *****************************************************************************/

	use SingleTableInheritanceTrait;
	protected $table               = 'items';
	protected $morphClass          = 'App\Models\AbstractItem';
	protected $discriminatorColumn = 'item_type_id';
	protected $inheritanceMap      = [
		'1' => 'App\Models\Items\Association',
		'2' => 'App\Models\Items\Photo',
		'4' => 'App\Models\Items\Project',
		'5' => 'App\Models\Items\School',
		'3' => 'App\Models\Items\Video',
	];


	/**
	 * Get the marker that is assigned to that item.
	 */
	public function marker()
	{
		return $this->belongsTo('App\Models\MapMarker');
	}

	/**
	 * Returns the picture for this item
	 * @return string
	 */
	public function getPictureAttribute() {

		if ( $this->picture ) {
			return $this->picture;
		}

		$meta_data = json_decode( $this->meta_data );
		if ( isset( $meta_data->url ) ) {
			$this->setPictureAttribute( $meta_data->url );

			return $this->picture;
		} else if ( isset( $meta_data->url_original ) && is_object( $meta_data->url_original ) ) {

			$this->setPictureAttribute( $meta_data->url_original->url );

			return $this->picture;
		} else if ( isset( $meta_data->files ) && is_array( $meta_data->files ) && count($meta_data->files) > 0 ) {

			$this->setPictureAttribute( $meta_data->files[0]->url );

			return $this->picture;
		}

		return $this->picture;
	}

	/**
	 * @param mixed $picture
	 */
	public function setPictureAttribute( $picture ) {
		$this->picture = $picture;
	}

	/**
	 * Returns the thumbnail for this item
	 * @return string
	 */
	public function getThumbnailAttribute() {

		if ( $this->thumbnail ) {
			return $this->thumbnail;
		}

		$meta_data = json_decode( $this->meta_data );
		if ( isset( $meta_data->photo_url_xs ) ) {
			$this->setThumbnailAttribute( $meta_data->photo_url_xs );

			return $this->thumbnail;
		} else if ( isset( $meta_data->url_thumbnail ) && is_object( $meta_data->url_thumbnail ) ) {
			$this->setThumbnailAttribute( $meta_data->url_thumbnail );

			return $this->thumbnail;
		} if ( isset( $meta_data->files ) && is_array( $meta_data->files ) && count($meta_data->files) > 0 ) {

			$this->setPictureAttribute( $meta_data->files[0]->url_thumbnail );

			return $this->picture;
		}

		if ( ! $this->thumbnail ) {
			$this->thumbnail = $this->getPictureAttribute();
		}

		return $this->thumbnail;
	}

	/**
	 * @param mixed $thumbnail
	 */
	public function setThumbnailAttribute( $thumbnail ) {
		$this->thumbnail = $thumbnail;
	}

}