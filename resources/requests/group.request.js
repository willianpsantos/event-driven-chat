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
