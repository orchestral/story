<?php

namespace Orchestra\Story\Listeners;

use Orchestra\Asset\Factory;

class AttachMarkdownEditor
{
    /**
     * The asset factory implementation.
     *
     * @var \Orchestra\Asset\Factory
     */
    protected $asset;

    /**
     * Construct a new instance.
     *
     * @param  \Orchestra\Asset\Factory  $asset
     */
    public function __construct(Factory $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Handle event.
     *
     * @return void
     */
    public function handle()
    {
        $asset = $this->asset->container('orchestra/foundation::footer');

        $asset->script('simplemde', 'packages/orchestra/story/js/simplemde.js');
        $asset->style('simplemde', 'packages/orchestra/story/css/simplemde.css');
        $asset->script('storycms', 'packages/orchestra/story/js/story.js');
        $asset->script('storycms.md', 'packages/orchestra/story/js/markdown.js', ['simplemde']);
    }
}
