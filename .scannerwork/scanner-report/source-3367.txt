// require module
var gulp = require('gulp'),
  sass = require('gulp-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  autoprefixer = require('gulp-autoprefixer')

// gulp sass
var sass_Config = {}
    // autoprefixer config
var autoprefixer_Config = {
  browsers: ['last 2 versions'],
  cascade: false
}

// for sass to css
gulp.task('sass', function () {
  gulp.src('sass/style.scss')
        //.pipe(sourcemaps.init())
        .pipe(autoprefixer(autoprefixer_Config))
        .pipe(sass(sass_Config).on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('css'))
})

gulp.task('sass:watch', function () {
  gulp.watch('sass/**/*.scss', ['sass'])
})

gulp.task('default', ['sass', 'sass:watch'])
