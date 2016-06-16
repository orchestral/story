import MDE from './vendor/simplemde'
import $ from './vendor/simplemde'

class Bootstrap {
  markdown() {
    const textarea = $('textarea')

    if (textarea.size() > 0) {
      const editor = new MDE({
        element: textarea[0],
        toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "preview", "guide"]
      })

      editor.render()
    }

    return this
  }
}

(new Bootstrap())
  .markdown()
