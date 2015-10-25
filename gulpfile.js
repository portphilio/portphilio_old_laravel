var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        'bootstrap.css',
        'font-awesome.css',
        'ace-fonts.css',
        'ace.css',
        'accounts.css'
    ], 'public/assets/css/accounts.css');
    mix.styles([
        'bootstrap.css',
        'font-awesome.css',
        'ace-fonts.css',
        'ace.css',
        'accounts.css'
    ], 'public/assets/css/portphilio.css');
    /**/
    mix.scripts([
        'bootstrap.js',
        'ace/ace.js',
        'ace/ace.sidebar.js',
        'ace/ace.settings.js',
        'ace/ace.settings-skin.js'
    ], 'public/assets/js/dashboard.js');
    
});
