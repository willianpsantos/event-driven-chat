const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')

   .scripts([
        'resources/js/prototype.js',
        'resources/js/loading.js',
        'resources/js/service.js'
   ], 'public/js/resources.js')

   .scripts([
        'resources/requests/message.to.group.request.js',
        'resources/requests/message.to.user.request.js',
        'resources/requests/message.read.request.js',
        'resources/requests/group.request.js',
        'resources/requests/group.participant.request.js',
        'resources/requests/mute.unmute.audio.request.js',
        'resources/requests/show.hide.video.request.js',

        'resources/services/user.service.js',
        'resources/services/event.service.js',
        'resources/services/conversation.service.js',
        'resources/services/group.service.js',
        'resources/services/call.service.js',
   ], 'public/js/services.js')

   .styles([
       'resources/css/app.css',
       'resources/css/scrollbar.css',
       'resources/css/login.css',
       'resources/css/sidebar.css',
       'resources/css/eventbar.css',
       'resources/css/user.css',
       'resources/css/contacts.css',
       'resources/css/video-call.css',
       'resources/css/messages.css',
   ], 'public/css/app.min.css');
