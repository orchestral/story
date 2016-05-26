Story CMS Extension
==============

Content Management System for Orchestra Platform, based on [Cello CMS](https://github.com/orchestral/cello) and inspired by [WardrobeCMS](http://wardrobecms.com).

[![Latest Stable Version](https://img.shields.io/github/release/orchestral/story.svg?style=flat-square)](https://packagist.org/packages/orchestra/story)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestra/story.svg?style=flat-square)](https://packagist.org/packages/orchestra/story)
[![MIT License](https://img.shields.io/packagist/l/orchestra/story.svg?style=flat-square)](https://packagist.org/packages/orchestra/story)
[![Build Status](https://img.shields.io/travis/orchestral/story/3.3.svg?style=flat-square)](https://travis-ci.org/orchestral/story)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/orchestral/story/3.3.svg?style=flat-square)](https://scrutinizer-ci.com/g/orchestral/story/)

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"orchestra/story": "~3.0"
	}
}
```

And then run `composer install` to fetch the package.

### Quick Installation

You could also simplify the above code by using the following command:

	composer require "orchestra/story=~3.0"

### Setup

To start using Story CMS, activate the extension from Orchestra Platform Administrator Interface.

## Quick Guide

By default, Story CMS is using Markdown format for post and page, however you can customize this by adding your own prefered formatting parser.

### Adding new Format

```php
use Orchestra\Story\Facades\StoryFormat;

StoryFormat::extend('bbcode', function () {
    return new BBCodeParser();
});

class BBCodeParser extends Orchestra\Story\Parsers\Parser {}
```

You can add a new JavaScript text editor using:

```php
Event::listen('orchestra.story.editor: bbcode', function () {
    // Add asset
});
```

## License

	The MIT License

	Copyright (C) 2012 by Mior Muhammad Zaki <http://git.io/crynobone>

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.

Credit to [WardrobeCMS](http://wardrobecms.com) for the inspiration.
