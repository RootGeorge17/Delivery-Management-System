class Ajax {
    constructor() {
        this.xhr = new XMLHttpRequest();
        this.token = '';
        this.fetchToken();
    }

    fetchToken() {
        const url = '/token';
        this.get(url, (error, response) => {
            if (error) {
                console.error('Error fetching token:', error);
            } else {
                const data = JSON.parse(response);
                this.token = data.token;
            }
        });
    }

    get(url, callback) {
        const fullUrl = this.addTokenToUrl(url);
        this.xhr.open('GET', fullUrl, true);
        this.xhr.onload = () => {
            if (this.xhr.status === 200) {
                callback(null, this.xhr.responseText);
            } else {
                callback(this.xhr.statusText, null);
            }
        };
        this.xhr.onerror = () => {
            callback(this.xhr.statusText, null);
        };
        this.xhr.send();
    }

    addTokenToUrl(url) {
        const urlWithToken = new URL(url, window.location.origin);
        urlWithToken.searchParams.append('token', this.token);
        return urlWithToken.toString();
    }

    renderAlert(response) {
        const alertDiv = document.querySelector('.alert.alert-danger');
        if (alertDiv) {
            const li = alertDiv.querySelector('li');
            if (li) {
                li.textContent = response;
                alertDiv.classList.remove('hide');

                setTimeout(() => {
                    alertDiv.classList.add('hide');
                }, 10000);
            }
        }
    }
}