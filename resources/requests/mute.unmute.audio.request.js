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
