<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Story\Model\Content;
use Illuminate\Support\Facades\Input;
use Orchestra\Story\Processor\Content as Processor;
use Orchestra\Story\Contracts\Listener\Content as Listener;

abstract class ContentController extends EditorController implements Listener
{
    /**
     * Current Resource.
     *
     * @var string
     */
    protected $resource;

    /**
     * Processor instance.
     *
     * @var \Orchestra\Story\Processor\Content
     */
    protected $processor;

    /**
     * Content CRUD Controller.
     *
     * @param \Orchestra\Story\Processor\Content  $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;

        parent::__construct();
    }

    /**
     * Define filters for current controller.
     *
     * @return void
     */
    protected function setupFilters()
    {
        $this->middleware('orchestra.auth');
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
     * Store a content.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->processor->store($this, Input::all());
    }

    /**
     * Edit a content.
     *
     * @param  int  $id
     *
     * @return mixed
     */
    abstract public function edit($id = null);

    /**
     * Update a content.
     *
     * @param  int  $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        return $this->processor->update($this, $id, Input::all());
    }

    /**
     * Delete a content.
     *
     * @param  int  $id
     *
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
     *
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->processor->destroy($this, $id);
    }

    /**
     * Response when content update has failed validation.
     *
     * @param  \Illuminate\Support\MessageBag|array  $errors
     *
     * @return mixed
     */
    public function storeHasFailedValidation($errors)
    {
        return redirect_with_errors(handles("orchestra::storycms/{$this->resource}/create"), $errors);
    }

    /**
     * Response when content store has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     *
     * @return mixed
     */
    abstract public function storeHasSucceed(Content $content, array $input);

    /**
     * Response when content update has failed validation.
     *
     * @param  int|string  $id
     * @param  \Illuminate\Support\MessageBag|array  $errors
     *
     * @return mixed
     */
    public function updateHasFailedValidation($id, $errors)
    {
        return redirect_with_errors(handles("orchestra::storycms/{$this->resource}/{$id}/edit"), $errors);
    }

    /**
     * Response when content update has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     *
     * @return mixed
     */
    abstract public function updateHasSucceed(Content $content, array $input);

    /**
     * Response when content deletion has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return mixed
     */
    abstract public function deletionHasSucceed(Content $content);
}
