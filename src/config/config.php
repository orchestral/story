<?php

return array(

	'permalink' => array(
		/*
		|------------------------------------------------------------------
		| Page Slug Format
		|------------------------------------------------------------------
		|
		| Define Page URI references to (:handle).
		| - :slug
		| - :id
		| - :year
		| - :month
		| - :date
		|
		*/
		'page' => ':slug',

		/*
		|------------------------------------------------------------------
		| Post Slug Format
		|------------------------------------------------------------------
		|
		| Define Post permalink format:
		| - :slug
		| - :id
		| - :year
		| - :month
		| - :date
		|
		*/

		'post' => 'posts/:slug',
	),
);
