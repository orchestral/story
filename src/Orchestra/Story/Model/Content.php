<?php namespace Orchestra\Story\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;

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
	 * Get the attributes that should be converted to dates.
	 *
	 * @return array
	 */
	public function getDates()
	{
		return array(static::CREATED_AT, static::UPDATED_AT, static::DELETED_AT, 'published_at');
	} 

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

	/**
	 * Query scope for published.
	 *
	 * @access public
	 * @return void
	 */
	public function scopeLatest($query, $take)
	{
		if (is_int($take) and $take > 0) $query->take($take);

		$query->orderBy('published_at', 'DESC');
	}

	/**
	 * Accessor for link.
	 *
	 * @access public
	 * @return void
	 */
	public function getLinkAttribute($value)
	{
		$id   = $this->attributes['id'];
		$slug = $this->attributes['slug'];
		$type = $this->attributes['type'];

		if ($permalink = Config::get("orchestra/story::permalink.{$type}", false))
		{
			$string  = array('{id}', '{slug}');
			$replace = array($id, $slug); 
			return handles(str_replace($string, $replace, "orchestra/story::{$permalink}"));
		}
	}
}
