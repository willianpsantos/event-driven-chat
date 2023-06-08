<template>
    <div class="sidebar">
        <img class="logo" v-bind:src="logoImage">

        <ul class="middle-options">
            <li v-for="item in middleOptions"
                :key="item.name"
                v-bind:class="{ 'selected': item.selected }">

                <img v-bind:src="item.icon"
                     v-bind:data-route="item.route"
                     @click="onSidebarOptionClick"/>
            </li>
        </ul>

        <ul class="bottom-options" >
            <li v-for="item in bottomOptions"
                :key="item.name"
                v-bind:class="{ 'selected': item.selected }">

                <img v-bind:src="item.icon"
                     v-bind:data-route="item.route"
                     @click="onSidebarOptionClick" />
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            logoImage: './images/logo.jpg',

            middleOptions: [
                { name: 'home', icon: './images/icons/home.png', route: '/', selected: true },
                { name: 'call', icon: './images/icons/camera.png', route: '/start-call' },
                //{ name: 'contacts', icon: './images/icons/camera.png', route: '/contacts' },
                //{ name: 'messages', icon: './images/icons/envelope.png', route: '/messages' },
                { name: 'profile', icon: './images/icons/profile.png', route: '/profile' },
            ],

            bottomOptions: [
                { name: 'settings', icon: './images/icons/cogwheel.png' }
            ]
        }
    },

    mounted() {
        const that = this;

        window.addEventListener('load', function() {
            const path = that.$route.path;
            const img = document.querySelector(`img[data-route="${path}"]`);

            if ( img ) {
                that.removeSelectedFromMenus();
                img.parentElement.classList.add('selected');
            }
        });
    },

    methods: {
        removeSelectedFromMenus: function() {
            const elements =
                document.querySelectorAll('.sidebar .middle-options li, .sidebar .bottom-options li');

            const options = [ ... elements ];
            options.forEach(item => void item.classList.remove('selected'));
        },

        onSidebarOptionClick: function(e) {
            const that = this;
            const target = e.currentTarget;
            const route = target.dataset.route;

            this.removeSelectedFromMenus();
            target.parentElement.classList.add('selected');
            that.$router.replace({ path: route }).catch(error => {});
        }
    }
}
</script>>
