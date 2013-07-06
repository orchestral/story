jQuery(function ($) { 'use strict';
	var Sluggable, events, title, slug;

	title  = $('#title');
	slug   = $('input[role="slug-editor"]:first');
	events = new Javie.Events;

	Sluggable = function (string, allowSlashes) {
		if (_.isUndefined(string))
			return '';

		return string.toLowerCase().replace(/[^\w\.]+/g, '-').replace(/ +/g, '-');
	};

	if (slug.val() === '') {
		slug.data('listen', true);
		events.fire('storycms.update: slug', [title.val(), true]);
	} else
		slug.data('listen', false);

	events.listen('storycms.update: slug', function listenToSlugUpdate (string, forceUpdate) {
		string = Sluggable(string);

		if (_.isUndefined(forceUpdate))
			forceUpdate = false;

		if (slug.data('listen') === true || forceUpdate) 
			slug.val(string);
	});

	title.on('keyup', function onTitleKeyUp () {
		events.fire('storycms.update: slug', [title.val()]);
	});

	slug.on('blur', function onSlugBlurFocus () {
		events.fire('storycms.update: slug', [slug.val(), true]);
	});

	
});
