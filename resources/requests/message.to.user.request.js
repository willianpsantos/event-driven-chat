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