<?php namespace Orchestra\Story\Services\Events;

use Orchestra\Support\Facades\Form;
use Orchestra\Story\Model\Content;

class ExtensionHandler {

	/**
	 * Handle on form view.
	 *
	 * @access public							
	 * @param  \Illuminate\Support\Fluent       $model
	 * @param  \Orchestra\Html\Form\FormBuilder $form
	 * @return void
	 */
	public function onFormView($model, $form)
	{
		$form->extend(function ($form) use ($model)
		{
			$form->fieldset('Page Management', function ($fieldset)
			{
				$fieldset->control('select', 'default_page', function ($control)
				{
					$control->label('Default Page');
					$control->options(Content::page()->publish()->lists('title', 'id'));
				});
			});
		});
	}
}
