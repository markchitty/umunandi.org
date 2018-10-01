'use strict';
module.exports = function(grunt) {

  grunt.initConfig({
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'assets/js/**/*.js',
        '!assets/js/scripts.min.js'
      ]
    },
    less: {
      dist: {
        files: {
          'assets/css/main.min.css': [
            'assets/less/app.less'
          ]
        },
        options: {
          compress: false,
          // LESS source map
          // To enable, set sourceMap to true and update sourceMapRootpath based on your install
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
            // 'assets/js/plugins/bootstrap/alert.js',
            // 'assets/js/plugins/bootstrap/button.js',
            // 'assets/js/plugins/bootstrap/dropdown.js',
            // 'assets/js/plugins/bootstrap/modal.js',
            // 'assets/js/plugins/bootstrap/tooltip.js',
            // 'assets/js/plugins/bootstrap/popover.js',
            // 'assets/js/plugins/bootstrap/tab.js',
            // 'assets/js/plugins/bootstrap/scrollspy.js',
            // 'assets/js/plugins/bootstrap/collapse.js',
            'assets/js/plugins/bootstrap/carousel.js',
            'assets/js/plugins/bootstrap/transition.js',
            'assets/js/plugins/bootstrap/affix.js',
            'assets/js/plugins/*.js',
            'assets/js/src/*.js'
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
        file: 'lib/scripts.php',
        css: 'assets/css/main.min.css',
        cssHandle: 'roots_main',
        js: 'assets/js/scripts.min.js',
        jsHandle: 'roots_scripts'
      }
    },
    watch: {
      less: {
        files: [
          'assets/less/**/*.less',
          'assets/less/bootstrap/*.less'
        ],
        tasks: ['less', 'version'],
      },
      js: {
        files: [
          '<%= jshint.all %>'
        ],
        tasks: [/*'jshint',*/ 'concat', 'version'],
        options: { livereload: true }
      },
      php: {
        files: [
          'templates/**/*.php',
          'lib/*.php',
          'functions/*.php',
          '*.php',
          '!lib/scripts.php'
        ],
        options: { livereload: true }
      },
      livereload: {
        files: [
          'assets/css/main.min.css',
        ],
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
