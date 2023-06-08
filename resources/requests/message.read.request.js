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