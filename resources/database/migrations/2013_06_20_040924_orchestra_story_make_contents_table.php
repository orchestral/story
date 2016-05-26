<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Orchestra\Story\Model\Content;

class OrchestraStoryMakeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $format = Config::get('orchestra/story::config.default_format', 'markdown');

        Schema::create('story_contents', function (Blueprint $table) use ($format) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('slug');
            $table->string('title');
            $table->text('content');
            $table->string('format')->default($format);
            $table->string('type')->default(Content::POST);
            $table->string('status')->default(Content::STATUS_DRAFT);

            $table->nullableTimestamps();
            $table->datetime('published_at');
            $table->softDeletes();

            $table->index('user_id');
            $table->index('slug');
            $table->index('format');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('story_contents');
    }
}
