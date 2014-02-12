var gulp = require('gulp'),
    gutil = require('gulp-util'),
    coffee = require('gulp-coffee'),
    csso = require('gulp-minify-css'),
    less = require('gulp-less'),
    rename = require('gulp-rename'),
    uglify = require('gulp-uglify');

// Less
gulp.task('css', function () {
    return gulp.src('public/css/style.less')
        .pipe(less())
        .pipe(csso())
        .pipe(gulp.dest('public/css'));
});

// Coffee
gulp.task('js', function () {
    return gulp.src('public/coffee/*.coffee')
        .pipe(coffee().on('error', gutil.log))
        .pipe(gulp.dest('public/js'));
});

// Uglify
gulp.task('uglify-backend', function () {
    var options = {
        outSourceMaps: false,
        output: {
            max_line_len: 150
        }
    };

    return gulp.src('public/js/storycms.js')
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify(options))
        .pipe(gulp.dest('public/js'));
});

gulp.task('uglify-markdown', function () {
    var options = {
        outSourceMaps: false,
        output: {
            max_line_len: 150
        }
    };

    return gulp.src('public/js/markdown.js')
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify(options))
        .pipe(gulp.dest('public/js'));
});

gulp.task('uglify', ['uglify-backend', 'uglify-markdown']);

// Watch any changes.
gulp.task('watch', function () {
    gulp.watch('public/css/*.less', ['css']);
    gulp.watch('public/coffee/*.coffee', ['js']);
    gulp.watch('public/js/storycms.js', ['uglify-backend']);
    gulp.watch('public/js/markdown.js', ['uglify-markdown']);
});

// Default task
gulp.task('default', ['css', 'js', 'uglify', 'watch']);
