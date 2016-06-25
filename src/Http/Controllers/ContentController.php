<?php

namespace Orchestra\Story\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Orchestra\Routing\Controller;

abstract class ContentController extends Controller
{
    /**
     * Show the content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function show(Request $request)
    {
        $params = $request->route()->parameters();
        $id     = Arr::get($params, 'id');
        $slug   = Arr::get($params, 'slug');

        $page = $this->getRequestedContent($id, $slug);
        $id   = $page->getAttribute('id');
        $slug = $page->getAttribute('slug');

        set_meta('title', $page->getAttribute('title'));

        return $this->getResponse($page, $id, $slug);
    }

    /**
     * Return the response, this method allow each content type to be group
     * via different set of view.
     *
     * @param  \Orchestra\Story\Model\Content  $page
     * @param  int  $id
     * @param  string  $slug
     *
     * @return mixed
     */
    abstract protected function getResponse($page, $id, $slug);

    /**
     * Get the requested page/content from Model.
     *
     * @param  int  $id
     * @param  string  $slug
     *
     * @return \Orchestra\Story\Model\Content
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    abstract protected function getRequestedContent($id, $slug);
}
