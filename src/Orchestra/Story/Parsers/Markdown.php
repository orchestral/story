<?php namespace Orchestra\Story\Parsers;

use dflydev\markdown\MarkdownExtraParser;

class Markdown extends Parser {

	/**
	 * Initiate a the parser.
	 *
	 * @access protected
	 * @return void
	 */
	protected function initiate()
	{
		$this->parser = new MarkdownExtraParser;
	}

	/**
	 * Initiate a the parser.
	 *
	 * @access public
	 * @param  string   $content
	 * @return void
	 */
	public function parse($content)
	{
		return $this->parser->transformMarkdown($content);
	}
}
