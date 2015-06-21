<?php namespace Orchestra\Story\Listeners;

class AddValidationRules
{
    /**
     * Handle event.
     *
     * @param  object  $rules
     * @return void
     */
    public function handle(& $rules)
    {
        $rules['page_permalink'] = ['required'];
        $rules['post_permalink'] = ['required'];
    }
}
