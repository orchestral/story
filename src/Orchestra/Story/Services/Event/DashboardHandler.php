<?php namespace Orchestra\Story\Services\Event;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Widget;
use Orchestra\Story\Model\Content;

class DashboardHandler {
	
	/**
	 * Handle pane for dashboard page.
	 *
	 * @return void
	 */
	public function onDashboardView()
	{
		$pane = Widget::make('pane.orchestra');

		$posts = Content::post()->publish()->latest(10)->get();

		if ($posts->isEmpty()) return;

		$pane->add('story-latest-posts')
			->attributes(array('class' => 'six columns widget'))
			->title('Latest Post')
			->content(View::make('orchestra/story::widgets.latest-posts')->with('posts', $posts));
	}
}
