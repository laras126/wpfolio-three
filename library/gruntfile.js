module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {   
            dist: {
                src: [
                    'js/plugins/*.js',
                    'js/scripts.js'
                ],
                dest: 'js/production.js',
            }
        },

        compass: {
            dist: {
                options: {
                    sassDir: 'scss',
                    cssDir: '../',
                    outputStyle: 'expanded'
                }
            }
        },

        watch: {
            scripts: {
                files: ['js/*.js', '**/*.scss'],
                tasks: ['concat', 'compass'],
                options: {
                    spawn: false,
                }
            },

        }

    

    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    
    grunt.registerTask('default', ['compass', 'concat']);

    

};