<?php namespace Orchestra\Story;

use Carbon\Carbon;
use Orchestra\Story\Model\Content;
use Illuminate\Contracts\Foundation\Application;

class Storyteller
{
    /**
     * Application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new instance of Storytelling.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Generate URL.
     *
     * @param  string  $type
     * @param  \Orchestra\Story\Model\Content|null  $content
     * @return string
     */
    public function url($type, $content = null)
    {
        $type       = trim($type, '/');
        $predefined = ['posts', 'rss', 'archives'];

        if (in_array($type, $predefined)) {
            return handles("orchestra/story::{$type}");
        }

        return $this->permalink($type, $content);
    }

    /**
     * Generate URL by content.
     *
     * @param  string  $type
     * @param  \Orchestra\Story\Model\Content|null  $content
     * @return string
     */
    public function permalink($type, $content = null)
    {
        $format = $this->app['config']->get("orchestra/story::permalink.{$type}");

        if (is_null($format) || ! ($content instanceof Content)) {
            return handles("orchestra/story::/");
        }

        if (is_null($published = $content->getAttribute('published_at'))) {
            $published = Carbon::now();
        }

        $permalinks = [
            'id'    => $content->getAttribute('id'),
            'slug'  => str_replace(['_post_/', '_page_/'], '', $content->getAttribute('slug')),
            'type'  => $content->getAttribute('type'),
            'date'  => $published->format('Y-m-d'),
            'year'  => $published->format('Y'),
            'month' => $published->format('m'),
            'day'   => $published->format('d'),
        ];

        foreach ($permalinks as $key => $value) {
            $format = str_replace('{'.$key.'}', $value, $format);
        }

        return handles("orchestra/story::{$format}");
    }
}
