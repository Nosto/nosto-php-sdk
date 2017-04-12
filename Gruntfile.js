module.exports = function (grunt) {
    // Project configuration.
    //noinspection JSUnresolvedFunction
    grunt.initConfig({
        uglify: {
            my_target: {
                files: {
                    'src/js/NostoIframe.min.js': ['src/js/src/NostoIframe.js']
                }
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Default task(s).
    //noinspection JSUnresolvedFunction
    grunt.registerTask('default', ['uglify']);
};