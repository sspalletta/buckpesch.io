<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 15:18
 */

namespace App\Validation\Exceptions;


use Respect\Validation\Exceptions\ValidationException;

class EmailAvailableException extends ValidationException {

	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => "Email is already taken"
		]
	];

}