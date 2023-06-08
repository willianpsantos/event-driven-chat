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
