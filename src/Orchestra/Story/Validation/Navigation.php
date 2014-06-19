<?php namespace Orchestra\Story\Validation;

use Orchestra\Support\Validator;

class Navigation extends Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = array(
        'title'   => array('required')
    );

}
