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
