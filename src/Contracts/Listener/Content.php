<?php namespace Orchestra\Story\Contracts\Listener;

use Orchestra\Story\Model\Content as Eloquent;

interface Content
{
    /**
     * Response when content update has failed validation.
     *
     * @param  \Illuminate\Support\MessageBag|array  $errors
     * @return mixed
     */
    public function storeHasFailedValidation($errors);

    /**
     * Response when content update has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    public function storeHasSucceed(Eloquent $content, array $input);

    /**
     * Response when content update has failed validation.
     *
     * @param  int|string  $id
     * @param  \Illuminate\Support\MessageBag|array  $errors
     * @return mixed
     */
    public function updateHasFailedValidation($id, $errors);

    /**
     * Response when content update has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @param  array  $input
     * @return mixed
     */
    public function updateHasSucceed(Eloquent $content, array $input);

    /**
     * Response when content deletion has succeed.
     *
     * @param  \Orchestra\Story\Model\Content  $content
     * @return mixed
     */
    public function deletionHasSucceed(Eloquent $content);
}
