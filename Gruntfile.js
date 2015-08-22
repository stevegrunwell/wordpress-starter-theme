module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    jshint: {
      options: {
        force: true
      },
      all: ['assets/js/src/*.js']
    },

    concat: {
      dist: {
        src: ['assets/js/src/theme.js'],
        dest: 'assets/js/scripts.js'
      }
    },

    uglify: {
      min: {
        files: {
          'assets/js/scripts.js': ['assets/js/scripts.js']
        }
      }
    },

    compass: {
      dist: {
        options: {
          config: 'config.rb'
        }
      }
    },

    watch: {
      options: {
        livereload: true
      },
      scripts: {
        files: ['assets/js/src/*.js'],
        tasks: ['assets/jshint', 'concat', 'uglify']
      },
      styles: {
        files: ['assets/sass/*.scss'],
        tasks: ['compass']
      },
    },

  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'compass']);

};