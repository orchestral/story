(function() {
  var $, Javie, _, dispatcher, root, slugify, story_bootstrap;

  root = this;

  $ = root.jQuery;

  _ = root._;

  Javie = root.Javie;

  dispatcher = Javie.make('event');

  story_bootstrap = function($) {
    var slug, title;
    title = $('#title');
    slug = $('input[role="slug-editor"]:first');
    Javie.on('storycms.update: slug', function(string, force) {
      string = slugify(string);
      if (force == null) {
        force = false;
      }
      if (slug.data('listen') === true || force) {
        return slug.val(string);
      }
    });
    if (slug.val() === '') {
      slug.data('listen', true);
      Javie.trigger('storycms.update: slug', [title.val(), true]);
    } else {
      slug.data('listen', false);
      Javie.trigger('storycms.update: slug', [slug.val(), true]);
    }
    title.on('keyup', function() {
      Javie.trigger('storycms.update: slug', [title.val()]);
    });
    slug.on('blur', function() {
      Javie.trigger('storycms.update: slug', [slug.val(), true]);
      if (slug.val() === !'') {
        slug.data('listen', false);
      }
    });
    return true;
  };

  slugify = function(string, separator) {
    if (string == null) {
      string = '';
    }
    if (separator == null) {
      separator = '-';
    }
    return string.toLowerCase().replace(/^(_post_\/|_page_\/)/g, '').replace(/[^\w\.]+/g, separator).replace(/\s+/g, separator);
  };

  $(story_bootstrap);

}).call(this);
