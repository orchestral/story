<?php namespace Orchestra\Story\Parsers;

class Plain extends Parser {

	/**
	 * Initiate a the parser.
	 *
	 * @access protected
	 * @return void
	 */
	protected function initiate() {}

	/**
	 * Initiate a the parser.
	 *
	 * @access public
	 * @param  string   $content
	 * @return void
	 */
	public function parse($content)
	{
		return $content;
	}
}
