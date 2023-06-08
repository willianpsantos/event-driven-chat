<template>
    <div class="row recent-contacts owl-carousel owl-theme" style="margin-left:45px; width: 93.5%">
        <div class="recent-contact" v-for="contact in contacts" :key="contact.id">
            <span class="user-image">
                <img v-bind:src="contact.image" />
            </span>

            <span> {{ contact.view_name }} </span>

            <div class="recent-contact-options">
                <img v-if="contact.can_phone == 'Y'" class="contact-options" v-bind:src="icons.phone">
                <img v-if="contact.can_video == 'Y'" class="contact-options" v-bind:src="icons.video">
                <img v-if="contact.can_message == 'Y'" class="contact-options" v-bind:src="icons.message">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userId: Number
    },

    data() {
        return {
            contacts: [],

            icons: {
                phone: './images/icons/bordered-phone.png',
                video: './images/icons/bordered-camera.png',
                message: './images/icons/bordered-envelope.png',
            }
        }
    },

    updated() {
        $('.recent-contacts').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
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

    watch: {
        userId: async function(newValue, oldValue) {
            const service = new UserService();
            this.contacts = await service.getRecentContacts(newValue);

            if( !this.contacts || this.contacts.length == 0 ) {
                return;
            }

            this.contacts.forEach(item => {
                if ( !item.image ) {
                    item.image = window.rootUrl + '/images/icons/user.png';
                }

                item.view_name = item.name;

                if ( item.view_name.length > 15) {
                    item.view_name = item.view_name.substr(0, 12) + '...';
                }
            });
        }
    }
}
</script>
