/**
 * @extends Ajax
 * @description This class handles the updating of delivery statuses in real-time using Ajax
 */
class DeliveryStatusUpdate extends Ajax {
    /**
     * Constructor for the DeliveryStatusUpdate class.
     * Initialises event listeners for updating delivery status
     */
    constructor() {
        super();
        // Initialize event listeners for updating delivery status
        this.initializeEventListeners();
    }

    /**
     * Initialises event listeners for the "Delivered" buttons, "No Answer" buttons, and status dropdown items for both manager view and deliverer view
     */
    initializeEventListeners() {
        const deliveredButtons = document.querySelectorAll('.delivered'); // Event listeners for delivered buttons
        const noAnswerButtons = document.querySelectorAll('.no-answer'); // Event listeners for no answer buttons
        const statusDropdownItems = document.querySelectorAll('.status-dropdown'); // Event listeners for status dropdown items for manager view

        deliveredButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Extract delivery ID and current status
                const deliveryId = button.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                const currentStatus = button.closest('.delivery-point').querySelector('span.status').textContent.trim();

                // Check if the status is not already "Delivered" and update if needed
                if (currentStatus !== "Delivered") {
                    this.updateDeliveryStatus('delivered', deliveryId);
                } else {
                    this.renderAlert("The status is already set to: Delivered");
                }
            });
        });

        noAnswerButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Extract delivery ID and current status
                const deliveryId = button.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                const currentStatus = button.closest('.delivery-point').querySelector('span.status').textContent.trim();

                // Check if the status is not already "Out for delivery" and update if needed
                if (currentStatus !== "Out for delivery") {
                    this.updateDeliveryStatus('no_answer', deliveryId);
                } else {
                    this.renderAlert("Status has been updated to: No Answer. You can continue with your next delivery!");
                }
            });
        });

        statusDropdownItems.forEach(item => {
            item.addEventListener('click', () => {
                // Extract delivery ID, current status, and new status (what the user selected)
                const deliveryId = item.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                const currentStatus = item.closest('.delivery-point').querySelector('span.status').textContent.trim();
                const newStatus = item.textContent.trim().slice(9);

                // Check if the status is different from the new status and update if needed
                if (currentStatus !== newStatus) {
                    this.updateDeliveryStatus(newStatus, deliveryId);
                } else {
                    this.renderAlert("The status is already set to: " + newStatus);
                }
            });
        });
    }

    /**
     * @param {string} status The new status to update.
     * @param {string} id The ID of the delivery to update.
     * Updates the delivery status by sending a request to the server with the new status and delivery ID.
     */
    updateDeliveryStatus(status, id) {
        // Construct URL for updating status
        const baseUrl = `/update?status=${status}&id=${id}`; // query params
        const url = this.addTokenToUrl(baseUrl); // Adds the token to the base URL as a query parameter
        console.log(url);

        // Send request to update status
        this.get(url, (error, response) => {
            if (error) {
                this.renderAlert(error);
            } else {
                this.renderResult(response, id);
            }
        });
    }

    /**
     * @param {string} response The response from the server after updating the delivery status.
     * @param {string} deliveryId The ID of the delivery being updated.
     * Renders the updated status on the page by updating the relevant elements based on the server's response.
     */
    renderResult(response, deliveryId) {
        const statusSpan = document.querySelector(`button#show-on-${deliveryId} + span.status`);
        const statusDropdownItem = statusSpan.closest('.delivery-point').querySelector('.dropdown-status');

        if(statusDropdownItem) {
            const dropdownButton = statusDropdownItem.querySelector('.btn');
            // Update dropdown button text based on response for manager view
            if (response === 'Status updated to "Out for delivery"') {
                dropdownButton.textContent = "Out for delivery";
                this.renderAlert(response);
            } else if (response.includes('Status updated to "Delivered"')) {
                dropdownButton.textContent = "Delivered";
                this.renderAlert(response);
            } else if(response === 'Status updated to "Shipped"') {
                dropdownButton.textContent = "Shipped";
                this.renderAlert(response);
            } else if(response === 'Status updated to "Pending"') {
                dropdownButton.textContent = "Pending";
                this.renderAlert(response);
            }
        } else {
            this.renderAlert(`Element with delivery ID ${deliveryId} not found.`)
        }

        // Update status display in UI for deliverer view
        if (statusSpan) {
            if (response === 'Status updated to "Out for delivery"') {
                statusSpan.textContent = "Out for delivery";
                this.renderAlert(response);
            } else if (response.includes('Status updated to "Delivered"')) {
                statusSpan.textContent = "Delivered";
                this.renderAlert(response);
            } else if(response === 'Status updated to "Shipped"') {
                statusSpan.textContent = "Shipped";
                this.renderAlert(response);
            } else if(response === 'Status updated to "Pending"') {
                statusSpan.textContent = "Pending";
                this.renderAlert(response);
            }
        } else {
            this.renderAlert(`Element with delivery ID ${deliveryId} not found.`)
        }
    }
}

// Instantiate the DeliveryStatusUpdate class
const deliveryStatusUpdate = new DeliveryStatusUpdate();