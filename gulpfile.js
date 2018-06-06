var gulp = require('gulp');

gulp.task('copy', function(){
  return gulp.src('node_modules/qdt-components/dist/*')
    .pipe(gulp.dest('scripts/qdt-components/'))
});

gulp.task('default', ['copy']);