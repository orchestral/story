<?php namespace Orchestra\Story\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;
use Orchestra\Story\Facades\Story;
use Orchestra\Story\Facades\StoryFormat;

class Navigation extends Eloquent
{

	public function __construct()
	{
		parent::__construct();
	}
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navigation_links';

    /**
     * Belongs to relationship with group.
     */
    public function navigationGroup()
    {
        return $this->belongsTo('Orchestra\\Story\\Model\\NavigationGroup','navigation_group_id');
    }

}
