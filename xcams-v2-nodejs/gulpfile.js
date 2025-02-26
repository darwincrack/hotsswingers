var jshint = require('gulp-jshint');
var gulp   = require('gulp');

gulp.task('lint', function() {
  return gulp.src('./server/*.js')
    .pipe(jshint({esnext: true}))
    .pipe(jshint.reporter('default'));
});