var gulp = require('gulp'),
  gutil = require('gulp-util'),
  coffee = require('gulp-coffee'),
  csso = require('gulp-minify-css'),
  less = require('gulp-less'),
  rename = require('gulp-rename'),
  uglify = require('gulp-uglify'),
  underscore = require('underscore'),
  dir;

dir = {
  asset: 'resources/assets',
  editor: 'resources/editor',
  web: 'resources/public'
}

// Less
gulp.task('css', function () {
  return gulp.src(dir.asset+'/less/**/*.less')
    .pipe(less())
    .pipe(csso())
    .pipe(gulp.dest(dir.web+'/css'));
});

// Coffee
gulp.task('js', function () {
  return gulp.src(dir.asset+'/coffee/**/*.coffee')
    .pipe(coffee().on('error', gutil.log))
    .pipe(gulp.dest(dir.web+'/js'));
});

// Uglify
gulp.task('minify', ['js'], function () {
  var options = {
    outSourceMaps: false,
    output: {
      max_line_len: 150
    }
  };

  return gulp.src(dir.web+'/js/**/*.js')
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify(options))
    .pipe(gulp.dest(dir.web+'/js'));
});

gulp.task('copy', function () {
  var copy = [
    [dir.editor+'/build/editor.css', dir.web+'/vendor/editor'],
    [dir.editor+'/build/editor.js', dir.web+'/vendor/editor'],
    [dir.editor+'/build/fonts/*', dir.web+'/vendor/editor/fonts']
  ];

  underscore.each(copy, function (file) {
    gulp.src(file[0]).pipe(gulp.dest(file[1]));
  });
});

// Watch any changes.
gulp.task('watch', function () {
  gulp.watch(dir.asset+'/less/**/*.less', ['css']);
  gulp.watch(dir.asset+'/coffee/**/*.coffee', ['js']);
  gulp.watch(dir.web+'/js/storycms.js', ['minify']);
  gulp.watch(dir.web+'/js/markdown.js', ['minify']);
});

// Default task
gulp.task('default', ['css', 'js', 'minify', 'copy']);
