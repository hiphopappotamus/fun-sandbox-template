const {
  series,
  dest,
  src,
  watch
} = require('gulp');

const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();
const cleanCSS = require('gulp-clean-css');
const jshint = require('gulp-jshint');

// config file
let cfg = require('./gulpconfig.json'),
  paths = cfg.paths;

/**
 * Compile sass to css
 * exports.sassy = sassy
 * 
 * run: gulp sassy
 */
function sassy(done) {

  console.log(`
    =====================
      . . . . . . . . .
      ----- sass ------ 
    * * * compiled! * * *
      . . . . . . . . .
    =====================
  `);
  return src([
    paths.sass + '/*.scss',
    paths.sass + '/**/_*.scss',
    paths.sass + '/**/*/_*.scss'
  ])
    .pipe(sourcemaps.init({
      loadMaps: true
    }))
    .pipe(sass({
      outputStyle: 'expanded'
    }))
    .pipe(sourcemaps.write(undefined, {
      sourceRoot: null
    }))
    .pipe(dest(paths.css))
    .pipe(browserSync.stream());

  done();
}

/**
 * Minify CSS files
 * exports.cssMinify = cssMinify
 * 
 * run: gulp cssMinify
 * 
 * TODO: figure out why multiple .min files are being generated
 */
function cssMinify(done) {
  console.log(`
    =====================
      . . . . . . . . .
      ----- css ------ 
    * * * minified! * * *
      . . . . . . . . .
    =====================
  `);
  return src([
    paths.css + '/*.css'
  ])
    .pipe(
      cleanCSS({
        compatibility: '*',
      })
    )
    .pipe(
      plumber({
        errorHandler(err) {
          console.log(`hold up!!! ` + err);
          this.emit('end');
        },
      })
    )
    .pipe(
      rename({
        suffix: '.min'
      })
    )
    .pipe(
      sourcemaps.write('./')
    )
    .pipe(
      dest(paths.css)
    );

  done();
}

/**
 * Scripts task
 * exports.scripty = scripty
 * 
 * run: gulp scripty
 * 
 * TODO: set up script minifier
 */
function scripty(done) {
  console.log(`
    =====================
      . . . . . . . . .
       ----- js ------ 
    * * * scripted! * * *
      . . . . . . . . .
    =====================
  `);
  return src(oaths.js + '/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(browserSync.stream());

  done();
}

/**
 * watch js and css files for changes
 * exports.watch = watchFiles
 * 
 * run: gulp watchFiles
 */
function watchFiles(done) {
  watch([
    paths.sass + '/*.scss',
    paths.sass + '/**/_*.scss',
    paths.sass + '/**/*/_*.scss'
  ], sassy);
  watch([
    paths.js + '/custom.js'
  ], scripty);

  done();
}

/**
 * BrowserSync task
 * exports.syncAll = syncAll
 * 
 * run: gulp syncAll
 */
function syncAll(done) {
  console.log(`
    =====================
      . . . . . . . . .
        everything but
      ------------------
       THE KITCHEN SYNC
      . . . . . . . . .
    =====================
  `);
  browserSync.init(cfg.browserSyncOptions);

  done();
}

// tasks
exports.sassy = sassy;
exports.cssMinify = cssMinify;
exports.scripty = scripty;
exports.watchFiles = watchFiles;
exports.syncAll = syncAll;

exports.default = series(
  watchFiles,
  syncAll,
  // cssMinify
);