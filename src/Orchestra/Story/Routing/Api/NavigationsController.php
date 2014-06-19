<?php namespace Orchestra\Story\Routing\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Orchestra\Support\Facades\Messages;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;
use Orchestra\Story\Model\Navigation;
use Orchestra\Story\Model\NavigationGroup;
use Orchestra\Story\Validation\Navigation as NavigationValidator;

class NavigationsController extends Controller
{
    /**
     * Current Resource.
     *
     * @var string
     */
    protected $resource;

    /**
     * Validation instance.
     *
     * @var object
     */
    protected $validator = null;

    /**
     * Content CRUD Controller.
     *
     * @param \Orchestra\Story\Validation\Content  $validator
     */
    public function __construct(NavigationValidator $validator)
    {
        //parent::__construct();

        $this->validator = $validator;
    }

    /**
     * Define filters for current controller.
     *
     * @return void
     */
    public function setupFilters()
    {
        parent::setupFilters();

        $this->resource = 'storycms.navigations';
        $this->beforeFilter('orchestra.story:create-navigation', array(
            'only' => array('create', 'store'),
        ));

        $this->beforeFilter('orchestra.story:update-navigation', array(
            'only' => array('edit', 'update'),
        ));

        $this->beforeFilter('orchestra.story:delete-navigation', array(
            'only' => array('delete', 'destroy'),
        ));

        $this->beforeFilter('orchestra.story:creategroup-navigation', array(
            'only' => array('creategroup', 'storegroup'),
        ));

        $this->beforeFilter('orchestra.story:updategroup-navigation', array(
            'only' => array('editgroup', 'updategroup'),
        ));

        $this->beforeFilter('orchestra.story:deletegroup-navigation', array(
            'only' => array('deletegroup', 'destroygroup'),
        ));
    }

    /**
     * List all the navigations.
     *
     * @return Response
     */
    public function index()
    {
        $contents = NavigationGroup::all();
        $type     = 'navigation';

        Site::set('title', 'List of Navigations');

        return View::make('orchestra/story::api.navigation.index', compact('contents', 'type'));
    }

    /**
     * Write a navigation.
     *
     * @return Response
     */
    public function create($group_id = 0)
    {
        Site::set('title', 'Write a Navigation');

        $navigation         = new Navigation;
        $navigation->type   = 'navigation';
        $navigations = Navigation::all();
        $pageList = Content::lists('title', 'id');
        $navList = Navigation::where('navigation_group_id', '=', $group_id)->lists('title', 'id');
        $navigationGroupList = NavigationGroup::lists('title', 'id');

        return View::make('orchestra/story::api.navigation.editor', array(
            'navigation' => $navigation,
            'url'     => resources('storycms.navigations'),
            'method'  => 'POST',
            'pageList' => $pageList,
            'navList' => $navList,
            'navigations' => $navigations,
            'navigationGroupList' => $navigationGroupList,
            'navigation_group_id' => $group_id
        ));
    }

    public function creategroup()
    {
        echo "group creation";
    }
    /**
     * Edit a navigation.
     *
     * @return Response
     */
    public function edit($id = null)
    {
        Site::set('title', 'Write a Navigation');

        $navigation = Navigation::find($id);
        $pageList = Content::lists('title', 'id');
        $navList = Navigation::where('navigation_group_id', '=', $navigation->navigation_group_id)->lists('title', 'id');
        $navigationGroupList = NavigationGroup::lists('title', 'id');

        return View::make('orchestra/story::api.navigation.editor', array(
            'navigation' => $navigation,
            'url'     => resources("storycms.navigations/{$navigation->id}"),
            'method'  => 'PUT',
            'pageList' => $pageList,
            'navList' => $navList,
            'navigationGroupList' => $navigationGroupList,
            'navigation_group_id' => $navigation->navigation_group_id
        ));
    }

    /**
     * Store a navigation.
     *
     * @return Response
     */
    protected function store()
    {
        $validation = $this->validate();
        if ($validation->fails()) {
            return Redirect::to(resources("storycms.navigations/".Input::get('navigation_group_id')."/create"))
                ->withInput()->withErrors($validation);
        }

        $navigation          = new Navigation;
        $navigation->title = Input::get( 'title' );
        $navigation->link_type = Input::get( 'link_type' );
        $navigation->parent = (int)Input::get( 'parent' );
        $navigation->page_id = Input::get( 'page_id' );
        $navigation->url = Input::get( 'url' );
        $navigation->uri = Input::get( 'uri' );
        $navigation->navigation_group_id = Input::get( 'navigation_group_id' );
        $navigation->position = (int)Input::get( 'position' );
        $navigation->target = Input::get( 'target' );
        $navigation->class = Input::get( 'class' );

        $navigation->save();

        Messages::add('success', 'Navigation has been created.');
        return Redirect::to(resources("storycms.navigations/{$navigation->id}/edit"));
    }

    /**
     * Update a navigation.
     *
     * @access protected
     * @return Response
     */
    protected function update($id)
    {
        $validation = $this->validate();
        if ($validation->fails()) {
            return Redirect::to(resources("storycms.navigations/".$id."/edit"))
                ->withInput()->withErrors($validation);
        }

        $navigation = Navigation::find($id);
        $navigation->title = Input::get( 'title' );
        $navigation->link_type = Input::get( 'link_type' );
        $navigation->parent = (int)Input::get( 'parent' );
        $navigation->page_id = Input::get( 'page_id' );
        $navigation->url = Input::get( 'url' );
        $navigation->uri = Input::get( 'uri' );
        $navigation->navigation_group_id = Input::get( 'navigation_group_id' );
        $navigation->position = (int)Input::get( 'position' );
        $navigation->target = Input::get( 'target' );
        $navigation->class = Input::get( 'class' );

        $navigation->save();
        Messages::add('success', 'Navigation has been updated.');
        return Redirect::to(resources("storycms.navigations/{$navigation->id}/edit"));
    }

    protected function validate()
    {
        $input         = Input::all();

        $rules = array(
            'title'   => 'required|min:3',
            'link_type' => 'required',
            'target' => 'required',
            'url' => 'url'
        );
        if($link_type = Input::get('link_type'))
        {
            $link_field = ($link_type == 'page') ? 'page_id' : $link_type;
            $rules[$link_field] = 'required';
        }
        return $validation = Validator::make($input, $rules);
    }
    /**
     * Delete a content.
     *
     * @return Response
     */
    public function delete($id = null)
    {
        return $this->destroy($id);
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    public function destroy($id)
    {
        $content = Navigation::findOrFail($id);

        return call_user_func(array($this, 'destroyCallback'), $content);
    }
    /**
     * Delete a navigation.
     *
     * @access protected
     * @return Response
     */
    protected function destroyCallback($content)
    {
        $content->delete();

        Messages::add('success', 'Navigation has been deleted.');

        return Redirect::to(resources('storycms.navigations'));
    }

    public function ajaxGroup(){
        if (Request::ajax())
        {
            echo $group = Input::post('group_id');exit;
        }
        echo "non ajax";exit;
    }
}
