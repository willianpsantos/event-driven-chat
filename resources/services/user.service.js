class UserService extends Service
{
    constructor() {
        super(window.rootUrl);
    }

    authenticate(email, password) {
        return new Promise( (resolve,reject) => {
            this.post('/user/auth', { email: email, password: password })
                .then(response => {
                    if(response.success) {
                        window.location.assign(response.redirectTo);
                    }

                    resolve(response);
                }).
                catch(error => {
                    reject(error);
                });
        });
    }

    search(text, onlyContacts, user) {
        if(onlyContacts === undefined || onlyContacts === false) {
            return this.get(`/user/search/${text}`);
        }
        else {
            return this.get(`/user/search/${text}/${onlyContacts}/${user}`);
        }
    }

    getUserContacts(id) {
        return this.get(`/user/contacts/${id}`);
    }

    getRecentContacts(id) {
        return this.get(`/user/contacts/recents/${id}`);
    }

    getAuthenticatedUser() {
        return this.get(`/user/auth`);
    }
}
