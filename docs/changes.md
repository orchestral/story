---
title: Story Change Log

---

## Version 3.1 {#v3-1}

### v3.1.6 {#v3-1-6}

* Add `Orchestra\Story\AuthServiceProvider` to support policies handling.
* Add `Orchestra\Story\Policies\ContentPolicy` policy class.
* Add `Orchestra\Story\Model\Content::newPostInstance()` and `Orchestra\Story\Model\Content::newPageInstance()` static methods.
* Add `Orchestra\Story\Model\Content::url()`, `Orchestra\Story\Model\Content::editUrl()` and `Orchestra\Story\Model\Content::deleteUrl()` methods.
* Remove `Orchestra\Story\Http\Middleware\CanManage` middleware class.
* Use `Orchestra\Support\Facades\ACL` instead of deprecated `Acl` aliases.
* Refactor views.
* Update Assets:
  - SimpleMDE v1.7.1

### v3.1.5 {#v3-1-5}

* `Orchestra\Story\StoryServiceProvider` should utilize the new `Orchestra\Foundation\Support\Providers\ModuleServiceProvider`.
* Remove `Orchestra\Story\Model\Content::$morphClass` property.

### v3.1.4 {#v3-1-4}

* Add `Orchestra\Story\StoryPlugin`.
* Update Assets:
  - SimpleMDE v1.7.0

### v3.1.3 {#v3-1-3}

* Fixes invalid passing by reference usage in `Orchestra\Story\Listeners\AddValidationRules`.
* Update Assets:
  - SimpleMDE v1.6.1

### v3.1.2 {#v3-1-2}

* Convert from [Lepture Markdown Editor](github.com/lepture/editor) to [Simple Markdown Editor (SimpleMDE)](https://github.com/NextStepWebs/simplemde-markdown-editor/).

### v3.1.1 {#v3-1-1}

* Refactor `Orchestra\Story\StoryServiceProvider` and convert events handler to use own class handler.
* Update Assets:
  - lepture
  - marked.js

### v3.1.0 {#v3-1-0}

* Update support for Orchestra Platform v3.1.
* Convert filter to middleware.

## Version 3.0 {#v3-0}

### v3.0.0 {#v3-0-0}

* Update support to Orchestra Platform v3.0.
* Simplify PSR-4 path.
* Use basic routing instead of `orchestra/resources`.
* Move all start-up files to service provider.
* Replace deprecated `dflydev/markdown` with `erusev/parsedown`.

## Version 2.2 {#v2-2}

### v2.2.5 {#v2-2-5}

* Improves CSRF support.

### v2.2.4 {#v2-2-4}

* Fixes slug generator.

### v2.2.3 {#v2-2-3}

* Utilize `Illuminate\Support\Arr`.
* Small code improvement.

### v2.2.2 {#v2-2-2}

* Fixes invalid reference to `markdown.min.js` asset.

### v2.2.1 {#v2-2-1}

* Fixes JavaScript bug preventing the page to load markdown editor.

### v2.2.0 {#v2-2-0}

* Bump minimum version to PHP v5.4.0.
* Add support for Orchestra Platform 2.2.
* Add `gulp` and restructure JavaScript to use CoffeeScript.

## Version 2.1 {#v2-1}

### v2.1.5 {#v2-1-5}

* Improves CSRF support.

### v2.1.4 {#v2-1-4}

* Fixes slug generator.

### v2.1.3 {#v2-1-3}

* Fixes invalid reference to `markdown.min.js` asset.

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
