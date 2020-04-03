// Define the required packages
var gulp    = require('gulp'),
    rename  = require('gulp-rename'),
    sass    = require('gulp-sass');

var styleSRC = './scss/template.scss';
var styleDIST = './css/';
var styleWatch = './scss/**/*.scss';
var styleWatch2 = './scss/*.scss';

gulp.task('style', function() {
    return gulp.src(styleSRC)
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .on('error', console.error.bind(console))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(styleDIST));
    
    // compile
});

gulp.task('watch', function() {
    gulp.watch(styleWatch, gulp.series('style'));
});

gulp.task('default', gulp.series('watch'));