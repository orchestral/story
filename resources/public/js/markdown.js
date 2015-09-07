(function() {
  var $, markdown, mde, root;

  root = this;

  mde = root.SimpleMDE;

  $ = root.jQuery;

  markdown = function($) {
    var editor, has, textarea;
    textarea = $('textarea');
    has = textarea.size() > 0;
    if (has) {
      editor = new mde({
        element: textarea[0],
        toolbar: ["bold", "italic", "heading", "|", "quote", "unordered-list", "ordered-list", "|", "link", "image", "|", "preview", "guide"]
      });
      editor.render();
    }
    return true;
  };

  $(markdown);

}).call(this);
