<template>
    <ul class="messages-history">
        <li class="messages-history-header">
            <h6> Todas as conversas </h6>

            <button id="btn-new-group" class="btn btn-light btn-new-group" @click="onCreateGroupButtonClick">
                <i class="fa fa-users"></i>
                Criar Novo Grupo
            </button>
        </li>

        <li class="message-history-item"
            v-for="item in history"
            :key="item.id"
            v-bind:id="item.id"
            @click="onHistoryClick($event, item)">

            <div class="message-history-item-images user user-image" v-if="item.receiver_type == 'user'">
                <img v-bind:src="item.receiver.image">
            </div>

            <div class="message-history-item-images group user-image" v-if="item.receiver_type == 'group'">
                <img v-for="participant in twoFirstsParticipantsOfGroup(item.receiver)"
                     :key="participant.user.id"
                     v-bind:src="participant.user.image">
            </div>

            <div class="message-history-item-info">
                <div class="message-history-item-name">
                    {{ item.receiver.name }}

                    <input type="text"
                           id="group-name"
                           v-if="item.receiver_type == 'group' && !item.receiver.name"
                           class="form-control"
                           v-bind:data-group-id="item.receiver.id"
                           v-bind:data-conversation-id="item.id"
                           @keypress="onGroupNameInputKeypress">

                    <span class="interval">
                        {{ item.interval_last_message }}
                    </span>
                </div>

                <span class="message-history-last-message" v-if="item.last_message">
                    {{ ellapseMessage(item.last_message.message, 30) }}

                    <div class="badge badge-pill badge-danger" style="float:right;" v-show="item.unread_messages_count > 0">
                        {{ item.unread_messages_count }}
                    </div>
                </span>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        userId: Number
    },

    data() {
        return {
            page: 1,
            take: 2,
            history: [],
            selectedConversation: undefined
        }
    },

    mounted() {
        const that = this;
        that.resizeMessageHistory();

        window.addEventListener('resize', function() {
            that.resizeMessageHistory();
        });
    },

    updated() {
        if ( this.selectedConversation ) {
            this.selectItem(this.selectedConversation);
        }
    },

    methods: {
        onGroupNameInputKeypress: async function(e) {
            if (e.keyCode != 13) {
                return;
            }

            const groupId = e.currentTarget.dataset.groupId;
            const conversationId = e.currentTarget.dataset.conversationId;
            const request = new GroupRequest();

            request.id = groupId;
            request.name = e.currentTarget.value;
            request.creator = this.userId;
            request.description = "";

            window.loading.show();
            const service = new GroupService();
            const result = await service.save(request);

            this.history.forEach(item => {
                if(item.id == conversationId) {
                    item.receiver.name = request.name;
                }
            });

            window.loading.hide();
        },

        resizeMessageHistory: function() {
            const historyElement = this.$el;
            const mainElement = document.body.querySelector('.main');

            const mainHeight = mainElement.clientHeight;
            const mainOffsetTop = mainElement.offsetTop;

            let historyHeight = ( mainHeight - (mainOffsetTop + 110) );

            historyElement.style.height = `${historyHeight}px`;
        },

        selectItem: function(conversation) {
            const element = this.$el.querySelector(`.message-history-item[id='${conversation.id}']`);
            const parent = element.parentElement;
            const others = [ ... parent.querySelectorAll('.message-history-item') ];

            others.forEach(el => void el.classList.remove('selected'));
            element.classList.add('selected');

            this.selectedConversation = conversation;
            this.$emit('conversation-history-selected', { sender: this, element, conversation });
        },

        onHistoryClick: function(e, item) {
            const element = e.currentTarget;
            const parent = element.parentElement;
            const others = [ ... parent.querySelectorAll('.message-history-item') ];

            others.forEach(el => void el.classList.remove('selected'));
            element.classList.add('selected');

            this.selectedConversation = item;
            this.$emit('conversation-history-selected', { sender: this, element, conversation: item });
        },

        twoFirstsParticipantsOfGroup: function(group) {
            if( !group.participants || group.participants.length == 0 ) {
                return [];
            }

            if ( group.participants.length < 2 ) {
                return group.participants;
            }

            const participants = [
                group.participants[0],
                group.participants[1]
            ];

            return participants;
        },

        ellapseMessage: function(message, size) {
            if ( !message ) {
                return "";
            }

            if ( message.length <= size) {
                return message;
            }

            return message.substr(0, size) + '...';
        },

        afterGetHistory: function() {
            this.history.forEach(item => {
                switch(item.receiver_type) {
                    case 'user':
                        if( !item.receiver.image) {
                            item.receiver.image = window.rootUrl + '/images/icons/user.png';
                        }
                        break;

                    case 'group':
                        item.receiver.participants.forEach(p => {
                            if( p.user && !p.user.image) {
                                p.user.image = window.rootUrl + '/images/icons/user.png';
                            }
                        });
                        break;
                }
            });
        },

        onCreateGroupButtonClick: async function(e) {
            const service = new ConversationMessageService();
            window.loading.show();
            const result = await service.createGroupConversation(this.userId, this.userId);
            this.history.splice(0,0,result);
            this.selectedConversation = result;
            window.loading.hide();
        }
    },

    watch: {
        userId: async function(newValue, oldValue) {
            const service = new ConversationMessageService();
            this.history = await service.getConversationsHistory(newValue, this.page, this.take);
            this.afterGetHistory();
        }
    }
}
</script>
