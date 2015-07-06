<?php namespace Orchestra\Story\Listeners;

use Orchestra\Widget\WidgetManager;

class AddPlaceholder
{
    /**
     * The widget manager implementation.
     *
     * @var \Orchestra\Widget\WidgetManager
     */
    protected $widget;

    /**
     * Construct a new instance.
     *
     * @param  \Orchestra\Widget\WidgetManager  $widget
     */
    public function __construct(WidgetManager $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Handle event.
     *
     * @return void
     */
    public function handle()
    {
        $placeholder = $this->widget->make('placeholder.orchestra.extensions');

        $placeholder->add('permalink')->value(view('orchestra/story::widgets.help'));
    }
}
