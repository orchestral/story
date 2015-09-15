root = @
mde = root.SimpleMDE
$ = root.jQuery

markdown = ($) ->
  textarea = $('textarea')
  has = textarea.size() > 0

  # Only include the editor if the current page contain a textarea.
  if has
    editor = new mde {
      element: textarea[0],
      toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "preview", "guide"]
    }

    do editor.render

  true

$(markdown)
