//list Dependences
const {src, dest, watch, series} = require('gulp');
var sass = require('gulp-sass')(require('sass'));
const prefix = require('gulp-autoprefixer');
const minify = require('gulp-clean-css');
const terser = require('gulp-terser');
const imagemin = require('gulp-imagemin');
const imagewebp = require('gulp-webp');


//Create Functions

//SCSS
function compilescss(){
    return src('wp-content/themes/IRP/assets/scss/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(prefix())
    .pipe(minify())
    .pipe(dest('wp-content/themes/IRP/assets/dist/css'))
}
//css
function minifycss(){
    return src('wp-content/themes/IRP/assets/css/*.css')
    .pipe(prefix())
    .pipe(minify())
    .pipe(dest('wp-content/themes/IRP/assets/dist/css'))
}

//js Min
function jsmin(){
    return src('wp-content/themes/IRP/assets/js/*.js')
    .pipe(terser())
    .pipe(dest('wp-content/themes/IRP/assets/dist/js'))
}

//Optmize
function optimizeim(){
    return src('wp-content/themes/IRP/assets/images/*.{jpg, png}')
    .pipe(imagemin([imagemin.mozjpeg({quality:50, progressive: true}), imagemin.optipng({optimizationLevel: 2})]))
    .pipe(dest('wp-content/themes/IRP/assets/dist/images'))
}

//webp images

function webpImage() {
    return src('wp-content/themes/IRP/assets/images/*.{jpg, png}')
    .pipe(imagewebp())
    .pipe(dest('wp-content/themes/IRP/assets/dist/images'))
}

//create watch task
function watchTask(){
    watch('wp-content/themes/IRP/assets/**/*.scss', compilescss);
    watch('wp-content/themes/IRP/assets/css/*.css', minifycss);
    watch('wp-content/themes/IRP/assets/js/*.js', jsmin);
    watch('wp-content/themes/IRP/assets/images/*.{jpg, png}', optimizeim);
    watch('wp-content/themes/IRP/assets/dist/images/*.{jpg, png}', webpImage);
}

//Defult gulp

exports.default = series(
    compilescss,
    minifycss,
    jsmin,
    optimizeim,
    webpImage,
    watchTask
);