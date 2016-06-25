/**
 * Created by ThinkPad on 2016/6/25.
 */
var gulp = require('gulp');
var sass = require('gulp-sass');
var gutil = require('gulp-util');
var coffee = require('gulp-coffee');
// var autoprefixer = require('gulp-autoprefixer');
var notify = require('gulp-notify');

var cssDir = {
    src: 'app/assets/sass',
    dest: 'public/css'
};

var jsDir = {
    src: 'app/assets/coffee',
    dest:'public/js'
};

gulp.task('css',function(){
    return gulp.src(cssDir.src + '/main.sass')
        .pipe(sass({style: 'compressed'}))
        // .pipe(autoprefixer('last 10 version'))
        .pipe(gulp.dest(cssDir.dest))
        .pipe(notify('CSS compiled and minified.'));
});

gulp.task('js',function () {
    return gulp.src(jsDir.src + '/**/*.coffee')
        .pipe(coffee().on('error',gutil.log))
        .pipe(gulp.dest(jsDir.dest))
        .pipe(notify('JS compiled.'));
});

gulp.task('watch',function () {
    gulp.watch(cssDir.src + '/**/*.sass',['css']);
    gulp.watch(jsDir.src + '/**/*.coffee',['js']);

});

gulp.task('default',['css','js','watch']);