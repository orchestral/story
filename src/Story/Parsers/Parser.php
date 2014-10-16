<?php namespace Orchestra\Story\Parsers;

use Illuminate\Contracts\Foundation\Application;

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
     * @var Object
     */
    protected $parser;

    /**
     * Create a new instance of Storytelling.
     *
     * @param  \Illuminate\Contracts\Foundation\Application   $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->initiate();
    }

    /**
     * Initiate a the parser.
     *
     * @return void
     */
    abstract protected function initiate();

    /**
     * Parse the content.
     *
     * @param  string   $content
     * @return string
     */
    abstract public function parse($content);
}
