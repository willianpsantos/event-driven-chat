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
