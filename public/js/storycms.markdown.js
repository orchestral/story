jQuery(function onPageLoadAddEditorForMarkdown ($) { 'use strict';
	var editor;

	// Only include the editor if the current page contain a textarea.
	if ($('textarea').size() > 0) {
		editor = new Editor();
		editor.render();
	}
});
