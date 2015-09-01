<?php namespace Orchestra\Story\Listeners;

use Illuminate\Support\Fluent;

class AddValidationRules
{
    /**
     * Handle event.
     *
     * @param  \Illuminate\Support\Fluent  $rules
     *
     * @return void
     */
    public function handle(Fluent $rules)
    {
        $rules['page_permalink'] = ['required'];
        $rules['post_permalink'] = ['required'];
    }
}
