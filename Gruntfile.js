/**
 * Created by rodrigo.martins on 12/01/2016.
 */
module.exports = function( grunt ) {

    grunt.initConfig({




        less: {
            development: {
                options: {
                    compress: true
                },
                files: {
                    "dist/css/sb-admin-2.css": "less/sb-admin-2.less"
                }
            }
        }, //less



        watch : {
            less : {
                files : [
                    '**/*'
                ],

                tasks : [ 'less' ]
            }
        } // watch

    });


    // Plugins do Grunt
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks( 'grunt-contrib-watch' );


    // Tarefas que serão executadas
    grunt.registerTask( 'default', [ 'less' ] );

    // Tarefa para Watch
    grunt.registerTask( 'w', [ 'watch' ] );

};
