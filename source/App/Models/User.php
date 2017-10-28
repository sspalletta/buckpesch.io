<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SRLabs\EloquentSTI\SingleTableInheritanceTrait;

/**
 * Abstract Item class
 * Class AbstractItem
 * @package App\Models
 */
class User extends Model {

	/*****************************************************************************
	 *  Eloquent Configuration
	 *****************************************************************************/

	protected $table = 'user'; // This will happen automatically, if the table is called users
	protected $primaryKey = 'uid'; // ID column, required if it differs from 'id'

	//protected $guarded  = [ 'id' ];
	//protected $fillable = [ 'name', 'description', 'status' ]; // All coulumns which can be written to
	//protected $appends = ['picture', 'thumbnail'];



}