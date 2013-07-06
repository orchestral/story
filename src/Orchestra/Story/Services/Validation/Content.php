<?php namespace Orchestra\Story\Services\Validation;

use Orchestra\Support\Validator;

class Content extends Validator {

	protected $rules = array(
		'title'   => array('required'),
		'slug'    => array('required'),
		'content' => array('required'),
	);
}
