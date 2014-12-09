<?php namespace Orchestra\Story\Parsers;

use ParsedownExtra;

class Markdown extends Parser
{
    /**
     * {@inheritdoc}
     */
    protected function initiate()
    {
        $this->parser = new ParsedownExtra;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        return $this->parser->text($content);
    }
}
