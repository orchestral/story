(function() {
  var $, markdown_bootstrap, root;

  root = this;

  $ = root.jQuery;

  markdown_bootstrap = function($) {
    var editor, textarea;
    textarea = $('textarea').size() > 0;
    if (textarea) {
      editor = new root.Editor;
      editor.render();
    }
    return true;
  };

  $(markdown_bootstrap);

}).call(this);
