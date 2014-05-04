<?php namespace Orchestra\Story\Parsers;

use dflydev\markdown\MarkdownExtraParser;

class Markdown extends Parser
{
    /**
     * {@inheritdoc}
     */
    protected function initiate()
    {
        $this->parser = new MarkdownExtraParser;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        return $this->parser->transformMarkdown($content);
    }
}
