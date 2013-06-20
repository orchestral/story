<?php

use Illuminate\Database\Migrations\Migration;
use Orchestra\Story\Model\Content;

class OrchestraStoryMakeContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('story_contents', function ($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('slug');
			$table->string('title');
			$table->text('content');
			$table->string('format')->default(Content::FORMAT_MARKDOWN);
			$table->string('type')->default(Content::POST);
			$table->string('status')->default(Content::STATUS_DRAFT);

			$table->timestamps();
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
