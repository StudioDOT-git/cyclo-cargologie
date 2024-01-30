import gulp from 'gulp'
import gulpif from 'gulp-if'
import sourcemaps from 'gulp-sourcemaps'
import { deleteSync } from 'del'
import webpack from 'webpack'
import gulpWebpack from 'webpack-stream'
import path from 'path'
import { fileURLToPath } from 'url'
import named from 'vinyl-named'
import autoprefixer from 'autoprefixer'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import postcss from 'gulp-postcss'
import minifyCSS from 'gulp-clean-css'
import rename from 'gulp-rename'
import 'dotenv/config'
import browsersync from 'browser-sync'
import yargs from 'yargs'

const server = browsersync.create()

const args = yargs(process.argv.slice(2)).argv

const ENV = process.env.ENVIRONMENT // Get ENV from yargs if defined
const PRODUCTION = ENV === 'production'

const sass = gulpSass(dartSass)

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const dest = path.resolve(__dirname, 'dist')

const dirs = {
  dest,
  js: dest + '/js',
  css: dest + '/css'
}

const scripts = [
  'assets/js/**/*.js',
  'dotstarter/**.*.js'
]

const scriptsEntryPoint = [
  'assets/js/frontend.js'
]

const styles = [
  'assets/scss/**/*.scss',
  'dotstarter/**/*.scss'
]

const stylesEntryPoints = [
  'assets/scss/frontend.scss',
  'assets/scss/admin.scss'
]

const clean = (cb) => {
  deleteSync(dirs.css)
  deleteSync(dirs.js)
  cb()
}

const cleanCSS = (cb) => {
  deleteSync(dirs.css)
  cb()
}

const cleanJS = (cb) => {
  deleteSync(dirs.js)
  cb()
}

const js = async () => {
  return gulp.src(scriptsEntryPoint)
    .pipe(named())
    .pipe(gulpWebpack({
      target: 'web',
      mode: PRODUCTION ? 'production' : 'development',
      devtool: 'eval-cheap-module-source-map',
      watch: args.watchFiles,
      output: {
        filename: 'bundle.js'
      },
      plugins: [
        new webpack.DefinePlugin({
          'process.env.ENV': JSON.stringify(process.env.ENV)
        })
      ],
      module: {
        rules: [
          {
            test: /\.(js|jsx)$/,
            resolve: {
              fullySpecified: false,
              alias: {
                '@': path.join(__dirname, '/assets/js/')
              }
            },
            use: {
              loader: 'babel-loader',
              options: {
                presets: [
                  ['@babel/preset-env', { targets: 'defaults' }]
                ]
              }
            }
          }
        ]
      }
    }, webpack
    ))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(dirs.js))
    .pipe(server.stream())
}

/* CSS */
const css = () => {
  return gulp.src(stylesEntryPoints)
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(postcss([autoprefixer()]))
    .pipe(minifyCSS())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write(dirs.css)))
    .pipe(gulp.dest(dirs.css))
    .pipe(server.stream())
}

const watchJS = () => {
  return gulp.watch(scripts, js)
}

const watchCSS = () => {
  return gulp.watch(styles, css)
}

const browserSync = () => {
  server.init({
    proxy: process.env.DEV_URL,
    https: false,
    port: 3000
  })
}

gulp.task('watch:css', gulp.series(cleanCSS, css, watchCSS))
gulp.task('watch', gulp.series(clean, gulp.series(gulp.parallel(js, css), gulp.parallel(watchJS, watchCSS))))
gulp.task('dev', gulp.series(clean, gulp.parallel('watch', browserSync)))

gulp.task('build', gulp.series(clean, gulp.parallel(js, css)))
gulp.task('build:css', gulp.series(cleanCSS, css))
gulp.task('build:js', gulp.series(cleanJS, js))
