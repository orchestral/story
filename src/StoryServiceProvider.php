<?php namespace Orchestra\Story;

use Orchestra\Support\Providers\ServiceProvider;

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
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../');

        $this->bootExtensionComponents($path);

        $this->mapExtensionConfig();

        $this->bootExtensionEvents();

        $this->bootExtensionWidgets();

        $this->bootExtensionRouting($path);

        $this->bootExtensionMenuEvents();
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
        $this->addConfigComponent('orchestra/story', 'orchestra/story', $path.'/resources/config');
        $this->addViewComponent('orchestra/story', 'orchestra/story', $path.'/resources/views');
    }

    /**
     * Boot extension events.
     *
     * @return void
     */
    protected function bootExtensionEvents()
    {
        $app = $this->app;

        $app['orchestra.acl']->make('orchestra/story')->attach($this->app['orchestra.platform.memory']);

        $app['events']->listen(
            'orchestra.form: extension.orchestra/story',
            'Orchestra\Story\Event\ExtensionHandler@onFormView'
        );

        $app['events']->listen('orchestra.validate: extension.orchestra/story', function (& $rules) {
            $rules['page_permalink'] = ['required'];
            $rules['post_permalink'] = ['required'];
        });

        $app['events']->listen('orchestra.story.editor: markdown', function () use ($app) {
            $asset = $app['orchestra.asset']->container('orchestra/foundation::footer');

            $asset->script('editor', 'packages/orchestra/story/vendor/editor/editor.js');
            $asset->style('editor', 'packages/orchestra/story/vendor/editor/editor.css');
            $asset->script('storycms', 'packages/orchestra/story/js/storycms.min.js');
            $asset->script('storycms.md', 'packages/orchestra/story/js/markdown.min.js', ['editor']);
        });
    }

    /**
     * Boot extension widgets.
     *
     * @return void
     */
    protected function bootExtensionWidgets()
    {
        $app = $this->app;

        $app['view']->composer(
            'orchestra/foundation::dashboard.index',
            'Orchestra\Story\Event\DashboardHandler@onDashboardView'
        );

        $app['events']->listen('orchestra.form: extension.orchestra/story', function () use ($app) {
            $placeholder = $app['orchestra.widget']->make('placeholder.orchestra.extensions');

            $placeholder->add('permalink')->value(view('orchestra/story::widgets.help'));
        });
    }

    /**
     * Boot extension menu handler.
     *
     * @return void
     */
    protected function bootExtensionMenuEvents()
    {
        $this->app['events']->listen('orchestra.ready: admin', 'Orchestra\Story\Http\Handlers\StoryMenuHandler');
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
        $this->app['router']->filter('orchestra.story.can', 'Orchestra\Story\Http\Filters\CanManage');
        $this->app['router']->filter('orchestra.story.editor', 'Orchestra\Story\Http\Filters\SetEditorFormat');

        include "{$path}/src/routes.php";
    }

    /**
     * Map extension config.
     *
     * @return void
     */
    protected function mapExtensionConfig()
    {
        $this->app['orchestra.extension.config']->map('orchestra/story', [
            'default_format' => 'orchestra/story::config.default_format',
            'default_page'   => 'orchestra/story::config.default_page',
            'per_page'       => 'orchestra/story::config.per_page',
            'page_permalink' => 'orchestra/story::config.permalink.page',
            'post_permalink' => 'orchestra/story::config.permalink.post',
        ]);
    }
}
