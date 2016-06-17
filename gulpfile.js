var dir, elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

dir = {
  asset: {
    css: './resources/public/css',
    img: './resources/public/img',
    js: './resources/public/js'
  },
  build: {
    less: './resources/assets/less',
    simplemde: './resources/simplemde'
  },
  js: './resources/js'
}

elixir.config.js.browserify.transformers.push({
  name: 'vueify'
})

elixir.config.sourcemaps = false

elixir(function(mix) {
  mix.copy(dir.build.simplemde+'/dist/simplemde.min.css', dir.asset.css+'/simplemde.css')
    .copy(dir.build.simplemde+'/dist/simplemde.min.js', dir.asset.js+'/simplemde.js')

  mix.less('story.less', dir.asset.css+'/story.css')

  mix.browserify('story.js', dir.asset.js+'/story.js', dir.js)
});
