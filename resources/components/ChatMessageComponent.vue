<template>
    <span class="chat">
        <group-video-call
            v-if="conversation && ( conversation.conversation_in_group == 'Y' || conversation.receiver_type == 'group' )"
            v-on:group-video-call-userfinder-shown="onGroupVideoCallUserFinderShown"
            v-on:group-video-call-userfinder-user-selected="onGroupVideoCallUserFinderUserSelected">
        </group-video-call>

        <div class="chat-container">
            <div class="chat-messages">
                <div class="chat-message-row"
                    v-for="message in preparedMessages"
                    :key="message.id"
                    v-bind:id="message.id">

                    <div v-bind:class="message.messageCssClass">
                        <div class="sender">
                            <div class="user-image">
                                <img v-bind:src="message.userImage">
                            </div>

                            <div class="sender-name">
                                {{ message.userName }}
                            </div>

                            <div class="sent-at">
                                {{ message.sent_at | datetime }}
                            </div>
                        </div>

                        <p>
                            {{ message.message }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="chat-message-input">
                <input
                    type="text"
                    placeholder="Digite aqui sua mensagem e pressione ENTER para enviar"
                    v-model="messageText"
                    @keyup="chatInputKeyPress"
                    v-bind:disabled="!enableInput">
            </div>
        </div>
    </span>
</template>

<script>
import GroupVideoCall from './GroupVideoCallComponent';

export default {
    components: {
        GroupVideoCall
    },

    props: {
        from: { type: Number, required: false },
        to: { type: Number, required: false },
        group: { type: Boolean, required: false },
        conversationId: { type: String, required: false },
    },

    data() {
        return {
            page: 1,
            take: 2,

            sentAndReceivedMessages: [],
            groupAddedUsers: [],
            conversation: undefined,
            mouseClicked: false,
            messageText: "",
            enableInput: true
        };
    },

    created() {
        const that = this;
        that.service = new ConversationMessageService();

        const pusher = window.createPusher();
        let channelName = `chat-message-sent-${window.pusherSettings.sesstoken}`;
        const channel = pusher.subscribe(channelName);

        channel.bind('chat-message-sent', async function(data) {
            const message = data.message;

            if ( that.conversationId === undefined ||
                  that.conversationId === null ||
                   that.conversationId === "" )
            {
                if ( !message.conversation ) {
                    message.conversation = await that.service.getConversationDataById(message.conversation_id);
                }

                that.$emit('chat-message-received', {
                    sender: that,
                    message: message
                });

                return;
            }

            if(message.conversation_id == that.conversationId) {
                that.sentAndReceivedMessages.push(message);
                that.toTheEndOfScroll();
                that.messageRead(message.conversation_id, message.id);
            }

            that.$emit('chat-message-received', {
                sender: that,
                message: message
            });

            that.enableInput = true;
        });
    },

    mounted() {
        const that = this;
        const chatmessage = this.$el.querySelector('.chat-messages');
        that.resizeChatMessages();

        window.addEventListener('resize', function() {
            that.resizeChatMessages();
        });

        chatmessage.addEventListener('scroll', function(e) {
            if(e.currentTarget.scrollTop > 0) {
                return;
            }

            that.page += 1;
            that.getMessagesOfConversation();
        });

        chatmessage.addEventListener('mousedown', function(e) {
            that.mouseClicked = true;
        });

        chatmessage.addEventListener('mousemove', function(e) {
            if (!that.mouseClicked) {
                return;
            }

            if(e.currentTarget.scrollTop > 0) {
                return;
            }

            that.mouseClicked = false;
            that.page += 1;
            that.getMessagesOfConversation();
        });

        chatmessage.addEventListener('mouseup', function(e) {
            that.mouseClicked = false;
        });
    },

    updated() {
        if ( this.page == 1 ) {
            const interval = window.setTimeout(() => {
                this.toTheEndOfScroll();
                window.clearTimeout(interval);
            }, 200);
        }

        this.resizeChatMessages();

        if ( this.groupAddedUsers && this.groupAddedUsers.length > 0 ) {
            this.$children[0].addedUsers.splice(0, this.$children[0].addedUsers.length);
            this.groupAddedUsers.forEach(item => void this.$children[0].addedUsers.push(item));
        }
    },

    watch: {
        conversationId: function(newValue, oldValue) {
            if ( !newValue ) {
                return;
            }

            this.page = 1;
            this.getMessagesOfConversation();
        }
    },

    computed: {
        preparedMessages: function() {
            const prepareItem = x => {
                x.messageCssClass = "";

                if( this.from == x.user_sender_id ) {
                    x.messageCssClass = 'own-messages';
                }
                else {
                    x.messageCssClass = 'others-messages';
                }

                x.userId = x.user_sender_id;
                x.userImage = x.sender.image;
                x.userName = x.sender.name;
                x.sent_at = x.message_sent_at;

                return x;
            };

            let reversed = [];

            if ( this.conversation && this.conversation.messages && this.conversation.messages.length > 0 ) {
                const prepared =
                    this.conversation
                        .messages
                        .map(x => prepareItem(x));

                reversed = prepared.reverse();
            }

            if ( this.sentAndReceivedMessages && this.sentAndReceivedMessages.length > 0 ) {
                this.sentAndReceivedMessages
                    .map(x => prepareItem(x))
                    .forEach(item => void reversed.push(item));
            }

            return reversed;
        }
    },

    methods: {
        onGroupVideoCallUserFinderUserSelected: async function(e) {
            const request = new GroupParticipantRequest();
            request.group = this.conversation.group_id;
            request.user = e.user.id;

            const service = new GroupService();
            const result = await service.addParticipant(request);

            if ( result && result.user ) {
                if ( !result.user.image ) {
                    result.user.image = window.rootUrl + '/images/icons/user.png';
                }

                this.groupAddedUsers.push(result.user);
            }
        },

        onGroupVideoCallUserFinderShown: function(e) {
            const interval = window.setTimeout(() => {
                this.resizeChatMessages();
                window.clearTimeout(interval);
            }, 50);
        },

        messageRead: async function(conversation, message) {
            const request  = new MessageReadRequest();
            request.conversation = conversation;
            request.message = message;
            const result = await this.service.messageRead(request);

            this.$emit('chat-message-read', {
                sender: this,
                conversation: conversation,
                unread_messages_count: result.unread_messages_count
            });
        },

        getMessagesOfConversation: function() {
            const that = this;

            window.loading.show();

            that.service.getMessagesOfConversation(
                that.conversationId,
                that.page,
                that.take
            )
            .then(conversation => {
                that.updateConversation(conversation);

                if( that.page == 1 ) {
                    const interval = window.setTimeout(() => {
                        that.toTheEndOfScroll();
                        window.clearTimeout(interval);
                    }, 50);
                }

                window.loading.hide();
            });
        },

        updateConversation: function(conversation) {
            const that = this;

            if ( that.conversation && that.conversation.id == conversation.id ) {
                conversation.messages.forEach(item => {
                    const exists =
                        that.conversation
                            .messages
                            .filter(x => x.id == item.id);

                    if(exists && exists.length > 0) {
                        return;
                    }

                    that.conversation.messages.push(item);
                });
            }
            else {
                that.conversation = conversation;

                if ( that.conversation.conversation_in_group == 'Y' ) {
                    that.conversation.group.participants.forEach(item => {
                        const user = item.user;

                        if ( !user.image ) {
                            user.image = window.rootUrl + '/images/icons/user.png';
                        }

                        // group-video-call
                        that.groupAddedUsers.push(user);
                    });
                }
            }

            const ids = that.conversation.messages.map(item => item.id);
            that.messageRead(that.conversation.id, ids);
        },

        toTheEndOfScroll: function() {
            const chatmessage = this.$el.querySelector('.chat-messages');

            chatmessage.scrollTo({
                top: chatmessage.scrollHeight + 150,
                left: 0,
                behavior: 'smooth'
            });
        },

        resizeChatMessages: function() {
            const groupElement = this.$el.querySelector('.group-video-call');
            const chatElement = this.$el.querySelector('.chat-messages');
            const chatInput = this.$el.querySelector('.chat-message-input');
            const chatMessages = this.$el.querySelector('.chat-messages');
            const mainElement = document.body.querySelector('.main');

            const mainHeight = mainElement.clientHeight;
            const mainOffsetTop = mainElement.offsetTop;
            const chatInputHeight = chatInput.clientHeight;
            const groupHeight = groupElement ? (groupElement.offsetHeight + 30) : 0

            let messagesHeight = ( mainHeight - (groupHeight + chatInputHeight + mainOffsetTop + 110) );

            chatMessages.style.height = `${messagesHeight}px`;
        },

        chatInputKeyPress: async function(e) {
            if ( e.keyCode != 13 ) {
                return;
            }

            this.enableInput = false;
            let request;

            if ( this.conversation.conversation_in_group == 'Y' ) {
                request = new MessageToGroupRequest();
                request.group = this.conversartion.group_id;
            }
            else {
                request = new MessageToUserRequest();
                request.from = this.from;
            }

            request.conversation = this.conversationId;
            request.to = this.to;
            request.message = this.messageText;

            const result = await this.service.sendMessage(request);
            this.enableInput = true;

            if(result.success) {
                this.messageText = "";
                this.sentAndReceivedMessages.push(result.messageData);
            }
        }
    }
}
</script>
