<?php
/**
 * Created by PhpStorm.
 * User: s.buckpesch
 * Date: 20.09.2016
 * Time: 16:07
 */

namespace App\Auth;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Auth {

	/**
	 * Checks the user credentials
	 * @param $email
	 * @param $password
	 *
	 * @return bool
	 */
	public function attempt( $email, $password ) {

		$user = User::where('email', $email)->first();
		if (!$user) {
			return false;
		}

		if (password_verify($password, $user->password)){
			$_SESSION['user'] = $user->id;
			return true;
		}

		return false;
	}

	/**
	 * Check if the user is logged in for the current app ID
	 * @return bool
	 */
	public function check( ) {
		global $am;

		return isset($_SESSION['instance_' . $am->getId()]['user']['uid']);
	}

	/**
	 * Returns the user object of the current user session
	 * @return mixed
	 */
	public function user() {
		global $am;

		return User::find($_SESSION['instance_' . $am->getId()]['user']['uid']);
	}

	public function isAdmin() {

		$user = $this->user();
		return (int)$user->getAttribute('is_admin');

	}

}