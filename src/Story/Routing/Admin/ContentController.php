<?php namespace Orchestra\Story\Routing\Admin;

use Carbon\Carbon;
use Orchestra\Story\Model\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\RedirectResponse;
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
    protected $validator;

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
        $this->beforeFilter('orchestra.auth');
    }

    /**
     * List all the contents.
     *
     * @return mixed
     */
    abstract public function index();

    /**
     * Write a content.
     *
     * @return mixed
     */
    abstract public function create();

    /**
     * Edit a content.
     *
     * @param  int  $id
     * @return mixed
     */
    abstract public function edit($id = null);

    /**
     * Store a content.
     *
     * @return mixed
     */
    public function store()
    {
        $input         = Input::all();
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation    = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return (new RedirectResponse(resources("{$this->resource}/create")))
                    ->withInput()->withErrors($validation);
        }

        $content = new Content;
        $content->setAttribute('title', $input['title']);
        $content->setAttribute('content', $input['content']);
        $content->setAttribute('slug', $input['slug']);
        $content->setAttribute('type', $input['type']);
        $content->setAttribute('format', $input['format']);
        $content->setAttribute('status', $input['status']);
        $content->setAttribute('user_id', Auth::user()->id);

        $this->updatePublishedAt($content) && $content->setAttribute('published_at', Carbon::now());

        return call_user_func([$this, 'storeCallback'], $content, $input);
    }

    /**
     * Update a content.
     *
     * @param  int  $id
     * @return mixed
     */
    public function update($id = null)
    {
        $input         = Input::all();
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation    = $this->validator->on('update')->bind(['id' => $id])->with($input);

        if ($validation->fails()) {
            return (new RedirectResponse(resources("{$this->resource}/{$id}/edit")))
                    ->withInput()->withErrors($validation);
        }

        $content = Content::findOrFail($id);

        $content->setAttribute('title', $input['title']);
        $content->setAttribute('content', $input['content']);
        $content->setAttribute('slug', $input['slug']);
        $content->setAttribute('type', $input['type']);
        $content->setAttribute('format', $input['format']);
        $content->setAttribute('status', $input['status']);

        $this->updatePublishedAt($content) && $content->setAttribute('published_at', Carbon::now());

        return call_user_func([$this, 'updateCallback'], $content, $input);
    }

    /**
     * Store a content.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    abstract protected function storeCallback($content, $input);

    /**
     * Update a content.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    abstract protected function updateCallback($content, $input);

    /**
     * Delete a content.
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id = null)
    {
        return $this->destroy($id);
    }

    /**
     * Delete a content.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        $content = Content::findOrFail($id);

        return call_user_func([$this, 'destroyCallback'], $content);
    }

    /**
     * Delete a content.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @return mixed
     */
    abstract protected function destroyCallback($content);

    /**
     * Generate Unique Slug.
     *
     * @param  array    $input
     * @return string
     */
    protected function generateUniqueSlug(array $input)
    {
        return '_'.$input['type'].'_/'.$input['slug'];
    }

    /**
     * Determine whether published_at should be updated.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @return bool
     */
    protected function updatePublishedAt($content)
    {
        $theBeginning = new Carbon('0000-00-00 00:00:00');

        if ($content->getAttribute('status') !== Content::STATUS_PUBLISH) {
            return false;
        }

        $publishedAt = $content->getAttribute('published_at');

        switch (true)
        {
            case is_null($publishedAt):
                # passthru;
            case $publishedAt->format('Y-m-d H:i:s') === '0000-00-00 00:00:00':
                # passthru;
            case $publishedAt->toDateTimeString() === $theBeginning->toDateTimeString():
                return true;
                break;
            default:
                return false;
        }
    }
}
