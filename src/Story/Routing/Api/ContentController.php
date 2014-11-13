<?php namespace Orchestra\Story\Routing\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Site;
use Orchestra\Story\Model\Content;
use Orchestra\Story\Validation\Content as ContentValidator;

abstract class ContentController extends EditorController
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
    public function __construct(ContentValidator $validator)
    {
        parent::__construct();

        $this->validator = $validator;
    }

    /**
     * Define filters for current controller.
     *
     * @return void
     */
    protected function setupFilters()
    {
        $this->beforeFilter(function () {
            if (Auth::guest()) {
                return Redirect::to(handles('orchestra::/'));
            }

            $this->beforeFilter('orchestra.csrf', array(
                'only' => array('store', 'update', 'destroy')
            ));
        });
    }

    /**
     * List all the contents.
     *
     * @return Response
     */
    abstract public function index();

    /**
     * Write a content.
     *
     * @return Response
     */
    abstract public function create();

    /**
     * Edit a content.
     *
     * @return Response
     */
    abstract public function edit($id = null);

    /**
     * Store a content.
     *
     * @return Response
     */
    public function store()
    {
        $input         = Input::all();
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation    = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return Redirect::to(resources("{$this->resource}/create"))
                    ->withInput()->withErrors($validation);
        }

        $content          = new Content;
        $content->title   = $input['title'];
        $content->content = $input['content'];
        $content->slug    = $input['slug'];
        $content->type    = $input['type'];
        $content->format  = $input['format'];
        $content->status  = $input['status'];
        $content->user_id = Auth::user()->id;

        $this->updatePublishedAt($content) and $content->published_at = Carbon::now();

        return call_user_func(array($this, 'storeCallback'), $content, $input);
    }

    /**
     * Update a content.
     *
     * @return Response
     */
    public function update($id = null)
    {
        $input         = Input::all();
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation    = $this->validator->on('update')->bind(array('id' => $id))->with($input);

        if ($validation->fails()) {
            return Redirect::to(resources("{$this->resource}/{$id}/edit"))
                    ->withInput()->withErrors($validation);
        }

        $content          = Content::findOrFail($id);
        $content->title   = $input['title'];
        $content->content = $input['content'];
        $content->slug    = $input['slug'];
        $content->type    = $input['type'];
        $content->format  = $input['format'];
        $content->status  = $input['status'];

        $this->updatePublishedAt($content) and $content->published_at = Carbon::now();

        return call_user_func(array($this, 'updateCallback'), $content, $input);
    }

    /**
     * Store a content.
     *
     * @return Response
     */
    abstract protected function storeCallback($content, $input);

    /**
     * Update a content.
     *
     * @return Response
     */
    abstract protected function updateCallback($content, $input);

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
        $content = Content::findOrFail($id);

        return call_user_func(array($this, 'destroyCallback'), $content);
    }

    /**
     * Delete a content.
     *
     * @return Response
     */
    abstract protected function destroyCallback($content);

    /**
     * Generate Unique Slug.
     *
     * @return string
     */
    protected function generateUniqueSlug($input)
    {
        return '_'.$input['type'].'_/'.$input['slug'];
    }

    /**
     * Determine whether published_at should be updated.
     *
     * @param  Orchestra\Story\Model\Content    $content
     * @return boolean
     */
    protected function updatePublishedAt($content)
    {
        $theBeginning = new Carbon('0000-00-00 00:00:00');

        if ($content->status !== Content::STATUS_PUBLISH) {
            return false;
        }

        switch (true)
        {
            case is_null($content->published_at):
                # passthru;
            case $content->published_at->format('Y-m-d H:i:s') === '0000-00-00 00:00:00':
                # passthru;
            case $content->published_at->toDateTimeString() === $theBeginning->toDateTimeString():
                return true;
                break;
            default:
                return false;
        }
    }
}
