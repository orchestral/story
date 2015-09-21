<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Story\Model\Content;
use Illuminate\Support\Facades\Gate;

class HomeController extends EditorController
{
    /**
     * Show Dashboard.
     *
     * @return mixed
     */
    public function show()
    {
        $content = Content::newPostInstance();

        if (Gate::denies('create', $content)) {
            return view('orchestra/story::admin.home');
        }

        return $this->writePost($content);
    }

    /**
     * Write a post.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return mixed
     */
    protected function writePost(Content $content)
    {
        set_meta('title', 'Write a Post');

        $content->setAttribute('format', $this->editorFormat);

        return view('orchestra/story::admin.editor', [
            'content' => $content,
            'url'     => handles('orchestra::storycms/posts'),
            'method'  => 'POST',
        ]);
    }
}
