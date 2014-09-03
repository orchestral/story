root = @
$ = root.jQuery
_ = root._
Javie = root.Javie
dispatcher = Javie.make('event')

story_bootstrap = ($) ->
    title = $('#title')
    slug  = $('input[role="slug-editor"]:first')

    dispatcher.listen('storycms.update: slug', (string, force) ->
        string = slugify(string)
        force ?= false

        if slug.data('listen') is yes or force
            slug.val(string)
    )

    if slug.val() is ''
        slug.data('listen', true)
        dispatcher.fire('storycms.update: slug', [title.val(), true])
    else
        slug.data('listen', false)
        dispatcher.fire('storycms.update: slug', [slug.val(), true])

    title.on('keyup', () ->
        dispatcher.fire('storycms.update: slug', [title.val()])

        return
    )

    slug.on('blur', () ->
        dispatcher.fire('storycms.update: slug', [slug.val(), true])
        slug.data('listen', false) if slug.val() is not ''

        return
    )

    true

slugify = (string, separator) ->
    string ?= ''
    separator ?= '-'

    string.toLowerCase()
        .replace(/^(_post_\/|_page_\/)/g, '')
        .replace(/[^\w\.]+/g, separator)
        .replace(/\s+/g, separator)

$(story_bootstrap)
