<?php namespace Orchestra\Story\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;
use Orchestra\Story\Facades\Story;
use Orchestra\Story\Facades\StoryFormat;

class Content extends Eloquent
{
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
     * Get the attributes that should be converted to dates.
     *
     * @return array
     */
    public function getDates()
    {
        return array_merge(parent::getDates(), array(static::PUBLISHED_AT));
    }

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
        if (is_null($orderBy)) {
            $orderBy = static::PUBLISHED_AT;
        }

        if (is_int($take) and $take > 0) {
            $query->take($take);
        }

        $query->orderBy($orderBy, 'DESC');
    }

    /**
     * Query scope for latest published.
     *
     * @return void
     */
    public function scopeLatest($query, $take = null)
    {
        if (is_int($take) and $take > 0) {
            $query->take($take);
        }

        $query->latestBy(static::PUBLISHED_AT, 'DESC');
    }

    /**
     * Accessor for title.
     *
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return stripslashes($value);
    }

    /**
     * Accessor for content.
     *
     * @return string
     */
    public function getContentAttribute($value)
    {
        return stripslashes($value);
    }

    /**
     * Accessor for parsed content.
     *
     * @return string
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
     * @return string
     */
    public function getLinkAttribute($value)
    {
        $type = $this->attributes['type'];

        return Story::permalink($type, $this);
    }
}
