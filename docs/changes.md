---
title: Story Change Log

---

## Version 2.1 {#v2-1}

### v2.1.2 {#v2-1-2}

* Add `gulp` and restructure JavaScript to use CoffeeScript.
* Fixes JavaScript bug preventing the page to load markdown editor.

### v2.1.1 {#v2-1-1}

* Add rss routing.
* Add `<!—more—>` tag to create excerpt.

### v2.1.0 {#v2-1-0}

* Add support for Orchestra Platform 2.1
* Implement [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard.

## Version 2.0 {#v2-0}

### v2.0.6 {#v2-0-6}

* Refactor dependency inject for the controller.
* Implement [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard.

### v2.0.5 {#v2-0-5}

* `stripslashes()` on `Orchestra\Story\Model\Content::getContentAttribute()` and `Orchestra\Story\Model\Content:: getTitleAttribute()` is required by certain hosting environment.
* Add to support subdomain routing.

### v2.0.4 {#v2-0-4}

* Fixed a bug where latest posts isn't sort by published date.
* Add `Orchestra\Story\Model\Content::scopeLatestPublish()`.

### v2.0.3 {#v2-0-3}

* Add support to response using `Orchestra\Facile`.
* Author relationship should be based from `auth.model` config.

### v2.0.2 {#v2-0-2}

* Update form to follow Twitter Bootstrap 3.

### v2.0.1 {#v2-0-1}

* Move bootstrap process to `Orchestra\Story\StoryServiceProvider`.

### v2.0.0 {#v2-0-0}

* Migrate Story CMS from [Cello CMS](https://github.com/orchestral/cello).
* Add support to create posts instead of just pages.
* Add ability to switch format type, default to Markdown.
