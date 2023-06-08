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
