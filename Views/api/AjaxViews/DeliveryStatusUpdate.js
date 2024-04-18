class DeliveryStatusUpdate extends Ajax {
    constructor() {
        super();
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        const deliveredButtons = document.querySelectorAll('.btn-primary');
        const noAnswerButtons = document.querySelectorAll('.btn-danger');

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
            if (response === 'Status updated to "Out For Delivery"') {
                statusSpan.textContent = "Out for delivery";
                this.renderAlert(response);
            } else if (response.includes('Status updated to "Delivered"')) {
                statusSpan.textContent = "Delivered";
                this.renderAlert(response);
            }
        } else {
            this.renderAlert(`Element with delivery ID ${deliveryId} not found.`)
        }
    }
}

// Instantiate the DeliveryStatusUpdate class
const deliveryStatusUpdate = new DeliveryStatusUpdate();