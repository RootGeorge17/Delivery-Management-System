class Ajax {
    constructor() {
        this.xhr = new XMLHttpRequest();
    }

    get(url, callback) {
        this.xhr.open('GET', url, true);
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

    post(url, data, callback) {
        this.xhr.open('POST', url, true);
        this.xhr.setRequestHeader('Content-Type', 'application/json');
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
        this.xhr.send(JSON.stringify(data));
    }
}