class ConversationMessageService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    getConversationsHistory(user, page, take) {
        if(page === undefined) {
            page = 1;
        }

        if(take === undefined) {
            take = 10;
        }

        return this.get(`/conversation/history/${user}/${page}/${take}`);
    }

    getMessagesOfConversation(conversation, page, take) {
        if(page === undefined) {
            page = 1;
        }

        if(take === undefined) {
            take = 10;
        }

        return this.get(`/conversation/messages/${conversation}/${page}/${take}`);
    }

    getConversationDataById(id) {
        return this.get(`/conversation/data/${id}`);
    }

    sendMessageToUser(request) {
        return this.post(`/conversation/messages/user/send`, request.toJson());
    }

    sendMessageToGroup(request) {
        return this.post(`/conversation/messages/group/send`, request.toJson());
    }

    sendMessage(request) {
        if ( request instanceof MessageToUserRequest ) {
            return this.sendMessageToUser(request);
        }
        else if (request instanceof MessageToGroupRequest ) {
            return this.sendMessageToGroup(request);
        }
    }

    messageRead(request) {
        return this.post(`/conversation/messages/read`, request.toJson());
    }

    createUserConversation(from, to) {
        return this.post(`/conversation/user/create`, { from, to });
    }

    createGroupConversation(from, creator, group) {
        if ( group === undefined || group === null || group === "" ) {
            group = "";
        }

        return this.post(`/conversation/group/create`, { from, creator, group });
    }
}
