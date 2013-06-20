<?php namespace Orchestra\Story;

use Illuminate\Support\ServiceProvider;

class StoryServiceProvider extends ServiceProvider {

	/**
	 * Register service provider.
	 *
	 * @return void
	 */
	public function register() 
	{
		$this->app['orchestra.story'] = $this->app->share(function ($app)
		{
			return new Storyteller($this->app);
		});
	}

	/**
	 * Boot the service provider
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('orchestra/story', 'orchestra/story');
	}
}
