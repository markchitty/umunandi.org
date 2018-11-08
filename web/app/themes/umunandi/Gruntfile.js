'use strict';
module.exports = function(grunt) {

  grunt.initConfig({
    jshint: {
      options: { jshintrc: '.jshintrc' },
      all: ['Gruntfile.js', 'src/**/*.js']
    },
    less: {
      dist: {
        files: { 'assets/css/main.min.css': 'src/core/main.less' },
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
      },
      admin: {
        files: { 'assets/css/admin.css': 'src/admin/admin.less' },
        options: { rootpath: '/app/themes/umunandi/assets/' }
      }
    },
    concat: {
      dist: {
        files: {
          'assets/js/scripts.min.js': [
            'src/core/main.js',  // must be first
            'vendor/bootstrap/js/carousel.js',
            'vendor/bootstrap/js/transition.js',
            'vendor/bootstrap/js/affix.js',
            'vendor/js/plugins/*.js',
            'src/**/*.js',
            '!src/admin/**'
          ]
        },
        options: {
          // JS source map: to enable, uncomment the lines below and update sourceMappingURL based on your install
          // sourceMap: 'assets/js/scripts.min.js.map',
          // sourceMappingURL: '/app/themes/umunandi/assets/js/scripts.min.js.map'
        }
      },
      admin: {
        files: { 'assets/js/admin.js': 'src/admin/**/*.js' }
      }
    },
    version: {
      options: {
        file: 'src/core/styles-scripts.php',
        css: 'assets/css/main.min.css',
        cssHandle: 'umunandi_css',
        js: 'assets/js/scripts.min.js',
        jsHandle: 'umunandi_js'
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
        files: ['src/**/*.php', '*.php', '!<%= version.options.file %>'],
        tasks: [],
        options: { livereload: true }
      },
      livereload: {
        files: ['assets/css/main.min.css'],
        tasks: [],
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

  // Load and register tasks
  require('load-grunt-tasks')(grunt);
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
