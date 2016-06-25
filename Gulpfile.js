/**
 * Created by ThinkPad on 2016/6/25.
 */
var gulp = require('gulp');
var sass = require('gulp-sass');
var gutil = require('gulp-util');
var coffee = require('gulp-coffee');
// var autoprefixer = require('gulp-autoprefixer');
var notify = require('gulp-notify');

var sassDir = 'app/assets/sass';
var cssDir = 'public/css';

var coffeeDir = 'app/assets/coffee';
var jsDir = 'public/js';

gulp.task('css',function(){
    return gulp.src(sassDir + '/main.scss')
        .pipe(sass({style: 'compressed'}))
        // .pipe(autoprefixer('last 10 version'))
        .pipe(gulp.dest(cssDir))
        .pipe(notify('CSS compiled, prefixed, and minified.'));
});

gulp.task('js',function () {
    return gulp.src(coffeeDir + '/**/*.coffee')
        .pipe(coffee().on('error',gutil.log))
        .pipe(gulp.dest(jsDir))
        .pipe(notify('JS compiled.'));
});

gulp.task('watch',function () {
    gulp.watch('app/assets/sass/**/*.scss',['css']);
    gulp.watch('app/assets/coffee/**/*.coffee',['js']);

});

gulp.task('default',['css','js','watch']);