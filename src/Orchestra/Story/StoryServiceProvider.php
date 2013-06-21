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
		$this->registerStoryTeller();
		$this->registerFormatManager();
	}

	/**
	 * Register service provider.
	 *
	 * @return void
	 */
	protected function registerStoryTeller()
	{
		$this->app['orchestra.story'] = $this->app->share(function ($app)
		{
			return new Storyteller($this->app);
		});
	}

	/**
	 * Register service provider.
	 *
	 * @return void
	 */
	protected function registerFormatManager()
	{
		$this->app['orchestra.story.format'] = $this->app->share(function ($app)
		{
			return new FormatManager($this->app);
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
