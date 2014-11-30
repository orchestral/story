<?php namespace Orchestra\Story\Routing\Admin;

use Orchestra\Story\Model\Content;
use Orchestra\Support\Facades\Meta;
use Illuminate\Http\RedirectResponse;
use Orchestra\Support\Facades\Messages;

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

        $this->resource = 'storycms.pages';

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

        Meta::set('title', 'List of Pages');

        return view('orchestra/story::api.index', compact('contents', 'type'));
    }

    /**
     * Write a page.
     *
     * @return mixed
     */
    public function create()
    {
        Meta::set('title', 'Write a Page');

        $content = new Content;
        $content->setAttribute('type', Content::PAGE);
        $content->setAttribute('format', $this->editorFormat);

        return view('orchestra/story::api.editor', [
            'content' => $content,
            'url'     => resources('storycms.pages'),
            'method'  => 'POST',
        ]);
    }

    /**
     * Edit a page.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id = null)
    {
        Meta::set('title', 'Write a Page');

        $content = Content::where('type', 'page')->where('id', $id)->firstOrFail();

        return view('orchestra/story::api.editor', [
            'content' => $content,
            'url'     => resources("storycms.pages/{$content->id}"),
            'method'  => 'PUT',
        ]);
    }

    /**
     * Store a page.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    protected function storeCallback($content, $input)
    {
        $content->save();

        Messages::add('success', 'Page has been created.');

        return new RedirectResponse(resources("storycms.pages/{$content->id}/edit"));
    }

    /**
     * Update a page.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    protected function updateCallback($content, $input)
    {
        $content->save();

        Messages::add('success', 'Page has been updated.');

        return new RedirectResponse(resources("storycms.pages/{$content->id}/edit"));
    }

    /**
     * Delete a page.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @return mixed
     */
    protected function destroyCallback($content)
    {
        $content->delete();

        Messages::add('success', 'Page has been deleted.');

        return new RedirectResponse(resources('storycms.pages'));
    }
}
