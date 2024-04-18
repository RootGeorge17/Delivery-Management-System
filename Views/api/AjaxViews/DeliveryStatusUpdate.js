class DeliveryStatusUpdate extends Ajax {
    constructor() {
        super();
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        const deliveredButtons = document.querySelectorAll('.delivered');
        const noAnswerButtons = document.querySelectorAll('.no-answer');
        const statusDropdownItems = document.querySelectorAll('.status-dropdown');

        deliveredButtons.forEach(button => {
            button.addEventListener('click', () => {
                const deliveryId = button.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                const currentStatus = button.closest('.delivery-point').querySelector('span.status').textContent.trim();

                if (currentStatus !== "Delivered") {
                    this.updateDeliveryStatus('delivered', deliveryId);
                } else {
                    this.renderAlert("The status is already set to: Delivered");
                }
            });
        });

        noAnswerButtons.forEach(button => {
            button.addEventListener('click', () => {
                const deliveryId = button.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                const currentStatus = button.closest('.delivery-point').querySelector('span.status').textContent.trim();

                if (currentStatus !== "Out for delivery") {
                    this.updateDeliveryStatus('no_answer', deliveryId);
                } else {
                    this.renderAlert("Status has been updated to: No Answer. You can continue with your next delivery!");
                }
            });
        });

        statusDropdownItems.forEach(item => {
            item.addEventListener('click', () => {
                const deliveryId = item.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                const currentStatus = item.closest('.delivery-point').querySelector('span.status').textContent.trim();
                const newStatus = item.textContent.trim().slice(9);

                if (currentStatus !== newStatus) {
                    this.updateDeliveryStatus(newStatus, deliveryId);
                } else {
                    this.renderAlert("The status is already set to: " + newStatus);
                }
            });
        });
    }

    updateDeliveryStatus(status, id) {
        const baseUrl = `/update?status=${status}&id=${id}`;
        const url = this.addTokenToUrl(baseUrl);
        console.log(url);

        this.get(url, (error, response) => {
            if (error) {
                this.renderAlert(error);
            } else {
                this.renderResult(response, id);
            }
        });
    }

    renderResult(response, deliveryId) {
        const statusSpan = document.querySelector(`button#show-on-${deliveryId} + span.status`);
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