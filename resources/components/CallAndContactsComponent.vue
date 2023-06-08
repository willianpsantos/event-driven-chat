<template>
    <div>
        <br>

        <h3 style="text-align:center"> <b> Vídeo Chamadas </b> </h3>

        <hr style="width:93.5%">

        <group-video-call></group-video-call>

        <h6 class="recent-contact-title"> Contatos recentes </h6>

        <user-recent-contacts v-bind:user-id="userId"></user-recent-contacts>

        <hr style="width:93.5%">

        <user-contacts v-bind:user-id="userId"></user-contacts>
    </div>
</template>

<script>
import UserContacts from './UserContactsComponent';
import UserRecentContacts from './UserRecentContactsComponent';
import GroupVideoCall from './GroupVideoCallComponent';


export default {
    components: {
        UserContacts,
        UserRecentContacts,
        GroupVideoCall
    },

    data() {
        return {
            user: undefined,
            userId: undefined,
        };
    },

    methods: {
        fillAuthUser: async function() {
            window.loading.show();

            const service = new UserService();
            this.user = await service.getAuthenticatedUser();
            this.userId = this.user.id;

            window.loading.hide();
        }
    },

    async created() {
        this.fillAuthUser();
    }
}
</script>
