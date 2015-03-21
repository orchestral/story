<?php namespace Orchestra\Story\Composers;

use Orchestra\Story\Model\Content;
use Orchestra\Widget\WidgetManager;

class Dashboard
{
    /**
     * Handle pane for dashboard page.
     *
     * @param  \Orchestra\Widget\WidgetManager  $widget
     *
     * @return void
     */
    public function compose(WidgetManager $widget)
    {
        $pane = $widget->make('pane.orchestra');

        $posts = Content::post()->publish()->latest(10)->get();

        if ($posts->isEmpty()) {
            return;
        }

        $pane->add('story-latest-posts')
            ->attributes(['class' => 'six columns widget'])
            ->title('Latest Post')
            ->content(view('orchestra/story::widgets.latest-posts')->with('posts', $posts));
    }
}
