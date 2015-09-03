<?php namespace Orchestra\Story;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use Orchestra\Story\Composers\Dashboard;
use Orchestra\Story\Listeners\AttachForm;
use Orchestra\Story\Listeners\AddPlaceholder;
use Orchestra\Story\Http\Middleware\CanManage;
use Orchestra\Support\Providers\ServiceProvider;
use Orchestra\Story\Listeners\AddValidationRules;
use Orchestra\Story\Http\Handlers\StoryMenuHandler;
use Orchestra\Story\Listeners\AttachMarkdownEditor;
use Orchestra\Story\Http\Middleware\SetEditorFormat;
use Orchestra\Support\Providers\Traits\EventProviderTrait;
use Orchestra\Support\Providers\Traits\MiddlewareProviderTrait;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class StoryServiceProvider extends ServiceProvider
{
    use EventProviderTrait, MiddlewareProviderTrait;

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'orchestra.story.editor: markdown' => [AttachMarkdownEditor::class],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'orchestra.story.can'    => CanManage::class,
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
     * Boot the service provider.
     *
     *
     * @param  \Illuminate\Routing\Router  $router
     * @param  \Illuminate\Contracts\Http\Kernel  $kernel
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     *
     * @return void
     */
    public function boot(Router $router, Kernel $kernel, DispatcherContract $events)
    {
        $path = realpath(__DIR__.'/../');

        $this->registerRouteMiddleware($router, $kernel);
        $this->registerEventListeners($events);

        $this->bootExtensionComponents($path);
        $this->bootExtensionRouting($path);
    }

    /**
     * Boot extension components.
     *
     * @param  string  $path
     *
     * @return void
     */
    protected function bootExtensionComponents($path)
    {
        $acl    = $this->app->make('orchestra.acl');
        $memory = $this->app->make('orchestra.platform.memory');
        $view   = $this->app->make('view');

        $acl->make('orchestra/story')->attach($memory);
        $view->composer('orchestra/foundation::dashboard.index', Dashboard::class);

        $this->addConfigComponent('orchestra/story', 'orchestra/story', "{$path}/resources/config");
        $this->addViewComponent('orchestra/story', 'orchestra/story', "{$path}/resources/views");
    }

    /**
     * Boot extension routing.
     *
     * @param  string  $path
     *
     * @return void
     */
    protected function bootExtensionRouting($path)
    {
        include "{$path}/src/routes.php";
    }
}
