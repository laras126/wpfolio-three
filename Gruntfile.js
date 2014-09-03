module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        bower_concat: {
            all: {
                dest: 'assets/js/_bower.js'
            }
        },

        concat: {   
            dist: {
                src: [
                    'assets/js/_*.js'

                ],
                dest: 'assets/js/scripts.js',
            }
        },

        uglify: {
            dist: {
                src: 'assets/js/scripts.js',
                dest: 'assets/js/scripts.min.js'
            }
        },

        sass: {
            dist: {
                options: {
                    style: 'expanded',
                    compass: true,
                    require: 'susy',
                    sourcemap: false
                },
                files: {
                    'style.css': ['assets/scss/style.scss']
                }
            }
        },

        watch: {
            scripts: {
                files: ['assets/js/*.js', 'assets/scss/*.scss', 'assets/scss/**/*.scss', 'Gruntfile.js'],
                tasks: ['concat', 'uglify', 'sass'],
                options: {
                    spawn: false,
                }
            }
        }

    });

    // grunt.loadNpmTasks('grunt-contrib-concat');
    // grunt.loadNpmTasks('grunt-bower-concat');
    // grunt.loadNpmTasks('grunt-contrib-uglify' );
    // grunt.loadNpmTasks('grunt-contrib-watch');
    // grunt.loadNpmTasks('grunt-contrib-sass');

    require('load-grunt-tasks')(grunt);
    
    grunt.registerTask('default', ['sass', 'uglify', 'concat']);

};