<?php namespace Orchestra\Story\Processor;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Orchestra\Foundation\Processor\Processor;
use Orchestra\Story\Model\Content as Eloquent;
use Orchestra\Story\Validation\Content as Validator;
use Orchestra\Story\Contracts\Listener\Content as Listener;

class Content extends Processor
{
    /**
     * Construct a new processor.
     *
     * @param  \Orchestra\Story\Validation\Content  $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Store new content.
     *
     * @param  \Orchestra\Story\Contracts\Listener\Content  $listener
     * @param  array  $input
     *
     * @return mixed
     */
    public function store(Listener $listener, array $input)
    {
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation    = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return $listener->storeHasFailedValidation($validation->getMessageBag());
        }

        $content = new Eloquent();
        $content->setAttribute('user_id', Auth::user()->id);

        $this->saving($content, $input);

        return $listener->storeHasSucceed($content, $input);
    }

    /**
     * Update a content.
     *
     * @param  \Orchestra\Story\Contracts\Listener\Content  $listener
     * @param  int  $id
     * @param  array  $input
     *
     * @return mixed
     */
    public function update(Listener $listener, $id, array $input)
    {
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation    = $this->validator->on('update')->bind(['id' => $id])->with($input);

        if ($validation->fails()) {
            return $listener->updateHasFailedValidation($id, $validation->getMessageBag());
        }

        $content = Eloquent::findOrFail($id);

        $this->saving($content, $input);

        return $listener->updateHasSucceed($content, $input);
    }

    /**
     * Destroy a content.
     *
     * @param  \Orchestra\Story\Contracts\Listener\Content  $listener
     * @param  int  $id
     *
     * @return mixed
     */
    public function destroy(Listener $listener, $id)
    {
        $content = Eloquent::findOrFail($id);

        $content->delete();

        return $listener->deletionHasSucceed($content);
    }

    /**
     * Saving content.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     *
     * @return void
     */
    protected function saving(Eloquent $content, array $input)
    {
        $content->setAttribute('title', $input['title']);
        $content->setAttribute('content', $input['content']);
        $content->setAttribute('slug', $input['slug']);
        $content->setAttribute('type', $input['type']);
        $content->setAttribute('format', $input['format']);
        $content->setAttribute('status', $input['status']);

        $this->updatePublishedAt($content) && $content->setAttribute('published_at', Carbon::now());

        $content->save();
    }

    /**
     * Generate unique slug.
     *
     * @param  array  $input
     *
     * @return string
     */
    protected function generateUniqueSlug(array $input)
    {
        return sprintf('_%s_/%s', $input['type'], $input['slug']);
    }

    /**
     * Determine whether published_at should be updated.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return bool
     */
    protected function updatePublishedAt(Eloquent $content)
    {
        $start = new Carbon('0000-00-00 00:00:00');

        if ($content->getAttribute('status') !== Eloquent::STATUS_PUBLISH) {
            return false;
        }

        $published = $content->getAttribute('published_at');

        switch (true) {
            case is_null($published):
                # next;
            case $published->format('Y-m-d H:i:s') === '0000-00-00 00:00:00':
                # next;
            case $published->toDateTimeString() === $start->toDateTimeString():
                return true;
                break;
            default:
                return false;
        }
    }
}
