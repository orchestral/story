<?php namespace Orchestra\Story\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Content extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'story_contents';

	/**
	 * Available format type.
	 */
	const FORMAT_MARKDOWN = 'markdown';
	const FORMAT_HTML = 'html';

	/**
	 * Available status type.
	 */
	const STATUS_DRAFT = 'draft';
	const STATUS_PUBLISH = 'publish';
	const STATUS_PRIVATE = 'private';

	/**
	 * Available type.
	 */
	const POST = 'post';
	const PAGE = 'page'; 

	/**
	 * Query scope for pages.
	 *
	 * @access public
	 * @return void
	 */
	public function scopePage($query)
	{
		$query->where('type', '=', self::PAGE);
	}

	/**
	 * Query scope for posts.
	 *
	 * @access public
	 * @return void
	 */
	public function scopePost($query)
	{
		$query->where('type', '=', self::POST);
	}

	/**
	 * Query scope for published.
	 *
	 * @access public
	 * @return void
	 */
	public function scopePublish($query)
	{
		$query->where('status', '=', self::STATUS_PUBLISH);
	}
}
