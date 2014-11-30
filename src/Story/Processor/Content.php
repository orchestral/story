<?php namespace Orchestra\Story\Processor;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Orchestra\Foundation\Processor\Processor;
use Orchestra\Story\Model\Content as Eloquent;
use Orchestra\Story\Validation\Content as Validator;
use Orchestra\Story\Contracts\Listener\Content as Listener;

class Content extends Processor
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function store(Listener $listener, array $input)
    {
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation = $this->validator->on('create')->with($input);

        if ($validation->fails()) {
            return $listener->storeHasFailedValidation($validation->getMessageBag());
        }

        $content = new Eloquent;
        $content->setAttribute('user_id', Auth::user()->id);

        $this->saving($content, $input);

        return $listener->storeHasSucceed($content, $input);
    }

    public function update(Listener $listener, $id, array $input)
    {
        $input['slug'] = $this->generateUniqueSlug($input);
        $validation = $this->validator->on('update')->bind(['id' => $id])->with($input);

        if ($validation->fails()) {
            return $listener->updateHasFailedValidation($id, $validation->getMessageBag());
        }

        $content = Eloquent::findOrFail($id);

        $this->saving($content, $input);

        return $listener->updateHasSucceed($content, $input);
    }

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
     * @return bool
     */
    protected function updatePublishedAt(Eloquent $content)
    {
        $theBeginning = new Carbon('0000-00-00 00:00:00');

        if ($content->getAttribute('status') !== Content::STATUS_PUBLISH) {
            return false;
        }

        $publishedAt = $content->getAttribute('published_at');

        switch (true) {
            case is_null($publishedAt):
                # next;
            case $publishedAt->format('Y-m-d H:i:s') === '0000-00-00 00:00:00':
                # next;
            case $publishedAt->toDateTimeString() === $theBeginning->toDateTimeString():
                return true;
                break;
            default:
                return false;
        }
    }
}
