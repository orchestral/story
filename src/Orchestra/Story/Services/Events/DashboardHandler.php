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

		$pane->add('story-latest-posts')
			->html('foo'); //View::make('orchestra/story::widgets.latest-posts')->with('posts', $posts));
	}
}
