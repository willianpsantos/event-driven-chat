<template>
    <div class="group-video-call">
        <div class="row">
            <div class="auth-user">
                <span class="user-image">
                    <img v-bind:src="user.image" />
                </span>

                <b class="user-name">
                    {{ user.name }}
                </b>
            </div>

            <div class="added-users owl-carousel owl-theme">
                <div class="item user-image" v-for="user in addedUsers" :key="user.id">
                    <img v-bind:src="user.image"
                         v-bind:title="user.name"
                         v-bind:alt="user.name" />
                </div>
            </div>

            <span class="add-user-to-call">
                <img v-bind:src="addUserIconUrl" @click="onAddUserClick" />
            </span>

            <!--
            <span class="add-user-to-call">
                <img v-bind:src="phoneIconUrl"  />
            </span>
            -->
        </div>

        <user-finder v-bind:show-autocomplete="userFinderComponent.showAutoComplete"
                     v-bind:show-add-user-icon="userFinderComponent.showAddUserIcon"
                     v-on:userclick="onUserFinderUserClick"
                     v-if="showUserFinder"
                     style="display:inline">
        </user-finder>
    </div>
</template>

<script>
import UserFinder from './UserFinderComponent';

export default {
    components: {
        UserFinder
    },

    data() {
        return {
            user: { id: undefined, name: undefined, image: undefined },
            addUserIconUrl: window.rootUrl + '/images/icons/add.png',
            phoneIconUrl: window.rootUrl + '/images/icons/phone.png',

            userFinderComponent: {
                showAutoComplete: true,
                showAddUserIcon: false
            },

            showUserFinder: false,
            addedUsers: []
        };
    },

    async mounted() {
        const that = this;
        const service = new UserService();
        const user =  await service.getAuthenticatedUser();
        that.user = user;

        window.addEventListener('keyup', function(e) {
            if (e.keyCode == 27) {
                that.showUserFinder = false;
            }
        });
    },

    updated() {
        $('.added-users').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            autoWidth: true,

            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
    },

    methods: {
        onAddUserClick: function() {
            this.showUserFinder = !this.showUserFinder;
            this.$emit('group-video-call-userfinder-shown', { sender: this });
        },

        onUserFinderUserClick: function(e) {
            const filter = this.addedUsers.filter(i => i.id == e.user.id);

            if (filter && filter.length > 0) {
                return;
            }

            this.addedUsers.push(e.user);
            e.sender.hideSearchResult();
            this.$emit('group-video-call-userfinder-user-selected', { sender: this, user: e.user });
        }
    }
}
</script>
