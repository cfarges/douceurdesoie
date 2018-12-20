module.exports = function(grunt) {

  require('load-grunt-tasks')(grunt);

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    jshint: {
      all: ['bs/assets/js/main.js']
    },

    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd HH:MM") %> */\n'
      },
      build: {
        src: ['bs/assets/js/plugins/*.js', 'bs/assets/js/main.js'],
        dest: 'bs/assets/js/main.min.js'
      }
    },

    watch: {
      js: {
        files: ['bs/assets/js/**/*.js', '!bs/assets/js/main.min.js'],
        tasks: ['jshint', 'uglify']
      }
    },

    imagemin: {
      dist: {
        files: [{
          expand: true,
          cwd: 'bs/assets/img/',
          src: ['**/*.{png,jpg,gif}'],
          dest: 'bs/assets/img/'
        }]
      }
    }
  });

  grunt.registerTask('default', ['jshint', 'uglify']);

};