var gulp = require('gulp'),
  gutil = require('gulp-util'),
  coffee = require('gulp-coffee'),
  csso = require('gulp-minify-css'),
  less = require('gulp-less'),
  rename = require('gulp-rename'),
  uglify = require('gulp-uglify');

// Less
gulp.task('css', function () {
  return gulp.src('assets/less/**/*.less')
    .pipe(less())
    .pipe(csso())
    .pipe(gulp.dest('public/css'));
});

// Coffee
gulp.task('js', function () {
  return gulp.src('assets/coffee/**/*.coffee')
    .pipe(coffee().on('error', gutil.log))
    .pipe(gulp.dest('public/js'));
});

// Uglify
gulp.task('minify', function () {
  var options = {
    outSourceMaps: false,
    output: {
      max_line_len: 150
    }
  };

  return gulp.src('public/js/**/*.js')
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify(options))
    .pipe(gulp.dest('public/js'));
});

// Watch any changes.
gulp.task('watch', function () {
  gulp.watch('assets/less/**/*.less', ['css']);
  gulp.watch('assets/coffee/**/*.coffee', ['js']);
  gulp.watch('public/js/storycms.js', ['minify']);
  gulp.watch('public/js/markdown.js', ['minify']);
});

// Default task
gulp.task('default', ['css', 'js', 'minify', 'watch']);
