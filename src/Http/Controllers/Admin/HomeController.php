<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Story\Model\Content;

class HomeController extends EditorController
{
    /**
     * Define the middleware.
     *
     * @return void
     */
    protected function setupMiddleware()
    {
        //
    }

    /**
     * Show Dashboard.
     *
     * @return mixed
     */
    public function show()
    {
        if (Gate::can('create', Content::class)) {
            return $this->writePost();
        }

        return view('orchestra/story::admin.home');
    }

    /**
     * Write a post.
     *
     * @return mixed
     */
    protected function writePost()
    {
        set_meta('title', 'Write a Post');

        $content = new Content();
        $content->setAttribute('type', Content::POST);
        $content->setAttribute('format', $this->editorFormat);

        return view('orchestra/story::admin.editor', [
            'content' => $content,
            'url'     => handles('orchestra::storycms/posts'),
            'method'  => 'POST',
        ]);
    }
}
