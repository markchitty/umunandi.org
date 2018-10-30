'use strict';
module.exports = function(grunt) {

  grunt.initConfig({
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'src/**/*.js'
      ]
    },
    less: {
      dist: {
        files: {
          'assets/css/main.min.css': 'src/core/main.less'
        },
        options: {
          rootpath: '/app/themes/umunandi/assets/',
          paths: ['src', 'vendor'],
          plugins: [
            // new (require('less-plugin-autoprefix'))({ browsers: ["last 2 versions"] }),
            require('less-plugin-glob')
          ],
          compress: false,
          sourceMap: false,
          sourceMapFilename: 'assets/css/main.min.css.map',
          sourceMapRootpath: '/app/themes/umunandi/'
        }
      }
    },
    concat: {
      dist: {
        files: {
          'assets/js/scripts.min.js': [
            'vendor/bootstrap/js/carousel.js',
            'vendor/bootstrap/js/transition.js',
            'vendor/bootstrap/js/affix.js',
            'vendor/js/plugins/*.js',
            'src/**/*.js'
          ]
        },
        options: {
          // JS source map: to enable, uncomment the lines below and update sourceMappingURL based on your install
          // sourceMap: 'assets/js/scripts.min.js.map',
          // sourceMappingURL: '/app/themes/umunandi/assets/js/scripts.min.js.map'
        }
      }
    },
    version: {
      options: {
        file: 'vendor/roots/scripts.php',
        css: 'assets/css/main.min.css',
        cssHandle: 'roots_main',
        js: 'assets/js/scripts.min.js',
        jsHandle: 'roots_scripts'
      }
    },
    watch: {
      less: {
        files: ['src/**/*.less'],
        tasks: ['less', 'version'],
      },
      js: {
        files: ['<%= jshint.all %>'],
        tasks: [/*'jshint',*/ 'concat', 'version'],
        options: { livereload: true }
      },
      php: {
        files: [
          'src/**/*.php',
          '*.php',
          '!lib/roots/scripts.php'
        ],
        options: { livereload: true }
      },
      livereload: {
        files: ['assets/css/main.min.css'],
        options: { livereload: true }
      }
    },
    clean: {
      dist: [
        'assets/css/main.min.css',
        'assets/js/scripts.min.js'
      ]
    }
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-wp-version');

  // Register tasks
  grunt.registerTask('default', [
    'clean',
    'less',
    'concat',
    'version'
  ]);
  grunt.registerTask('dev', [
    'watch'
  ]);

};
