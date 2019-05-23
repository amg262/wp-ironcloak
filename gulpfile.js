/*
 * Copyright (c) 2019.
 * Andrew M. Gunn  |  andrewmgunn26@gmail.com
 * github.com/amg262  |
 */

// Require our dependencies
//const babel = require("gulp-babel");
const gulp = require('gulp');
const concat = require('gulp-concat');
//const uglify = require('gulp-uglify');
//const imagemin = require('gulp-imagemin');
const del = require('del');
const clean = require('gulp-clean');
const rename = require('gulp-rename');
const browserSync = require('browser-sync').create();
//const cssnano = require('gulp-cssnano');
//const zip = require('gulp-zip');
//const unzip = require('gulp-unzip');
const minimatch = require('minimatch');
const mkdirp = require('mkdirp');

//var paths = {
//	acf: 'includes/acf/',
//	app: 'app/',
//	containers: 'app/containers/',
//	utils: 'app/utils/',
//	test: 'test/',
//	api: 'includes/api/',
//	native: 'native/',
//	electron: 'native/electron-quick-start/',
//	test: 'includes/api/',
//	vendor: 'vendor/',
//	node: 'node_modules/',
//	webpack: 'webpack.config.js/',
//	yml: '_config.yml/',
//	yarn: 'yarn.*/',
//	composer: 'composer.json/',
//	gulp: 'gulpfile.js/',
//	npm: 'package.json/',
//	yarn: 'yarn.*/',
//	assets: 'assets/',
//	classes: 'classes/',
//	data: 'assets/data/',
//	dist: 'dist/',
//	logs: 'logs/',
//	includes: 'includes/',
//	images: 'assets/images/*.png',
//	js: 'assets/js/*.js',
//	css: 'assets/css/*',
//	min_js: 'dist/js/*',
//	min_css: 'dist/css/*',
//	min_img: 'dist/images/',
//	log: 'assets/log/',
//	backups: 'assets/backups/',
//	dist_data: 'dist/data/',
//	archive: 'dist/data/archive.zip',
//	exports: 'assets/export/',
//	endpoint: 'includes/Endpoint/',
//	img: 'assets/images/*',
//	archive: 'assets/archive/',
//	dist_js: 'dist/',
//	dist_css: 'dist/',
//	dist_img: 'dist/images/',
//	host: 'http://localhost/wp/wp-admin',
//	php: '*.php',
//	wpb: 'wp-bom.php',
//};

var dirs = {

	all: '*',
	js: '*.js',
	ic: 'wp-ironcloak.php',
	g: 'gulpfile.js',
	p: '*.php',
	n: '/*/',
};

//// Not all tasks need to use streams
//// A gulpfile is just another node program and you can use any package available on npm
//gulp.task('purge', function () {
//	gulp.src('js/*').pipe(clean());
//	gulp.src(paths.dist + 'css/*').pipe(clean());
//});
//
//// Copy all static images
//gulp.task('imagemin', function () {
//	gulp.src(paths.images).pipe(imagemin()).pipe(gulp.dest(paths.min_img));
//});
//
//gulp.task('cssnano', function () {
//	gulp.src(paths.css).pipe(cssnano()).pipe(rename({suffix: '.min'})).pipe(gulp.dest('dist/css'));
//});
//
gulp.task('scripts', function () {
	return gulp.src(paths.data).pipe(concat('*')).pipe(gulp.dest('archive'));
});
//
///**
// * Minify compiled JavaScript.
// *
// * https://www.npmjs.com/package/gulp-uglify
// */
//gulp.task('uglify', function () {
//
//	gulp.src(paths.js).pipe(uglify()).pipe(rename({suffix: '.min'})).pipe(gulp.dest('dist/js'));
//});



// Static Server + watching scss/html files
gulp.task('serve', function () {

	browserSync.init({
		proxy: 'http://localhost/wordpress/wp-admin/',
	});

});

// Rerun the task when a file changes
gulp.task('watch', function () {
	//gulp.watch(paths.scripts, ["scripts"]);
	gulp.watch(dirs.all).on('change', browserSync.reload);
	gulp.watch(dirs.g).on('change', browserSync.reload);
	gulp.watch(dirs.ic).on('change', browserSync.reload);
	gulp.watch(dirs.js).on('change', browserSync.reload);
	gulp.watch(dirs.p).on('change', browserSync.reload);
	gulp.watch(dirs.n).on('change', browserSync.reload);
});

//
//gulp.task('clean', ['purge', 'imagemin', 'cssnano', 'uglify']);
//gulp.task('run', ['purge', 'imagemin', 'cssnano', 'uglify', 'zip', 'scripts', 'serve', 'watch']);
gulp.task('live', ['serve', 'watch']);
gulp.task('serve', ['serve']);
gulp.task('watch', ['watch']);

