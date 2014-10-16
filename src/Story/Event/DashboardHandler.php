<?php namespace Orchestra\Story\Event;

use Orchestra\Story\Model\Content;
use Orchestra\Support\Facades\Widget;

class DashboardHandler
{
    /**
     * Handle pane for dashboard page.
     *
     * @return void
     */
    public function onDashboardView()
    {
        $pane = Widget::make('pane.orchestra');

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
