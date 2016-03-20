<?php

namespace Orchestra\Story\Parsers;

class Plain extends Parser
{
    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        return $content;
    }
}
