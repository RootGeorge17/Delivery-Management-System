/**
 * @description Validator class for validating and displaying errors to the users.
 */
class Validator {

    /**
     * Validates a string based on its length.
     *
     * @param {string} value The string value to be validated.
     * @param {number} min The minimum length of the string (default: 1).
     * @param {number} max The maximum length of the string (default: Infinity).
     * @returns {boolean} Returns true if the string length is within the specified range, false otherwise.
     */
    static validateString(value, min = 1, max = Infinity) {
        const stringValue = value.trim();
        // Return true if the trimmed string length is between min and max (inclusive)
        return stringValue.length >= min && stringValue.length <= max;
    }

    /**
     * Validates whether a value is numeric.
     *
     * @param {any} value The value to be validated.
     * @returns {boolean} Returns true if the value is a numeric string or numeric, false otherwise.
     */
    static isNumeric(value) {
        // Check if the value is a string or not numeric
        if (typeof value !== 'string' && typeof value !== 'number' || isNaN(value)) {
            return false;
        }

        // Check if the value matches the pattern for integer or float
        // The pattern matches positive/negative integers and floats
        return /^[+\-]?\d*\.?\d+$/.test(value);
    }

    /**
     * Renders an alert message with the provided response from the server / function returns
     *
     * @param {string} response The response message to be displayed in the alert.
     */
    renderAlert(response) {
        const alertDiv = document.querySelector('.alert.alert-danger');
        if (alertDiv) {
            const li = alertDiv.querySelector('li');
            if (li) {
                li.textContent = response;
                // Remove the "hide" class from the alert div to make it visible
                alertDiv.classList.remove('hide');
                // Scroll the alert div into view smoothly
                alertDiv.scrollIntoView({behavior: 'smooth', block: 'start'});

                // Add close icon dynamically
                const closeIcon = document.createElement('span');
                closeIcon.className = 'bi bi-x';
                li.appendChild(closeIcon);

                // Add event listener to close icon
                closeIcon.addEventListener('click', function() {
                    alertDiv.classList.add('hide');
                });
            }
        }
    }
}


