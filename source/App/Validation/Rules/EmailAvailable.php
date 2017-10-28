<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 15:11
 */

namespace App\Validation\Rules;


use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule {

	public function validate( $input ) {
		return User::where('email', $input)->count() === 0;
	}

}