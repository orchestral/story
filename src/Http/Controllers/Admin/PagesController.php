<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Story\Model\Content;
use Illuminate\Support\Facades\Gate;

class PagesController extends ContentController
{
    /**
     * Define the middleware.
     *
     * @return void
     */
    protected function setupMiddleware()
    {
        parent::setupMiddleware();

        $this->resource = 'pages';
    }

    /**
     * List all the pages.
     *
     * @return mixed
     */
    public function index()
    {
        $contents = Content::with('author')->latestBy(Content::CREATED_AT)->page()->paginate();

        set_meta('title', 'List of Pages');

        return view('orchestra/story::admin.index', [
            'contents' => $contents,
            'create'   => Gate::allows('create', Content::newPageInstance()),
            'type'     => 'page',
        ]);
    }

    /**
     * Write a page.
     *
     * @return mixed
     */
    public function create()
    {
        set_meta('title', 'Write a Page');

        $content = Content::newPageInstance();
        $content->setAttribute('format', $this->editorFormat);

        $this->authorize('create', $content);

        return view('orchestra/story::admin.editor', [
            'content' => $content,
            'url'     => handles('orchestra::storycms/pages'),
            'method'  => 'POST',
        ]);
    }

    /**
     * Edit a page.
     *
     * @param  int  $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        set_meta('title', 'Write a Page');

        $content = Content::page()->where('id', $id)->firstOrFail();

        $this->authorize('update', $content);

        return view('orchestra/story::admin.editor', [
            'content' => $content,
            'url'     => handles("orchestra::storycms/pages/{$content->getAttribute('id')}"),
            'method'  => 'PUT',
        ]);
    }

    /**
     * Response when content store has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     *
     * @return mixed
     */
    public function storeHasSucceed(Content $content, array $input)
    {
        messages('success', 'Page has been created.');

        return redirect(handles("orchestra::storycms/pages/{$content->getAttribute('id')}/edit"));
    }

    /**
     * Response when content update has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     *
     * @return mixed
     */
    public function updateHasSucceed(Content $content, array $input)
    {
        messages('success', 'Page has been updated.');

        return redirect(handles("orchestra::storycms/pages/{$content->getAttribute('id')}/edit"));
    }

    /**
     * Response when content deletion has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return mixed
     */
    public function deletionHasSucceed(Content $content)
    {
        messages('success', 'Page has been deleted.');

        return redirect(handles('orchestra::storycms/pages'));
    }
}
