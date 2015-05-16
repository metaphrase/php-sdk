module.exports = function (grunt) {
    grunt.initConfig({
        phpcs: {
            application: {
                src: ['src/metaphrase/phpsdk']
            },
            options: {
                bin: 'vendor/bin/phpcs',
                standard: 'PSR2', //'PSR2',
                callback: log,
                showSniffCodes: true,
                verbose: true
            }
        },
        php_analyzer: {
            application: {
                dir: 'src/metaphrase/phpsdk'
            },
            options: {
                bin: 'vendor/bin/phpalizer',
            },
        },
        phplint: {
            options: {
                swapPath: '/tmp'
            },
            all: ['src/metaphrase/phpsdk/*.php', 'src/metaphrase/phpsdk/cache/*.php', 'src/metaphrase/phpsdk/controllers/*.php']
        },
    });
    function log(err, stdout, stderr, cb) {
        console.log(stdout);
        cb();
    }

    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-php-analyzer');

    grunt.registerTask('default', ['phplint:all', 'phpcs', 'php_analyzer:application']);
};
