window._ = require('lodash');
window.Pusher = require('pusher-js');

window.createPusher = function() {
    const pusher = new Pusher(window.pusherSettings.appKey, {
        cluster: window.pusherSettings.cluster
    });

    return pusher;
}


window.createPeer = function(id) {
    return new Peer(id, {
        host: window.peerServerSettings.host,
        key: window.peerServerSettings.key,
        port: window.peerServerSettings.port,
        path: window.peerServerSettings.path
    });
}


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'eb160f70eb71d8330b9b',
    cluster: 'us2',
    encrypted: true
 });
