var gulp = require('gulp')
    post = require('gulp-postcss')
    renm = require('gulp-rename')

var proc = [
  require('precss'),               // use sass-like markup inside css files
  require('rucksack-css'),         // adds some coll css stuff give a look : https://www.rucksackcss.org/
  require('postcss-aspect-ratio'), // incredibly useful for videos and other ratio-ish things
  require('autoprefixer')({ browsers: ['last 5 versions'] }),
  require('css-mqpacker'),         // groups media queries at the end of file
  require('cssnano')               // minifies output file
]

gulp.task('css', function() {
  gulp.src('css/app.css')
    .pipe(post(proc))
    .pipe(renm('masterstyle.css'))
    .pipe(gulp.dest('./css/'))
})

gulp.task('default', ['css'], function() {
  gulp.watch('./css/**/*.css', ['css'])
})
