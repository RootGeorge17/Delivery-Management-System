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
                this.updateDeliveryStatus('delivered', deliveryId);
                console.log(deliveryId);
            });
        });

        noAnswerButtons.forEach(button => {
            button.addEventListener('click', () => {
                const deliveryId = button.closest('.delivery-point').querySelector('p:first-child').textContent.split(':')[1].trim();
                this.updateDeliveryStatus('no_answer', deliveryId);
            });
        });
    }

    updateDeliveryStatus(status, id) {
        const baseUrl = `/update?status=${status}&id=${id}`;
        const url = this.addTokenToUrl(baseUrl);
        console.log(url);

        this.get(url, (error, response) => {
            if (error) {
                console.log(error);
            } else {
                console.log(response);
                this.renderResult(response, id);
            }
        });
    }

    renderResult(response, deliveryId) {
        const statusSpan = document.querySelector(`button#show-on-${deliveryId} + span.status`);
        if (statusSpan) {
            if (response === 'Status updated to "Out For Delivery"') {
                statusSpan.textContent = "Out For Delivery";
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