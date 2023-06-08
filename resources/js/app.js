require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import swal from 'sweetalert';

window.Vue = Vue;
window.VueRouter = VueRouter;
window.swal = swal;

Vue.use(VueRouter);

import Login from "../components/LoginComponent.vue";
import Home from "../components/HomeComponent.vue";
import Sidebar from "../components/SidebarComponent.vue";
import EventBar from "../components/EventBarComponent";
import UserFinder from "../components/UserFinderComponent";
import UserContacts from "../components/UserContactsComponent";
import UserRecentContacts from "../components/UserRecentContactsComponent";
import CallAndContacts from "../components/CallAndContactsComponent";
import GroupVideoCall from "../components/GroupVideoCallComponent";
import ConversationsHistory from "../components/ConversationsHistoryComponent";
import ConversationsMessagesGroupsHistory from "../components/ConversartionsMessagesGroupsHistoryComponent";
import ChatMessage from "../components/ChatMessageComponent";
import StartCall from "../components/StartCallComponent";
import Call from "../components/CallComponent";

Vue.component('login', Login);
Vue.component('home', Home);
Vue.component('sidebar', Sidebar);
Vue.component('eventbar', EventBar);
Vue.component('user-finder', UserFinder);
Vue.component('user-contacts', UserContacts);
Vue.component('user-recent-contacts', UserRecentContacts);
Vue.component('call-and-contacts', CallAndContacts);
Vue.component('group-video-call', GroupVideoCall);
Vue.component('conversations-history', ConversationsHistory);
Vue.component('conversations-messages-groups-history', ConversationsMessagesGroupsHistory);
Vue.component('chat-message', ChatMessage);
Vue.component('start-call', StartCall);
Vue.component('call', Call);

Vue.filter('datetime', function(value) {
    if( !value ) {
        return '';
    }

    let d = value;

    if( !(d instanceof Date) ) {
        d = new Date(value);
    }

    const day = d.getDate().toString().padStart(2, '0');
    const month = (d.getMonth() + 1).toString().padStart(2, '0');
    const year = d.getFullYear();
    const hour = d.getHours().toString().padStart(2, '0');
    const minute = d.getMinutes().toString().padStart(2, '0');

    return `${day}/${month}/${year} ${hour}:${minute}`;
});

Vue.filter('date', function(value) {
    if( !value ) {
        return '';
    }

    let d = value;

    if( !(d instanceof Date) ) {
        d = new Date(value);
    }

    const day = d.getDate().padStart(2, '0');
    const month = (d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();

    return `${day}/${month}/${year}`;
});

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login },
    { path: '/contacts', name: 'contacts', component: CallAndContacts },
    { path: '/start-call', name: 'startcall', component: StartCall },
    { path: '/call/:callId', name: 'call', component: Call, props: true },
    { path: '/messages', name: 'conversations-messages-groups-history', component: ConversationsMessagesGroupsHistory },
]

const router = new VueRouter({
    routes
});

window.App = new Vue({
    el: '#app',
    router
})
