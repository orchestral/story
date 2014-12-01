root = @
$ = root.jQuery

markdown = ($) ->
  has_textarea = $('textarea').size() > 0

  # Only include the editor if the current page contain a textarea.
  if has_textarea
    editor = new root.Editor
    editor.render()

  true

$(markdown)
