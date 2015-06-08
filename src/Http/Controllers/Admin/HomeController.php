<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Story\Model\Content;
use Orchestra\Support\Facades\ACL;

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
    public function getIndex()
    {
        return $this->show();
    }

    /**
     * Show Dashboard.
     *
     * @return mixed
     */
    public function show()
    {
        $acl = Acl::make('orchestra/story');

        if ($acl->can('create post') or $acl->can('manage post')) {
            return $this->write();
        }

        return view('orchestra/story::admin.home');
    }

    /**
     * Write a post.
     *
     * @return mixed
     */
    protected function write()
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
