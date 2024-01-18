const {src, dest, watch, parallel} = require ("gulp");
const sass = require("gulp-sass")(require("sass"));
const plumber = require("gulp-plumber");
// Optimizar imagenes
const webp = require("gulp-webp");
const cache = require("gulp-cache")
const imagemin = require("gulp-imagemin");

function compilarSass(done){
  src("src/scss/**/*.scss")
    .pipe(plumber())
    .pipe(sass())
    .pipe(dest("build/css"));

  done();
}
function javascript(done){
  src('src/js/**/*.js')
    .pipe(dest('build/js'))    

  done();
}
function verSass(done){
  watch("src/scss/**/*.scss", compilarSass)
  watch("src/js/**/*.js", javascript)

  done();
}
function versionWebp(done){
  const opciones = {
    quality: 60    
  }
  src("src/img/**/*.{png,jpg}")
    .pipe(webp(opciones))
    .pipe(dest("build/img"))

  done();
}
function optImagenes(done){
  const opciones = {
    optimizationLevel: 3
  }
  src("src/img/**/*.{png,jpg}")
    .pipe(cache(imagemin(opciones)))
    .pipe(dest("build/img"))

  done();
}

exports.dev = parallel(versionWebp,optImagenes,javascript,verSass);