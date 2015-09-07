<?php namespace Orchestra\Story\Parsers;

abstract class Parser
{
    /**
     * Application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Parser instance.
     *
     * @var object
     */
    protected $parser;

    /**
     * Create a new instance of Storytelling.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct($app)
    {
        $this->app = $app;

        if (method_exists($this, 'initiate')) {
            $app->call([$this, 'initiate']);
        }
    }

    /**
     * Parse the content.
     *
     * @param  string   $content
     *
     * @return string
     */
    abstract public function parse($content);
}
