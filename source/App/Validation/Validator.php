<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Http\Request;

class Validator {

	protected $errors;

	/**
	 * @param Request $request
	 * @param array $rules
	 * @return Validator
	 */
	public function validate( $request, array $rules ) {
		foreach ( $rules as $field => $rule ) {
			try {
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			} catch (NestedValidationException $e) {
			    $this->errors[$field] = $e->getMessages();
			}
		}

		// Persist data to a session
		$_SESSION['errors'] = $this->errors;

		return $this;

	}

	public function failed(  ) {
		return !empty($this->errors);
	}

	/**
	 * @return mixed
	 */
	public function getErrors() {
		return $this->errors;
	}

}