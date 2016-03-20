<?php

namespace Orchestra\Story\Parsers;

use ParsedownExtra;

class Markdown extends Parser
{
    /**
     * Initiate parser.
     *
     * @param  \ParsedownExtra  $parser
     *
     * @return void
     */
    public function initiate(ParsedownExtra $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        return $this->parser->text($content);
    }
}
