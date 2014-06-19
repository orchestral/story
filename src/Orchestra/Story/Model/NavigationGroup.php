<?php namespace Orchestra\Story\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;
use Orchestra\Story\Facades\Story;
use Orchestra\Story\Facades\StoryFormat;
use Orchestra\Story\Model\Navigation;

class NavigationGroup extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navigation_groups';


    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Belongs to relationship with group.
     */
    public function navigations()
    {
        return $this->hasMany('Orchestra\\Story\\Model\\Navigation','navigation_group_id');
    }


}
