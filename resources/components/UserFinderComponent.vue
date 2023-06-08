<template>
    <div class="row">
        <div class="col-lg user-finder">
            <img v-bind:src="addUserIconUrl" v-if="showAddUserIcon" />

            <input type="text"
                   id="user-input-search"
                   placeholder="Encontre um usuário pelo nome ou e-mail"
                   v-model="search"
                   @keyup="onSearchInputKeyup" />

            <div class="search-result" v-if="showAutocomplete && (!users || users.length == 0)">
                <h4 v-if="!users || users.length == 0" class="not-found">
                    Nenhum Usuário Encontrado!
                </h4>
            </div>

            <div class="search-result" v-if="showAutocomplete && (users && users.length > 0)">
                <div class="row user-row"
                     v-for="user in users"
                     :key="user.id"
                     @click="onUserClick($event, user)">

                    <div class="user-image">
                        <img v-bind:src="user.image" />
                    </div>

                    <div class="user-description">
                        <h5> {{ user.name }} </h5>
                        <h6 class="email"> {{ user.email }} </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        showAutocomplete: Boolean,
        showAddUserIcon: Boolean,
        onlyContacts: Boolean,
        userId: Number
    },

    data() {
        return {
            search: "",
            users: [],
            addUserIconUrl: "./images/add_user.png"
        }
    },

    mounted() {
        const that = this;

        that.hideSearchResult();

        window.addEventListener('keyup', function(e) {
            if (e.keyCode == 27) {
                that.hideSearchResult();
                e.stopImmediatePropagation();
            }
        });

        window.onresize = function() {
            that.adjustSearchResultPositionAndSize();
        }
    },

    methods: {
        showSearchResult: function() {
            const searchResult = this.$el.querySelector('.search-result');
            searchResult && searchResult.show();
        },

        hideSearchResult: function() {
            const searchResult = this.$el.querySelector('.search-result');
            searchResult && searchResult.hide();
        },

        adjustSearchResultPositionAndSize: function() {
            const searchResult = this.$el.querySelector('.search-result');
            const input = this.$el.querySelector('#user-input-search');
            const main = document.querySelector('.main');

            let top = input.clientTop + input.offsetTop + input.offsetHeight;
            const left = input.clientLeft + input.offsetLeft;
            top -= 3;

            searchResult.style.left = left + 'px';
            searchResult.style.top = top + 'px';
            searchResult.style.width = (input.clientWidth) + 'px';
            searchResult.style.maxHeight = (main.clientHeight - 155) + 'px';
        },

        onSearchInputKeyup: async function(e) {
            if ( !this.search || this.search.length < 3 ) {
                this.hideSearchResult();
                return;
            }

            try {
                const service = new UserService();
                const users = await service.search(this.search, this.onlyContacts, this.userId);

                if ( users && users.length > 0 ) {
                    users.forEach(item => {
                        if ( !item.image ) {
                            item.image = window.rootUrl + '/images/icons/user.png';
                        }
                    });
                }
                else {
                    this.hideSearchResult();
                    return;
                }

                this.users = users;
                this.showAutocomplete && this.showSearchResult();
                this.showAutocomplete && this.adjustSearchResultPositionAndSize();
                const element = e.currentTarget;

                this.$emit('search', {
                    sender: this,
                    element,
                    users
                });
            }
            catch(error) {
                //
            }
        },

        onUserClick: function(e, user) {
            const element = e.currentTarget;
            this.hideSearchResult();

            this.$emit('userclick', {
                sender: this,
                element,
                user
            });
        }
    }
}
</script>
