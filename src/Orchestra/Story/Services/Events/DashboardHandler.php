<?php namespace Orchestra\Story\Services\Events;

use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Widget;
use Orchestra\Story\Model\Content;

class DashboardHandler {
	
	/**
	 * Handle pane for dashboard page.
	 *
	 * @access public
	 * @return void
	 */
	public function onDashboardView()
	{
		$pane = Widget::make('pane.orchestra');

		$posts = Content::post()->publish()->latest(10)->get();

		if ($posts->isEmpty()) return;

		$pane->add('story-latest-posts')
			->attributes(array('class' => 'col col-lg-6 widget'))
			->title('Latest Post')
			->content(View::make('orchestra/story::widgets.latest-posts')->with('posts', $posts));
	}
}
