let gulp = require('gulp');
let sass = require('gulp-sass');
let sourcemaps = require('gulp-sourcemaps');
let autoprefixer = require('autoprefixer');
let postcss = require('gulp-postcss');
let minify = require('gulp-minify-css');
//let jquery = require('jquery');
//let bootstrap = require('bootstrap-sass');

gulp.task('sass', function() {
  return gulp.src([
    //'scss/_bootstrap-custom',
    'node_modules/normalize.css/normalize.css',
    'scss/bootstrap.scss',
    'scss/styles.scss',
  ])
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([
      //bootstrap(),
      autoprefixer()
    ]))
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./css/'));
});

gulp.task('sass:watch', function() {
  gulp.watch('scss/**', gulp.parallel('sass'));
});

gulp.task('hello', function(collback) {
  console.log('Hello log.');
  collback();
});

gulp.task('default', gulp.series('sass', 'sass:watch'));
