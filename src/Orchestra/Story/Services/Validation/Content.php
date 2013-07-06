<?php namespace Orchestra\Story\Services\Validation;

use Orchestra\Support\Validator;

class Content extends Validator {

	/**
	 * Validation rules.
	 * 
	 * @var array
	 */
	protected $rules = array(
		'title'   => array('required'),
		'slug'    => array('required'),
		'content' => array('required'),
	);

	/**
	 * On update scenario.
	 *
	 * @access protected
	 * @return voide
	 */
	protected function onUpdate()
	{
		$this->rules['slug'] = array('required', 'unique:story_contents,slug,{id}');
	}
}
