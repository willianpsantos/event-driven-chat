class EventService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    getEventsForHome() {
        return this.get('/home/events');
    }
}
