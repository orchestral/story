<?php namespace Orchestra\Story;

use Illuminate\Support\ServiceProvider;

class StoryServiceProvider extends ServiceProvider
{
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
        $this->app->bindShared('orchestra.story', function ($app) {
            return new Storyteller($app);
        });
    }

    /**
     * Register service provider.
     *
     * @return void
     */
    protected function registerFormatManager()
    {
        $this->app->bindShared('orchestra.story.format', function ($app) {
            return new FormatManager($app);
        });
    }

    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../');

        $this->package('orchestra/story', 'orchestra/story', $path);

        include "{$path}/start/global.php";
        include "{$path}/start/events.php";
        include "{$path}/filters.php";
        include "{$path}/resources.php";

        if (! $this->app->routesAreCached()) {
            include "{$path}/routes.php";
        }
    }
}
