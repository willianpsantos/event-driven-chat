<template>
    <div class="container-fluid">
        <user-finder
            v-bind:user-id="user.id"
            v-bind:only-contacts="userFinderComponent.onlyContacts"
            v-bind:show-autocomplete="userFinderComponent.showAutocomplete"
            v-bind:show-add-user-icon="userFinderComponent.showAddUserIcon"
            v-on:userclick="onUserClick">
        </user-finder>

        <div class="row">
            <div class="col-4">
                <conversations-history
                    v-bind:user-id="user.id"
                    v-on:conversation-history-selected="onConversationHistorySelected">
                </conversations-history>
            </div>

            <div class="col-8">
                <chat-message
                    v-show="showChat"
                    v-bind:from="user.id"
                    v-bind:to="otherUserConversation"
                    v-bind:conversation-id="conversationIdSelected"
                    v-on:chat-message-received="onChatMessageReceived"
                    v-on:chat-message-read="onChatMessageRead">
                </chat-message>
            </div>
        </div>
    </div>
</template>

<script>
import UserFinder from './UserFinderComponent';
import ConversationsHistory from './ConversationsHistoryComponent';
import ChatMessage from "./ChatMessageComponent";

export default {
    components: {
        UserFinder,
        ConversationsHistory,
        ChatMessage
    },

    data() {
        return {
            user: { id: undefined },
            otherUserConversation: 0,
            messagesHistory: [],
            conversationIdSelected: undefined,
            showChat: false,

            userFinderComponent: {
                showAutocomplete: true,
                showAddUserIcon: true,
                onlyContacts: true,
            }
        }
    },

    async beforeMount() {
        const service = new UserService();
        this.user = await service.getAuthenticatedUser();
    },

    methods: {
        onChatMessageReceived: function(e) {
            // $children 1 = ConversationsHistory
            // $children 2 = ChatMessage

            const filtered =
                this.$children[1]
                    .history
                    .filter(item => item.id == e.message.conversation_id);

            if( !filtered || filtered.length == 0 ) {
                this.$children[1].history.splice(0,0, e.message.conversation);
                this.$children[1].afterGetHistory();
            }

            this.$children[1].history.forEach(item => {
                if (item.id == e.message.conversation_id) {
                    item.last_message = e.message;
                }
            });
        },

        onChatMessageRead: function(e) {
            this.$children[1].history.forEach(item => {
                if (item.id == e.conversation) {
                    item.unread_messages_count = e.unread_messages_count;
                }
            });
        },

        onConversationHistorySelected: function(e) {
            this.conversationIdSelected = e.conversation.id;

            if( e.conversation.receiver_type == 'group' ) {
                this.otherUserConversation = undefined;
            }
            else if( this.user.id != e.conversation.receiver.id ) {
                this.otherUserConversation = e.conversation.receiver.id;
            }
            else {
                this.otherUserConversation = e.conversation.owner.id;
            }

            this.showChat = true;
        },

        onUserClick: async function(e) {
            const service = new ConversationMessageService();
            const conversation = await service.createUserConversation(this.user.id, e.user.id);

            this.$children[1].history.splice(0, 0, conversation);
            this.$children[1].afterGetHistory();
            this.conversationIdSelected = conversation.id;

            this.$children[1].$emit('conversation-history-selected', { conversation });
            this.showChat = true;
        }
    }
}
</script>
