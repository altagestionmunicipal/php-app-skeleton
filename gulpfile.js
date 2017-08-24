var gulp = require('gulp');
var gutil = require('gulp-util');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var rename = require('gulp-rename');

var paths = {
  sass: ['./resources/scss/**/*.scss'],
  bootstrap: './bower_components/bootstrap/',
  jquery: './bower_components/jquery/',
  font_awesome: './bower_components/font-awesome/',
  jqueryValidator: './bower_componets/jquery-validation/',
  animated: './bower_components/animate.css/',
  popoverjs: './bower_components/popover.js/',
  public: './public/js/'
};

gulp.task('default', ['sass', 'bundle']);

/**
 * Compilar sass
 */
gulp.task('sass', function(done) {
  gulp.src('./resources/scss/main.scss')
    .pipe(sass())
    .pipe(gulp.dest('./public/css/'))
    .pipe(minifyCss({
      keepSpecialComments: 0
    }))
    .pipe(rename({ extname: '.min.css' }))
    .pipe(gulp.dest('./public/css/'))
    .on('end', done);
});

/**
 * Fonts
 */
gulp.task('fonts', ['font-awesome']);

/**
 * Copy font-awesome
 */
gulp.task('font-awesome', function(done) { 
    gulp.src([paths.font_awesome + 'fonts/**/*']) 
    .pipe(gulp.dest('./public/fonts'))
    .on('end', done);
});

/**
 * Compilar un solo bonche de librerias
 */
gulp.task('bundle', function(done) {
  gulp.src([
    paths.jquery + "dist/jquery.min.js",
    paths.bootstrap + "dist/js/bootstrap.min.js",
    paths.jqueryValidator + 'dist/jquery.validate.min.js',
    paths.jqueryValidator + 'dist/additional-methods.min.js',
    paths.jqueryValidator + 'src/localization/messages_es.js',
  ])
  .pipe(concat('vendor.bundle.js'))
  .pipe(gulp.dest('./public/js/'));
});

/**
 * Registrar tareas que pueden ser watchadas
 */
gulp.task('watch', function() {
  gulp.watch(paths.sass, ['sass']);
});
