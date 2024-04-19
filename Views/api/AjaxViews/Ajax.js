/**
 * @description Ajax class for handling AJAX requests with token-based authentication.
 * @extends Validator
 */
class Ajax extends Validator {
    /**
     * Constructor for the Ajax class.
     * Initializes a new XMLHttpRequest object, sets the token to an empty string,
     * and calls the fetchToken method to fetch the token from the server.
     */
    constructor() {
        super();
        this.xhr = new XMLHttpRequest();
        this.token = '';
        this.fetchToken();
    }

    /**
     * Fetches the token from the server for authentication.
     */
    fetchToken() {
        const url = '/token';
        this.get(url, (error, response) => {
            if (error) {
                // Display the error to the user if there's an issue fetching the token
                this.renderAlert('Error fetching token:', error);
            } else {
                // Parse the response as JSON and extract the token
                const data = JSON.parse(response);
                this.token = data.token;
            }
        });
    }

    /**
     * Sends a GET request to the specified URL with the token appended.
     * @param {string} url - The URL to send the GET request to.
     * @param {function} callback - The callback function to handle the response.
     */
    get(url, callback) {
        const fullUrl = this.addTokenToUrl(url); // Add the token to the URL
        this.xhr.open('GET', fullUrl, true); // Open a GET request with the full URL

        // Define the onload callback function to handle the response
        this.xhr.onload = () => {
            if (this.xhr.status === 200) {
                // If the request was successful, call the callback with null error and the response text
                callback(null, this.xhr.responseText);
            } else {
                // If the request failed, call the callback with the status text as the error and null response
                callback(this.xhr.statusText, null);
            }
        };
        // Define the onerror callback function to handle errors
        this.xhr.onerror = () => {
            // If an error occurs, call the callback with the status text as the error and null response
            callback(this.xhr.statusText, null);
        };
        this.xhr.send(); // Send the request
    }

    /**
     * Adds the token to the provided URL as a query parameter.
     * @param {string} url - The URL to append the token to.
     * @returns {string} The URL with the token appended as a query parameter.
     */
    addTokenToUrl(url) {
        // Create a new URL object with the provided URL and the current origin
        const urlWithToken = new URL(url, window.location.origin);
        urlWithToken.searchParams.set('token', this.token); // Set the token as a query parameter
        return urlWithToken.toString(); // Return the URL string with the token appended
    }
}