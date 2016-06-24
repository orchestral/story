<?php

namespace Orchestra\Story;

use Orchestra\Story\Composers\Dashboard;
use Orchestra\Story\Listeners\AttachMarkdownEditor;
use Orchestra\Story\Http\Middleware\SetEditorFormat;
use Orchestra\Foundation\Support\Providers\ModuleServiceProvider;

class StoryServiceProvider extends ModuleServiceProvider
{
    /**
     * The application or extension namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Orchestra\Story\Http\Controllers';

    /**
     * The application or extension group namespace.
     *
     * @var string|null
     */
    protected $routeGroup = 'orchestra/story';

    /**
     * The fallback route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'cms';

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'orchestra.story.editor: markdown' => [AttachMarkdownEditor::class],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'orchestra.story.editor' => SetEditorFormat::class,
    ];

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
        $this->app->singleton('orchestra.story', function ($app) {
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
        $this->app->singleton('orchestra.story.format', function ($app) {
            return new FormatManager($app);
        });
    }

    /**
     * Boot extension components.
     *
     * @return void
     */
    protected function bootExtensionComponents()
    {
        $path = realpath(__DIR__.'/../resources');

        $acl    = $this->app->make('orchestra.acl');
        $memory = $this->app->make('orchestra.platform.memory');
        $view   = $this->app->make('view');

        $acl->make('orchestra/story')->attach($memory);
        $view->composer('orchestra/foundation::dashboard.index', Dashboard::class);

        $this->addConfigComponent('orchestra/story', 'orchestra/story', "{$path}/config");
        $this->addViewComponent('orchestra/story', 'orchestra/story', "{$path}/views");

        $this->loadMigrationsFrom([
            "{$path}/database/migrations",
        ]);
    }

    /**
     * Boot extension routing.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $path = realpath(__DIR__);

        $this->loadFrontendRoutesFrom("{$path}/Http/frontend.php");
        $this->loadBackendRoutesFrom("{$path}/Http/backend.php", "{$this->namespace}\Admin");
    }
}
