<?php namespace Orchestra\Story\Routing\Admin;

use Orchestra\Story\Model\Content;

class PostsController extends ContentController
{
    /**
     * Define filters for current controller.
     *
     * @return void
     */
    public function setupFilters()
    {
        parent::setupFilters();

        $this->resource = 'storycms.posts';

        $this->beforeFilter('orchestra.story.can:create-post', [
            'only' => ['create', 'store'],
        ]);

        $this->beforeFilter('orchestra.story.can:update-post', [
            'only' => ['edit', 'update'],
        ]);

        $this->beforeFilter('orchestra.story.can:delete-post', [
            'only' => ['delete', 'destroy'],
        ]);
    }

    /**
     * List all the posts.
     *
     * @return mixed
     */
    public function index()
    {
        $contents = Content::with('author')->latestBy(Content::CREATED_AT)->post()->paginate();
        $type     = 'post';

        set_meta('title', 'List of Posts');

        return view('orchestra/story::admin.index', compact('contents', 'type'));
    }

    /**
     * Write a post.
     *
     * @return mixed
     */
    public function create()
    {
        $content = new Content;

        $content->setAttribute('type', Content::POST);
        $content->setAttribute('format', $this->editorFormat);

        set_meta('title', 'Write a Post');

        return view('orchestra/story::admin.editor', [
            'content' => $content,
            'url'     => resources('storycms.posts'),
            'method'  => 'POST',
        ]);
    }

    /**
     * Edit a post.
     *
     * @param  int  $id
     * @return mixed
     */
    public function edit($id = null)
    {
        set_meta('title', 'Write a Post');

        $content = Content::where('type', 'post')->where('id', $id)->firstOrFail();

        return view('orchestra/story::admin.editor', [
            'content' => $content,
            'url'     => resources("storycms.posts/{$content->getAttribute('id')}"),
            'method'  => 'PUT',
        ]);
    }

    /**
     * Response when content store has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    public function storeHasSucceed(Content $content, array $input)
    {
        messages('success', 'Post has been created.');

        return redirect(resources("storycms.posts/{$content->getAttribute('id')}/edit"));
    }

    /**
     * Response when content update has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    public function updateHasSucceed(Content $content, array $input)
    {
        messages('success', 'Post has been updated.');

        return redirect(resources("storycms.posts/{$content->getAttribute('id')}/edit"));
    }

    /**
     * Response when content deletion has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @return mixed
     */
    public function deletionHasSucceed(Content $content)
    {
        messages('success', 'Post has been deleted.');

        return redirect(resources('storycms.posts'));
    }
}
