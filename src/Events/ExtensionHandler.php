<?php namespace Orchestra\Story\Events;

use Orchestra\Story\Model\Content;
use Orchestra\Story\Facades\StoryFormat;

class ExtensionHandler
{
    /**
     * Handle on form view.
     *
     * @param  \Illuminate\Support\Fluent  $model
     * @param  \Orchestra\Html\Form\FormBuilder  $form
     *
     * @return void
     */
    public function onFormView($model, $form)
    {
        $form->extend(function ($form) use ($model) {
            $form->fieldset('Page Management', function ($fieldset) {
                $fieldset->control('select', 'default_format', function ($control) {
                    $control->label('Default Format');
                    $control->options(StoryFormat::getParsers());
                });

                $fieldset->control('select', 'default_page', function ($control) {
                    $pages = array_merge(
                        ['_posts_' => 'Display Posts'],
                        Content::page()->publish()->lists('title', 'slug')
                    );
                    $control->label('Default Page');
                    $control->options($pages);
                });

                $fieldset->control('text', 'Page Permalink', 'page_permalink');
                $fieldset->control('text', 'Post Permalink', 'post_permalink');
            });
        });
    }
}
