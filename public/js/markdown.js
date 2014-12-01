(function() {
  var $, markdown, root;

  root = this;

  $ = root.jQuery;

  markdown = function($) {
    var editor, has_textarea;
    has_textarea = $('textarea').size() > 0;
    if (has_textarea) {
      editor = new root.Editor;
      editor.render();
    }
    return true;
  };

  $(markdown);

}).call(this);
