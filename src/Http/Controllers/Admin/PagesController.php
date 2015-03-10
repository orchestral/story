<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Story\Model\Content;

class PagesController extends ContentController
{
    /**
     * Define filters for current controller.
     *
     * @return void
     */
    public function setupFilters()
    {
        parent::setupFilters();

        $this->resource = 'pages';

        $this->beforeFilter('orchestra.story.can:create-page', [
            'only' => ['create', 'store'],
        ]);

        $this->beforeFilter('orchestra.story.can:update-page', [
            'only' => ['edit', 'update'],
        ]);

        $this->beforeFilter('orchestra.story.can:delete-page', [
            'only' => ['delete', 'destroy'],
        ]);
    }

    /**
     * List all the pages.
     *
     * @return mixed
     */
    public function index()
    {
        $contents = Content::with('author')->latestBy(Content::CREATED_AT)->page()->paginate();
        $type     = 'page';

        set_meta('title', 'List of Pages');

        return view('orchestra/story::admin.index', compact('contents', 'type'));
    }

    /**
     * Write a page.
     *
     * @return mixed
     */
    public function create()
    {
        set_meta('title', 'Write a Page');

        $content = new Content();
        $content->setAttribute('type', Content::PAGE);
        $content->setAttribute('format', $this->editorFormat);

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

        $content = Content::where('type', 'page')->where('id', $id)->firstOrFail();

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
