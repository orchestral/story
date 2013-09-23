<?php namespace Orchestra\Story\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;
use Orchestra\Story\Facades\Story;
use Orchestra\Story\Facades\StoryFormat;

class Content extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'story_contents';

	/**
	 * Available status type.
	 */
	const STATUS_DRAFT   = 'draft';
	const STATUS_PUBLISH = 'publish';
	const STATUS_PRIVATE = 'private';

	/**
	 * Available type.
	 */
	const POST = 'post';
	const PAGE = 'page';

	/**
	 * Dates constant.
	 */
	const PUBLISHED_AT = 'published_at';

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = array('published_at');

	/**
	 * Belongs to relationship with User.
	 */
	public function author()
	{
		return $this->belongsTo(Config::get('auth.model', 'User'), 'user_id');
	}

	/**
	 * Query scope for pages.
	 *
	 * @return void
	 */
	public function scopePage($query)
	{
		$query->where('type', '=', self::PAGE);
	}

	/**
	 * Query scope for posts.
	 *
	 * @return void
	 */
	public function scopePost($query)
	{
		$query->where('type', '=', self::POST);
	}

	/**
	 * Query scope for published.
	 *
	 * @return void
	 */
	public function scopePublish($query)
	{
		$query->where('status', '=', self::STATUS_PUBLISH);
	}

	/**
	 * Query scope for latest published.
	 *
	 * @return void
	 */
	public function scopeLatestPublish($query)
	{
		$query->latest()->publish();
	}

	/**
	 * Query scope for latest by specified field.
	 *
	 * @return void
	 */
	public function scopeLatestBy($query, $orderBy = null, $take = null)
	{
		if (is_null($orderBy)) $orderBy = static::PUBLISHED_AT;
		if (is_int($take) and $take > 0) $query->take($take);

		$query->orderBy($orderBy, 'DESC');
	}

	/**
	 * Query scope for latest published.
	 *
	 * @return void
	 */
	public function scopeLatest($query, $take = null)
	{
		if (is_int($take) and $take > 0) $query->take($take);

		$query->latestBy(static::PUBLISHED_AT, 'DESC');
	}

	/**
	 * Accessor for content.
	 *
	 * @return void
	 */
	public function getContentAttribute($value)
	{
		return stripslashes($value);
	}

	/**
	 * Accessor for parsed content.
	 *
	 * @return void
	 */
	public function getBodyAttribute($value)
	{
		$value  = $this->getAttribute('content');
		$format = $this->attributes['format'];

		return StoryFormat::driver($format)->parse($value);
	}

	/**
	 * Accessor for link.
	 *
	 * @param  mixed   $value
	 * @return void
	 */
	public function getLinkAttribute($value)
	{
		$type = $this->attributes['type'];
		
		return Story::permalink($type, $this);
	}
}
