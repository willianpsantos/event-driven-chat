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
