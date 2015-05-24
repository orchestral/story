<?php namespace Orchestra\Story\Http\Controllers\Admin;

use Orchestra\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Orchestra\Story\Facades\StoryFormat;

abstract class EditorController extends Controller
{
    /**
     * Editor format.
     *
     * @var string
     */
    protected $editorFormat;

    /**
     * Define filter for the controller.
     */
    public function __construct()
    {
        $this->setupFormat();
        $this->setupFilters();
    }

    /**
     * Setup content format type.
     *
     * @return void
     */
    protected function setupFormat()
    {
        $format = StoryFormat::get(Input::get('format'));

        $this->middleware("orchestra.story.editor:{$format}");
        $this->editorFormat = $format;
    }

    /**
     * Define filters for current controller.
     *
     * @return void
     */
    abstract protected function setupFilters();
}
