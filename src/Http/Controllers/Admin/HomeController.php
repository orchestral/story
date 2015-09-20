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
        $content = new Content();
        $content->setAttribute('type', Content::POST);

        if (Gate::denies('create', $content)) {
            return view('orchestra/story::admin.home');
        }

        return $this->writePost();
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
