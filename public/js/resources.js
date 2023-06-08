HTMLElement.prototype.disable = function () {
    this.setAttribute('disabled', 'disabled');
};

HTMLElement.prototype.enable = function () {
    this.removeAttribute('disabled');
};

HTMLFormElement.prototype.disable = function () {
    const items = this.querySelectorAll('input, button, select, textarea');

    items.forEach(item => {
        item.setAttribute('disabled', 'disabled');
    });
};

HTMLFormElement.prototype.enable = function () {
    const items = this.querySelectorAll('input, button, select, textarea');

    items.forEach(item => {
        item.removeAttribute('disabled');
    });
};

HTMLElement.prototype.show = function(display) {
    if ( display === undefined || display === null || display === "") {
        display = "block";
    }

    this.style.display = display;
}

HTMLElement.prototype.hide = function() {
    this.style.display = 'none';
}

HTMLCollection.prototype.forEach = function (callback) {
    for (let i = 0; i < this.length; i++) {
        const item = this.item(i);
        callback.call(this, item);
    }
};
window.loading = {
    processCount: 0,
    isBusy: false,

    show: function() {
        const loading = $(".loading");

        if ( loading.is(':visible') ) {
            if(this.processCount === undefined) {
                this.processCount = 0;
            }

            this.processCount++;
            return;
        }

        loading.css({ 'opacity' : '0.7' });
        this.isBusy = true;
        loading.fadeIn();
    },

    hide: function() {
        if(this.processCount > 0) {
            this.processCount--;
            return;
        }

        var loading = $(".loading");
        this.isBusy = false;
        loading.fadeOut();
    }
};

class Service
{
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    fullUrl(url) {
        if ( !/\/+$/g.test(this.baseUrl) ) {
            this.baseUrl += '/';
        }

        if ( /^\/+/g.test(url) ) {
            url = url.replace(/^\/+/g, '');
        }

        return this.baseUrl + url;
    }

    formData(data) {
        const formData = new FormData();
        const keys = Object.keys(data);
        keys.forEach(key => void formData.append(key, data[key]));

        return formData;
    }

    csrfToken() {
        const meta = document.head.querySelector('meta[name="_token"]');
        const token = meta.getAttribute('content');
        return token;
    }

    get(url) {
        const fullUrl = this.fullUrl(url);

        return new Promise( (resolve, reject) => {
            fetch(fullUrl)
                .then(response => response.json())
                .then(json => void resolve(json))
                .catch(error => void reject(error));
        });
    }

    sendRequest(type, url, data, requireCsrfToken) {
        return new Promise( (resolve, reject) => {
            const request = new XMLHttpRequest();

            request.onload = e => {
                if (request.status >= 200 && request.status < 300) {
                    let response = request.response;

                    if(typeof response == 'string') {
                        response = JSON.parse(response);
                    }

                    resolve(response);
                }
                else {
                    reject({
                        success: false,
                        message: request.statusText,
                        data: request.response
                    });
                }
            };

            request.onerror = () => {
                reject({
                    success: false,
                    message: request.statusText,
                    data: request.response
                });
            }

            const fullUrl = this.fullUrl(url);
            const hasData = data !== undefined && data !== null && data !== '' && data !== 0;
            let formData = null;

            if( hasData ) {
                formData = this.formData(data);
            }

            if(requireCsrfToken === undefined || requireCsrfToken === true) {
                const token = this.csrfToken();
                formData.append('_token', token);
            }

            request.open(type, fullUrl);

            if(hasData) {
                request.send(formData);
            }
            else {
                request.send();
            }
        });
    }

    post(url, data, requireCsrfToken) {
        return this.sendRequest('POST', url, data, requireCsrfToken);
    }

    put(url, data, requireCsrfToken) {
        return this.sendRequest('PUT', url, data, requireCsrfToken);
    }

    delete(url) {
        return this.sendRequest('DELETE', url);
    }
}
