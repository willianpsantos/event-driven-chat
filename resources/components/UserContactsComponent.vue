<template>
    <div class="col-lg-8">
        <div class="user-contacts">
            <div class="row">
                <input type="text"
                    id="contact-search"
                    class="search-contact"
                    placeholder="Encontre um contato pelo nome"
                    v-model="search"
                    @keyup="onSearchKeyup" />
            </div>

            <div class="row">
                <span class="letter-group"
                      v-for="group in contactsGroupedByFirstLetter"
                      :key="group.letter">

                    <h4 class="letter-group-header">
                        {{ group.letter }}
                    </h4>

                    <ul class="letter-group-contacts">
                        <li class="letter-group-item"
                            v-for="contact in group.contacts"
                            :key="contact.contact_id">
                            <div class="row">
                                <div class="user-image">
                                    <img v-bind:src="contact.image" />
                                </div>

                                <div class="col-md" style="padding-top:0.5em;">
                                    {{ contact.name }}
                                </div>

                                <div class="col-md-2">
                                    <img v-if="contact.can_phone == 'Y'" class="contact-options" v-bind:src="icons.phone">
                                    <img v-if="contact.can_video == 'Y'" class="contact-options" v-bind:src="icons.video">
                                    <img v-if="contact.can_message == 'Y'" class="contact-options" v-bind:src="icons.message">
                                </div>
                            </div>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        userId: { type: Number, required: false }
    },

    data() {
        return {
            showAutocompleteWhenSearchUser: false,
            search: "",
            contacts: [],
            contactsGroupedByFirstLetter: [],

            icons: {
                phone: './images/icons/bordered-phone.png',
                video: './images/icons/bordered-camera.png',
                message: './images/icons/bordered-envelope.png',
            }
        }
    },

    watch: {
        userId: async function(newValue, oldValue) {
            const service = new UserService();
            this.contacts = await service.getUserContacts(newValue);

            if (this.contacts && this.contacts.length > 0) {
                this.contactsGroupedByFirstLetter = this.groupContactsByFirstLetter(this.contacts);
            }
        }
    },

    methods: {
        groupContactsByFirstLetter: function(data) {
            const alphabet = [
                'A', 'B', 'C', 'D', 'E', 'F',' G', 'H', 'I',
                'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
                'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
            ];

            const grouped = [];

            alphabet.forEach(letter => {
                const mapped = data.filter(item => item.name.startsWith(letter));

                if ( mapped && mapped.length > 0 ) {
                    mapped.forEach(c => {
                        if( !c.image )
                            c.image = window.rootUrl + '/images/icons/user.png';
                    });

                    grouped.push({
                        letter: letter,
                        selector: `#contacts-${letter}`,
                        id: `contacts-${letter}`,
                        contacts: mapped
                    });
                }
            });

            return grouped;
        },

        onSearchKeyup: function(e) {
            if(!this.search) {
                this.contactsGroupedByFirstLetter = this.groupContactsByFirstLetter(this.contacts);
                return;
            }

            const lsearch = this.search.toLowerCase();
            const filtered = this.contacts.filter(i => i.name.toLowerCase().includes(lsearch));

            if (filtered && filtered.length > 0) {
                this.contactsGroupedByFirstLetter = this.groupContactsByFirstLetter(filtered);
            }
        }
    }
}
</script>
