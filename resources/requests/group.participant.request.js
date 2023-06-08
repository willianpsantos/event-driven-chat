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
