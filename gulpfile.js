/*
  This is a gulp workflow based around a sass file called app.scss
  It compiles and then watches for changes in themes using the folder
  structure shown below. The source and destination are set to the
  specific theme name.

  To make it work, you make to install:

  $ npm install
  
  To install the gulp requirements individually:

  $ npm install gulp gulp-zip gulp-notify

  To execute, change to project root:

  $ gulp
*/

var gulp = require('gulp');
var zip = require('gulp-zip');
var notify = require('gulp-notify');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');

var testPath = '../wptest/wp-content/plugins';
var sourcePath = 'source';
var buildPath = 'build';
var fileName = 'household-photos';

/**
 * create css file from scss files
 */
gulp.task('sassy', async function() {
  gulp.src(sourcePath + '/sass/app.scss')
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    .pipe(concat('style.min.css'))
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest(buildPath + '/' + fileName + '/css/'))
    .pipe(notify({ title: "Sassy!", message: "Sass compilation complete" }));
});

gulp.task('zippy', async function() {
  gulp.src(sourcePath + '/**')
    .pipe(zip(fileName + '.zip', {
      createSubFolders: true
    }))
    .pipe(gulp.dest(buildPath))
    .pipe(notify({ title: "Gulp!", message: "WordPress plugin zipped" }));
});

/**
 * copy all source files and license
 */
gulp.task('copy', async function () {
  gulp.src(sourcePath + '/**')
    .pipe(gulp.dest(buildPath + '/' + fileName + '/'));
});

/**
 * copy all of source over to test path in subfolder
 */
gulp.task('test', async function () {
  gulp.src(sourcePath + '/**')
    .pipe(gulp.dest(testPath + '/' + fileName + '/'));
});

/**
 * publish task to output to WordPress plugin SVN repository
 */
gulp.task('publish', async function () {
  gulp.src(sourcePath + '/readme.txt')
    .pipe(gulp.dest(publishPath + '/trunk/'));
  gulp.src(sourcePath + '/assets/**')
    .pipe(gulp.dest(publishPath + '/assets/'));
  gulp.src(sourcePath + '/includes')
    .pipe(gulp.dest(publishPath + '/trunk/'));
  gulp.src(sourcePath + '/*.php')
    .pipe(gulp.dest(publishPath + '/trunk/'))
    .pipe(notify({ title: "Gulp - Publish", message: "WordPress plugin SVN directory updated" }));
});

gulp.task('default', gulp.series('zippy', 'copy', 'test'));

/**
 * watch php files and process scripts
 */
gulp.task('watch', async function() {
  gulp.watch(sourcePath + '/**/*.php', gulp.series('test', 'copy'));
  gulp.watch(sourcePath + '/**/*.scss', gulp.series('sassy'));
});
