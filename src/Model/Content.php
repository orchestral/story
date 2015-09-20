<?php namespace Orchestra\Story\Model;

use Orchestra\Story\Facades\Story;
use Illuminate\Support\Facades\Config;
use Orchestra\Story\Facades\StoryFormat;
use Illuminate\Database\Eloquent\Model as Eloquent;

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
        return array_merge(parent::getDates(), [static::PUBLISHED_AT]);
    }

    /**
     * Belongs to relationship with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Config::get('auth.model', 'User'), 'user_id');
    }

    /**
     * Query scope for pages.
     *
     * @param  object   $query
     *
     * @return void
     */
    public function scopePage($query)
    {
        $query->with('author')->where('type', '=', self::PAGE);
    }

    /**
     * Query scope for posts.
     *
     * @param  object   $query
     *
     * @return void
     */
    public function scopePost($query)
    {
        $query->with('author')->where('type', '=', self::POST);
    }

    /**
     * Query scope for published.
     *
     * @param  object   $query
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
     * @param  object   $query
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
     * @param  object       $query
     * @param  string|null  $orderBy
     * @param  int|null     $take
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
     * @param  object     $query
     * @param  int|null   $take
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
     * Accessor for parsed excerpt.
     *
     * @return string
     */
    public function getExcerptAttribute()
    {
        $value  = $this->getAttribute('content');
        $format = $this->attributes['format'];

        list($excerpt, ) = explode('<!--more-->', $value, 2);

        return StoryFormat::driver($format)->parse($excerpt);
    }

    /**
     * Accessor for parsed content.
     *
     * @return string
     */
    public function getBodyAttribute()
    {
        $value  = $this->getAttribute('content');
        $format = $this->attributes['format'];

        return StoryFormat::driver($format)->parse($value);
    }

    /**
     * Accessor for link.
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        return $this->url();
    }

    /**
     * Accessor for link.
     *
     * @return string
     */
    public function url()
    {
        $type = $this->attributes['type'];

        return Story::permalink($type, $this);
    }

    public function editUrl()
    {
        $id   = $this->getKey();
        $type = $this->attributes['type'];

        return handles("orchestra::storycms/{$type}s/{$id}/edit");
    }

    public function deleteUrl()
    {
        $id   = $this->getKey();
        $type = $this->attributes['type'];

        return handles("orchestra::storycms/{$type}s/{$id}/edit");
    }

    public static function newPostInstance()
    {
        $model = new static();
        $model->setAttribute('type', static::POST);

        return $model;
    }

    public static function newPageInstance()
    {
        $model = new static();
        $model->setAttribute('type', static::PAGE);

        return $model;
    }
}
