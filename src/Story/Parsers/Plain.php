<?php namespace Orchestra\Story\Parsers;

class Plain extends Parser
{
    /**
     * {@inheritdoc}
     */
    protected function initiate()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        return $content;
    }
}
