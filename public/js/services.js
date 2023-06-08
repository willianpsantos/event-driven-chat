class MessageToGroupRequest
{
    get conversation(){ return this._conversation; }
    set conversation(value) { this._conversation = value; }

    get from() { return this._from; }
    set from(value) { this._from = value; }

    get group() { return this._group };
    set group(value) { this._group = value; }

    get message() { return this._message; };
    set message(value) { this._message = value; }

    toJson() {
        let obj = {};
        obj.group = this._group;
        obj.from = this._from;
        obj.message = this._message;
        obj.conversation = this._conversation;

        return obj;
    }
}

class MessageToUserRequest
{
    get conversation(){ return this._conversation; }
    set conversation(value) { this._conversation = value; }

    get from() { return this._from; }
    set from(value) { this._from = value; }

    get to() { return this._to };
    set to(value) { this._to = value; }

    get message() { return this._message; };
    set message(value) { this._message = value; }

    toJson() {
        let obj = {};
        obj.to = this._to;
        obj.from = this._from;
        obj.message = this._message;
        obj.conversation = this._conversation;

        return obj;
    }
}
class MessageReadRequest
{
    get conversation(){ return this._conversation; }
    set conversation(value) { this._conversation = value; }

    get message() { return this._message; };
    set message(value) { this._message = value; }

    toJson() {
        let obj = {};        
        obj.message = this._message;
        obj.conversation = this._conversation;

        return obj;
    }
}
class GroupRequest
{
    get id(){ return this._id; }
    set id(value) { this._id = value; }

    get name(){ return this._name; }
    set name(value) { this._name = value; }

    get description() { return this._description; };
    set description(value) { this._description = value; }

    get creator() { return this._creator; }
    set creator(value) { this._creator = value; }

    toJson() {
        let obj = {};
        obj.id = this._id;
        obj.name = this._name;
        obj.description = this._description;
        obj.creator = this._creator;

        return obj;
    }
}

class GroupParticipantRequest
{
    get group(){ return this._group; }
    set group(value) { this._group = value; }

    get user(){ return this._user; }
    set user(value) { this._user = value; }

    toJson() {
        let obj = {};
        obj.group = this._group;
        obj.user = this._user;

        return obj;
    }
}

class MuteUnmutedAudioRequest
{
    get member() { return this._member; }
    set member(value) { this._member = value; }

    get call() { return this._call; }
    set call(value){ this._call = value; }

    get host() { return this._host; }
    set host(value) { this._host = value; }

    get mute() { return this._mute; }
    set mute(value) { this._mute = value; }

    toJson() {
        let obj = {};
        obj.member = this._member;
        obj.call = this._call;
        obj.host = this._host;
        obj.mute = this._mute;

        return obj;
    }
}

class ShowHideVideoRequest
{
    get member() { return this._member; }
    set member(value) { this._member = value; }

    get call() { return this._call; }
    set call(value){ this._call = value; }

    get host() { return this._host; }
    set host(value) { this._host = value; }

    get show() { return this._show; }
    set show(value) { this._show = value; }

    toJson() {
        let obj = {};
        obj.member = this._member;
        obj.call = this._call;
        obj.host = this._host;
        obj.show = this._show;

        return obj;
    }
}

class UserService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    authenticate(email, password) {
        return new Promise( (resolve,reject) => {
            this.post('/user/auth', { email: email, password: password })
                .then(response => {
                    if(response.success) {
                        window.location.assign(response.redirectTo);
                    }

                    resolve(response);
                }).
                catch(error => {
                    reject(error);
                });
        });
    }

    search(text, onlyContacts, user) {
        if(onlyContacts === undefined || onlyContacts === false) {
            return this.get(`/user/search/${text}`);
        }
        else {
            return this.get(`/user/search/${text}/${onlyContacts}/${user}`);
        }
    }

    getUserContacts(id) {
        return this.get(`/user/contacts/${id}`);
    }

    getRecentContacts(id) {
        return this.get(`/user/contacts/recents/${id}`);
    }

    getAuthenticatedUser() {
        return this.get(`/user/auth`);
    }
}

class EventService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    getEventsForHome() {
        return this.get('/home/events');
    }
}

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

class GroupService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    save(request) {
        return this.post('/group/save', request.toJson());
    }

    addParticipant(request) {
        return this.post('/group/partipants/add', request.toJson());
    }
}

class CallService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    getById(id) {
        return this.get(`/call/${id}`);
    }

    createCall(host) {
        return this.post('/call/create', { host });
    }

    createInvite(call) {
        return this.post('/call/invite/create', { call });
    }

    acceptMember(id) {
        return this.post('/call/member/allow', { id });
    }

    denyMember(id) {
        return this.post('/call/member/deny', { id });
    }

    disconnectMember(peer) {
        return this.post('/call/member/disconnect', { peer });
    }

    muteUnmuteAudio(request) {
        return this.post('/call/member/audio/mute-unmute', request.toJson());
    }

    showHideVideo(request) {
        return this.post('/call/member/video/show-hide', request.toJson());
    }
}
