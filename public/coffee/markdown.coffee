root = @
$ = root.jQuery

markdown_bootstrap = ($) ->
	textarea = $('textarea').size() > 0

	# Only include the editor if the current page contain a textarea.
	if textarea
		editor = new root.Editor
		editor.render()

	true

$(markdown_bootstrap)
